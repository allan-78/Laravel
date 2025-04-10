<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const STATUSES = [
        'pending' => 'pending',
        'failed' => 'failed',
        'completed' => 'completed',
        'refunded' => 'refunded'
    ];

    protected $fillable = ['user_id', 'product_id', 'quantity', 'total_price', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}