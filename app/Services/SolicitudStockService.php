<?php

namespace App\Services;

use App\Interfaces\SolicitudStockInterface;

class SolicitudStockService
{
    protected SolicitudStockInterface $solicitudStockRepository;

    public function __construct(SolicitudStockInterface $solicitudStockRepository)
    {
        $this->solicitudStockRepository = $solicitudStockRepository;
    }

    public function getAll()
    {
        return $this->solicitudStockRepository->getAll();
    }

    public function getById(string $id)
    {
        return $this->solicitudStockRepository->getById($id);
    }

    public function create(array $data)
    {
        return $this->solicitudStockRepository->create($data);
    }

    public function update(string $id, array $data)
    {
        return $this->solicitudStockRepository->update($id, $data);
    }

    public function delete(string $id)
    {
        return $this->solicitudStockRepository->delete($id);
    }

    public function listarPorProveedor(string $nit)
    {
        return $this->solicitudStockRepository->findByProveedor($nit);
    }

    public function listarPorPrioridad(string $prioridad)
    {
        return $this->solicitudStockRepository->findByPrioridad($prioridad);
    }

    public function listarPorFecha(string $fecha)
    {
        return $this->solicitudStockRepository->findFechaSolicitud($fecha);
    }
}