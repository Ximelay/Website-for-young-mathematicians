@extends('layouts.app')

@section('title', 'Редактировать пользователя — ' . $user->full_name)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Хлебные крошки --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Кабинет</a>
        <span>/</span>
        <a href="{{ route('users.index') }}" class="hover:text-indigo-600 transition">Пользователи</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">{{ $user->full_name }}</span>
    </nav>

    @if (session('error'))
        <x-alert type="danger" class="mb-6">{{ session('error') }}</x-alert>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Шапка --}}
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center flex-shrink-0">
                <span class="text-xl font-bold text-white">
                    {{ mb_strtoupper(mb_substr($user->first_name, 0, 1)) }}
                </span>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">{{ $user->full_name }}</h1>
                <p class="text-sm text-gray-500 mt-0.5">{{ $user->email }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('users.update', $user) }}" class="divide-y divide-gray-100">
            @csrf
            @method('PUT')

            {{-- Личные данные --}}
            <div class="px-6 py-6 space-y-4">
                <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Личные данные</h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Фамилия <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('last_name') border-red-400 @enderror">
                        @error('last_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Имя <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('first_name') border-red-400 @enderror">
                        @error('first_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Отчество</label>
                        <input type="text" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('email') border-red-400 @enderror">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Телефон</label>
                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="+7 (999) 000-00-00">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Новый пароль
                            <span class="text-gray-400 font-normal">(оставьте пустым чтобы не менять)</span>
                        </label>
                        <input type="password" name="password"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('password') border-red-400 @enderror"
                               placeholder="Минимум 8 символов">
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Подтверждение пароля</label>
                        <input type="password" name="password_confirmation"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="Повторите пароль">
                    </div>
                </div>
            </div>

            {{-- Роли --}}
            <div class="px-6 py-6 space-y-4">
                <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                    Роли в системе <span class="text-red-500">*</span>
                </h2>
                @error('roles')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
                @php
                    $roleLabels = [
                        'organizer'             => ['label' => 'Организатор',  'emoji' => '⚙️',  'badge' => 'bg-purple-100 text-purple-700'],
                        'municipal_coordinator' => ['label' => 'Координатор',  'emoji' => '🏛️', 'badge' => 'bg-blue-100 text-blue-700'],
                        'mentor'                => ['label' => 'Наставник',    'emoji' => '👨‍🏫', 'badge' => 'bg-green-100 text-green-700'],
                        'participant'           => ['label' => 'Участник',     'emoji' => '🎒',  'badge' => 'bg-yellow-100 text-yellow-700'],
                    ];
                @endphp
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach($roles as $role)
                        @php $rc = $roleLabels[$role->name] ?? ['label' => $role->name, 'emoji' => '👤', 'badge' => 'bg-gray-100 text-gray-700']; @endphp
                        <label class="relative cursor-pointer">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                   {{ in_array($role->id, old('roles', $userRoles)) ? 'checked' : '' }}
                                   class="peer sr-only">
                            <div class="flex flex-col items-center gap-2 p-4 rounded-xl border-2 border-gray-200
                                        peer-checked:border-indigo-500 peer-checked:bg-indigo-50
                                        hover:border-gray-300 transition text-center">
                                <span class="text-2xl">{{ $rc['emoji'] }}</span>
                                <span class="text-xs font-semibold text-gray-700">{{ $rc['label'] }}</span>
                                <span class="absolute top-2 right-2 hidden peer-checked:block">
                                    <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Привязка к структуре --}}
            <div class="px-6 py-6 space-y-4">
                <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Привязка к структуре</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Муниципалитет</label>
                        <select name="municipality_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">— Не указан —</option>
                            @foreach($municipalities as $mun)
                                <option value="{{ $mun->id }}"
                                    {{ old('municipality_id', $user->municipality_id) == $mun->id ? 'selected' : '' }}>
                                    {{ $mun->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Организация</label>
                        <select name="organization_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">— Не указана —</option>
                            @foreach($organizations as $org)
                                <option value="{{ $org->id }}"
                                    {{ old('organization_id', $user->organization_id) == $org->id ? 'selected' : '' }}>
                                    {{ $org->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Команда</label>
                        <select name="team_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">— Не указана —</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}"
                                    {{ old('team_id', $user->team_id) == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Класс</label>
                        <select name="grade"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">— Не указан —</option>
                            @for($i = 5; $i <= 11; $i++)
                                <option value="{{ $i }}" {{ old('grade', $user->grade) == $i ? 'selected' : '' }}>
                                    {{ $i }} класс
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Должность</label>
                        <input type="text" name="position" value="{{ old('position', $user->position) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="Учитель, методист...">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Населённый пункт</label>
                    <input type="text" name="locality" value="{{ old('locality', $user->locality) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                           placeholder="Тюмень, Тобольск...">
                </div>
            </div>

            {{-- Статус --}}
            <div class="px-6 py-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $user->is_active ? '1' : '0') == '1' ? 'checked' : '' }}
                           class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <div>
                        <span class="text-sm font-medium text-gray-900">Активный аккаунт</span>
                        <p class="text-xs text-gray-500">Пользователь может входить в систему</p>
                    </div>
                </label>
            </div>

            {{-- Кнопки --}}
            <div class="px-6 py-5 bg-gray-50 flex items-center justify-between gap-3">
                <a href="{{ route('users.index') }}"
                   class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 transition shadow-sm">
                    Отмена
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition shadow-sm">
                    Сохранить изменения
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
