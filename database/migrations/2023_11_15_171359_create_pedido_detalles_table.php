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
        Schema::create('pedido_detalles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal('costo_unitario', 10, 2); 
            $table->decimal('cantidad', 6, 2); 
            $table->string('detalle',200)->nullable(); 
            $table->unsignedBigInteger('articulo_id');
            $table->unsignedBigInteger('pedido_id');
            $table->foreign('articulo_id')->references('id')->on('articulos');
            $table->foreign('pedido_id')->references('id')->on('pedidos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_detalles');
    }
};
