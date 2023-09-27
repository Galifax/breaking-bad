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
Auth::routes();

Route::middleware('auth')->group(function() {
    Route::as('dashboard.')->group(function() {
        Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('index');
        Route::post('createToken', [App\Http\Controllers\DashboardController::class, 'createToken'])->name('createToken');
    });

    Route::prefix('tokens')->as('tokens.')->group(function() {
        Route::post('/', [App\Http\Controllers\TokenController::class, 'store'])->name('store');
        Route::get('{token}', [App\Http\Controllers\TokenController::class, 'destroy'])->name('destroy');
    });
});
