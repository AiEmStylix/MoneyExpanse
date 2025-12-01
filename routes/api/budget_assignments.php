<?php

use App\Http\Controllers\BudgetAssignmentController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::apiResource('budget-assignments', BudgetAssignmentController::class);
});
