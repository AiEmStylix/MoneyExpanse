<?php

use App\Http\Controllers\CategoryWebController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('categories', CategoryWebController::class);
});
