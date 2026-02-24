<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Municipality;
use App\Models\Organization;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Допустимые роли для самостоятельной регистрации.
     * municipal_coordinator — только через назначение организатором, не через публичную регистрацию.
     */
    protected array $allowedRoles = ['participant', 'mentor'];

    protected array $roleLabels = [
        'participant' => 'Участник',
        'mentor'      => 'Наставник',
    ];

    /**
     * Страница ожидания одобрения
     */
    public function showPending(): View
    {
        return view('auth.register-pending');
    }

    /**
     * Страница выбора роли
     * @return View|RedirectResponse
     */
    public function showSelectRole(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register-select', [
            'roleLabels' => $this->roleLabels,
        ]);
    }

    /**
     * Форма регистрации для конкретной роли
     * @param string $role Роль пользователя
     * @return View|RedirectResponse
     */
    public function showForm(string $role): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        if (! in_array($role, $this->allowedRoles)) {
            abort(404);
        }

        //TODO добавить методы `orderBy` в модели
        $municipalities = Municipality::orderBy('name')->get();
        $organizations = Organization::orderBy('name')->get();
        $teams = ($role === 'participant') ? Team::orderBy('name')->get() : collect();

        return view('auth.register', compact('role', 'municipalities', 'organizations', 'teams'));
    }

    /**
     * Обработка регистрации
     * @param RegisterRequest $request Проверенный запрос на регистрацию
     * @param string $role Роль пользователя
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function register(RegisterRequest $request, string $role): RedirectResponse
    {
        if (! in_array($role, $this->allowedRoles)) {
            abort(404);
        }

        // Наставник ожидает одобрения — аккаунт создаётся неактивным
        $requiresApproval = ($role === 'mentor');

        $user = DB::transaction(function () use ($request, $role, $requiresApproval) {
            $data = [
                'first_name'      => $request->first_name,
                'last_name'       => $request->last_name,
                'middle_name'     => $request->middle_name,
                'email'           => $request->email,
                'password'        => $request->password,
                'phone'           => $request->phone,
                'municipality_id' => $request->municipality_id,
                'is_active'       => ! $requiresApproval,
            ];

            if ($role === 'participant') {
                $data['organization_id'] = $request->organization_id;
                $data['grade']           = $request->grade;
                $data['locality']        = $request->locality;
                $data['team_id']         = $request->team_id;
            }

            if ($role === 'mentor') {
                $data['organization_id'] = $request->organization_id;
                $data['position']        = $request->position;
            }

            $user = User::create($data);

            // Привязываем роль
            $roleModel = Role::where('name', $role)->first();
            if ($roleModel) {
                $user->roles()->attach($roleModel->id);
            }

            return $user;
        });

        // Наставника не логиним — отправляем на страницу ожидания
        if ($requiresApproval) {
            return redirect()->route('register.pending')
                ->with('pending_name', $user->first_name);
        }

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Добро пожаловать, ' . $user->first_name . '! Регистрация прошла успешно.');
    }
}
