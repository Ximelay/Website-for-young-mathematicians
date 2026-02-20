@extends('layouts.app')

@php
    $roleLabels = [
        'participant'           => 'Участник',
        'mentor'                => 'Наставник',
        'municipal_coordinator' => 'Координатор',
    ];
    $roleLabel = $roleLabels[$role] ?? $role;
@endphp

@section('title', "Регистрация: {$roleLabel} — Турнир юных математиков")

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-8">
            <span class="text-4xl">🎓</span>
            <h2 class="mt-4 text-3xl font-bold text-gray-900">Регистрация</h2>
            <p class="mt-2 text-gray-600">
                Роль:
                <span class="font-semibold text-indigo-600">{{ $roleLabel }}</span>
            </p>
            <p class="text-sm text-gray-500 mt-1">
                <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-500">← Выбрать другую роль</a>
            </p>
        </div>

        <x-card title="Данные для регистрации">

            @if ($errors->any())
                <x-alert type="danger" class="mb-6">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <form method="POST" action="{{ route('register.submit', $role) }}" class="space-y-5">
                @csrf

                {{-- ФИО --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Фамилия <span class="text-red-500">*</span></label>
                        <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" required
                            class="mt-1 block w-full input-field @error('last_name') border-red-300 @enderror"
                            placeholder="Иванов">
                        @error('last_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">Имя <span class="text-red-500">*</span></label>
                        <input id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" required
                            class="mt-1 block w-full input-field @error('first_name') border-red-300 @enderror"
                            placeholder="Иван">
                        @error('first_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="middle_name" class="block text-sm font-medium text-gray-700">Отчество</label>
                        <input id="middle_name" name="middle_name" type="text" value="{{ old('middle_name') }}"
                            class="mt-1 block w-full input-field"
                            placeholder="Иванович">
                    </div>
                </div>

                {{-- Email и телефон --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required
                            class="mt-1 block w-full input-field @error('email') border-red-300 @enderror"
                            placeholder="you@example.com">
                        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Телефон <span class="text-red-500">*</span></label>
                        <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" required
                            class="mt-1 block w-full input-field @error('phone') border-red-300 @enderror"
                            placeholder="+7 (999) 000-00-00">
                        @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Пароль --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Пароль <span class="text-red-500">*</span></label>
                        <input id="password" name="password" type="password" required
                            class="mt-1 block w-full input-field @error('password') border-red-300 @enderror"
                            placeholder="Минимум 8 символов">
                        @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Подтверждение пароля <span class="text-red-500">*</span></label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="mt-1 block w-full input-field"
                            placeholder="Повторите пароль">
                    </div>
                </div>

                {{-- Муниципалитет --}}
                <div>
                    <label for="municipality_id" class="block text-sm font-medium text-gray-700">Муниципалитет <span class="text-red-500">*</span></label>
                    <select id="municipality_id" name="municipality_id" required
                        class="mt-1 block w-full input-field @error('municipality_id') border-red-300 @enderror">
                        <option value="">— Выберите муниципалитет —</option>
                        @foreach ($municipalities as $municipality)
                            <option value="{{ $municipality->id }}" {{ old('municipality_id') == $municipality->id ? 'selected' : '' }}>
                                {{ $municipality->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('municipality_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Поля только для участника --}}
                @if ($role === 'participant')
                    <div>
                        <label for="locality" class="block text-sm font-medium text-gray-700">Населённый пункт <span class="text-red-500">*</span></label>
                        <input id="locality" name="locality" type="text" value="{{ old('locality') }}" required
                            class="mt-1 block w-full input-field @error('locality') border-red-300 @enderror"
                            placeholder="Город / посёлок / деревня">
                        @error('locality')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="organization_id" class="block text-sm font-medium text-gray-700">Учебное заведение <span class="text-red-500">*</span></label>
                            <select id="organization_id" name="organization_id" required
                                class="mt-1 block w-full input-field @error('organization_id') border-red-300 @enderror">
                                <option value="">— Выберите организацию —</option>
                                @foreach ($organizations as $org)
                                    <option value="{{ $org->id }}" {{ old('organization_id') == $org->id ? 'selected' : '' }}>
                                        {{ $org->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('organization_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="grade" class="block text-sm font-medium text-gray-700">Класс <span class="text-red-500">*</span></label>
                            <select id="grade" name="grade" required
                                class="mt-1 block w-full input-field @error('grade') border-red-300 @enderror">
                                <option value="">— Класс —</option>
                                @for ($i = 1; $i <= 11; $i++)
                                    <option value="{{ $i }}" {{ old('grade') == $i ? 'selected' : '' }}>{{ $i }} класс</option>
                                @endfor
                            </select>
                            @error('grade')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    @if ($teams->isNotEmpty())
                        <div>
                            <label for="team_id" class="block text-sm font-medium text-gray-700">Команда (если уже есть)</label>
                            <select id="team_id" name="team_id"
                                class="mt-1 block w-full input-field">
                                <option value="">— Без команды —</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                        {{ $team->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                @endif

                {{-- Поля для наставника --}}
                @if ($role === 'mentor')
                    <div>
                        <label for="organization_id" class="block text-sm font-medium text-gray-700">Организация <span class="text-red-500">*</span></label>
                        <select id="organization_id" name="organization_id" required
                            class="mt-1 block w-full input-field @error('organization_id') border-red-300 @enderror">
                            <option value="">— Выберите организацию —</option>
                            @foreach ($organizations as $org)
                                <option value="{{ $org->id }}" {{ old('organization_id') == $org->id ? 'selected' : '' }}>
                                    {{ $org->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('organization_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700">Должность <span class="text-red-500">*</span></label>
                        <input id="position" name="position" type="text" value="{{ old('position') }}" required
                            class="mt-1 block w-full input-field @error('position') border-red-300 @enderror"
                            placeholder="Учитель математики">
                        @error('position')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                @endif

                {{-- Поля для координатора --}}
                @if ($role === 'municipal_coordinator')
                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700">Должность <span class="text-red-500">*</span></label>
                        <input id="position" name="position" type="text" value="{{ old('position') }}" required
                            class="mt-1 block w-full input-field @error('position') border-red-300 @enderror"
                            placeholder="Методист управления образования">
                        @error('position')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                @endif

                {{-- Согласие на обработку ПД --}}
                <div class="border-t border-gray-200 pt-5">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="consent" value="1"
                            class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 @error('consent') border-red-300 @enderror"
                            {{ old('consent') ? 'checked' : '' }}>
                        <span class="text-sm text-gray-600">
                            Я даю согласие на обработку персональных данных в соответствии с Федеральным законом №152-ФЗ
                            «О персональных данных». <span class="text-red-500">*</span>
                        </span>
                    </label>
                    @error('consent')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Кнопки --}}
                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('register') }}" class="text-sm text-gray-500 hover:text-gray-700">
                        ← Назад
                    </a>
                    <x-button type="submit" variant="primary" class="px-8 py-2.5 text-base">
                        Зарегистрироваться
                    </x-button>
                </div>

            </form>
        </x-card>
    </div>
</div>

@push('styles')
<style>
    .input-field {
        @apply px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm;
    }
</style>
@endpush
@endsection
