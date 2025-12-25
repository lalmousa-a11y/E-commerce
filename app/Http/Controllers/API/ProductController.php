<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Resources\ProductResource;
use App\Models\ProductImage;





class ProductController extends Controller
{
     public function myProducts()
    {
        $products = Product::where('seller_id', auth()->id())
            ->with(['category', 'seller'])
            ->get();


        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
        'name' => 'required|string|max:100',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'category_id' => 'required|exists:categories,id',
        'image' => 'required|url'
        
    ]);

     $category = Category::where('id', $data['category_id'])->first();

     if (!$category) {
    return response()->json(['message' => 'Category not found'], 404);
}


    $data['seller_id'] = auth()->id();
    $data['category_id'] = $category->id;

    $product = Product::create([
        'name' => $data['name'],
        'description' => $data['description'] ?? null,
        'price' => $data['price'],
        'seller_id' => $data['seller_id'],
        'category_id' => $data['category_id'],
    ]);
        ProductImage::create([
        'product_id' => $product->id,
        'image_path' => $data['image'],
    ]);


return new ProductResource($product->load(['category', 'seller', 'images']));

}
        public function show(Product $product)
    {
return new ProductResource($product->load(['category', 'seller', 'images']));

    }
      public function update(Request $request, Product $product)
    {
        if ($product->seller_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'name' => 'sometimes|string|max:100',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric',
            'category_id' => 'sometimes|exists:categories,id',

        ]);

        $product->update($data);

        return new ProductResource($product->load(['category', 'seller', 'images']));
    }

    public function destroy(Product $product)
    {
        if ($product->seller_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}

    

