<?php

namespace App\Contracts\Product;

interface ProductCrudInterface
{
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function find(int $id);
}
