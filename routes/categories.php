<?php

use App\Http\Controllers\Categories\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/categories', [CategoryController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('categories.index');

Route::get('/categories/create', [CategoryController::class, 'create'])
    ->middleware(['auth', 'verified'])->name('categories.create');

Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])
    ->name('categories.edit');

Route::patch('/categories/{category}', [CategoryController::class, 'update'])
    ->name('categories.edit');

Route::post('/categories', [CategoryController::class, 'store'])
    ->middleware(['auth', 'verified'])->name('categories.store');

Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('categories.destroy');
