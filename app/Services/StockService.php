<?php

namespace App\Services;

use App\Interfaces\StockInterface;
use App\Models\SolicitudStock;
use App\Models\Usuario;
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
        return $this->stockRepository->findLowStock();
    }

    public function procesarAlertasYSolicitudesStock()
    {
        $itemsBajos = $this->stockRepository->findLowStockUnnotified();

        if ($itemsBajos->isEmpty()) {
            return $itemsBajos;
        }

        $admin = Usuario::find(1); 

        foreach ($itemsBajos as $stock) {
            
            if ($admin) {
                $admin->notify(new StockLowNotification($stock));
            }

            $this->stockRepository->update($stock->id_compra, ['notificado' => true]);

            $existeSolicitud = SolicitudStock::where('stock', $stock->id_compra)
                ->where('estado', 'pendiente')
                ->exists();

            if (!$existeSolicitud) {
                SolicitudStock::create([
                    'stock' => $stock->id_compra,
                    'cantidad_solicitada' => $stock->cantidad_min_stock, 
                    'estado' => 'pendiente' 
                ]);
            }
        }

        return $itemsBajos;
    }
}
