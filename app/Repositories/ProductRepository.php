<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function all(): Collection
    {
        return Product::with(['category', 'seller', 'files'])->get();
    }

    public function find(int $id): ?Product
    {
        return Product::with(['category', 'seller', 'files'])->find($id);
    }

    public function findBySeller(int $sellerId): Collection
    {
        return Product::where('seller_id', $sellerId)
            ->with(['category', 'seller', 'files'])
            ->get();
    }

    public function findApproved(): Collection
    {
        return Product::where('is_approved', true)
            ->with(['category', 'seller', 'files'])
            ->get();
    }

    public function findDisapproved(): Collection
    {
        return Product::where('is_approved', false)
            ->with(['category', 'seller', 'files'])
            ->get();
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product->fresh(['category', 'seller', 'files']);
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    public function approve(Product $product): Product
    {
        $product->update(['is_approved' => true]);
        return $product->fresh(['category', 'seller', 'files']);
    }

    public function disapprove(Product $product): Product
    {
        $product->update(['is_approved' => false]);
        return $product->fresh(['category', 'seller', 'files']);
    }
}
