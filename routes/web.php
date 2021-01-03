<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

// Route::get('/', function () {
//     return view('welcome');
// });

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\ProductDeclarationController::class, 'index'])->name('declare');
Route::post('/', [App\Http\Controllers\ProductDeclarationController::class, 'store'])->name('store-declare');
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('list');
Route::get('/products-cancel', [App\Http\Controllers\ProductCancelController::class, 'index'])->name('cancel');
