<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Проверяет, что у пользователя есть одна из переданных ролей.
     * Роли передаются через запятую: role:organizer,municipal_coordinator
     * @param Request $request
     * @param Closure $next
     * @param string ...$roles
     * @return Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (! $user->is_active) {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Ваш аккаунт деактивирован.']);
        }

        if ($user->hasAnyRole($roles)) {
            return $next($request);
        }

        abort(403, 'Доступ запрещён.');
    }
}
