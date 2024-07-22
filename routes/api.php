<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VoucherClaimController;
use App\Http\Controllers\VoucherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/vouchers', [VoucherController::class, 'index']);
    Route::post('/vouchers/claim/{id}', [VoucherClaimController::class, 'claim']);
    Route::get('/vouchers/history', [VoucherClaimController::class, 'history']);
    Route::delete('/vouchers/history/{id}', [VoucherClaimController::class, 'delete']);
});
