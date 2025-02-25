<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::get();
        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'dni' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'dni' => $request->dni,
            'password' => Hash::make($request->password),
        ]);
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        return response()->json([
            'success' => true,
            'data' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
        $request->validate([
            'name' => 'required',
            'dni' => 'required',
            'email' => 'required',
            'estado' => 'required',
        ]);
        $user->name=$request->name;
        $user->dni=$request->dni;
        $user->email=$request->email;
        $user->estado=$request->estado;
        $user->save();
    
        return response()->json([
            'success' => true,
            'data' => $user,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'El usuario se ha eliminado correctamente.',
        ]);
    }
    public function resetPassword(Request $request, User $user)
    {
        $user->password=Hash::make($user->dni);
        $user->save();
    
        return response()->json([
            'success' => true,
            'data' => $user,
        ], 200);
    }
}
