<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;
    protected $fillable=['nombre','descripcion','precio','oferta','url','cantidad_stock','categoria_id','almacen_id'];
}
