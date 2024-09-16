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
        Schema::create('envios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->tinyInteger('estado')->default(1)->comment('0=recogido,1=entregado');
            $table->string('distrito',200); 
            $table->string('direccion',200);    
            $table->string('referencia',200)->nullable();    
            $table->tinyInteger('tipo_doc')->default(1)->comment('0=dni,1=Carnet');
            $table->string('num_doc',13);    
            $table->string('apellidos',120);    
            $table->string('nombres',120);  
            $table->string('celular',18); 
            $table->unsignedBigInteger('pedido_id');
            $table->foreign('pedido_id')->references('id')->on('pedidos'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envios');
    }
};
