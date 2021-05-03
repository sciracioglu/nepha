<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::get('sale', [App\Http\Controllers\SalesController::class, 'index'])->name('declare');
Route::post('sale', [App\Http\Controllers\SalesController::class, 'store'])->name('store-declare');
Route::delete('sale/{id}', [App\Http\Controllers\SalesController::class, 'destroy'])->name('cancel');
Route::post('corp', [App\Http\Controllers\CorporationController::class, 'index'])->name('declare');

Route::get('cities', [App\Http\Controllers\CityController::class, 'index'])->name('cties');
Route::get('countries', [App\Http\Controllers\CountryController::class, 'index'])->name('countries');

Route::get('products', [App\Http\Controllers\ProductController::class, 'index'])->name('list');

Route::get('medicine', [App\Http\Controllers\MedicineController::class, 'index'])->name('medicine');
Route::post('medicine', [App\Http\Controllers\MedicineController::class, 'store'])->name('store-medicine');
Route::delete('medicine/{gtin}', [App\Http\Controllers\MedicineController::class, 'destroy'])->name('delete-medicine');
Route::get('medicine-list', [App\Http\Controllers\MedicineController::class, 'list'])->name('medicine-list');

Route::get('facility', [App\Http\Controllers\FacilityController::class, 'index'])->name('facility');
Route::post('facility', [App\Http\Controllers\FacilityController::class, 'store'])->name('store-facility');
Route::delete('facility/{id}', [App\Http\Controllers\FacilityController::class, 'destroy'])->name('delete-facility');
Route::get('facility-list', [App\Http\Controllers\FacilityController::class, 'list'])->name('facility-list');

Route::get('user', [App\Http\Controllers\UsersController::class, 'index'])->name('user');
Route::get('user-list', [App\Http\Controllers\UsersController::class, 'list'])->name('users-list');
Route::post('user', [App\Http\Controllers\UsersController::class, 'store'])->name('store-user');
Route::delete('user/{id}', [App\Http\Controllers\UsersController::class, 'destroy'])->name('delete-user');
Route::patch('user/{user}', [App\Http\Controllers\UsersController::class, 'update'])->name('update-user');

Route::get('reports', [App\Http\Controllers\ReportsController::class, 'index'])->name('reports');
Route::post('reports', [App\Http\Controllers\ReportsController::class, 'show'])->name('report-result');
