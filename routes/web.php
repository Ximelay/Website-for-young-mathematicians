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
    Route::post('/users/{user}/confirm-deletion', [App\Http\Controllers\DashboardController::class, 'confirmDeletion'])
        ->name('users.confirm-deletion');
    Route::post('/users/{user}/mark-for-deletion', [App\Http\Controllers\DashboardController::class, 'markForDeletion'])
        ->name('users.mark-for-deletion');

    Route::post('/users/{user}/confirm-deletion', [App\Http\Controllers\DashboardController::class, 'confirmDeletion'])
        ->name('users.confirm-deletion');

    Route::post('/users/{user}/cancel-deletion', [App\Http\Controllers\DashboardController::class, 'cancelDeletion'])
        ->name('users.cancel-deletion');
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');
    Route::post('/users/{user}/mark-for-deletion', [App\Http\Controllers\DashboardController::class, 'markForDeletion'])
        ->name('users.mark-for-deletion');
    // ─── МАТЕРИАЛЫ ─────────────────────────────────────────────────────────────
    Route::middleware(['auth'])->group(function () {
        Route::get('/materials', [App\Http\Controllers\MaterialController::class, 'index'])
            ->name('materials.index');
        Route::get('/materials/create', [App\Http\Controllers\MaterialController::class, 'create'])
            ->name('materials.create');
        Route::post('/materials', [App\Http\Controllers\MaterialController::class, 'store'])
            ->name('materials.store');
        Route::get('/materials/{material}/download', [App\Http\Controllers\MaterialController::class, 'download'])
            ->name('materials.download');
        Route::delete('/materials/{material}', [App\Http\Controllers\MaterialController::class, 'destroy'])
            ->name('materials.destroy');
    });
    // ─── КОМАНДЫ ─────────────────────────────────────────────────────────────
// Публичные маршруты (для участников)
    Route::get('/teams', [App\Http\Controllers\TeamController::class, 'publicIndex'])
        ->name('teams.public');
    Route::post('/teams/{team}/join', [App\Http\Controllers\TeamController::class, 'join'])
        ->middleware('auth')->name('teams.join');
    Route::post('/teams/leave', [App\Http\Controllers\TeamController::class, 'leave'])
        ->middleware('auth')->name('teams.leave');

// Только для авторизованных (наставники, организаторы)
    Route::middleware(['auth'])->group(function () {
        Route::get('/my-teams', [App\Http\Controllers\TeamController::class, 'index'])
            ->name('teams.index');
        Route::get('/my-teams/create', [App\Http\Controllers\TeamController::class, 'create'])
            ->name('teams.create');
        Route::post('/my-teams', [App\Http\Controllers\TeamController::class, 'store'])
            ->name('teams.store');
        Route::get('/my-teams/{team}', [App\Http\Controllers\TeamController::class, 'show'])
            ->name('teams.show');
        Route::get('/my-teams/{team}/edit', [App\Http\Controllers\TeamController::class, 'edit'])
            ->name('teams.edit');
        Route::put('/my-teams/{team}', [App\Http\Controllers\TeamController::class, 'update'])
            ->name('teams.update');
        Route::delete('/my-teams/{team}', [App\Http\Controllers\TeamController::class, 'destroy'])
            ->name('teams.destroy');

        // Управление участниками команды
        Route::post('/my-teams/{team}/add-participant', [App\Http\Controllers\TeamController::class, 'addParticipant'])
            ->name('teams.add-participant');
        Route::post('/my-teams/{team}/remove-participant/{user}', [App\Http\Controllers\TeamController::class, 'removeParticipant'])
            ->name('teams.remove-participant');
    });
});

// Маршрут с параметром — ВСЕГДА ПОСЛЕДНИМ!
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');
