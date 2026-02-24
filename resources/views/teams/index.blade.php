@extends('layouts.app')

@section('title', 'Мои команды')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if (session('success'))
        <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
    @endif
    @if (session('error'))
        <x-alert type="danger" class="mb-6">{{ session('error') }}</x-alert>
    @endif

    {{-- Хлебные крошки --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Кабинет</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">Команды</span>
    </nav>

    {{-- Заголовок --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">🏆 Команды</h1>
            <p class="text-sm text-gray-500 mt-0.5">
                @if(auth()->user()->hasRole('organizer')) Все команды турнира
                @else Команды, которыми вы руководите
                @endif
            </p>
        </div>
        @if(auth()->user()->hasRole('mentor'))
            <a href="{{ route('teams.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Создать команду
            </a>
        @endif
    </div>

    {{-- Список --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @forelse($teams as $team)
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50 last:border-0 hover:bg-gray-50 transition">
                <div class="flex items-center gap-4 min-w-0">
                    <div class="w-11 h-11 rounded-xl bg-indigo-600 flex items-center justify-center flex-shrink-0 shadow-sm">
                        <span class="text-white font-bold text-sm">
                            {{ mb_strtoupper(mb_substr($team->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $team->name }}</h3>
                            <span class="flex-shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $team->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $team->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                {{ $team->is_active ? 'Активна' : 'Неактивна' }}
                            </span>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 mt-0.5 text-xs text-gray-400">
                            @if($team->organization)
                                <span>🏫 {{ $team->organization->name }}</span>
                            @endif
                            @if($team->municipality)
                                <span>🏛️ {{ $team->municipality->name }}</span>
                            @endif
                            @if($team->grade)
                                <span>📚 {{ $team->grade }} класс</span>
                            @endif
                            <span>👥 {{ $team->members->count() }} участников</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0 ml-4">
                    <a href="{{ route('teams.show', $team) }}"
                       class="px-3 py-1.5 text-xs font-semibold text-indigo-600 border border-indigo-200 rounded-lg hover:bg-indigo-50 transition">
                        Открыть
                    </a>
                    <a href="{{ route('teams.edit', $team) }}"
                       class="px-3 py-1.5 text-xs font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        Изменить
                    </a>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-gray-700 font-semibold">Команд пока нет</p>
                @if(auth()->user()->hasRole('mentor'))
                    <p class="text-gray-400 text-sm mt-1 mb-4">Создайте первую команду и добавьте участников</p>
                    <a href="{{ route('teams.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Создать команду
                    </a>
                @endif
            </div>
        @endforelse

        @if($teams->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $teams->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
