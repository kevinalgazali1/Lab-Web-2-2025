<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';
    
    protected $fillable = ['nama', 'harga', 'kategori_id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function detailProduk()
    {
        return $this->hasOne(DetailProduk::class, 'produk_id');
    }

    public function gudangs()
    {
        return $this->belongsToMany(Gudang::class, 'stok_gudangs', 'produk_id', 'gudang_id')
                    ->withPivot('kuantitas');
    }
}