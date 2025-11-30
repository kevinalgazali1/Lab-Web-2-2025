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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id(); // bigint, PRIMARY KEY, AUTO INCREMENT 
            // Foreign Key ke products.id dengan constraint UNIQUE (1:1 Relasi)
            $table->foreignId('product_id')
                ->unique() // Memastikan relasi 1:1 
                ->constrained('products')
                ->onDelete('cascade'); // Relasi 1:1, onDelete 'cascade' 
            $table->text('description')->nullable(); // text, NULLABLE 
            $table->decimal('weight', 8, 2)->notNull(); // decimal(8,2), NOT NULL 
            $table->string('size', 255)->nullable(); // varchar(255), NULLABLE 
            $table->timestamps(); // created_at dan updated_at 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};