<?php
// database/migrations/2025_11_17_131251_create_warehouses_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('gudangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->text('lokasi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gudangs');
    }
};