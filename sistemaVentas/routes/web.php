<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('template');
});

Route::view('/panel','panel.index')->name('panel');
Route::view('/categorias','categoria.index');
Route::resource('categorias', CategoriaController::class);



Route::view('/marcas','marca.index');
Route::resource('marcas', MarcaController::class);




Route::view('/productos','producto.index');
Route::resource('productos', ProductoController::class);




Route::view('/clientes','cliente.index');
Route::resource('clientes', ClienteController::class);



Route::view('/proveedores', 'proveedore.index');
Route::resource('proveedores', ProveedoreController::class);


Route::view('/compras', 'compra.index');
Route::resource('compras', CompraController::class);



Route::get('/login', function () {
    return view('auth.login');
});


Route::get('/401', function () {
    return view('pages.401');
});


Route::get('/404', function () {
    return view('pages.404');
});


Route::get('/500', function () {
    return view('pages.500');
});

