<?php

namespace App\Services;

use App\Interfaces\ClienteInterface;

class ClienteService
{
    protected ClienteInterface $clienteRepository;

    public function __construct(ClienteInterface $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function listarClientes()
    {
        return $this->clienteRepository->getAll();
    }

    public function obtenerClientePorId(string $numero_documento)
    {
        return $this->clienteRepository->getById($numero_documento);
    }

    public function buscarClientesPorNombre(string $nombre)
    {
        return $this->clienteRepository->findByNombre($nombre);
    }

    public function crearCliente(array $data)
    {
        return $this->clienteRepository->create($data);
    }

    public function actualizarCliente(string $numero_documento, array $data)
    {
        return $this->clienteRepository->update($numero_documento, $data);
    }

    public function eliminarCliente(string $numero_documento)
    {
        return $this->clienteRepository->delete($numero_documento);
    }
}