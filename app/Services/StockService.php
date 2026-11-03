<?php

namespace App\Services;

use App\Interfaces\StockInterface;
use App\Models\SolicitudStock;

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

    public function getLowStock()
    {
        $itemsBajos = $this->stockRepository->findLowStock();

        if ($itemsBajos->isEmpty()) {
            return $itemsBajos;
        }

        foreach ($itemsBajos as $stock) {
            $existeSolicitud = SolicitudStock::where('stock', $stock->id_compra)
                ->where('estado', 'pendiente')
                ->exists();

            if (!$existeSolicitud) {
                SolicitudStock::create([
                    'stock' => $stock->id_compra,
                    'cantidad_solicitada' => $stock->cantidad_min_stock * 2,  
                    'estado' => 'pendiente' 
                ]);
            }
        }

        return $itemsBajos;
    }
}