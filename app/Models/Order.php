<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status'
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the products for the order.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}