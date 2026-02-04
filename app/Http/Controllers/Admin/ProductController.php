<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProductStatusRequest;

class ProductController extends Controller
{
 
    public function index(Request $request)
    {
        $query = Product::with(['category', 'seller', 'files']);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('seller_id') && $request->seller_id) {
            $query->where('seller_id', $request->seller_id);
        }

        $products = $query->latest()
            ->paginate(20)
            ->appends($request->query());

        $categories = Category::all();
        $sellers = User::where('user_type', 'seller')->get();

        return view('admin.products.index', compact('products', 'categories', 'sellers'));
    }

 
    public function show(Product $product)
    {
        $product->load(['category', 'seller', 'files']);

        return view('admin.products.show', compact('product'));
    }

   
    public function updateStatus(UpdateProductStatusRequest $request, Product $product)
    {
     
        $product->update(['status' => $request->status]);

        return back()->with('success', 'updated successfully ');
    }

  
    public function destroy(Product $product)
    {
        foreach ($product->files as $file) {
            if ($file->files && Storage::disk('public')->exists($file->files)) {
                Storage::disk('public')->delete($file->files);
            }
            $file->delete();
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', ' Product deleted successfully');
    }

}