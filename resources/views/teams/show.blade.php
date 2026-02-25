@extends('layouts.app')

@section('title', 'Команда: ' . $team->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Уведомления --}}
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
        <a href="{{ route('teams.index') }}" class="hover:text-indigo-600 transition">Команды</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">{{ $team->name }}</span>
    </nav>

    {{-- Hero-шапка --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                {{-- Аватар команды --}}
                <div class="w-16 h-16 rounded-2xl bg-indigo-600 flex items-center justify-center flex-shrink-0 shadow">
                    <span class="text-2xl font-bold text-white">
                        {{ mb_strtoupper(mb_substr($team->name, 0, 1)) }}
                    </span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $team->name }}</h1>
                    <div class="flex flex-wrap items-center gap-2 mt-1.5">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium
                            {{ $team->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $team->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                            {{ $team->is_active ? 'Активна' : 'Неактивна' }}
                        </span>
                        @if($team->grade)
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">
                                {{ $team->grade }} класс
                            </span>
                        @endif
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                            👥 {{ $team->members->count() }} участников
                        </span>
                    </div>
                    @if($team->description)
                        <p class="text-sm text-gray-500 mt-2">{{ $team->description }}</p>
                    @endif
                </div>
            </div>

            {{-- Кнопки действий --}}
            @if(auth()->user()->hasAnyRole(['mentor', 'organizer']))
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('teams.edit', $team) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Редактировать
                    </a>
                    <form method="POST" action="{{ route('teams.destroy', $team) }}">
                        @csrf @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Удалить команду «{{ addslashes($team->name) }}»?\nУчастники останутся в системе без команды.')"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-red-200 text-red-600 text-sm font-semibold rounded-lg hover:bg-red-50 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Удалить
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Левая колонка: информация --}}
        <div class="space-y-5">

            {{-- Карточка сведений --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-900">ℹ️ Сведения о команде</h2>
                </div>
                <div class="divide-y divide-gray-50">
                    <div class="px-5 py-3.5 flex justify-between items-start gap-3">
                        <span class="text-sm text-gray-500 flex-shrink-0">Наставник</span>
                        <span class="text-sm font-medium text-gray-900 text-right">
                            {{ $team->mentor?->full_name ?? '—' }}
                        </span>
                    </div>
                    <div class="px-5 py-3.5 flex justify-between items-start gap-3">
                        <span class="text-sm text-gray-500 flex-shrink-0">Муниципалитет</span>
                        <span class="text-sm font-medium text-gray-900 text-right">
                            {{ $team->municipality?->name ?? '—' }}
                        </span>
                    </div>
                    <div class="px-5 py-3.5 flex justify-between items-start gap-3">
                        <span class="text-sm text-gray-500 flex-shrink-0">Организация</span>
                        <span class="text-sm font-medium text-gray-900 text-right">
                            {{ $team->organization?->name ?? '—' }}
                        </span>
                    </div>
                    <div class="px-5 py-3.5 flex justify-between items-center gap-3">
                        <span class="text-sm text-gray-500">Создана</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $team->created_at->format('d.m.Y') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Добавить участника --}}
            @if(auth()->user()->hasAnyRole(['mentor', 'organizer']))
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h2 class="font-semibold text-gray-900">➕ Добавить участника</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Участники без команды</p>
                    </div>
                    <div class="p-5">
                        @if($freeParticipants->isEmpty())
                            <p class="text-sm text-gray-400 text-center py-2">Нет свободных участников</p>
                        @else
                            <form method="POST" action="{{ route('teams.add-participant', $team) }}" class="space-y-3">
                                @csrf
                                <div>
                                    <select name="user_id" required
                                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('user_id') border-red-400 @enderror">
                                        <option value="">— Выберите участника —</option>
                                        @foreach($freeParticipants as $p)
                                            <option value="{{ $p->id }}" {{ old('user_id') == $p->id ? 'selected' : '' }}>
                                                {{ $p->full_name }} ({{ $p->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit"
                                        class="w-full py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">
                                    Добавить в команду
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- Правая колонка: участники --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900">👥 Участники</h2>
                    <span class="px-2.5 py-0.5 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full">
                        {{ $team->members->count() }}
                    </span>
                </div>

                @forelse($team->members as $member)
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50 last:border-0 hover:bg-gray-50 transition">
                        <div class="flex items-center gap-3 min-w-0">
                            {{-- Аватар --}}
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center flex-shrink-0 shadow-sm">
                                <span class="text-white font-semibold text-sm">
                                    {{ mb_strtoupper(mb_substr($member->first_name, 0, 1) . mb_substr($member->last_name, 0, 1)) }}
                                </span>
                            </div>
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-gray-900 truncate">{{ $member->full_name }}</div>
                                <div class="text-xs text-gray-400 truncate">{{ $member->email }}</div>
                                @if($member->grade)
                                    <div class="text-xs text-gray-400">{{ $member->grade }} класс</div>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-3 flex-shrink-0 ml-4">
                            {{-- Роли --}}
                            <div class="hidden sm:flex gap-1">
                                @foreach($member->roles as $role)
                                    @php
                                        $badge = match($role->name) {
                                            'participant'           => 'bg-yellow-100 text-yellow-700',
                                            'mentor'                => 'bg-green-100 text-green-700',
                                            'organizer'             => 'bg-purple-100 text-purple-700',
                                            'municipal_coordinator' => 'bg-blue-100 text-blue-700',
                                            default                 => 'bg-gray-100 text-gray-700',
                                        };
                                        $label = match($role->name) {
                                            'participant'           => 'Участник',
                                            'mentor'                => 'Наставник',
                                            'organizer'             => 'Организатор',
                                            'municipal_coordinator' => 'Координатор',
                                            default                 => $role->name,
                                        };
                                    @endphp
                                    <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $badge }}">
                                        {{ $label }}
                                    </span>
                                @endforeach
                            </div>

                            {{-- Удалить --}}
                            @if(auth()->user()->hasAnyRole(['mentor', 'organizer']))
                                <form method="POST" action="{{ route('teams.remove-participant', [$team, $member]) }}">
                                    @csrf
                                    <button type="submit"
                                            onclick="return confirm('Убрать {{ addslashes($member->full_name) }} из команды?')"
                                            class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                            title="Убрать из команды">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6h8m5-5l5 5m0-5l-5 5"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 font-medium">Участников пока нет</p>
                        <p class="text-gray-400 text-sm mt-1">Добавьте первого участника через форму слева</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
