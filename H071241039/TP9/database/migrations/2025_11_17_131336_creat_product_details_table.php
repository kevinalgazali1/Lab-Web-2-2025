<?php
// database/migrations/2025_11_17_131336_create_product_details_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->unique()->constrained('produks')->onDelete('cascade');
            $table->text('deskripsi')->nullable();
            $table->decimal('berat', 8, 2);
            $table->string('ukuran', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_produks');
    }
};