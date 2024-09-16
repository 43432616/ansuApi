<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $query = Articulo::query();

        // Filtrar por categoría
        if ($request->has('categoria')) {
            $categoria = $request->input('categoria');
            if (!empty($categoria)) {
                $query->where('categoria_id','=',$request->input('categoria'));
            }
        }
        if ($request->has('almacen')) {
            $categoria = $request->input('almacen');
            if (!empty($categoria)) {
                $query->where('almacen_id','=',$request->input('almacen'));
            }
        }
        $articulos = $query->paginate(3);

        return response()->json([
            'success' => true,
            'data' => $articulos,
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
            'descripcion' => 'required',
            'precio' => 'required',
            'url' => 'required',
            'cantidad_stock' => 'required',
            'categoria_id' => 'required',
            'almacen_id' => 'required',
        ]);
        

        $articulo = Articulo::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'oferta'=>$request->oferta,
            'url' => $request->url,
            'cantidad_stock' => $request->cantidad_stock,
            'categoria_id' => $request->categoria_id,
            'almacen_id' => $request->almacen_id,
        ]);
        
        if ($request->hasFile('image')) {
            $imagen = $request->file('image');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $rutaImagen = $imagen->storeAs('imagenes', $nombreImagen, 'public');
            $articulo->url = $rutaImagen;
            $articulo->save();
        }
        return response()->json($articulo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Articulo $articulo)
    {
        //
        return response()->json([
            'success' => true,
            'data' => $articulo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Articulo $articulo)
    {
        //
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required',
            'cantidad_stock' => 'required',
            'categoria_id' => 'required',
            'almacen_id' => 'required',
        ]);
        $articulo->nombre=$request->nombre;
        $articulo->descripcion=$request->descripcion;
        $articulo->precio=$request->precio;
        $articulo->cantidad_stock=$request->cantidad_stock;
        $articulo->categoria_id=$request->categoria_id;
        $articulo->almacen_id=$request->almacen_id;
        $articulo->save();
    
        return response()->json([
            'success' => true,
            'data' => $articulo,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Articulo $articulo)
    {
        //
        $articulo->delete();
        return response()->json([
            'success' => true,
            'message' => 'El articulo se ha eliminado correctamente.',
        ]);
    }
}
