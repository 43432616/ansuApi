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
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre');
            $table->text('descripcion');
            $table->decimal('precio', 8, 2);
            $table->decimal('oferta', 8, 2)->nullable();
            $table->text('url');
            $table->integer('cantidad_stock');
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('almacen_id');
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->foreign('almacen_id')->references('id')->on('almacens');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos');
    }
};
