<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $role = $this->route('role');

        // Базовые правила для всех ролей
        $rules = [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'phone' => ['required', 'string', 'max:20'],
            'municipality_id' => ['required', 'exists:municipalities,id'],
            'consent' => ['required', 'accepted'],
        ];

        // Правила для участника
        if ($role === 'participant') {
            $rules['organization_id'] = ['required', 'exists:organizations,id'];
            $rules['grade'] = ['required', 'integer', 'min:1', 'max:11'];
            $rules['locality'] = ['required', 'string', 'max:200'];
            $rules['team_id'] = ['nullable', 'exists:teams,id'];
        }

        // Правила для наставника
        if ($role === 'mentor') {
            $rules['organization_id'] = ['required', 'exists:organizations,id'];
            $rules['position'] = ['required', 'string', 'max:200'];
        }

        // Правила для координатора
        if ($role === 'municipal_coordinator') {
            $rules['position'] = ['required', 'string', 'max:200'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Введите имя.',
            'last_name.required' => 'Введите фамилию.',
            'email.required' => 'Введите email.',
            'email.email' => 'Введите корректный email.',
            'email.unique' => 'Этот email уже зарегистрирован.',
            'password.required' => 'Введите пароль.',
            'password.confirmed' => 'Пароли не совпадают.',
            'phone.required' => 'Введите телефон.',
            'municipality_id.required' => 'Выберите муниципалитет.',
            'municipality_id.exists' => 'Выбранный муниципалитет не найден.',
            'organization_id.required' => 'Выберите организацию.',
            'organization_id.exists' => 'Выбранная организация не найдена.',
            'grade.required' => 'Укажите класс.',
            'grade.min' => 'Класс должен быть от 1 до 11.',
            'grade.max' => 'Класс должен быть от 1 до 11.',
            'locality.required' => 'Укажите населённый пункт.',
            'position.required' => 'Укажите должность.',
            'consent.required' => 'Необходимо дать согласие на обработку персональных данных.',
            'consent.accepted' => 'Необходимо дать согласие на обработку персональных данных.',
        ];
    }
}
