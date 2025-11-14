<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductWarehouse extends Model
{
    /**
     * Menunjukkan bahwa ini adalah tabel pivot.
     */
    protected $table = 'products_warehouses';

    /**
     * Nonaktifkan timestamps.
     */
    public $timestamps = false;

    /**
     * Kolom yang boleh diisi.
     */
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity'
    ];

    // Relasi (ini tetap sama dan bagus)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
