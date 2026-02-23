@extends('layouts.app')

@section('title', 'Главная - Турнир юных математиков')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-4xl font-bold sm:text-5xl md:text-6xl">
                Турнир юных математиков
            </h1>
            <p class="mt-4 text-xl sm:text-2xl">
                памяти А.А. Кошкина
            </p>
            <p class="mt-4 text-lg text-indigo-100 max-w-2xl mx-auto">
                Ежегодное интеллектуальное соревнование для школьников региона
            </p>
            <div class="mt-8 flex justify-center gap-4">
                <a href="#" class="px-8 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-gray-100 transition">
                    Зарегистрироваться
                </a>
                <a href="#" class="px-8 py-3 bg-indigo-700 text-white font-semibold rounded-lg hover:bg-indigo-800 transition">
                    Узнать больше
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Status Info -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <x-alert type="success">
        <strong>База данных успешно создана!</strong> Все таблицы и модели готовы к использованию. Миграции выполнены.
    </x-alert>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Участников</p>
                    <p class="text-2xl font-semibold text-gray-900">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Команд</p>
                    <p class="text-2xl font-semibold text-gray-900">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Организаций</p>
                    <p class="text-2xl font-semibold text-gray-900">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Новостей</p>
                    <p class="text-2xl font-semibold text-gray-900">0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <!-- Latest News -->
        <x-card title="Последние новости">
            <div class="text-center py-12 text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <p class="mt-4">Новостей пока нет</p>
                <p class="text-sm">Скоро здесь появятся актуальные новости турнира</p>
            </div>
        </x-card>

        <!-- Upcoming Events -->
        <x-card title="Предстоящие события">
            @if(isset($upcomingEvents) && $upcomingEvents->isEmpty())
                <div class="text-center py-12 text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="mt-4">События не запланированы</p>
                    <p class="text-sm">Календарь событий будет доступен позже</p>
                </div>
            @elseif(isset($upcomingEvents))
                <div class="space-y-4">
                    @foreach($upcomingEvents as $event)
                        <div class="border-b pb-4">
                            <h3 class="text-lg font-semibold">{{ $event->title }}</h3>
                            <p class="text-gray-600">{{ $event->description }}</p>
                            <p class="text-gray-500 flex items-center">
                                <svg class="h-4 w-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $event->start_date->format('d.m.Y H:i') }}
                            </p>
                            <p class="text-gray-500 flex items-center">
                                <svg class="h-4 w-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $event->location }}
                            </p>
                            <p class="text-gray-500">
                                Тип: <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            {{ $event->getTypeName() }}
                        </span>
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 text-gray-500">
                    <p class="mt-4">События не загружены</p>
                </div>
            @endif
        </x-card>

    <!-- System Info -->
    <div class="bg-blue-50 rounded-lg p-8 mb-12">
        <h3 class="text-xl font-semibold text-blue-900 mb-6">Информация для разработчиков</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h4 class="font-semibold text-blue-900 mb-3">База данных</h4>
                <ul class="space-y-2 text-blue-800 text-sm">
                    <li>15 моделей созданы</li>
                    <li>RBAC система настроена</li>
                    <li>Связи между таблицами</li>
                    <li>Миграции выполнены</li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-blue-900 mb-3">Роли пользователей</h4>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <span class="inline-block px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold mr-2">Организатор</span>
                        <span class="text-sm text-blue-700">Полный доступ</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold mr-2">Координатор</span>
                        <span class="text-sm text-blue-700">Муниципалитет</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold mr-2">Наставник</span>
                        <span class="text-sm text-blue-700">Команда</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold mr-2">Участник</span>
                        <span class="text-sm text-blue-700">Просмотр</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6">
            <h4 class="font-semibold text-gray-900 mb-4">Документация</h4>
            <p class="text-gray-700 mb-4">
                Файл <code class="bg-gray-100 px-2 py-1 rounded text-sm">MODELS_DOCUMENTATION.md</code> в корне проекта содержит полную документацию по моделям, связям и примеры использования.
            </p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm text-gray-600">
                <div>• User</div>
                <div>• Role</div>
                <div>• Municipality</div>
                <div>• Organization</div>
                <div>• Team</div>
                <div>• Event</div>
                <div>• News</div>
                <div>• Material</div>
                <div>• MunicipalStage</div>
                <div>• RegionalStage</div>
                <div>• Review</div>
                <div>• ConsentDocument</div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="/examples" class="block bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
            <div class="flex items-center mb-3">
                <svg class="h-8 w-8 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900">Примеры компонентов</h3>
            </div>
            <p class="text-gray-600">Посмотрите примеры всех готовых компонентов и элементов интерфейса</p>
        </a>

        <div class="block bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center mb-3">
                <svg class="h-8 w-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900">Документация</h3>
            </div>
            <p class="text-gray-600">Читайте DEVELOPER_GUIDE.md и MODELS_DOCUMENTATION.md в корне проекта</p>
        </div>

        <div class="block bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center mb-3">
                <svg class="h-8 w-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900">Быстрый старт</h3>
            </div>
            <p class="text-gray-600">Ознакомьтесь с QUICKSTART.md для начала разработки</p>
        </div>
    </div>
</div>
@endsection
