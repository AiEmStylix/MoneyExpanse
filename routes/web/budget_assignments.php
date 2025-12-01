<?php

use App\Http\Controllers\BudgetAssignmentWebController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('budget-assignments', BudgetAssignmentWebController::class);
});
