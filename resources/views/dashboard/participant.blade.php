@extends('layouts.app')

@section('title', 'Личный кабинет — Участник')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if (session('success'))
        <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
    @endif

    @php
        $materials = \App\Models\Material::published()->latest()->take(3)->get();
        $news = \App\Models\News::published()->latest()->take(3)->get();
        $teammates = $user->team?->members->where('is_active', true)->where('id', '!=', $user->id);
    @endphp

    {{-- Шапка --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow flex-shrink-0">
                <span class="text-2xl font-bold text-white">{{ mb_strtoupper(mb_substr($user->first_name, 0, 1)) }}</span>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $user->full_name }}</h1>
                <div class="flex flex-wrap items-center gap-2 mt-1">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Участник</span>
                    @if($user->grade)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">{{ $user->grade }} класс</span>
                    @endif
                    @if($user->municipality)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">
                            🏛️ {{ $user->municipality->name }}
                        </span>
                    @endif
                    @if($user->organization)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                            🏫 {{ $user->organization->name }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Левая колонка --}}
        <div class="space-y-5">

            {{-- Моя команда --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-900">🏅 Моя команда</h2>
                </div>
                @if($user->team)
                    <div class="p-5 space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold text-sm">{{ mb_strtoupper(mb_substr($user->team->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $user->team->name }}</div>
                                @if($user->team->mentor)
                                    <div class="text-xs text-gray-400">👨‍🏫 {{ $user->team->mentor->full_name }}</div>
                                @endif
                            </div>
                        </div>
                        @if($teammates && $teammates->count() > 0)
                            <div class="pt-2 border-t border-gray-50">
                                <p class="text-xs text-gray-500 mb-2">Участники команды ({{ $teammates->count() + 1 }}):</p>
                                <div class="space-y-1.5">
                                    <div class="flex items-center gap-2 text-xs">
                                        <div class="w-5 h-5 rounded-full bg-indigo-500 flex items-center justify-center flex-shrink-0">
                                            <span class="text-white font-bold" style="font-size:8px">{{ mb_strtoupper(mb_substr($user->first_name,0,1)) }}</span>
                                        </div>
                                        <span class="font-medium text-indigo-600">{{ $user->full_name }} (вы)</span>
                                    </div>
                                    @foreach($teammates as $mate)
                                        <div class="flex items-center gap-2 text-xs">
                                            <div class="w-5 h-5 rounded-full bg-gray-300 flex items-center justify-center flex-shrink-0">
                                                <span class="text-white font-bold" style="font-size:8px">{{ mb_strtoupper(mb_substr($mate->first_name,0,1)) }}</span>
                                            </div>
                                            <span class="text-gray-700">{{ $mate->full_name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('teams.leave') }}" class="pt-1">
                            @csrf
                            <button type="submit"
                                    onclick="return confirm('Выйти из команды?')"
                                    class="w-full py-2 text-xs font-semibold text-red-600 border border-red-200 rounded-xl hover:bg-red-50 transition">
                                Выйти из команды
                            </button>
                        </form>
                    </div>
                @else
                    <div class="p-5 text-center">
                        <div class="w-12 h-12 bg-yellow-50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 mb-3">Вы ещё не в команде</p>
                        <a href="{{ route('teams.public') }}"
                           class="block w-full py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition">
                            Выбрать команду
                        </a>
                    </div>
                @endif
            </div>

            {{-- Профиль --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-900">👤 Мои данные</h2>
                </div>
                <div class="divide-y divide-gray-50">
                    <div class="px-5 py-3 flex justify-between items-center gap-3">
                        <span class="text-xs text-gray-400">Email</span>
                        <span class="text-sm font-medium text-gray-700 truncate text-right">{{ $user->email }}</span>
                    </div>
                    <div class="px-5 py-3 flex justify-between items-center gap-3">
                        <span class="text-xs text-gray-400">Телефон</span>
                        <span class="text-sm font-medium text-gray-700">{{ $user->phone ?? '—' }}</span>
                    </div>
                    <div class="px-5 py-3 flex justify-between items-center gap-3">
                        <span class="text-xs text-gray-400">Населённый пункт</span>
                        <span class="text-sm font-medium text-gray-700">{{ $user->locality ?? '—' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Правая колонка --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Этапы --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-900">📅 Этапы турнира</h2>
                </div>
                <div class="divide-y divide-gray-50">
                    <div class="px-5 py-4 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center flex-shrink-0">
                            <span class="text-indigo-600 font-bold text-sm">1</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Муниципальный этап</p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                @if($user->team?->municipalStages?->count() > 0)
                                    <span class="text-green-600 font-medium">✓ Вы участвуете</span>
                                @else Ожидается
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="px-5 py-4 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                            <span class="text-purple-600 font-bold text-sm">2</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Региональный этап</p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                @if($user->team?->regionalStages?->count() > 0)
                                    <span class="text-green-600 font-medium">✓ Вы участвуете</span>
                                @else Квалификация после муниципального
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Материалы --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900">📚 Материалы</h2>
                    <a href="{{ route('materials.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Все →</a>
                </div>
                @forelse($materials as $material)
                    <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-50 last:border-0 hover:bg-gray-50 transition">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-sm">📄</span>
                            </div>
                            <div class="min-w-0">
                                <div class="text-sm font-medium text-gray-900 truncate">{{ $material->title }}</div>
                                @if($material->description)
                                    <div class="text-xs text-gray-400 truncate">{{ Str::limit($material->description, 50) }}</div>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('materials.download', $material) }}" target="_blank"
                           class="flex-shrink-0 ml-3 p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                        </a>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center text-sm text-gray-400">Материалов пока нет</div>
                @endforelse
            </div>

            {{-- Новости --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900">📰 Новости</h2>
                    <a href="{{ route('news.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Все →</a>
                </div>
                @forelse($news as $item)
                    <a href="{{ route('news.show', $item) }}"
                       class="block px-5 py-3.5 border-b border-gray-50 last:border-0 hover:bg-gray-50 transition">
                        <div class="text-sm font-medium text-gray-900 truncate">{{ $item->title }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ $item->published_at->format('d.m.Y') }}</div>
                    </a>
                @empty
                    <div class="px-5 py-8 text-center text-sm text-gray-400">Новостей пока нет</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
