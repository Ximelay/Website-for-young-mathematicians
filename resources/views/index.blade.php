@extends('layouts.app')

@section('title', 'Главная - Турнир юных математиков')

@section('content')

    {{-- Hero --}}
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
            <h1 class="text-4xl font-bold sm:text-5xl md:text-6xl">Турнир юных математиков</h1>
            <p class="mt-4 text-xl sm:text-2xl">памяти А.А. Кошкина</p>
            <p class="mt-4 text-lg text-indigo-100 max-w-2xl mx-auto">
                Ежегодное интеллектуальное соревнование для школьников региона
            </p>
            <div class="mt-8 flex justify-center gap-4">
                @guest
                    <a href="{{ route('register') }}"
                       class="px-8 py-3 bg-white text-indigo-600 font-semibold rounded-xl hover:bg-gray-100 transition shadow">
                        Зарегистрироваться
                    </a>
                @endguest
                <a href="{{ route('calendar') }}"
                   class="px-8 py-3 bg-indigo-700 text-white font-semibold rounded-xl hover:bg-indigo-800 transition shadow">
                    📅 Календарь событий
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- Статистика --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
            @php
                $statsConfig = [
                    ['label' => 'Участников',   'value' => $stats['participants'],  'color' => 'indigo',  'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                    ['label' => 'Команд',        'value' => $stats['teams'],         'color' => 'green',   'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
                    ['label' => 'Организаций',  'value' => $stats['organizations'], 'color' => 'yellow',  'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                    ['label' => 'Новостей',     'value' => $stats['news'],          'color' => 'purple',  'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ];
            @endphp
            @foreach($statsConfig as $s)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-{{ $s['color'] }}-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-{{ $s['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['icon'] }}"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ $s['label'] }}</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $s['value'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Новости + События --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Последние новости --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900">📰 Последние новости</h2>
                    <a href="{{ route('news.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Все →</a>
                </div>
                @forelse($latestNews as $news)
                    <a href="{{ route('news.show', $news) }}"
                       class="flex items-start gap-4 px-6 py-4 border-b border-gray-50 last:border-0 hover:bg-gray-50 transition group">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center flex-shrink-0 mt-0.5 group-hover:bg-indigo-200 transition">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition truncate">
                                {{ $news->title }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">
                                {{ Str::limit(strip_tags($news->content), 90) }}
                            </p>
                            <div class="flex items-center gap-3 mt-1.5 text-xs text-gray-400">
                                <span>{{ $news->published_at->format('d.m.Y') }}</span>
                                @if($news->author)
                                    <span>{{ $news->author->first_name }} {{ mb_substr($news->author->last_name, 0, 1) }}.</span>
                                @endif
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-indigo-400 transition flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @empty
                    <div class="flex flex-col items-center justify-center py-14 text-center px-6">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 font-medium text-sm">Новостей пока нет</p>
                        <p class="text-gray-400 text-xs mt-1">Скоро здесь появятся актуальные новости</p>
                    </div>
                @endforelse
            </div>

            {{-- Ближайшие события --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900">📅 Ближайшие события</h2>
                    <a href="{{ route('calendar') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Все →</a>
                </div>
                @php
                    $typeColors = [
                        'municipal_stage' => ['bg' => 'bg-blue-100',   'text' => 'text-blue-700'],
                        'regional_stage'  => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
                        'meeting'         => ['bg' => 'bg-green-100',  'text' => 'text-green-700'],
                        'deadline'        => ['bg' => 'bg-red-100',    'text' => 'text-red-700'],
                        'other'           => ['bg' => 'bg-gray-100',   'text' => 'text-gray-600'],
                    ];
                @endphp
                @forelse($upcomingEvents as $event)
                    @php
                        $tc = $typeColors[$event->type] ?? $typeColors['other'];
                        $daysLeft = (int) now()->startOfDay()->diffInDays($event->start_date->startOfDay(), false);
                    @endphp
                    <div class="flex items-start gap-4 px-6 py-4 border-b border-gray-50 last:border-0 hover:bg-gray-50 transition">
                        {{-- Дата-блок --}}
                        <div class="flex-shrink-0 w-12 text-center">
                            <div class="bg-indigo-600 text-white text-xs font-bold rounded-t-lg py-0.5">
                                {{ mb_strtoupper($event->start_date->translatedFormat('M')) }}
                            </div>
                            <div class="bg-indigo-50 border border-indigo-100 text-indigo-900 text-xl font-bold rounded-b-lg py-1 leading-none">
                                {{ $event->start_date->format('d') }}
                            </div>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $event->title }}</h3>
                            <div class="flex flex-wrap items-center gap-2 mt-1">
                                <span class="px-2 py-0.5 text-xs rounded-full font-medium {{ $tc['bg'] }} {{ $tc['text'] }}">
                                    {{ $event->getTypeName() }}
                                </span>
                                @if($event->location)
                                    <span class="text-xs text-gray-400 truncate">📍 {{ Str::limit($event->location, 28) }}</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 mt-1 text-xs text-gray-400">
                                <span>{{ $event->start_date->format('d.m.Y, H:i') }}</span>
                                @if($daysLeft === 0)
                                    <span class="font-semibold text-orange-500">Сегодня!</span>
                                @elseif($daysLeft > 0 && $daysLeft <= 7)
                                    <span class="font-semibold text-orange-400">Через {{ $daysLeft }} дн.</span>
                                @endif
                            </div>
                        </div>
                        @auth
                            @if(auth()->user()->hasRole('organizer'))
                                <a href="{{ route('events.edit', $event) }}"
                                   class="flex-shrink-0 p-1.5 text-gray-300 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                   title="Редактировать">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                            @endif
                        @endauth
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-14 text-center px-6">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 font-medium text-sm">Событий пока нет</p>
                        <p class="text-gray-400 text-xs mt-1">Запланированные события появятся здесь</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
@endsection
