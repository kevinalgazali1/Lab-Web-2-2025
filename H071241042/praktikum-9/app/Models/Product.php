<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi 1:1 ke ProductDetail
    public function detail()
    {
        return $this->hasOne(ProductDetail::class);
    }

    // Relasi Many-to-Many ke Warehouse melalui product_warehouse
    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'product_warehouse')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    // Accessor untuk nama kategori
    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->name : 'No Category';
    }
}