@extends('layouts.app')

@php
    $roleConfig = [
        'participant' => [
            'label'    => 'Участник',
            'emoji'    => '🎒',
            'color'    => 'yellow',
            'badge'    => 'bg-yellow-100 text-yellow-700',
            'accent'   => 'bg-yellow-50 border-yellow-200',
        ],
        'mentor' => [
            'label'    => 'Наставник',
            'emoji'    => '👨‍🏫',
            'color'    => 'green',
            'badge'    => 'bg-green-100 text-green-700',
            'accent'   => 'bg-green-50 border-green-200',
        ],
        'municipal_coordinator' => [
            'label'    => 'Координатор',
            'emoji'    => '🏛️',
            'color'    => 'blue',
            'badge'    => 'bg-blue-100 text-blue-700',
            'accent'   => 'bg-blue-50 border-blue-200',
        ],
    ];
    $cfg = $roleConfig[$role] ?? $roleConfig['participant'];
@endphp

@section('title', "Регистрация: {$cfg['label']} — Турнир юных математиков")

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Хлебные крошки --}}
        <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
            <a href="{{ route('login') }}" class="hover:text-indigo-600 transition">Войти</a>
            <span>/</span>
            <a href="{{ route('register') }}" class="hover:text-indigo-600 transition">Регистрация</a>
            <span>/</span>
            <span class="text-gray-700 font-medium">{{ $cfg['label'] }}</span>
        </nav>

        {{-- Заголовок карточки --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Шапка с ролью --}}
            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-{{ $cfg['color'] }}-100 flex items-center justify-center flex-shrink-0">
                    <span class="text-xl">{{ $cfg['emoji'] }}</span>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Регистрация</h1>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="px-2 py-0.5 text-xs rounded-full font-medium {{ $cfg['badge'] }}">
                            {{ $cfg['label'] }}
                        </span>
                        <a href="{{ route('register') }}" class="text-xs text-gray-400 hover:text-indigo-600 transition">
                            Изменить роль →
                        </a>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('register.submit', $role) }}" class="p-6 space-y-5">
                @csrf

                {{-- Баннер об одобрении для наставника --}}
                @if($role === 'mentor')
                    <div class="flex items-start gap-3 p-4 bg-amber-50 border border-amber-200 rounded-xl">
                        <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-amber-800">
                            <span class="font-semibold">Требуется одобрение.</span>
                            После регистрации ваш аккаунт будет отправлен на проверку организатору.
                            Войти в систему вы сможете только после одобрения.
                        </p>
                    </div>
                @endif

                {{-- Ошибки --}}
                @if ($errors->any())
                    <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                        <p class="font-semibold mb-1">Пожалуйста, исправьте ошибки:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Секция: ФИО --}}
                <div>
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Личные данные</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Фамилия <span class="text-red-500">*</span>
                            </label>
                            <input name="last_name" type="text" value="{{ old('last_name') }}" required
                                   placeholder="Иванов"
                                   class="w-full px-3.5 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition
                                          {{ $errors->has('last_name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                            @error('last_name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Имя <span class="text-red-500">*</span>
                            </label>
                            <input name="first_name" type="text" value="{{ old('first_name') }}" required
                                   placeholder="Иван"
                                   class="w-full px-3.5 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition
                                          {{ $errors->has('first_name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                            @error('first_name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Отчество</label>
                            <input name="middle_name" type="text" value="{{ old('middle_name') }}"
                                   placeholder="Иванович"
                                   class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        </div>
                    </div>
                </div>

                {{-- Секция: Контакты --}}
                <div>
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Контакты</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input name="email" type="email" value="{{ old('email') }}" required
                                   placeholder="you@example.com"
                                   class="w-full px-3.5 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition
                                          {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Телефон <span class="text-red-500">*</span>
                            </label>
                            <input name="phone" type="tel" value="{{ old('phone') }}" required
                                   placeholder="+7 (999) 000-00-00"
                                   class="w-full px-3.5 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition
                                          {{ $errors->has('phone') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                            @error('phone')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Секция: Пароль --}}
                <div>
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Пароль</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Пароль <span class="text-red-500">*</span>
                            </label>
                            <input name="password" type="password" required
                                   placeholder="Минимум 8 символов"
                                   class="w-full px-3.5 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition
                                          {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Подтверждение <span class="text-red-500">*</span>
                            </label>
                            <input name="password_confirmation" type="password" required
                                   placeholder="Повторите пароль"
                                   class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        </div>
                    </div>
                </div>

                {{-- Секция: Местоположение --}}
                <div>
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Место</h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Муниципалитет <span class="text-red-500">*</span>
                        </label>
                        <select name="municipality_id" required
                                class="w-full px-3.5 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition
                                       {{ $errors->has('municipality_id') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                            <option value="">— Выберите муниципалитет —</option>
                            @foreach ($municipalities as $municipality)
                                <option value="{{ $municipality->id }}" {{ old('municipality_id') == $municipality->id ? 'selected' : '' }}>
                                    {{ $municipality->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('municipality_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- === УЧАСТНИК: доп. поля === --}}
                @if ($role === 'participant')
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Учёба</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Населённый пункт <span class="text-red-500">*</span>
                                </label>
                                <input name="locality" type="text" value="{{ old('locality') }}" required
                                       placeholder="Город / посёлок / деревня"
                                       class="w-full px-3.5 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition
                                              {{ $errors->has('locality') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                                @error('locality')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Учебное заведение <span class="text-red-500">*</span>
                                    </label>
                                    <select name="organization_id" required
                                            class="w-full px-3.5 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition
                                                   {{ $errors->has('organization_id') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                                        <option value="">— Выберите школу —</option>
                                        @foreach ($organizations as $org)
                                            <option value="{{ $org->id }}" {{ old('organization_id') == $org->id ? 'selected' : '' }}>
                                                {{ $org->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('organization_id')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Класс <span class="text-red-500">*</span>
                                    </label>
                                    <select name="grade" required
                                            class="w-full px-3.5 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition
                                                   {{ $errors->has('grade') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                                        <option value="">— Класс —</option>
                                        @for ($i = 1; $i <= 11; $i++)
                                            <option value="{{ $i }}" {{ old('grade') == $i ? 'selected' : '' }}>{{ $i }} класс</option>
                                        @endfor
                                    </select>
                                    @error('grade')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            @if ($teams->isNotEmpty())
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Команда <span class="text-gray-400 font-normal">(необязательно)</span>
                                    </label>
                                    <select name="team_id"
                                            class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                        <option value="">— Без команды —</option>
                                        @foreach ($teams as $team)
                                            <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                                {{ $team->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- === НАСТАВНИК: доп. поля === --}}
                @if ($role === 'mentor')
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Место работы</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Организация <span class="text-red-500">*</span>
                                </label>
                                <select name="organization_id" required
                                        class="w-full px-3.5 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition
                                               {{ $errors->has('organization_id') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                                    <option value="">— Выберите организацию —</option>
                                    @foreach ($organizations as $org)
                                        <option value="{{ $org->id }}" {{ old('organization_id') == $org->id ? 'selected' : '' }}>
                                            {{ $org->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('organization_id')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Должность <span class="text-red-500">*</span>
                                </label>
                                <input name="position" type="text" value="{{ old('position') }}" required
                                       placeholder="Учитель математики"
                                       class="w-full px-3.5 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition
                                              {{ $errors->has('position') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                                @error('position')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endif

                {{-- === КООРДИНАТОР: доп. поля === --}}
                @if ($role === 'municipal_coordinator')
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Место работы</h3>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Должность <span class="text-red-500">*</span>
                            </label>
                            <input name="position" type="text" value="{{ old('position') }}" required
                                   placeholder="Методист управления образования"
                                   class="w-full px-3.5 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition
                                          {{ $errors->has('position') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                            @error('position')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endif

                {{-- Согласие на ПД --}}
                <div class="pt-2 border-t border-gray-100">
                    <label class="flex items-start gap-3 cursor-pointer group">
                        <div class="flex-shrink-0 mt-0.5">
                            <input type="checkbox" name="consent" value="1"
                                   {{ old('consent') ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                        </div>
                        <span class="text-sm text-gray-600 leading-relaxed">
                            Я даю согласие на обработку персональных данных в соответствии с ФЗ №152
                            «О персональных данных» <span class="text-red-500">*</span>
                        </span>
                    </label>
                    @error('consent')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Кнопки --}}
                <div class="flex items-center justify-between pt-1">
                    <a href="{{ route('register') }}"
                       class="text-sm text-gray-400 hover:text-gray-600 transition flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Назад
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition shadow-sm">
                        Зарегистрироваться
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>

            </form>
        </div>

        {{-- Уже есть аккаунт --}}
        <p class="text-center text-sm text-gray-400 mt-6">
            Уже зарегистрированы?
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Войти</a>
        </p>

    </div>
</div>
@endsection
