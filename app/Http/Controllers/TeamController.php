<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\Municipality;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Список команд (для наставника)
     */
    public function index()
    {
        $user = auth()->user();

        // Наставник видит только свои команды
        if ($user->hasRole('mentor')) {
            $teams = Team::where('mentor_id', $user->id)
                ->with('mentor', 'municipality', 'members')
                ->latest()
                ->paginate(15);
        }
        // Организатор видит все команды
        elseif ($user->hasRole('organizer')) {
            $teams = Team::with('mentor', 'municipality', 'members')
                ->latest()
                ->paginate(15);
        }
        else {
            abort(403);
        }

        return view('teams.index', compact('teams'));
    }

    /**
     * Форма создания команды
     */
    public function create()
    {
        $user = auth()->user();

        // Только наставник может создавать команды
        if (!$user->hasRole('mentor')) {
            abort(403, 'Только наставник может создавать команду');
        }

        $municipalities = Municipality::all();

        return view('teams.create', compact('municipalities'));
    }

    /**
     * Сохранение команды
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->hasRole('mentor')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name',
            'municipality_id' => 'required|exists:municipalities,id',
            'organization_id' => 'required|exists:organizations,id', // ✅ Добавлено
            'grade' => 'required|integer|min:1|max:11',
            'description' => 'nullable|string|max:1000',
        ]);

        Team::create([
            'name' => $validated['name'],
            'mentor_id' => $user->id,
            'municipality_id' => $validated['municipality_id'],
            'organization_id' => $validated['organization_id'], // ✅ Добавлено
            'grade' => $validated['grade'],
            'description' => $validated['description'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('teams.index')
            ->with('success', '✅ Команда успешно создана!');
    }

    /**
     * Просмотр команды
     */
    public function show(Team $team)
    {
        $user = auth()->user();

        // Проверка прав: наставник видит только свои, организатор — все
        if ($user->hasRole('mentor') && $team->mentor_id !== $user->id) {
            abort(403);
        }

        $team->load('mentor', 'municipality', 'members.roles');

        // Участники без команды (для формы добавления)
        $freeParticipants = User::whereHas('roles', fn($q) => $q->where('name', 'participant'))
            ->whereNull('team_id')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('teams.show', compact('team', 'freeParticipants'));
    }

    /**
     * Форма редактирования команды
     */
    public function edit(Team $team)
    {
        $user = auth()->user();

        if ($user->hasRole('mentor') && $team->mentor_id !== $user->id) {
            abort(403);
        }

        $municipalities = Municipality::all();

        return view('teams.edit', compact('team', 'municipalities'));
    }

    /**
     * Обновление команды
     */
    public function update(Request $request, Team $team)
    {
        $user = auth()->user();

        if ($user->hasRole('mentor') && $team->mentor_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name,' . $team->id,
            'municipality_id' => 'required|exists:municipalities,id',
            'organization_id' => 'required|exists:organizations,id',
            'grade' => 'required|integer|min:1|max:11',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $team->update($validated);

        return redirect()->route('teams.show', $team)
            ->with('success', '✅ Команда обновлена!');
    }

    /**
     * Удаление команды
     */
    public function destroy(Team $team)
    {
        $user = auth()->user();

        if ($user->hasRole('mentor') && $team->mentor_id !== $user->id) {
            abort(403);
        }

        // Удаляем команду (участники остаются, team_id = null)
        $team->delete();

        return redirect()->route('teams.index')
            ->with('success', '🗑️ Команда удалена');
    }

    /**
     * Добавить участника в команду (для наставника)
     */
    public function addParticipant(Request $request, Team $team)
    {
        $user = auth()->user();

        if ($user->hasRole('mentor') && $team->mentor_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $participant = User::findOrFail($validated['user_id']);

        // Проверка: пользователь должен быть участником
        if (!$participant->hasRole('participant')) {
            return back()->with('error', '❌ Пользователь не является участником');
        }

        $participant->update(['team_id' => $team->id]);

        return back()->with('success', '✅ Участник добавлен в команду');
    }

    /**
     * Удалить участника из команды
     */
    public function removeParticipant(Team $team, User $user)
    {
        $auth = auth()->user();

        if ($auth->hasRole('mentor') && $team->mentor_id !== $auth->id) {
            abort(403);
        }

        $user->update(['team_id' => null]);

        return back()->with('success', '✅ Участник удалён из команды');
    }

    /**
     * Публичный список команд (для выбора участником)
     */
    public function publicIndex()
    {
        $teams = Team::where('is_active', true)
            ->with('mentor', 'municipality')
            ->withCount('members')
            ->latest()
            ->paginate(15);

        return view('teams.public', compact('teams'));
    }

    /**
     * Вступить в команду (для участника)
     */
    public function join(Team $team)
    {
        $user = auth()->user();

        if (!$user->hasRole('participant')) {
            abort(403, 'Только участник может вступить в команду');
        }

        if ($user->team_id) {
            return back()->with('error', '❌ Вы уже состоите в команде');
        }

        $user->update(['team_id' => $team->id]);

        return redirect()->route('dashboard')
            ->with('success', '✅ Вы вступили в команду "' . $team->name . '"!');
    }

    /**
     * Выйти из команды
     */
    public function leave()
    {
        $user = auth()->user();

        if (!$user->team_id) {
            return back()->with('error', '❌ Вы не состоите в команде');
        }

        $teamName = $user->team->name;
        $user->update(['team_id' => null]);

        return back()->with('success', '✅ Вы вышли из команды "' . $teamName . '"');
    }
}
