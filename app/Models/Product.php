<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'category_id',
        'stock' // Ensure stock is included
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        // Customize the data array for database search
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'is_active' => $this->is_active,
        ];
    }
}
