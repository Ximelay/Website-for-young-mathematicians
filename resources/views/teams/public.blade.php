@extends('layouts.app')

@section('title', 'Команды турнира')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if (session('success'))
            <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
        @endif
        @if (session('error'))
            <x-alert type="error" class="mb-6">{{ session('error') }}</x-alert>
        @endif

        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">🏆 Команды турнира</h1>
                <p class="text-gray-500 mt-1">Активные команды, участвующие в турнире</p>
            </div>
            @auth
                @if(auth()->user()->hasRole('participant') && auth()->user()->team_id)
                    <form method="POST" action="{{ route('teams.leave') }}">
                        @csrf
                        <button type="submit"
                                onclick="return confirm('Вы уверены, что хотите выйти из команды?')"
                                class="px-5 py-2.5 bg-red-100 text-red-700 font-semibold rounded-lg hover:bg-red-200 transition">
                            🚪 Выйти из команды
                        </button>
                    </form>
                @endif
            @endauth
        </div>

        <x-card>
            @forelse($teams as $team)
                @php
                    $isMember = auth()->check() && auth()->user()->team_id === $team->id;
                @endphp
                <div class="flex items-center justify-between p-4 border-b border-gray-200 last:border-0 hover:bg-gray-50 {{ $isMember ? 'bg-indigo-50' : '' }}">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <span class="text-indigo-600 font-bold text-lg">🏆</span>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $team->name }}</h3>
                                @if($isMember)
                                    <span class="px-2 py-0.5 text-xs bg-indigo-100 text-indigo-700 rounded-full font-medium">Ваша команда</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 mt-0.5">
                                🏛️ {{ $team->municipality->name ?? '—' }}
                                @if($team->mentor)
                                    • 👨‍🏫 {{ $team->mentor->full_name }}
                                @endif
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                👥 Участников: {{ $team->members_count }}
                            </p>
                        </div>
                    </div>

                    @auth
                        @if(auth()->user()->hasRole('participant'))
                            <div class="flex-shrink-0">
                                @if($isMember)
                                    {{-- Уже в этой команде — кнопка выхода --}}
                                    <form method="POST" action="{{ route('teams.leave') }}">
                                        @csrf
                                        <button type="submit"
                                                onclick="return confirm('Выйти из команды «{{ addslashes($team->name) }}»?')"
                                                class="px-4 py-2 text-sm text-red-600 hover:text-red-800 font-medium border border-red-200 rounded-lg hover:bg-red-50 transition">
                                            Выйти
                                        </button>
                                    </form>
                                @elseif(!auth()->user()->team_id)
                                    {{-- Ещё не в команде — кнопка вступить --}}
                                    <form method="POST" action="{{ route('teams.join', $team) }}">
                                        @csrf
                                        <button type="submit"
                                                class="px-4 py-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium border border-indigo-200 rounded-lg hover:bg-indigo-50 transition">
                                            Вступить
                                        </button>
                                    </form>
                                @else
                                    {{-- Уже в другой команде --}}
                                    <span class="text-xs text-gray-400">Вы в другой команде</span>
                                @endif
                            </div>
                        @endif
                    @endauth
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    <p class="mt-2 text-gray-500 text-lg">Команд пока нет</p>
                    <p class="mt-1 text-gray-400 text-sm">Активные команды появятся здесь после регистрации</p>
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
