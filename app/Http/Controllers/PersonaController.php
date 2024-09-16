<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Persona $persona)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Persona $persona)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Persona $persona)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Persona $persona)
    {
        //
    }
    public function buscarPersona(Request $request){
        $numero=$request->numero;
        $persona=Persona::where('numdoc','=',$numero)->first();
        if (!$persona) {
            $persona = $this->consultaReniec($numero);
            return $persona;
        }else{
            return $persona;
        }
    }
    public function consultaReniec($numero){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://my.apidevs.pro/api/dni/" . $numero . "?api_token=744a3e902cdf9cad147e0bf2c04fe360c4c3e4e848bbeab116e21538f7f6fd36",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
    
        if ($err) {
            echo "cURL Error #:" . $err;
            return null;
        }
    
        $data = json_decode($response)->data; // Acceder directamente a 'data'
    
        $persona = new Persona;
        $persona->numdoc = $data->numero;
        $persona->apellidos = $data->apellido_paterno. ' ' .$data->apellido_materno;
        $persona->nombres = $data->nombres;
        $persona->tipodoc = '1';
        $persona->fnac = $data->fecha_nacimiento;
        $persona->save();
        return $persona;
    }
}
