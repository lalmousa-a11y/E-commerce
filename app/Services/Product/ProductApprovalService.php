<?php

namespace App\Services\Product;

use App\Contracts\Product\ProductApprovalInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductApprovalService implements ProductApprovalInterface
{
    public function approve(int $productId)
    {
        $product = Product::findOrFail($productId);
        $product->update(['is_approved' => true]);
        
        Log::info("Product {$productId} approved by admin");
        
        return $product;
    }

    public function reject(int $productId, string $reason)
    {
        $product = Product::findOrFail($productId);
        $product->update([
            'is_approved' => false,
            'rejection_reason' => $reason,
        ]);
        
        Log::info("Product {$productId} rejected: {$reason}");
        
        return $product;
    }

    public function getPendingApprovals()
    {
        return Product::whereNull('is_approved')
            ->orWhere('is_approved', false)
            ->with(['category', 'seller'])
            ->get();
    }
}
