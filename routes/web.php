<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/admin', function () {
    return view('adminlterol');
})->middleware(['auth'])->name('adminlterol');

Route::get('/clientes', function () {
    return view('clients');
})->middleware(['auth'])->name('clients');

Route::get('/pedidos', function () {
    return view('pedidos');
})->middleware(['auth'])->name('pedidos');

Route::get('/materiales', function () {
    return view('materiales');
})->middleware(['auth'])->name('livewire-material');


Route::get('/proveedores', function () {
    return view('providers');
})->middleware(['auth'])->name('providers');

Route::get('/instalaciones', function () {
    return view('instalaciones');
})->middleware(['auth'])->name('instalaciones');

Route::get('/depositos', function () {
    return view('depositos');
})->middleware(['auth'])->name('depositos');

Route::get('/planilla-de-compras', function () {
    return view('pucharsing-sheets');
})->middleware(['auth'])->name('pucharsing-sheets');

Route::get('/ordenes-de-entrada-de-materiales', function () {
    return view('ordenes-de-entrada-de-materiales');
})->middleware(['auth'])->name('ordenes-de-entrada-de-materiales');

require __DIR__.'/auth.php';
