<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'Введите email.',
            'email.email'       => 'Введите корректный email.',
            'password.required' => 'Введите пароль.',
        ];
    }

    /**
     * Проверяет лимит — не более 7 попыток за минуту.
     */
    public function ensureIsNotRateLimited(): void
    {
        $key = 'login.' . $this->ip();

        if (RateLimiter::tooManyAttempts($key, 7)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => "Слишком много попыток входа. Повторите через {$seconds} сек.",
            ]);
        }
    }

    public function incrementRateLimit(): void
    {
        RateLimiter::hit('login.' . $this->ip(), 60);
    }

    public function clearRateLimit(): void
    {
        RateLimiter::clear('login.' . $this->ip());
    }
}
