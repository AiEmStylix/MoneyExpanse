<?php

use App\Http\Controllers\BudgetController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', [BudgetController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/api/budget_assignments.php';
require __DIR__.'/api/categories.php';
require __DIR__.'/api/category_groups.php';
require __DIR__.'/api/transactions.php';
