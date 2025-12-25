<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;

class ProductImageController extends Controller
{
    public function store(Request $request, Product $product)
    {
        if ($product->seller_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'image' => 'required|url', 
        ]);

        $image = ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $request->image,
        ]);

        return response()->json([
            'message' => 'Image added successfully',
            'image' => $image
        ], 201);
    }
}