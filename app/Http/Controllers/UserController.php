<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use App\Models\Organization;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Только организатор имеет доступ
     */
    private function authorizeOrganizer(): void
    {
        if (! auth()->user()->hasRole('organizer')) {
            abort(403, 'Доступ запрещён');
        }
    }

    /**
     * Просмотр профиля пользователя
     */
    public function show(User $user): View
    {
        $this->authorizeOrganizer();

        $user->load('roles', 'municipality', 'organization', 'team.mentor');

        return view('users.show', compact('user'));
    }

    /**
     * Одобрить регистрацию наставника
     */
    public function approve(User $user): RedirectResponse
    {
        $this->authorizeOrganizer();

        if (! $user->hasRole('mentor')) {
            return back()->with('error', 'Одобрение доступно только для наставников.');
        }

        $user->update(['is_active' => true]);

        return back()->with('success', "✅ Наставник {$user->full_name} одобрен и может войти в систему.");
    }

    /**
     * Форма создания нового пользователя
     */
    public function create(): View
    {
        $this->authorizeOrganizer();

        $municipalities = Municipality::orderBy('name')->get();
        $organizations  = Organization::orderBy('name')->get();
        $roles          = Role::orderBy('name')->get();
        $teams          = Team::where('is_active', true)->orderBy('name')->get();

        return view('users.create', compact('municipalities', 'organizations', 'roles', 'teams'));
    }

    /**
     * Сохранение нового пользователя
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorizeOrganizer();

        $validated = $request->validate([
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'middle_name'     => 'nullable|string|max:100',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|string|min:8|confirmed',
            'phone'           => 'nullable|string|max:30',
            'municipality_id' => 'nullable|exists:municipalities,id',
            'organization_id' => 'nullable|exists:organizations,id',
            'team_id'         => 'nullable|exists:teams,id',
            'grade'           => 'nullable|integer|min:1|max:11',
            'locality'        => 'nullable|string|max:255',
            'position'        => 'nullable|string|max:255',
            'is_active'       => 'boolean',
            'roles'           => 'required|array|min:1',
            'roles.*'         => 'exists:roles,id',
        ], [
            'first_name.required'  => 'Имя обязательно',
            'last_name.required'   => 'Фамилия обязательна',
            'email.required'       => 'Email обязателен',
            'email.email'          => 'Некорректный формат email',
            'email.unique'         => 'Пользователь с таким email уже существует',
            'password.required'    => 'Пароль обязателен',
            'password.min'         => 'Пароль должен быть не менее 8 символов',
            'password.confirmed'   => 'Пароли не совпадают',
            'roles.required'       => 'Необходимо выбрать хотя бы одну роль',
            'roles.min'            => 'Необходимо выбрать хотя бы одну роль',
        ]);

        $user = DB::transaction(function () use ($validated) {
            $user = User::create([
                'first_name'      => $validated['first_name'],
                'last_name'       => $validated['last_name'],
                'middle_name'     => $validated['middle_name'] ?? null,
                'email'           => $validated['email'],
                'password'        => Hash::make($validated['password']),
                'phone'           => $validated['phone'] ?? null,
                'municipality_id' => $validated['municipality_id'] ?? null,
                'organization_id' => $validated['organization_id'] ?? null,
                'team_id'         => $validated['team_id'] ?? null,
                'grade'           => $validated['grade'] ?? null,
                'locality'        => $validated['locality'] ?? null,
                'position'        => $validated['position'] ?? null,
                'is_active'       => $validated['is_active'] ?? true,
            ]);

            $user->roles()->sync($validated['roles']);

            return $user;
        });

        return redirect()->route('users.index')
            ->with('success', "✅ Пользователь {$user->full_name} успешно создан.");
    }

    /**
     * Форма редактирования пользователя
     */
    public function edit(User $user): View
    {
        $this->authorizeOrganizer();

        $municipalities = Municipality::orderBy('name')->get();
        $organizations  = Organization::orderBy('name')->get();
        $roles          = Role::orderBy('name')->get();
        $teams          = Team::where('is_active', true)->orderBy('name')->get();
        $userRoles      = $user->roles->pluck('id')->toArray();

        return view('users.edit', compact('user', 'municipalities', 'organizations', 'roles', 'teams', 'userRoles'));
    }

    /**
     * Обновление данных пользователя и его ролей
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorizeOrganizer();

        // Защита: нельзя убрать роль organizer у последнего организатора
        $requestedRoleNames = Role::whereIn('id', $request->input('roles', []))->pluck('name')->toArray();
        if ($user->hasRole('organizer') && ! in_array('organizer', $requestedRoleNames)) {
            $organizersCount = User::whereHas('roles', fn($q) => $q->where('name', 'organizer'))
                ->where('is_active', true)->count();
            if ($organizersCount <= 1) {
                return back()->with('error', '⚠️ Нельзя снять роль организатора с последнего администратора системы!');
            }
        }

        $validated = $request->validate([
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'middle_name'     => 'nullable|string|max:100',
            'email'           => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password'        => 'nullable|string|min:8|confirmed',
            'phone'           => 'nullable|string|max:30',
            'municipality_id' => 'nullable|exists:municipalities,id',
            'organization_id' => 'nullable|exists:organizations,id',
            'team_id'         => 'nullable|exists:teams,id',
            'grade'           => 'nullable|integer|min:1|max:11',
            'locality'        => 'nullable|string|max:255',
            'position'        => 'nullable|string|max:255',
            'is_active'       => 'boolean',
            'roles'           => 'required|array|min:1',
            'roles.*'         => 'exists:roles,id',
        ], [
            'first_name.required'  => 'Имя обязательно',
            'last_name.required'   => 'Фамилия обязательна',
            'email.required'       => 'Email обязателен',
            'email.email'          => 'Некорректный формат email',
            'email.unique'         => 'Пользователь с таким email уже существует',
            'password.min'         => 'Пароль должен быть не менее 8 символов',
            'password.confirmed'   => 'Пароли не совпадают',
            'roles.required'       => 'Необходимо выбрать хотя бы одну роль',
            'roles.min'            => 'Необходимо выбрать хотя бы одну роль',
        ]);

        DB::transaction(function () use ($validated, $user) {
            $data = [
                'first_name'      => $validated['first_name'],
                'last_name'       => $validated['last_name'],
                'middle_name'     => $validated['middle_name'] ?? null,
                'email'           => $validated['email'],
                'phone'           => $validated['phone'] ?? null,
                'municipality_id' => $validated['municipality_id'] ?? null,
                'organization_id' => $validated['organization_id'] ?? null,
                'team_id'         => $validated['team_id'] ?? null,
                'grade'           => $validated['grade'] ?? null,
                'locality'        => $validated['locality'] ?? null,
                'position'        => $validated['position'] ?? null,
                'is_active'       => $validated['is_active'] ?? true,
            ];

            if (! empty($validated['password'])) {
                $data['password'] = Hash::make($validated['password']);
            }

            $user->update($data);
            $user->roles()->sync($validated['roles']);
        });

        return redirect()->route('users.index')
            ->with('success', "✅ Данные пользователя {$user->full_name} обновлены.");
    }
}
