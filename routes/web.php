<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public routes
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Auth routes
require __DIR__.'/auth.php';

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Players routes
    Route::get('/jugadores', [PlayerController::class, 'index'])->name('players');
    Route::get('/jugadores/{id}', [PlayerController::class, 'show'])->name('players.show');
    
    // Contracts routes
    Route::get('/contratos', [\App\Http\Controllers\ContractController::class, 'index'])->name('contracts');
    Route::get('/contratos/{id}', [\App\Http\Controllers\ContractController::class, 'show'])->name('contracts.show');
    
    // Investments routes
    Route::get('/inversiones', [\App\Http\Controllers\InvestmentController::class, 'index'])->name('investments');
    Route::get('/inversiones/jugador/{playerId}', [\App\Http\Controllers\InvestmentController::class, 'show'])->name('investments.show');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Email verification routes
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {
        return Inertia::render('Auth/VerifyEmail');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('dashboard');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware(['throttle:6,1'])->name('verification.send');
});
