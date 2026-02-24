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
                    <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-gray-100 transition">
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
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['participants'] }}</p>
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
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['teams'] }}</p>
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
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['organizations'] }}</p>
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
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['news'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">

            <!--  Последние новости -->
            <!-- Последние новости -->
            <x-card title="📰 Последние новости" class="mb-8">
                @forelse($latestNews as $news)
                    <div class="mb-6 pb-6 border-b border-gray-200 last:border-b-0 last:mb-0 last:pb-0">

                        <!-- Заголовок -->
                        <h3 class="text-lg font-bold text-gray-900 mb-3 hover:text-indigo-600 transition-colors">
                            <a href="{{ route('news.show', $news) }}" class="hover:text-indigo-600">
                                {{ $news->title }}
                            </a>
                        </h3>

                        <!-- Контент с авто-ссылками -->
                        <div class="text-gray-600 text-sm mb-3 leading-relaxed">
                            <div class="text-gray-600 text-sm mb-3 leading-relaxed">
                                @php
                                    $text = $news->content;
                                    // Простой парсинг URL
                                    $text = preg_replace(
                                        '/(https?:\/\/[^\s<]+)/i',
                                        '<a href="$1" target="_blank" rel="noopener" class="text-indigo-600 hover:text-indigo-800 underline">$1</a>',
                                        $text
                                    );
                                @endphp
                                {!! nl2br($text) !!}
                            </div>
                        </div>

                        <!-- Мета-информация -->
                        <div class="flex items-center justify-between text-xs text-gray-500 pt-2">
                            <div class="flex items-center gap-3">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $news->published_at->format('d.m.Y') }}
                    </span>

                                @if($news->author)
                                    <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ $news->author->first_name }} {{ mb_substr($news->author->last_name, 0, 1) }}.
                        </span>
                                @endif
                            </div>

                            <a href="{{ route('news.show', $news) }}" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center gap-1 transition-colors">
                                Читать
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <!-- Заглушка -->
                    <div class="text-center py-12 px-4">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <p class="text-gray-500 font-medium">Новостей пока нет</p>
                        <p class="text-gray-400 text-sm mt-1">Скоро здесь появятся актуальные новости</p>
                    </div>
                @endforelse

                @if($latestNews->count() > 0)
                    <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                        <a href="{{ route('news.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-semibold transition-colors">
                            Все новости
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                @endif
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
    </div>
@endsection
