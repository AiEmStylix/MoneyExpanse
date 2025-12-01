<?php

use App\Http\Controllers\CategoryGroupController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->name('api.')->group(function () {
    Route::apiResource('category-groups', CategoryGroupController::class);
});
