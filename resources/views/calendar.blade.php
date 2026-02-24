@extends('layouts.app')

@section('title', 'Календарь событий')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Заголовок --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">📅 Календарь событий</h1>
            <p class="text-sm text-gray-500 mt-0.5">Все этапы и мероприятия турнира</p>
        </div>
        @auth
            @if(auth()->user()->hasRole('organizer'))
                <a href="{{ route('events.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Добавить событие
                </a>
            @endif
        @endauth
    </div>

    {{-- Предстоящие события --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">🔜 Предстоящие</h2>
            <span class="px-2.5 py-0.5 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full">
                {{ $upcoming->count() }}
            </span>
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

        @forelse($upcoming as $event)
            @php
                $tc = $typeColors[$event->type] ?? $typeColors['other'];
                $daysLeft = (int) now()->startOfDay()->diffInDays($event->start_date->startOfDay(), false);
            @endphp
            <div class="flex items-start gap-5 px-6 py-5 border-b border-gray-50 last:border-0 hover:bg-gray-50 transition">

                {{-- Дата-блок --}}
                <div class="flex-shrink-0 w-14 text-center">
                    <div class="bg-indigo-600 text-white text-xs font-bold rounded-t-xl py-1">
                        {{ mb_strtoupper($event->start_date->translatedFormat('M')) }}
                    </div>
                    <div class="bg-indigo-50 border border-indigo-100 text-indigo-900 text-2xl font-bold rounded-b-xl py-1.5 leading-none">
                        {{ $event->start_date->format('d') }}
                    </div>
                </div>

                {{-- Контент --}}
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h3 class="text-base font-semibold text-gray-900">{{ $event->title }}</h3>
                        @if($daysLeft === 0)
                            <span class="px-2 py-0.5 text-xs rounded-full bg-orange-100 text-orange-700 font-semibold">Сегодня!</span>
                        @elseif($daysLeft > 0 && $daysLeft <= 7)
                            <span class="px-2 py-0.5 text-xs rounded-full bg-orange-50 text-orange-500 font-medium">Через {{ $daysLeft }} дн.</span>
                        @endif
                    </div>

                    @if($event->description)
                        <p class="text-sm text-gray-500 mb-2 line-clamp-2">{{ $event->description }}</p>
                    @endif

                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-400">
                        <span class="px-2 py-0.5 rounded-full font-medium {{ $tc['bg'] }} {{ $tc['text'] }}">
                            {{ $event->getTypeName() }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $event->start_date->format('d.m.Y, H:i') }}
                            @if($event->end_date && $event->end_date->ne($event->start_date))
                                — {{ $event->end_date->format('d.m.Y, H:i') }}
                            @endif
                        </span>
                        @if($event->location)
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $event->location }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Кнопки организатора --}}
                @auth
                    @if(auth()->user()->hasRole('organizer'))
                        <div class="flex items-center gap-1.5 flex-shrink-0">
                            <a href="{{ route('events.edit', $event) }}"
                               class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                               title="Редактировать">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('events.destroy', $event) }}">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Удалить событие «{{ addslashes($event->title) }}»?')"
                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                        title="Удалить">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-14 text-center px-6">
                <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-gray-600 font-semibold">Предстоящих событий нет</p>
                <p class="text-gray-400 text-sm mt-1">Новые события появятся здесь после добавления</p>
            </div>
        @endforelse
    </div>

    {{-- Прошедшие события --}}
    @if($past->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-500">📁 Прошедшие</h2>
                <span class="px-2.5 py-0.5 bg-gray-100 text-gray-500 text-xs font-semibold rounded-full">
                    {{ $past->count() }}
                </span>
            </div>
            @foreach($past as $event)
                @php $tc = $typeColors[$event->type] ?? $typeColors['other']; @endphp
                <div class="flex items-start gap-5 px-6 py-4 border-b border-gray-50 last:border-0 opacity-60 hover:opacity-100 transition">
                    <div class="flex-shrink-0 w-14 text-center">
                        <div class="bg-gray-400 text-white text-xs font-bold rounded-t-xl py-1">
                            {{ mb_strtoupper($event->start_date->translatedFormat('M')) }}
                        </div>
                        <div class="bg-gray-50 border border-gray-200 text-gray-600 text-2xl font-bold rounded-b-xl py-1.5 leading-none">
                            {{ $event->start_date->format('d') }}
                        </div>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-sm font-semibold text-gray-700">{{ $event->title }}</h3>
                        <div class="flex flex-wrap items-center gap-3 mt-1 text-xs text-gray-400">
                            <span class="px-2 py-0.5 rounded-full font-medium {{ $tc['bg'] }} {{ $tc['text'] }}">
                                {{ $event->getTypeName() }}
                            </span>
                            <span>{{ $event->start_date->format('d.m.Y') }}</span>
                            @if($event->location)
                                <span>📍 {{ $event->location }}</span>
                            @endif
                        </div>
                    </div>
                    @auth
                        @if(auth()->user()->hasRole('organizer'))
                            <form method="POST" action="{{ route('events.destroy', $event) }}" class="flex-shrink-0">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Удалить событие?')"
                                        class="p-1.5 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
