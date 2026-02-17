<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(array $data, $file = null): Product
    {
        $product = $this->productRepository->create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'seller_id' => $data['seller_id'],
            'category_id' => $data['category_id'],
        ]);

        if ($file) {
            $this->attachFile($product, $file);
        }

        return $product;
    }

    public function updateProduct(Product $product, array $data, $file = null): Product
    {
        $product = $this->productRepository->update($product, $data);

        if ($file) {
            $this->replaceFile($product, $file);
        }

        return $product;
    }

    protected function attachFile(Product $product, $file): void
    {
        $path = $file->store('products', 'public');
        
        File::create([
            'files' => $path,
            'product_id' => $product->id,
        ]);
    }

    protected function replaceFile(Product $product, $file): void
    {
        $oldFile = $product->files()->first();

        if ($oldFile) {
            Storage::disk('public')->delete($oldFile->files);
            $oldFile->delete();
        }

        $this->attachFile($product, $file);
    }

    public function getSellerProducts(int $sellerId)
    {
        return $this->productRepository->findBySeller($sellerId);
    }

    public function approveProduct(Product $product): Product
    {
        return $this->productRepository->approve($product);
    }

    public function disapproveProduct(Product $product): Product
    {
        return $this->productRepository->disapprove($product);
    }
}
