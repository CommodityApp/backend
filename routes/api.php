<?php

use App\Http\Controllers\Api\AnimalTypeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RawController;
use App\Http\Controllers\Api\ReceiptController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile']);
    Route::apiResource('clients', ClientController::class);
    Route::get('/countries', [CountryController::class, 'index']);
    Route::apiResource('animal-types', AnimalTypeController::class);
    Route::get('/raws', [RawController::class, 'index']);
    Route::get('/receipts', [ReceiptController::class, 'index']);
    Route::resource('orders', OrderController::class)->only([
        'index', 'store', 'show',
    ]);
});
