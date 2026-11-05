<?php

namespace App\Interfaces;

interface BaseInterface
{
    public function getAll();
    public function getById(int|string $id);
    public function create(array $data);
    public function update(int|string $id, array $data);
    public function delete(int|string $id);
}