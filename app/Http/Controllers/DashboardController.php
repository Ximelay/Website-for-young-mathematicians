<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Страница dashboard в зависимости от роли пользователя
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse
    {
        $user = auth()->user();
        $user->load('roles');

        if ($user->hasRole('organizer')) {
            return view('dashboard.organizer', compact('user'));
        }

        if ($user->hasRole('municipal_coordinator')) {
            return view('dashboard.coordinator', compact('user'));
        }

        if ($user->hasRole('mentor')) {
            $user->load('mentorTeams.participants');
            return view('dashboard.mentor', compact('user'));
        }

        if ($user->hasRole('participant')) {
            $user->load('team', 'organization', 'municipality');
            return view('dashboard.participant', compact('user'));
        }

        // Нет роли — базовый дашборд
        return view('dashboard.index', compact('user'));
    }
}
