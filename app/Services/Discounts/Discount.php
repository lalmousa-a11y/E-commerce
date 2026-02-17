<?php

namespace App\Services\Discounts;

abstract class Discount
{
    protected $name;
    protected $description;

    abstract public function calculate(float $amount): float;
    
    public function apply(float $amount): float
    {
        $discount = $this->calculate($amount);
        
        // Ensure discount never exceeds amount (LSP guarantee)
        return min($discount, $amount);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
