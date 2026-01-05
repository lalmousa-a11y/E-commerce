<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Resources\ProductResource;
use App\Models\File;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;






class ProductController extends Controller
{
     public function myProducts()
    {
        $products = Product::where('seller_id', auth()->id())
            ->with(['category', 'seller'])
            ->get();


        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest  $request)
    {

        
    $product = Product::create([
        'name' => $request['name'],
        'description' => $request['description'] ?? null,
        'price' => $request['price'],
        'seller_id' => $request['seller_id'],
        'category_id' => $request['category_id'],
    ]);
    $path = $request->file('file')->store('products', 'public');

  File::create([
    'files' => $path,
    'product_id' => $product->id, 
]);


return new ProductResource($product->load(['category', 'seller', 'files']));

}
        public function show(Product $product)
    {
return new ProductResource($product->load(['category', 'seller', 'files']));

    }
 public function update(UpdateProductRequest $request, Product $product)
{
    if ($product->seller_id !== auth()->id()) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $product->update($request);

    if ($request->hasFile('file')) {

        $oldFile = $product->files()->first();

        if ($oldFile) {
            Storage::disk('public')->delete($oldFile->files);

            $oldFile->delete();
        }

        $path = $request->file('file')->store('products', 'public');

        File::create([
            'files' => $path,
            'product_id' => $product->id,
        ]);
    }

    return new ProductResource($product->load(['category', 'seller', 'files']));
}

    public function destroy(Product $product)
    {
        if ($product->seller_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
public function approveProduct($product_id)
{
    $product = Product::find($product_id);

    if ($product) {
        $product->is_approved = 1;
        $product->save();

        return response()->json([
            'message' => 'Product approved successfully',
            'product' => new ProductResource($product->load('files', 'category', 'seller'))
        ]);
    }

    return response()->json(['message' => 'Product not found'], 404);
}

public function disapproveProduct($product_id)
{
    $product = Product::find($product_id);

    if ($product) {
        $product->is_approved = 0;
        $product->save();

        return response()->json([
            'message' => 'Product disapproved successfully',
            'product' => new ProductResource($product->load('files', 'category', 'seller'))
        ]);
    }

    return response()->json(['message' => 'Product not found'], 404);
}
public function  AllApprovedProducts() 
{
    $products = Product::with(['category', 'seller', 'files'])
        ->where('is_approved', 1)
        ->get();

    return ProductResource::collection($products);
}
public function AllDisapprovedProducts() 
{
    $products = Product::with(['category', 'seller', 'files'])
        ->where('is_approved', 0)
        ->get();

    return ProductResource::collection($products);
}


}

    

