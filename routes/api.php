<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Admin routes
 */
Route::prefix('admin')->group(function () {
    Route::post('/register', [AdminController::class, 'register']);
    Route::post('/login', [AdminController::class, 'login']);

    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        /**
         * Banner CRUD
         */
        Route::get('/banner', [BannerController::class, 'index']);
        Route::post('/banner', [BannerController::class, 'store']);
        Route::put('/banner/{id}', [BannerController::class, 'update']);
        Route::delete('/banner/{id}', [BannerController::class, 'destroy']);


        Route::post('/logout', [AdminController::class, 'logout']);
    });
});
