<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
        protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'seller_id',
        'status',
    ];

 public function seller()
{
    return $this->belongsTo(Seller::class, 'seller_id', 'id');
}

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
public function files()
{
    return $this->hasMany(File::class);
}
public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

}
