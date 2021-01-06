<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\ProductDeclarationController::class, 'index'])->name('declare');
Route::post('/', [App\Http\Controllers\ProductDeclarationController::class, 'store'])->name('store-declare');
Route::delete('/{id}', [App\Http\Controllers\ProductDeclarationController::class, 'destroy'])->name('cancel');
Route::post('/corp', [App\Http\Controllers\CorporationController::class, 'index'])->name('declare');
Route::get('/city', [App\Http\Controllers\CityController::class, 'index'])->name('declare');
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('list');
