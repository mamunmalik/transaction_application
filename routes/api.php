<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('get-mock-response', [TransactionController::class, 'getMockRespnses']);
Route::post('create-payment', [TransactionController::class, 'createPayment']);
Route::post('update-payment', [TransactionController::class, 'updatePayment']);