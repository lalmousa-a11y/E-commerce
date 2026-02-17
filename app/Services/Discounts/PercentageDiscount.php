<?php

namespace App\Services\Discounts;

class PercentageDiscount extends Discount
{
    protected $percentage;

    public function __construct(float $percentage, string $name = 'Percentage Discount')
    {
        $this->percentage = $percentage;
        $this->name = $name;
        $this->description = "{$percentage}% off";
    }

    public function calculate(float $amount): float
    {
        return $amount * ($this->percentage / 100);
    }
}
