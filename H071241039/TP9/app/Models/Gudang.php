<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    use HasFactory;

    protected $table = 'gudangs';
    
    protected $fillable = ['nama', 'lokasi'];

    public function produks()
    {
        return $this->belongsToMany(Produk::class, 'stok_gudangs', 'gudang_id', 'produk_id')
                    ->withPivot('kuantitas');
    }
}