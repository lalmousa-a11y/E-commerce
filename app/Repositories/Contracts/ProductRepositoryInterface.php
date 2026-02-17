<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Product;
    public function findBySeller(int $sellerId): Collection;
    public function findApproved(): Collection;
    public function findDisapproved(): Collection;
    public function create(array $data): Product;
    public function update(Product $product, array $data): Product;
    public function delete(Product $product): bool;
    public function approve(Product $product): Product;
    public function disapprove(Product $product): Product;
}
