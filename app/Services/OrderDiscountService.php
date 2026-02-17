<?php

namespace App\Services;

use App\Services\Discounts\Discount;
use App\Models\Order;

class OrderDiscountService
{
    public function applyDiscount(Order $order, Discount $discount): float
    {
        $discountAmount = $discount->apply($order->total_amount);
        
        $order->update([
            'discount_amount' => $discountAmount,
            'discount_name' => $discount->getName(),
            'final_amount' => $order->total_amount - $discountAmount,
        ]);

        return $discountAmount;
    }

    public function applyMultipleDiscounts(Order $order, array $discounts): float
    {
        $totalDiscount = 0;
        $remainingAmount = $order->total_amount;

        foreach ($discounts as $discount) {
            if (!$discount instanceof Discount) {
                throw new \InvalidArgumentException('All items must be Discount instances');
            }

            $discountAmount = $discount->apply($remainingAmount);
            $totalDiscount += $discountAmount;
            $remainingAmount -= $discountAmount;
        }

        $order->update([
            'discount_amount' => $totalDiscount,
            'final_amount' => $remainingAmount,
        ]);

        return $totalDiscount;
    }
}
