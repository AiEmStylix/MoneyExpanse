<?php

use App\Http\Controllers\CategoryGroupWebController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('category-groups', CategoryGroupWebController::class);
});
