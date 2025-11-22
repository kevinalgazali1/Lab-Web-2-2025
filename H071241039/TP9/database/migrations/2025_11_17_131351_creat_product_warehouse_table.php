<?php
// database/migrations/2025_11_17_131351_create_product_warehouse_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stok_gudangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->foreignId('gudang_id')->constrained('gudangs')->onDelete('cascade');
            $table->integer('kuantitas')->default(0);
            $table->timestamps();
            
            $table->unique(['produk_id', 'gudang_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('stok_gudangs');
    }
};