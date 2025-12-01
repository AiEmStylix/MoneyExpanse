<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::apiResource('transactions', TransactionController::class);
});
