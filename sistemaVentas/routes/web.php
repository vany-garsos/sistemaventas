<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PorfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedoreController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\userController;
use App\Http\Controllers\ventaController;
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

Route::get('/', [homeController::class, 'index'])->name('panel');


Route::resource('categorias', CategoriaController::class);


Route::resource('marcas', MarcaController::class);


Route::resource('productos', ProductoController::class);


Route::resource('clientes', ClienteController::class);


Route::resource('proveedores', ProveedoreController::class);


Route::resource('compras', CompraController::class);


Route::resource('ventas', ventaController::class);

Route::resource('users', userController::class);
Route::resource('roles', roleController::class);


Route::resource('profile', PorfileController::class);



Route::get('/login', [loginController::class, 'index'])->name('login');
Route::post('/login', [loginController::class, 'login']);
Route::get('/logout', [logoutController::class, 'logout'])->name('logout');

Route::get('/401', function () {
    return view('pages.401');
});


Route::get('/404', function () {
    return view('pages.404');
});


Route::get('/500', function () {
    return view('pages.500');
});

