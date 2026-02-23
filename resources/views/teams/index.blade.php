@extends('layouts.app')

@section('title', 'Мои команды')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if (session('success'))
            <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
        @endif

        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">🏆 Мои команды</h1>
                <p class="text-gray-500 mt-1">Управление командами</p>
            </div>
            <a href="{{ route('teams.create') }}"
               class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                ➕ Создать команду
            </a>
        </div>

        <x-card>
            @forelse($teams as $team)
                <div class="flex items-center justify-between p-4 border-b border-gray-200 last:border-0 hover:bg-gray-50">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <span class="text-indigo-600 font-bold text-lg">🏆</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $team->name }}</h3>
                            <p class="text-sm text-gray-500">
                                🏫 {{ $team->organization->name ?? '—' }} •
                                🏛️ {{ $team->municipality->name ?? '—' }} •
                                {{ $team->grade }} класс
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                👥 Участников: {{ $team->members->count() }} •
                                👨‍🏫 Наставник: {{ $team->mentor->getFullNameAttribute() }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('teams.show', $team) }}"
                           class="px-4 py-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            Просмотр
                        </a>
                        <a href="{{ route('teams.edit', $team) }}"
                           class="px-4 py-2 text-sm text-blue-600 hover:text-blue-800 font-medium">
                            Редактировать
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <p class="mt-2 text-gray-500 text-lg">Команд пока нет</p>
                    <p class="mt-1 text-gray-400 text-sm">Создайте первую команду, чтобы начать работу</p>
                    <a href="{{ route('teams.create') }}"
                       class="mt-4 inline-block px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                        ➕ Создать команду
                    </a>
                </div>
            @endforelse

            @if($teams->hasPages())
                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $teams->links() }}
                </div>
            @endif
        </x-card>

    </div>
@endsection
