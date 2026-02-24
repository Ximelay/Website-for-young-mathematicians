<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\News;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            $stats = [
                'users'  => User::active()->count(),
                'events' => Event::count(),
                'news'   => News::count(),
                'teams'  => Team::count(),
            ];

            $pendingDeletions = User::where('marked_for_deletion', true)
                ->with('roles', 'municipality', 'organization')
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.organizer', compact('user', 'stats', 'pendingDeletions'));
        }

        if ($user->hasRole('municipal_coordinator')) {
            return view('dashboard.coordinator', compact('user'));
        }

        if ($user->hasRole('mentor')) {
            $user->load('mentorTeams.members', 'mentorTeams.municipality', 'mentorTeams.organization');
            return view('dashboard.mentor', compact('user'));
        }

        if ($user->hasRole('participant')) {
            $user->load('team', 'organization', 'municipality');
            return view('dashboard.participant', compact('user'));
        }

        // Нет роли — базовый дашборд
        return view('dashboard.index', compact('user'));
    }

    /**
     * Список всех пользователей (только для организатора)
     */
    public function users(): View|RedirectResponse
    {
        if (!auth()->user()->hasRole('organizer')) {
            abort(403);
        }

        $users = User::with('roles', 'municipality', 'organization')
            ->orderBy('last_name')
            ->paginate(20);

        return view('dashboard.users', compact('users'));
    }

    /**
     * Включить / выключить пользователя (только для организатора)
     */
    public function toggleActive(User $user): RedirectResponse
    {
        if (!auth()->user()->hasRole('organizer')) {
            abort(403);
        }

        // Нельзя деактивировать последнего организатора
        if (!$user->is_active === false && $user->hasRole('organizer')) {
            $count = User::whereHas('roles', fn($q) => $q->where('name', 'organizer'))
                ->where('is_active', true)->count();
            if ($count <= 1) {
                return back()->with('error', '⚠️ Нельзя деактивировать последнего организатора!');
            }
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'активирован' : 'деактивирован';
        return back()->with('success', "✅ Пользователь {$user->full_name} {$status}.");
    }

    /**
     * Пометить пользователя на удаление (для координатора и наставника)
     */
    public function markForDeletion(Request $request, User $user): RedirectResponse
    {
        $auth = auth()->user();

        // 🔐 Проверка прав: координатор может только в своём муниципалитете
        if ($auth->hasRole('municipal_coordinator')) {
            if ($user->municipality_id !== $auth->municipality_id) {
                abort(403, 'Доступ запрещён');
            }
        }

        // 🔐 Проверка прав: наставник может только участников своей команды
        if ($auth->hasRole('mentor')) {
            if (!$user->team || $user->team->mentor_id !== $auth->id) {
                abort(403, 'Доступ запрещён');
            }
        }

        // 🔥 ЗАЩИТА: Нельзя пометить на удаление последнего организатора
        if ($user->hasRole('organizer')) {
            $organizersCount = User::whereHas('roles', function($q) {
                $q->where('name', 'organizer');
            })
                ->where('is_active', true)
                ->count();

            if ($organizersCount <= 1) {
                return back()->with('error', '⚠️ Нельзя удалить последнего организатора системы!');
            }
        }

        $validated = $request->validate([
            'deletion_reason' => 'required|string|max:500',
        ]);

        $user->update([
            'marked_for_deletion' => true,
            'deletion_reason' => $validated['deletion_reason'],
        ]);

        return back()->with('success', '✅ Пользователь помечен на удаление. Ожидает подтверждения организатора.');
    }

    /**
     * Подтвердить удаление пользователя (только для организатора)
     */
    public function confirmDeletion(User $user): RedirectResponse
    {
        // 🔐 Только организатор может подтверждать удаление
        if (!auth()->user()->hasRole('organizer')) {
            abort(403, 'Доступ запрещён');
        }

        // 🔥 ЗАЩИТА: Нельзя удалить последнего активного организатора!
        if ($user->hasRole('organizer')) {
            $organizersCount = User::whereHas('roles', function($q) {
                $q->where('name', 'organizer');
            })
                ->where('is_active', true)
                ->count();

            // Если это последний активный организатор — блокируем
            if ($organizersCount <= 1) {
                return back()->with('error', '⚠️ Нельзя удалить последнего организатора! В системе должен остаться хотя бы один администратор.');
            }
        }

        // Выполняем деактивацию
        $user->update(['is_active' => false]);

        return back()->with('success', '🗑️ Пользователь деактивирован');
    }

    /**
     * Отменить пометку на удаление
     */
    public function cancelDeletion(User $user): RedirectResponse
    {
        $auth = auth()->user();

        // Только организатор или тот, кто пометил
        if (!$auth->hasRole('organizer') && $auth->id !== $user->id) {
            abort(403, 'Доступ запрещён');
        }

        $user->update([
            'marked_for_deletion' => false,
            'deletion_reason' => null,
        ]);

        return back()->with('success', '✅ Пометка на удаление снята');
    }
}
