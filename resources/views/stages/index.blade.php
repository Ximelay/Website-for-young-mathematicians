@extends('layouts.app')

@section('title', 'Этапы турнира')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Заголовок --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">🏆 Этапы турнира</h1>
            <p class="text-gray-500 mt-1">Муниципальный и региональный этапы</p>
        </div>
        @auth
            @if(auth()->user()->hasRole('organizer'))
                <div class="flex gap-3">
                    <a href="{{ route('stages.municipal.create') }}"
                       class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition shadow-sm">
                        ➕ Муниципальный этап
                    </a>
                    <a href="{{ route('stages.regional.create') }}"
                       class="px-4 py-2 bg-purple-600 text-white text-sm font-semibold rounded-xl hover:bg-purple-700 transition shadow-sm">
                        ➕ Региональный этап
                    </a>
                </div>
            @endif
        @endauth
    </div>

    {{-- Муниципальные этапы --}}
    <div class="mb-10">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-blue-500 inline-block"></span>
            Муниципальные этапы
        </h2>

        @if($municipalStages->isEmpty())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-10 text-center text-gray-400">
                <p class="text-lg">Муниципальных этапов пока нет</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($municipalStages as $stage)
                    @php
                        $statusColor = match($stage->status) {
                            'planned'   => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'dot' => 'bg-yellow-400', 'label' => 'Запланирован'],
                            'ongoing'   => ['bg' => 'bg-green-100',  'text' => 'text-green-700',  'dot' => 'bg-green-500',  'label' => 'Идёт'],
                            'completed' => ['bg' => 'bg-gray-100',   'text' => 'text-gray-600',   'dot' => 'bg-gray-400',   'label' => 'Завершён'],
                            default     => ['bg' => 'bg-gray-100',   'text' => 'text-gray-600',   'dot' => 'bg-gray-400',   'label' => $stage->status],
                        };
                    @endphp
                    <a href="{{ route('stages.municipal.show', $stage) }}"
                       class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:border-blue-200 transition group block">
                        <div class="flex items-start justify-between mb-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColor['bg'] }} {{ $statusColor['text'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $statusColor['dot'] }}"></span>
                                {{ $statusColor['label'] }}
                            </span>
                        </div>
                        <h3 class="font-bold text-gray-900 group-hover:text-blue-600 transition">
                            {{ $stage->municipality->name }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            📅 {{ $stage->event_date->format('d.m.Y') }}
                        </p>
                        <p class="text-sm text-gray-500 truncate">
                            📍 {{ $stage->venue }}
                        </p>
                        <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs text-gray-400">👥 {{ $stage->teams_count }} команд</span>
                            <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Региональные этапы --}}
    <div>
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-purple-500 inline-block"></span>
            Региональные этапы
        </h2>

        @if($regionalStages->isEmpty())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-10 text-center text-gray-400">
                <p class="text-lg">Региональных этапов пока нет</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($regionalStages as $stage)
                    @php
                        $statusColor = match($stage->status) {
                            'planned'   => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'dot' => 'bg-yellow-400', 'label' => 'Запланирован'],
                            'ongoing'   => ['bg' => 'bg-green-100',  'text' => 'text-green-700',  'dot' => 'bg-green-500',  'label' => 'Идёт'],
                            'completed' => ['bg' => 'bg-gray-100',   'text' => 'text-gray-600',   'dot' => 'bg-gray-400',   'label' => 'Завершён'],
                            default     => ['bg' => 'bg-gray-100',   'text' => 'text-gray-600',   'dot' => 'bg-gray-400',   'label' => $stage->status],
                        };
                    @endphp
                    <a href="{{ route('stages.regional.show', $stage) }}"
                       class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:border-purple-200 transition group block">
                        <div class="flex items-start justify-between mb-3">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            </div>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColor['bg'] }} {{ $statusColor['text'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $statusColor['dot'] }}"></span>
                                {{ $statusColor['label'] }}
                            </span>
                        </div>
                        <h3 class="font-bold text-gray-900 group-hover:text-purple-600 transition">
                            Региональный этап {{ $stage->year }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            📅 {{ $stage->event_date->format('d.m.Y') }}
                        </p>
                        <p class="text-sm text-gray-500 truncate">
                            📍 {{ $stage->venue }}
                        </p>
                        <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs text-gray-400">👥 {{ $stage->teams_count }} команд</span>
                            <svg class="w-4 h-4 text-gray-300 group-hover:text-purple-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
