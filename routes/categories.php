<?php

use App\Http\Controllers\Category\CategoryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/categories', function () {
    return Inertia::render('categories/index');
})->middleware(['auth', 'verified'])->name('categories.index');

Route::post('/categories', [CategoryController::class, 'store'])
    ->middleware(['auth', 'verified'])->name('categories.store');
