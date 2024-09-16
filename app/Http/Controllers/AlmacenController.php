<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $alamcens = Almacen::get();
        return response()->json([
            'success' => true,
            'data' => $alamcens,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nombre' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'estado' => 'required',
        ]);

        $almacen = Almacen::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado,
        ]);

        return response()->json($almacen, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Almacen $almacen)
    {
        //
        return response()->json([
            'success' => true,
            'data' => $almacen,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Almacen $almacen)
    {
        //
        $request->validate([
            'nombre' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'estado' => 'required',
        ]);
        $almacen->nombre=$request->nombre;
        $almacen->descripcion=$request->descripcion;
        $almacen->direccion=$request->direccion;
        $almacen->estado=$request->estado;
        $almacen->telefono=$request->telefono;
        $almacen->save();
    
        return response()->json([
            'success' => true,
            'data' => $almacen,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Almacen $almacen)
    {
        //
        $almacen->delete();
        return response()->json([
            'success' => true,
            'message' => 'El almace se ha eliminado correctamente.',
        ]);
    }
}
