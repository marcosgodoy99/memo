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
        Schema::create('lineas_remitos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('quantity')->nullable();
            $table->string('product')->nullable();
            $table->integer('idProduct')->nullable();
            $table->foreignId('remito_id')->constrained()->onDelete('cascade');
            $table->decimal('price')->nullable();
            $table->decimal('subtotal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lineas_remitos');
    }
};
