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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // bigint, PRIMARY KEY, AUTO INCREMENT 
            $table->string('name', 255)->notNull(); // varchar(255), NOT NULL 
            $table->decimal('price', 15, 2)->notNull(); // decimal(15,2), NOT NULL 
            // Foreign Key ke categories.id
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->onDelete('set null'); // Relasi 1:N, onDelete 'set null' 
            $table->timestamps(); // created_at dan updated_at 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};