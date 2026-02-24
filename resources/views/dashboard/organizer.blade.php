@extends('layouts.app')

@section('title', 'Личный кабинет — Организатор')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if (session('error'))
        <x-alert type="danger" class="mb-6">{{ session('error') }}</x-alert>
    @endif
    @if (session('success'))
        <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
    @endif

    {{-- Шапка --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-indigo-600 flex items-center justify-center shadow flex-shrink-0">
                <span class="text-2xl font-bold text-white">
                    {{ mb_strtoupper(mb_substr($user->first_name, 0, 1)) }}
                </span>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $user->full_name }}</h1>
                <div class="flex flex-wrap items-center gap-2 mt-1">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700">Организатор</span>
                    @if($user->municipality)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">
                            🏛️ {{ $user->municipality->name }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Статистика --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @php
            $statCards = [
                ['label' => 'Пользователей', 'value' => $stats['users'],  'color' => 'indigo',  'route' => route('users.index'),  'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                ['label' => 'Событий',       'value' => $stats['events'], 'color' => 'green',   'route' => route('calendar'),     'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['label' => 'Новостей',      'value' => $stats['news'],   'color' => 'purple',  'route' => route('news.index'),   'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
                ['label' => 'Команд',        'value' => $stats['teams'],  'color' => 'blue',    'route' => route('teams.index'),  'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
            ];
        @endphp
        @foreach($statCards as $card)
            <a href="{{ $card['route'] }}"
               class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md hover:border-{{ $card['color'] }}-200 transition group">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-{{ $card['color'] }}-100 flex items-center justify-center group-hover:bg-{{ $card['color'] }}-200 transition">
                        <svg class="w-5 h-5 text-{{ $card['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                        </svg>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-{{ $card['color'] }}-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-0.5">{{ $card['value'] }}</p>
                <p class="text-sm text-gray-500">{{ $card['label'] }}</p>
            </a>
        @endforeach
    </div>

    {{-- Быстрые действия --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="font-semibold text-gray-900 mb-4">⚡ Быстрые действия</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('news.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-600 text-white text-sm font-semibold rounded-xl hover:bg-green-700 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Написать новость
            </a>
            <a href="{{ route('events.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Добавить событие
            </a>
            <a href="{{ route('teams.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Команды
            </a>
            <a href="{{ route('users.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Пользователи
            </a>
        </div>
    </div>

    {{-- Ожидают подтверждения --}}
    @if($pendingDeletions->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-red-100 flex items-center justify-between bg-red-50">
                <div>
                    <h2 class="font-semibold text-gray-900">⏳ Ожидают подтверждения удаления</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Помечены координаторами или наставниками</p>
                </div>
                <span class="px-2.5 py-0.5 bg-red-100 text-red-700 text-xs font-semibold rounded-full">
                    {{ $pendingDeletions->count() }}
                </span>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($pendingDeletions as $pending)
                    <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-red-700 font-semibold text-sm">
                                    {{ mb_strtoupper(mb_substr($pending->first_name, 0, 1) . mb_substr($pending->last_name, 0, 1)) }}
                                </span>
                            </div>
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-gray-900">{{ $pending->full_name }}</div>
                                <div class="text-xs text-gray-400">{{ $pending->email }} • {{ $pending->municipality->name ?? '—' }}</div>
                                @if($pending->deletion_reason)
                                    <div class="text-xs text-red-600 mt-0.5 truncate max-w-xs" title="{{ $pending->deletion_reason }}">
                                        Причина: {{ $pending->deletion_reason }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0 ml-4">
                            @foreach($pending->roles as $role)
                                @php
                                    $labels = ['participant'=>'Участник','mentor'=>'Наставник','organizer'=>'Организатор','municipal_coordinator'=>'Координатор'];
                                @endphp
                                <span class="hidden sm:inline text-xs px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full">
                                    {{ $labels[$role->name] ?? $role->name }}
                                </span>
                            @endforeach
                            <form method="POST" action="{{ route('users.confirm-deletion', $pending) }}">
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('Деактивировать {{ addslashes($pending->full_name) }}?')"
                                        class="px-3 py-1.5 bg-red-600 text-white text-xs font-semibold rounded-lg hover:bg-red-700 transition">
                                    Подтвердить
                                </button>
                            </form>
                            <form method="POST" action="{{ route('users.cancel-deletion', $pending) }}">
                                @csrf
                                <button type="submit"
                                        class="px-3 py-1.5 bg-white border border-gray-200 text-gray-600 text-xs font-semibold rounded-lg hover:bg-gray-50 transition">
                                    Отмена
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
