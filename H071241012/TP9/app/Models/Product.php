<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price', 'category_id'];

    public function detail()
    {
        return $this->hasOne(ProductDetail::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'product_warehouse', 'product_id', 'warehouse_id')
                    ->withPivot('quantity');
    }
}