<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokGudang extends Model
{
    use HasFactory;

    protected $table = 'stok_gudangs';
    
    protected $fillable = ['produk_id', 'gudang_id', 'kuantitas'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }
}