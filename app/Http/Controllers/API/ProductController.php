<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use App\Models\Product;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function myProducts()
    {
        $products = $this->productService->getSellerProducts(auth()->id());
        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->createProduct(
            $request->validated(),
            $request->file('file')
        );

        return new ProductResource($product->load(['category', 'seller', 'files']));
    }

    public function show(Product $product)
    {
        return new ProductResource($product->load(['category', 'seller', 'files']));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $product = $this->productService->updateProduct(
            $product,
            $request->validated(),
            $request->file('file')
        );

        return new ProductResource($product);
    }

    public function approveProduct(Product $product)
    {
        $product = $this->productService->approveProduct($product);
        return new ProductResource($product);
    }

    public function disapproveProduct(Product $product)
    {
        $product = $this->productService->disapproveProduct($product);
        return new ProductResource($product);
    }
}
