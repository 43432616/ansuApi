<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class ClienteController extends Controller
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
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = auth('cliente')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
        // Obtiene la fecha y hora actual
        $now = Carbon::now();
        // Obtiene la fecha y hora de expiración sumando el tiempo de expiración configurado
        $expiration = $now->addMinutes(config('jwt.ttl'));
        // Calcula el tiempo de expiración en segundos
        $cliente=Auth::guard('cliente')->user();
        $clienteConPersona = $cliente->load('persona');
        return response()->json([
                'status' => 'success',
                'cliente' => $clienteConPersona,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                    'expires_in' => $expiration, // Agrega el tiempo de expiración
                ]
            ], 200);
    }
    public function register(Request $request)
    {
        //
        $request->validate([
            'celular' => 'required',
            'correo' => 'required|unique:clientes,email',
            'password' => 'required',
            'persona_id' => 'required',
        ]);

        $cliente = Cliente::create([
            'celular' => $request->celular,
            'email' => $request->correo,
            'persona_id'=>$request->persona_id,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($cliente, 201);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'celular' => 'required',
            'correo' => 'required|unique:clientes,numdoc',
            'password' => 'required',
            'persona_id' => 'required',
        ]);
        $cliente = Cliente::create([
            'persona_id'=>$request->persona_id,
            'celular' => $request->celular,
            'email' => $request->correo,
            'password' => Hash::make($request->password),
        ]);
        return response()->json($cliente, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Clientes $clientes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clientes $clientes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clientes $clientes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clientes $clientes)
    {
        //
    }
    

}
