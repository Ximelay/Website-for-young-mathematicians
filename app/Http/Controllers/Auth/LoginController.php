<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $request->ensureIsNotRateLimited();

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        // Проверка активности аккаунта
        $user = User::where('email', $credentials['email'])->first();

        if ($user && ! $user->is_active) {
            $request->incrementRateLimit();

            // Различаем: наставник ожидает одобрения vs деактивированный аккаунт
            $isPendingMentor = $user->hasRole('mentor') && ! $user->marked_for_deletion;
            $message = $isPendingMentor
                ? 'Ваш аккаунт ещё не одобрен организатором. Пожалуйста, ожидайте.'
                : 'Ваш аккаунт деактивирован. Обратитесь к организатору.';

            return back()->withErrors(['email' => $message])->onlyInput('email');
        }

        if (! Auth::attempt($credentials, $remember)) {
            $request->incrementRateLimit();
            return back()->withErrors([
                'email' => 'Неверный email или пароль.',
            ])->onlyInput('email');
        }

        $request->clearRateLimit();
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
