<?php

use App\Http\Controllers\Api\CharacterController;
use App\Http\Controllers\Api\EpisodeController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\StatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function() {
    Route::middleware(['apiRequestHit', 'throttle:20,1'])->group(function() {
        Route::prefix('episodes')->group(function() {
            Route::get('/', [EpisodeController::class, 'index']);
            Route::get('{id}', [EpisodeController::class, 'show']);
        });

        Route::prefix('characters')->group(function() {
            Route::get('/', [CharacterController::class, 'index']);
            Route::get('random', [CharacterController::class, 'random']);
        });

        Route::prefix('quotes')->group(function() {
            Route::get('/', [QuoteController::class, 'index']);
            Route::get('random', [QuoteController::class, 'random']);
        });
    });

    Route::get('stats', [StatController::class, 'stats']);
    Route::get('my-stats', [StatController::class, 'myStats']);
});
