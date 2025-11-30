<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_warehouse', function (Blueprint $table) {
            // Tidak ada id() karena ini pivot table
            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('cascade'); // Relasi N:M, onDelete 'cascade' 
            $table->foreignId('warehouse_id')
                ->constrained('warehouses')
                ->onDelete('cascade'); // Relasi N:M, onDelete 'cascade' 
            $table->integer('quantity')->default(0); // integer, DEFAULT 0 
            $table->primary(['product_id', 'warehouse_id']); // Composite Primary Key 
            // Tidak ada timestamps karena data pivot biasanya tidak memerlukannya
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_warehouse');
    }
};