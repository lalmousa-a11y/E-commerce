<?php

namespace App\Contracts\Product;

interface ProductApprovalInterface
{
    public function approve(int $productId);
    public function reject(int $productId, string $reason);
    public function getPendingApprovals();
}
