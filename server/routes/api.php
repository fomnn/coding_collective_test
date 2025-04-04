<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("/deposite", [TransactionController::class, 'deposite']);
Route::post("/withdraw", [TransactionController::class, 'withdraw']);
Route::get("/transactions", [TransactionController::class, 'transactions']);
