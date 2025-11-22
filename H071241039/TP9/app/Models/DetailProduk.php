<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProduk extends Model
{
    use HasFactory;

    protected $table = 'detail_produks';
    
    protected $fillable = ['produk_id', 'deskripsi', 'berat', 'ukuran'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}