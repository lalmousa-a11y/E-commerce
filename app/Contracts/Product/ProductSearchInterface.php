<?php

namespace App\Contracts\Product;

interface ProductSearchInterface
{
    public function search(string $query, array $filters = []);
    public function searchByCategory(int $categoryId);
    public function searchBySeller(int $sellerId);
}
