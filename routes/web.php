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
    return redirect('/login');
});

Route::get('/roles-users', function () {
    return view('roles-users');
})->middleware(['auth'])->name('roles-users');

Route::get('/customers', function () {
    return view('customers');
})->middleware(['auth'])->name('customers');

Route::get('/orders', function () {
    return view('orders');
})->middleware(['auth'])->name('orders');

Route::get('/products', function () {
    return view('products');
})->middleware(['auth'])->name('products');


Route::get('/providers', function () {
    return view('providers');
})->middleware(['auth'])->name('providers');

Route::get('/equipments', function () {
    return view('equipments');
})->middleware(['auth'])->name('equipments');

Route::get('/warehouses', function () {
    return view('warehouses');
})->middleware(['auth'])->name('warehouses');

Route::get('/purchase-forms', function () {
    return view('purchase-forms');
})->middleware(['auth'])->name('purchase-forms');

Route::get('/entry-orders', function () {
    return view('entry-orders');
})->middleware(['auth'])->name('entry-orders');

Route::get('/work-orders', function () {
    return view('workorders');
})->middleware(['auth'])->name('workorders');

Route::get('/release-orders', function () {
    return view('release-orders');
})->middleware(['auth'])->name('release-orders');

Route::get('/dollar', function () {
    return view('dollar');
})->middleware(['auth'])->name('dollar');


require __DIR__.'/auth.php';
