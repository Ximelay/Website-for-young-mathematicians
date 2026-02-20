<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Проверяет, что у пользователя есть нужное разрешение.
     * permission:manage_events
     * @param Request $request Проверенный запрос
     * @param Closure $next
     * @param string $permission
     * @return Response
     */
    public function handle(Request $request, Closure $next, string $permission): Response
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

        if ($user->hasPermission($permission)) {
            return $next($request);
        }

        abort(403, 'Недостаточно прав.');
    }
}
