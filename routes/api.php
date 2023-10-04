<?php

use App\Http\Controllers\Api;
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

Route::post('/auth/login', [Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [Api\ProfileController::class, 'profile']);
    Route::apiResource('animal-types', Api\AnimalTypeController::class);
    Route::apiResource('raw-types', Api\RawTypeController::class);
    Route::apiResource('bunkers', Api\BunkerController::class);
    Route::apiResource('clients', Api\ClientController::class);
    Route::apiResource('orders', Api\OrderController::class);
    Route::apiResource('receipts', Api\ReceiptController::class);
    Route::apiResource('raws', Api\RawController::class);
    Route::apiResource('producers', Api\ProducerController::class);
    Route::apiResource('prices', Api\PriceController::class);
    Route::post('prices/{price}/replicate', [Api\PriceController::class, 'replicate']);
    Route::post('receipts/{receipt}/replicate', [Api\ReceiptController::class, 'replicate']);
    Route::get('/countries', [Api\CountryController::class, 'index']);
});
