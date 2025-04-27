<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\EnrollmentController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Pages
Route::get('/clients', [ClientController::class, 'index']);
Route::get('/programs', [ProgramController::class, 'index']);
Route::get('/enrollment', [EnrollmentController::class, 'index']);
Route::get('/profile/{client}', [ClientController::class, 'show']);
Route::get('/clients/search', [ClientController::class, 'searchForm']);
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
Route::get('/enrollment', [EnrollmentController::class, 'index'])->name('enrollment.index');
Route::post('/enrollment', [EnrollmentController::class, 'store'])->name('enrollment.store');
Route::post('/programs', [ProgramController::class, 'store'])->name('programs.store');
Route::get('/activity', function () {
    return inertia('Activity');
});

require __DIR__.'/auth.php';
