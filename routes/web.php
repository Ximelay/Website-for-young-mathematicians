<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/examples', function () {
    return view('examples');
});
// Маршруты для событий
Route::get('/calendar', [CalendarController::class, 'index'])
    ->name('calendar')
    ->middleware('auth'); // Добавьте middleware для авторизации
Route::resource('events', EventController::class)->except('show');

// ─── Гостевые маршруты ───────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showSelectRole'])->name('register');
    Route::get('/register/{role}', [RegisterController::class, 'showForm'])->name('register.form');
    Route::post('/register/{role}', [RegisterController::class, 'register'])->name('register.submit');
});

// ─── Выход ───────────────────────────────────────────────────────────────────
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ─── Личный кабинет ──────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

