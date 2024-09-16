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
        Schema::create('almacens', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre',200);
            $table->string('direccion',100);
            $table->string('descripcion',600)->nullable();
            $table->string('telefono',9);
            $table->tinyInteger('estado')->default(1)->comment('0=inactivo,1=activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('almacens');
    }
};
