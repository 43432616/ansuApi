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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('numero')->nullable();
            $table->tinyInteger('estado')->default(1)->comment('0=inactivo,1=activo');
            $table->tinyInteger('tipo_entrega')->default(1)->comment('0=recojo,1=envio');
            $table->tinyInteger('forma_pago')->default(1)->comment('0=online,1=contraentrega');
            $table->string('numero_operacion')->nullable();
            $table->dateTime('fecha_pedido');
            $table->date('fecha_entrega')->nullable();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->decimal('costo_envio', 6, 2)->nullable(); // Campo decimal con 6 dígitos en total, 2 dígitos para decimales
            $table->unsignedBigInteger('almacen_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('almacen_id')->references('id')->on('almacens');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
