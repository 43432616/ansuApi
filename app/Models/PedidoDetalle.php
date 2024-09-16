<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoDetalle extends Model
{
    use HasFactory;
    protected $fillable = [
        'costo_unitario',
        'cantidad',
        'detalle',
        'articulo_id',
        'pedido_id'
    ];
    public function articulo (){
        return $this->belongsTo(Articulo::class,'articulo_id');
    }
}
