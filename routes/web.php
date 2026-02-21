<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

Route::get('/', function () {
    return view('index');
});

Route::get('/examples', function () {
    return view('examples');
});
Route::get('/test', function () {
    return view('test-page');
});

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
// Новости
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');
// Маршруты для создания новостей (только для организатора)
Route::middleware(['auth'])->group(function () {
    Route::get('/news/create', [App\Http\Controllers\NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [App\Http\Controllers\NewsController::class, 'store'])->name('news.store');
});
