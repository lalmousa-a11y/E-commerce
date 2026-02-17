<?php

namespace App\Services\Discounts;

class BuyOneGetOneDiscount extends Discount
{
    public function __construct(string $name = 'BOGO')
    {
        $this->name = $name;
        $this->description = "Buy one get one 50% off";
    }

    public function calculate(float $amount): float
    {
        // 50% discount (simplified for demonstration)
        return $amount * 0.25;
    }
}
