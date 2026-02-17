<?php

namespace App\Services\Product;

use App\Contracts\Product\ProductSearchInterface;
use App\Models\Product;

class ProductSearchService implements ProductSearchInterface
{
    public function search(string $query, array $filters = [])
    {
        $products = Product::query()
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%");

        if (isset($filters['min_price'])) {
            $products->where('price', '>=', $filters['min_price']);
        }

        if (isset($filters['max_price'])) {
            $products->where('price', '<=', $filters['max_price']);
        }

        return $products->with(['category', 'seller'])->get();
    }

    public function searchByCategory(int $categoryId)
    {
        return Product::where('category_id', $categoryId)
            ->with(['category', 'seller'])
            ->get();
    }

    public function searchBySeller(int $sellerId)
    {
        return Product::where('seller_id', $sellerId)
            ->with(['category', 'seller'])
            ->get();
    }
}
