@extends('layouts.app')

@section('title', 'Личный кабинет — Организатор')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if (session('success'))
            @if (session('error'))
                <x-alert type="error" class="mb-6">{{ session('error') }}</x-alert>
            @endif
            <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
        @endif

        <!-- Заголовок -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">🎯 Панель организатора</h1>
            <p class="text-gray-500 mt-1">Полный доступ к управлению турниром</p>
            @if ($user->municipality)
                <span class="inline-block mt-2 px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">
                🏛️ {{ $user->municipality->name }}
            </span>
            @endif
        </div>

        <!-- Статистика (карточки) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

            <!-- Пользователи -->
            <x-card title="👥 Пользователи" class="hover:shadow-xl transition-shadow duration-300">
                <p class="text-3xl font-bold text-indigo-600 mb-2">
                    {{ \App\Models\User::active()->count() }}
                </p>
                <p class="text-gray-500 text-sm mb-4">Участники, наставники, координаторы</p>
                <a href="#" class="block w-full text-center px-4 py-2 border-2 border-indigo-600 text-indigo-600 font-semibold rounded-lg hover:bg-indigo-600 hover:text-white transition-all duration-300">
                    Управление →
                </a>
            </x-card>

            <!-- События -->
            <x-card title="📅 События" class="hover:shadow-xl transition-shadow duration-300">
                <p class="text-3xl font-bold text-green-600 mb-2">
                    {{ \App\Models\Event::count() }}
                </p>
                <p class="text-gray-500 text-sm mb-4">Муниципальный и региональный этапы</p>
                <a href="#" class="block w-full text-center px-4 py-2 border-2 border-green-600 text-green-600 font-semibold rounded-lg hover:bg-green-600 hover:text-white transition-all duration-300">
                    Календарь →
                </a>
            </x-card>

            <!-- Новости -->
            <x-card title="📰 Новости" class="hover:shadow-xl transition-shadow duration-300">
                <p class="text-3xl font-bold text-purple-600 mb-2">
                    {{ \App\Models\News::count() }}
                </p>
                <p class="text-gray-500 text-sm mb-4">Публикации и объявления</p>
                <a href="{{ route('news.index') }}" class="block w-full text-center px-4 py-2 border-2 border-purple-600 text-purple-600 font-semibold rounded-lg hover:bg-purple-600 hover:text-white transition-all duration-300">
                    Все новости →
                </a>
            </x-card>

            <!-- Команды -->
            <x-card title="🏆 Команды" class="hover:shadow-xl transition-shadow duration-300">
                <p class="text-3xl font-bold text-blue-600 mb-2">
                    {{ \App\Models\Team::count() }}
                </p>
                <p class="text-gray-500 text-sm mb-4">Зарегистрированные команды</p>
                <a href="#" class="block w-full text-center px-4 py-2 border-2 border-blue-600 text-blue-600 font-semibold rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-300">
                    Список →
                </a>
            </x-card>
        </div>

        <!-- Быстрые действия -->
        <x-card title="⚡ Быстрые действия" class="mb-8">
            <div class="flex flex-wrap gap-4">

                <!-- Опубликовать новость -->
                <a href="{{ route('news.create') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white font-semibold rounded-lg border-2 border-green-600 hover:bg-white hover:text-green-600 transition-all duration-300 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Опубликовать новость
                </a>

                <!-- Добавить событие -->
                <a href="#"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg border-2 border-indigo-600 hover:bg-white hover:text-indigo-600 transition-all duration-300 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Добавить событие
                </a>

                <!-- Управление командами -->
                <a href="#"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg border-2 border-blue-600 hover:bg-white hover:text-blue-600 transition-all duration-300 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Команды
                </a>

                <!-- Экспорт данных -->
                <a href="#"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg border-2 border-gray-600 hover:bg-white hover:text-gray-600 transition-all duration-300 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Экспорт
                </a>
            </div>
        </x-card>

        <!-- 🔥 НОВОЕ: Ожидают подтверждения (удаление) -->
        @php
            $pendingDeletions = \App\Models\User::where('marked_for_deletion', true)
                ->with('roles', 'municipality', 'organization')
                ->latest()
                ->take(5)
                ->get();
        @endphp

        @if($pendingDeletions->count() > 0)
            <x-card title="⏳ Ожидают подтверждения" class="mb-8">
                <p class="text-sm text-gray-500 mb-4">Пользователи, помеченные на удаление координаторами/наставниками</p>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Пользователь</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Роль</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Муниципалитет</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Причина</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pendingDeletions as $pending)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $pending->getFullNameAttribute() }}</div>
                                    <div class="text-xs text-gray-500">{{ $pending->email }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    @foreach($pending->roles as $role)
                                        <span class="inline-block px-2 py-0.5 text-xs rounded bg-blue-100 text-blue-800">
                                    {{ $role->display_name ?? $role->name }}
                                </span>
                                    @endforeach
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $pending->municipality->name ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 max-w-xs truncate" title="{{ $pending->deletion_reason }}">
                                    {{ $pending->deletion_reason ?? 'Не указана' }}
                                </td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="{{ route('users.confirm-deletion', $pending) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                onclick="return confirm('Подтвердить удаление пользователя {{ addslashes($pending->getFullNameAttribute()) }}?')"
                                                class="text-red-600 hover:text-red-800 text-sm font-medium inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Подтвердить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        @endif

    </div>
@endsection
