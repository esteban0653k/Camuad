<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerarVentasHistoricas extends Command
{
    protected $signature = 'ventas:generar
        {--desde=2022 : Año inicial}
        {--por-mes=40 : Ventas base por mes}
        {--sin-compras : No generar compras}
        {--fresh : Borra TODAS las ventas y compras antes de generar}';

    protected $description = 'Genera ventas y compras históricas de ejemplo para alimentar las estadísticas';

    public function handle(): int
    {
        $clientes = DB::table('cliente')->whereNull('deleted_at')->pluck('numero_documento')->all();
        $productos = DB::table('producto')->whereNull('deleted_at')
            ->get(['sku', 'precio', 'precio_compra', 'nit_proveedor'])->shuffle()->values();

        if ($productos->isEmpty()) {
            $this->error('No hay productos. Corre primero: php artisan migrate --seed');
            return self::FAILURE;
        }

        if (!$clientes) {
            $nombres = ['Camila Rojas', 'Andrés Pérez', 'Valentina Gómez', 'Juan Torres', 'Daniela Ruiz', 'Santiago Mejía', 'Laura Castro',
                'Sebastián Vargas', 'Mariana Ortiz', 'Felipe Herrera', 'Isabella Cardona', 'Mateo Salazar', 'Sofía Duarte', 'Nicolás Ramírez',
                'Paula Moreno', 'Camilo Restrepo', 'Natalia Aguirre', 'David Londoño', 'Juliana Parra', 'Esteban Cruz', 'Carolina Silva',
                'Julián Medina', 'Gabriela Núñez', 'Tomás Acosta', 'Luisa Bermúdez'];
            foreach ($nombres as $i => $nombre) {
                DB::table('cliente')->insert([
                    'numero_documento' => (string) (1010000000 + $i * 7919), 'tipo_documento' => 'CC', 'nombre' => $nombre,
                    'correo' => Str::slug($nombre, '.') . '@correo.com', 'telefono' => '3' . mt_rand(100000000, 299999999),
                    'created_at' => now(), 'updated_at' => now(),
                ]);
            }
            $clientes = DB::table('cliente')->whereNull('deleted_at')->pluck('numero_documento')->all();
            $this->info('No había clientes: se crearon ' . count($nombres) . ' de ejemplo.');
        }

        if ($this->option('fresh')) {
            if (!$this->confirm('Esto borra TODAS las ventas, compras y sus movimientos. ¿Continuar?')) {
                return self::SUCCESS;
            }
            DB::table('movimientos')->where(fn ($q) => $q->whereNotNull('id_venta')->orWhereNotNull('id_compra'))->delete();
            foreach (['detalle_venta', 'venta', 'detalle_compra', 'compra_proveedor'] as $t) {
                DB::table($t)->delete();
            }
        }

        $salida  = $this->tipo('Salida', 'Egreso de mercancía');
        $entrada = $this->tipo('Entrada', 'Ingreso de mercancía al inventario');

        // Popularidad: pocos productos se venden mucho y la mayoría poco.
        $acum = 0;
        $cum = [];
        foreach ($productos as $i => $_) {
            $acum += (int) round(1000 / (($i + 1) ** 0.8));
            $cum[] = $acum;
        }
        $elegir = function () use ($productos, $cum, $acum) {
            $r = mt_rand(1, $acum);
            foreach ($cum as $i => $c) {
                if ($r <= $c) return $productos[$i];
            }
            return $productos[0];
        };
        $porProveedor = $productos->where('precio_compra', '>', 0)->groupBy('nit_proveedor');
        $estacion = [1 => .8, 2 => .9, 3 => 1, 4 => 1, 5 => 1.05, 6 => 1.1, 7 => 1, 8 => .95, 9 => 1, 10 => 1.05, 11 => 1.25, 12 => 1.6];

        $hoy = now();
        $ini = now()->setDate((int) $this->option('desde'), 1, 1)->startOfDay();
        $meses = ($hoy->year - $ini->year) * 12 + $hoy->month - $ini->month + 1;
        if ($meses < 1) {
            $this->error('El año inicial no puede ser mayor al actual.');
            return self::FAILURE;
        }
        $base = (int) $this->option('por-mes');
        $conCompras = !$this->option('sin-compras') && $porProveedor->isNotEmpty();
        $nVentas = $nCompras = 0;
        $vendido = 0;
        $bar = $this->output->createProgressBar($meses);

        DB::transaction(function () use (&$nVentas, &$nCompras, &$vendido, $bar, $meses, $ini, $hoy, $base, $estacion, $clientes, $elegir, $porProveedor, $conCompras, $salida, $entrada) {
            for ($m = 0; $m < $meses; $m++) {
                $mes = $ini->copy()->addMonths($m);
                $actual = $mes->isSameMonth($hoy);
                $dias = $actual ? $hoy->day : $mes->daysInMonth;
                $crecimiento = 0.6 + 0.4 * ($meses > 1 ? $m / ($meses - 1) : 1);
                $n = max(1, (int) round($base * $crecimiento * $estacion[$mes->month] * mt_rand(85, 115) / 100));
                if ($actual) $n = max(1, (int) round($n * $dias / $mes->daysInMonth));
                $factorPrecio = max(0.7, 1 - 0.06 * ($hoy->year - $mes->year)); // precios más bajos en años anteriores
                $subtotalMes = 0;
                $detalles = $movs = $detCompra = [];

                for ($i = 0; $i < $n; $i++) {
                    $fecha = $mes->copy()->day(mt_rand(1, $dias))->setTime(mt_rand(8, 19), mt_rand(0, 59), mt_rand(0, 59));
                    if ($fecha->isFuture()) $fecha = $hoy->copy()->subMinutes(mt_rand(1, 600));

                    $lineas = [];
                    $sub = 0;
                    for ($k = mt_rand(1, 4); $k > 0; $k--) {
                        $p = $elegir();
                        if (isset($lineas[$p->sku])) continue;
                        $cant = mt_rand(1, 10) > 7 ? mt_rand(2, 4) : 1;
                        $precio = round($p->precio * $factorPrecio, 2);
                        $lineas[$p->sku] = [$cant, $precio];
                        $sub += $cant * $precio;
                    }
                    $iva = round($sub * 0.19, 2);
                    $desc = mt_rand(1, 10) === 1 ? round($sub * 0.05, 2) : 0;
                    $total = round($sub + $iva - $desc, 2);
                    $r = mt_rand(1, 100);
                    $pago = $r <= 45 ? 'Efectivo' : ($r <= 80 ? 'Tarjeta' : 'Transferencia');
                    $recibido = $pago === 'Efectivo' ? ceil($total / 1000) * 1000 : $total;

                    $idVenta = DB::table('venta')->insertGetId([
                        'documento_cliente' => $clientes[array_rand($clientes)],
                        'fecha_venta' => $fecha, 'metodo_pago' => $pago,
                        'monto_recibido' => $recibido, 'cambio' => round($recibido - $total, 2),
                        'subtotal' => $sub, 'iva' => $iva, 'descuento' => $desc, 'total' => $total,
                        'created_at' => $fecha, 'updated_at' => $fecha,
                    ], 'id_venta');

                    foreach ($lineas as $sku => [$cant, $precio]) {
                        $detalles[] = ['id_venta' => $idVenta, 'sku_producto' => $sku, 'cantidad' => $cant,
                            'precio_unitario' => $precio, 'subtotal' => round($cant * $precio, 2), 'estado_venta' => 'activa'];
                        $movs[] = ['fecha_movimiento' => $fecha, 'cantidad' => $cant, 'estado' => 'activo',
                            'id_tipo_movimiento' => $salida, 'sku_producto' => $sku, 'id_venta' => $idVenta, 'id_compra' => null];
                    }
                    $subtotalMes += $sub;
                    $nVentas++;
                }
                $vendido += $subtotalMes;

                // Compras: entre 55% y 75% de lo vendido ese mes, para que las gráficas muestren margen.
                if ($conCompras) {
                    $objetivo = $subtotalMes * mt_rand(55, 75) / 100;
                    $acumulado = 0;
                    $guard = 0;
                    while ($acumulado < $objetivo && $guard++ < 15) {
                        $nit = $porProveedor->keys()->random();
                        $items = $porProveedor[$nit]->random(min(mt_rand(1, 4), $porProveedor[$nit]->count()));
                        $fechaC = $mes->copy()->day(mt_rand(1, $dias))->setTime(mt_rand(8, 17), mt_rand(0, 59));
                        if ($fechaC->isFuture()) $fechaC = $hoy->copy()->subHours(2);

                        $lineasC = [];
                        $totalC = 0;
                        foreach ($items as $p) {
                            $cant = mt_rand(5, 40);
                            $costo = round($p->precio_compra * $factorPrecio, 2);
                            $lineasC[] = [$p->sku, $cant, $costo];
                            $totalC += $cant * $costo;
                        }
                        $idCompra = DB::table('compra_proveedor')->insertGetId([
                            'total_compra' => round($totalC, 2), 'estado' => 'recibida', 'nit_proveedor' => $nit,
                            'created_at' => $fechaC, 'updated_at' => $fechaC,
                        ], 'id_compra');
                        foreach ($lineasC as [$sku, $cant, $costo]) {
                            $detCompra[] = ['id_compra' => $idCompra, 'sku_producto' => $sku, 'cantidad_solicitada' => $cant,
                                'costo_unitario' => $costo, 'subtotal' => round($cant * $costo, 2),
                                'created_at' => $fechaC, 'updated_at' => $fechaC];
                            $movs[] = ['fecha_movimiento' => $fechaC, 'cantidad' => $cant, 'estado' => 'activo',
                                'id_tipo_movimiento' => $entrada, 'sku_producto' => $sku, 'id_compra' => $idCompra, 'id_venta' => null];
                        }
                        $acumulado += $totalC;
                        $nCompras++;
                    }
                }

                $this->insertar('detalle_venta', $detalles);
                $this->insertar('detalle_compra', $detCompra);
                $this->insertar('movimientos', $movs);
                $bar->advance();
            }
        });

        $bar->finish();
        $this->newLine(2);
        $this->info("Listo: {$nVentas} ventas" . ($conCompras ? " y {$nCompras} compras" : '') . " generadas desde {$ini->year}.");
        $this->line('Total vendido (sin IVA): $' . number_format($vendido, 0, ',', '.'));
        $this->line('El stock actual de los productos no se modificó.');
        return self::SUCCESS;
    }

    private function tipo(string $nombre, string $descripcion): int
    {
        return DB::table('tipo_movimiento')->where('nombre', $nombre)->value('id_tipo_movimiento')
            ?? DB::table('tipo_movimiento')->insertGetId(['nombre' => $nombre, 'descripcion' => $descripcion], 'id_tipo_movimiento');
    }

    private function insertar(string $tabla, array $filas): void
    {
        foreach (array_chunk($filas, 500) as $lote) {
            DB::table($tabla)->insert($lote);
        }
    }
}