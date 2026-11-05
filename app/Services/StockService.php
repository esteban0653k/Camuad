<?php

namespace App\Services;

use App\Interfaces\StockInterface;
use App\Models\SolicitudStock;
use App\Models\Usuario;
use App\Models\Stock;
use App\Notifications\StockLowNotification;

class StockService
{
    protected StockInterface $stockRepository;

    public function __construct(StockInterface $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    public function getAll()
    {
        return $this->stockRepository->getAll();  
    }

    public function getById(string $id)
    {
        return $this->stockRepository->getById($id);  
    }

    public function create(array $data)
    {
        return $this->stockRepository->create($data); 
    }

    public function update(string $id, array $data)
    {
        $currentStock = $this->stockRepository->getById($id);

        if ($currentStock && isset($data['cantidad'])) {
            $minStock = $data['cantidad_min_stock'] ?? $currentStock->cantidad_min_stock;
            if ($data['cantidad'] > $minStock) {
                $data['notificado'] = false;
            }
        }

       return $this->stockRepository->update($id, $data);
    }

    public function delete(string $id)
    {
        return $this->stockRepository->delete($id);
    }

    public function listarStockActivo()
    {
        return $this->stockRepository->findByActivo(true);
    }
    
    public function verificarStockBajo()
    {
        return Stock::whereColumn('cantidad', '<=', 'cantidad_min_stock')->get();
    }

    public function procesarAlertasYSolicitudesStock()
    {
        $itemsBajos = Stock::whereColumn('cantidad', '<=', 'cantidad_min_stock')
                           ->where('notificado', false)
                           ->get();

        if ($itemsBajos->isEmpty()) {
            return $itemsBajos;
        }

        $admin = Usuario::find(1); 

        foreach ($itemsBajos as $stock) {
            
            if ($admin) {
                try {
                    $admin->notify(new StockLowNotification($stock));
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 'error',
                        'mensaje' => 'Fallo al enviar el correo mediante Gmail SMTP',
                        'error_detallado' => $e->getMessage()
                    ], 500);
                }
            }

            $stock->update(['notificado' => true]);

            $existeSolicitud = SolicitudStock::where('stock', $stock->id_compra)
                ->where('estado', 'pendiente')
                ->exists();

            if (!$existeSolicitud) {
                // Tomamos el nit_proveedor directamente del registro de stock y respaldamos con uno existente si viniera vacío
                $nitProveedor = $stock->nit_proveedor ?? '890123457';

                SolicitudStock::create([
                    'stock' => $stock->id_compra,
                    'fecha_solicitud' => now()->toDateString(), 
                    'prioridad' => 'media',                            
                    'costo_unitario' => 0,                            
                    'total_compra' => 0,                                
                    'cantidad_comprar' => $stock->cantidad_min_stock, 
                    'estado' => 'pendiente',                            
                    'nit_proveedor' => $nitProveedor 
                ]);
            }
        }

        return $itemsBajos;
    }
}