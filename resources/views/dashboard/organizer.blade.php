@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if (session('success'))
            <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
        @endif

        <!-- Заголовок -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">🎯 Личный кабинет</h1>
            <p class="text-gray-500 mt-1">Панель управления — Организатор</p>
            @if ($user->municipality)
                <span class="inline-block mt-2 px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">
                🏛️ {{ $user->municipality->name }}
            </span>
            @endif
        </div>

        <!-- Статистика (карточки) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <!-- Пользователи -->
            <x-card title="👥 Пользователи" class="hover:shadow-xl transition-shadow duration-300">
                <p class="text-3xl font-bold text-indigo-600 mb-2">
                    {{ \App\Models\User::active()->count() }}
                </p>
                <p class="text-gray-500 text-sm mb-4">Управление участниками, наставниками и координаторами</p>
                <a href="#" class="block w-full text-center px-4 py-2 border-2 border-indigo-600 text-indigo-600 font-semibold rounded-lg hover:bg-indigo-600 hover:text-white transition-all duration-300">
                    Перейти →
                </a>
            </x-card>

            <!-- События -->
            <x-card title="📅 События" class="hover:shadow-xl transition-shadow duration-300">
                <p class="text-3xl font-bold text-green-600 mb-2">
                    {{ \App\Models\Event::count() }}
                </p>
                <p class="text-gray-500 text-sm mb-4">Создание и управление событиями турнира</p>
                <a href="#" class="block w-full text-center px-4 py-2 border-2 border-green-600 text-green-600 font-semibold rounded-lg hover:bg-green-600 hover:text-white transition-all duration-300">
                    Перейти →
                </a>
            </x-card>

            <!-- Новости -->
            <x-card title="📰 Новости" class="hover:shadow-xl transition-shadow duration-300">
                <p class="text-3xl font-bold text-purple-600 mb-2">
                    {{ \App\Models\News::count() }}
                </p>
                <p class="text-gray-500 text-sm mb-4">Публикация новостей и объявлений</p>
                <a href="{{ route('news.index') }}" class="block w-full text-center px-4 py-2 border-2 border-purple-600 text-purple-600 font-semibold rounded-lg hover:bg-purple-600 hover:text-white transition-all duration-300">
                    Перейти →
                </a>
            </x-card>
        </div>

        <!-- Быстрые действия -->
        <x-card title="⚡ Быстрые действия">
            <div class="flex flex-wrap gap-4">

                <!-- Добавить событие -->
                <a href="#"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg border-2 border-indigo-600 hover:bg-white hover:text-indigo-600 transition-all duration-300 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Добавить событие
                </a>

                <!-- Опубликовать новость (РАБОТАЮЩАЯ ССЫЛКА!) -->
                <a href="{{ route('news.create') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white font-semibold rounded-lg border-2 border-green-600 hover:bg-white hover:text-green-600 transition-all duration-300 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Опубликовать новость
                </a>

                <!-- Управление командами -->
                <a href="#"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg border-2 border-blue-600 hover:bg-white hover:text-blue-600 transition-all duration-300 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Команды
                </a>

                <!-- Результаты этапов -->
                <a href="#"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg border-2 border-gray-600 hover:bg-white hover:text-gray-600 transition-all duration-300 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Результаты
                </a>
            </div>
        </x-card>

    </div>
@endsection
