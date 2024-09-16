<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PersonaController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('clientes/login',[ClienteController::class,'login']);
    Route::post('clientes/register',[ClienteController::class,'register']);
    Route::post('personas/busca',[PersonaController::class,'buscarPersona']);
    Route::post('refresh', 'refresh');
    Route::post('pago/token', [PedidoController::class,'generaTokenPago']);
    Route::post('pago/validate', [PedidoController::class,'validarPago']);
    Route::get('pedidos/pdf', [PedidoController::class,'generaPdfPedido']);
    Route::post('pedidos/almacen', [PedidoController::class,'seleccionaAlmacen']);
    Route::resource('pedidos', PedidoController::class);
    Route::resource('articulos', ArticuloController::class)->only(['index']);
    Route::resource('categorias', CategoriaController::class)->only(['index']);
    Route::resource('almacens', AlmacenController::class)->only(['index']);
});

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::resource('categorias', CategoriaController::class)->except(['index']);
    Route::resource('users', UserController::class);
    Route::resource('almacens', AlmacenController::class)->except(['index']);
    Route::resource('articulos', ArticuloController::class)->except(['index']);
    Route::put('/resetpassword/{user}',[UserController::class,'resetPassword'])->name('users.resetpassword');
});

Route::middleware('auth:cliente')->group(function () {
    // Rutas protegidas para clientes
    Route::resource('clientes', ClienteController::class);
});