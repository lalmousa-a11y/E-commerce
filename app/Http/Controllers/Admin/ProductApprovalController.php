<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\Product\ProductApprovalInterface;
use Illuminate\Http\Request;

class ProductApprovalController extends Controller
{
    protected $approvalService;

    // Only needs approval interface
    public function __construct(ProductApprovalInterface $approvalService)
    {
        $this->approvalService = $approvalService;
    }

    public function pending()
    {
        $products = $this->approvalService->getPendingApprovals();
        return response()->json($products);
    }

    public function approve($id)
    {
        $product = $this->approvalService->approve($id);
        return response()->json(['message' => 'Product approved', 'product' => $product]);
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['reason' => 'required|string']);
        
        $product = $this->approvalService->reject($id, $request->reason);
        return response()->json(['message' => 'Product rejected', 'product' => $product]);
    }
}
