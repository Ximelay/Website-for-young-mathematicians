@extends('layouts.app')

@section('title', 'Региональный этап ' . $stage->year)

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('stages.index') }}" class="hover:text-indigo-600 transition">Этапы</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">Региональный {{ $stage->year }}</span>
    </nav>

    @php
        $statusColor = match($stage->status) {
            'planned'   => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'dot' => 'bg-yellow-400', 'label' => 'Запланирован'],
            'ongoing'   => ['bg' => 'bg-green-100',  'text' => 'text-green-700',  'dot' => 'bg-green-500',  'label' => 'Идёт'],
            'completed' => ['bg' => 'bg-gray-100',   'text' => 'text-gray-600',   'dot' => 'bg-gray-400',   'label' => 'Завершён'],
            default     => ['bg' => 'bg-gray-100',   'text' => 'text-gray-600',   'dot' => 'bg-gray-400',   'label' => $stage->status],
        };
    @endphp

    {{-- Шапка --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="text-2xl font-bold text-gray-900">Региональный этап {{ $stage->year }}</h1>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColor['bg'] }} {{ $statusColor['text'] }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $statusColor['dot'] }}"></span>
                            {{ $statusColor['label'] }}
                        </span>
                    </div>
                    <p class="text-gray-500 mt-0.5">Финальный этап турнира юных математиков</p>
                </div>
            </div>
            @auth
                @if(auth()->user()->hasRole('organizer'))
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <a href="{{ route('stages.regional.edit', $stage) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-purple-600 text-white text-sm font-semibold rounded-lg hover:bg-purple-700 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Редактировать
                        </a>
                        <form method="POST" action="{{ route('stages.regional.destroy', $stage) }}">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Удалить региональный этап {{ $stage->year }}?')"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-red-200 text-red-600 text-sm font-semibold rounded-lg hover:bg-red-50 transition">
                                Удалить
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Левая колонка --}}
        <div class="space-y-5">

            {{-- Сведения --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-900">ℹ️ Сведения</h2>
                </div>
                <div class="divide-y divide-gray-50">
                    <div class="px-5 py-3.5 flex justify-between items-start gap-3">
                        <span class="text-sm text-gray-500">Дата</span>
                        <span class="text-sm font-medium text-gray-900">{{ $stage->event_date->format('d.m.Y') }}</span>
                    </div>
                    @if($stage->event_time)
                    <div class="px-5 py-3.5 flex justify-between items-start gap-3">
                        <span class="text-sm text-gray-500">Время</span>
                        <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($stage->event_time)->format('H:i') }}</span>
                    </div>
                    @endif
                    <div class="px-5 py-3.5 flex justify-between items-start gap-3">
                        <span class="text-sm text-gray-500">Место</span>
                        <span class="text-sm font-medium text-gray-900 text-right">{{ $stage->venue }}</span>
                    </div>
                    @if($stage->venue_address)
                    <div class="px-5 py-3.5 flex justify-between items-start gap-3">
                        <span class="text-sm text-gray-500">Адрес</span>
                        <span class="text-sm font-medium text-gray-900 text-right">{{ $stage->venue_address }}</span>
                    </div>
                    @endif
                    @if($stage->contact_info)
                    <div class="px-5 py-3.5">
                        <span class="text-sm text-gray-500 block mb-1">Контакты</span>
                        <span class="text-sm text-gray-900">{{ $stage->contact_info }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Итоги --}}
            @if($stage->results)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-900">📋 Итоги</h2>
                </div>
                <div class="px-5 py-4">
                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $stage->results }}</p>
                </div>
            </div>
            @endif

            {{-- Добавить команду --}}
            @auth
                @if(auth()->user()->hasRole('organizer'))
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-900">➕ Добавить команду</h2>
                            <p class="text-xs text-gray-400 mt-0.5">Квалифицированные с муниципального этапа</p>
                        </div>
                        <div class="p-5">
                            @if($availableTeams->isEmpty())
                                <p class="text-sm text-gray-400 text-center py-2">Нет доступных команд</p>
                            @else
                                <form method="POST" action="{{ route('stages.regional.add-team', $stage) }}" class="space-y-3">
                                    @csrf
                                    <select name="team_id" required
                                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500">
                                        <option value="">— Выберите команду —</option>
                                        @foreach($availableTeams as $team)
                                            <option value="{{ $team->id }}">
                                                {{ $team->name }} ({{ $team->municipality->name ?? '' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit"
                                            class="w-full py-2.5 bg-purple-600 text-white text-sm font-semibold rounded-lg hover:bg-purple-700 transition">
                                        Добавить
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
            @endauth
        </div>

        {{-- Правая колонка: команды --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900">👥 Команды-участники</h2>
                    <span class="px-2.5 py-0.5 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">
                        {{ $stage->teams->count() }}
                    </span>
                </div>

                @forelse($stage->teams->sortBy('pivot.rank') as $team)
                    <div class="px-6 py-4 border-b border-gray-50 last:border-0 hover:bg-gray-50 transition">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 min-w-0">
                                @if($team->pivot->rank)
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 font-bold text-sm
                                        {{ $team->pivot->rank == 1 ? 'bg-yellow-100 text-yellow-700' :
                                           ($team->pivot->rank == 2 ? 'bg-gray-200 text-gray-700' :
                                           ($team->pivot->rank == 3 ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-500')) }}">
                                        {{ $team->pivot->rank }}
                                    </div>
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0 text-gray-400 text-xs">—</div>
                                @endif
                                <div class="min-w-0">
                                    <a href="{{ route('teams.show', $team) }}"
                                       class="text-sm font-semibold text-gray-900 hover:text-purple-600 transition truncate block">
                                        {{ $team->name }}
                                    </a>
                                    <div class="flex items-center gap-2 mt-0.5 text-xs text-gray-400">
                                        <span>{{ $team->grade }} класс</span>
                                        @if($team->municipality)
                                            <span>· {{ $team->municipality->name }}</span>
                                        @endif
                                        <span>· {{ $team->members->count() }} участников</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 flex-shrink-0">
                                @if($team->pivot->score !== null)
                                    <span class="px-2.5 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full">
                                        {{ $team->pivot->score }} б.
                                    </span>
                                @endif

                                @auth
                                    @if(auth()->user()->hasRole('organizer'))
                                        <div x-data="{ open: false }" class="relative">
                                            <button @click="open = !open" @click.outside="open = false"
                                                    class="p-1.5 text-gray-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </button>
                                            <div x-show="open" x-transition
                                                 class="absolute right-0 mt-1 w-56 bg-white rounded-xl shadow-lg border border-gray-100 z-10 p-4 space-y-3"
                                                 style="display:none">
                                                <form method="POST" action="{{ route('stages.regional.update-team', [$stage, $team]) }}" class="space-y-2">
                                                    @csrf @method('PUT')
                                                    <div class="flex gap-2">
                                                        <div class="flex-1">
                                                            <label class="text-xs text-gray-500 block mb-1">Баллы</label>
                                                            <input type="number" name="score" value="{{ $team->pivot->score }}" min="0"
                                                                   class="w-full px-2 py-1.5 border border-gray-300 rounded-lg text-sm">
                                                        </div>
                                                        <div class="flex-1">
                                                            <label class="text-xs text-gray-500 block mb-1">Место</label>
                                                            <input type="number" name="rank" value="{{ $team->pivot->rank }}" min="1"
                                                                   class="w-full px-2 py-1.5 border border-gray-300 rounded-lg text-sm">
                                                        </div>
                                                    </div>
                                                    <button type="submit"
                                                            class="w-full py-1.5 bg-purple-600 text-white text-xs font-semibold rounded-lg hover:bg-purple-700 transition">
                                                        Сохранить
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('stages.regional.remove-team', [$stage, $team]) }}">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                            onclick="return confirm('Убрать команду с этапа?')"
                                                            class="w-full py-1.5 border border-red-200 text-red-600 text-xs font-semibold rounded-lg hover:bg-red-50 transition">
                                                        Убрать с этапа
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-14 text-center px-6">
                        <p class="text-gray-500 font-medium text-sm">Команды ещё не добавлены</p>
                        <p class="text-gray-400 text-xs mt-1">Добавьте квалифицированные команды из панели слева</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
