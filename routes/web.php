<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

// ─── ГЛАВНАЯ СТРАНИЦА  ──────────────────────────────
Route::get('/', function () {
    // Получаем последние 3 опубликованные новости
    $latestNews = \App\Models\News::published()
        ->latest('published_at')
        ->take(3)
        ->get();

    return view('index', compact('latestNews'));
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

// ─── НОВОСТИ (CRUD) ──────────────────────────────────────────────────────────
// ВАЖНО: Сначала конкретные маршруты, потом с параметрами!

// Публичные маршруты
Route::get('/news', [NewsController::class, 'index'])->name('news.index');

// Только для авторизованных (конкретные маршруты ДО /news/{news})
Route::middleware(['auth'])->group(function () {
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');
});

// Маршрут с параметром — ВСЕГДА ПОСЛЕДНИМ!
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');
