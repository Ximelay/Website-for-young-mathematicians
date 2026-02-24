<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Models\News;
use App\Models\Organization;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// ─── ГЛАВНАЯ СТРАНИЦА ────────────────────────────────────────────────────────
Route::get('/', function () {
    $latestNews = News::published()
        ->latest('published_at')
        ->take(3)
        ->get();

    $upcomingEvents = \App\Models\Event::where('start_date', '>=', now())
        ->orderBy('start_date')
        ->take(4)
        ->get();

    $stats = [
        'participants'  => User::participants()->count(),
        'teams'         => Team::where('is_active', true)->count(),
        'organizations' => Organization::count(),
        'news'          => News::published()->count(),
    ];

    return view('index', compact('latestNews', 'upcomingEvents', 'stats'));
});

// ─── ГОСТЕВЫЕ МАРШРУТЫ ───────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showSelectRole'])->name('register');
    Route::get('/register/{role}', [RegisterController::class, 'showForm'])->name('register.form');
    Route::post('/register/{role}', [RegisterController::class, 'register'])->name('register.submit');
    Route::get('/register-pending', [RegisterController::class, 'showPending'])->name('register.pending');
});

// ─── ВЫХОД ───────────────────────────────────────────────────────────────────
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// ─── ПУБЛИЧНЫЕ СТРАНИЦЫ ──────────────────────────────────────────────────────
Route::get('/news', [NewsController::class, 'index'])->name('news.index');

// ─── АВТОРИЗОВАННЫЕ МАРШРУТЫ ─────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Личный кабинет
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Управление пользователями (только организатор)
    Route::get('/users', [DashboardController::class, 'users'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
    Route::post('/users/{user}/confirm-deletion', [DashboardController::class, 'confirmDeletion'])->name('users.confirm-deletion');
    Route::post('/users/{user}/mark-for-deletion', [DashboardController::class, 'markForDeletion'])->name('users.mark-for-deletion');
    Route::post('/users/{user}/cancel-deletion', [DashboardController::class, 'cancelDeletion'])->name('users.cancel-deletion');
    Route::patch('/users/{user}/toggle-active', [DashboardController::class, 'toggleActive'])->name('users.toggle-active');

    // Календарь и события
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
    Route::resource('events', EventController::class)->except('show');

    // Новости — сначала конкретные маршруты, потом с параметрами!
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');

    // Материалы
    Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
    Route::get('/materials/create', [MaterialController::class, 'create'])->name('materials.create');
    Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
    Route::get('/materials/{material}/download', [MaterialController::class, 'download'])->name('materials.download');
    Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');

    // Публичный список команд
    Route::get('/teams', [TeamController::class, 'publicIndex'])->name('teams.public');
    Route::post('/teams/{team}/join', [TeamController::class, 'join'])->name('teams.join');
    Route::post('/teams/leave', [TeamController::class, 'leave'])->name('teams.leave');

    // Управление командами (наставник / организатор)
    Route::get('/my-teams', [TeamController::class, 'index'])->name('teams.index');
    Route::get('/my-teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/my-teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('/my-teams/{team}', [TeamController::class, 'show'])->name('teams.show');
    Route::get('/my-teams/{team}/edit', [TeamController::class, 'edit'])->name('teams.edit');
    Route::put('/my-teams/{team}', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('/my-teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');
    Route::post('/my-teams/{team}/add-participant', [TeamController::class, 'addParticipant'])->name('teams.add-participant');
    Route::post('/my-teams/{team}/remove-participant/{user}', [TeamController::class, 'removeParticipant'])->name('teams.remove-participant');
});

// Динамический маршрут новостей — ПОСЛЕ всех статичных /news/create, /news/*/edit
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

