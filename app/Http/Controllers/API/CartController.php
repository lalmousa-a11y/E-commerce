<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use App\Http\Resources\CartItemResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddToCartRequest;

class CartController extends Controller
{
      public function addToCart(AddToCartRequest  $request)
    {
        
        $item = CartItem::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($item) {
            $item->increment('qty', $request->qty);
        } else {
            CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'qty' => $request->qty
            ]);
        }

        return response()->json(['message' => 'Product added to cart']);
    }
    public function updateQty(AddToCartRequest $request, $id)
    {
        $item = CartItem::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $item->update(['qty' => $request->qty]);

        return response()->json(['message' => 'Quantity updated']);
    }

     public function removeItem($id)
    {
        CartItem::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        return response()->json(['message' => 'Item removed']);
    }
 public function cart()
    {
        $items = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->get();

        $total = $items->sum(function ($item) {
            return $item->product->price * $item->qty;
        });

         return response()->json([
        'items' => CartItemResource::collection($items),
        'total' => $total
    ]);
    }
}
