<?php

namespace App\Services\Discounts;

class FixedAmountDiscount extends Discount
{
    protected $fixedAmount;

    public function __construct(float $fixedAmount, string $name = 'Fixed Discount')
    {
        $this->fixedAmount = $fixedAmount;
        $this->name = $name;
        $this->description = "$" . number_format($fixedAmount, 2) . " off";
    }

    public function calculate(float $amount): float
    {
        return $this->fixedAmount;
    }
}
