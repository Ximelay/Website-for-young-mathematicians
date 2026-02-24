@php use App\Models\User; @endphp
@extends('layouts.app')

@section('title', 'Личный кабинет — Наставник')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if (session('success'))
            <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
        @endif
        @if (session('error'))
            <x-alert type="danger" class="mb-6">{{ session('error') }}</x-alert>
        @endif

        @php
            $teamsCount = $user->mentorTeams->count();
            $participantsCount = $user->mentorTeams->sum(fn($t) => $t->members->where('is_active', true)->count());
            $participants = User::whereHas('team', fn($q) => $q->where('mentor_id', $user->id))
                ->with('team', 'organization')->where('is_active', true)->latest()->get();
        @endphp

        {{-- Шапка --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-green-600 flex items-center justify-center shadow flex-shrink-0">
                    <span
                        class="text-2xl font-bold text-white">{{ mb_strtoupper(mb_substr($user->first_name, 0, 1)) }}</span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $user->full_name }}</h1>
                    <div class="flex flex-wrap items-center gap-2 mt-1">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Наставник</span>
                        @if($user->organization)
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                            🏫 {{ $user->organization->name }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Статистика + Действия --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-0.5">{{ $teamsCount }}</p>
                <p class="text-sm text-gray-500">Моих команд</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-0.5">{{ $participantsCount }}</p>
                <p class="text-sm text-gray-500">Участников</p>
            </div>
            <a href="{{ route('teams.create') }}"
               class="bg-indigo-600 rounded-2xl shadow-sm p-5 hover:bg-indigo-700 transition group flex flex-col justify-between">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-white">Создать команду</p>
            </a>
            <a href="{{ route('materials.create') }}"
               class="bg-green-600 rounded-2xl shadow-sm p-5 hover:bg-green-700 transition group flex flex-col justify-between">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-white">Загрузить материал</p>
            </a>
        </div>

        {{-- Мои команды --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-900">🏆 Мои команды</h2>
                <a href="{{ route('teams.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Все
                    →</a>
            </div>
            @if($user->mentorTeams->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 text-center px-6">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium text-sm">У вас пока нет команд</p>
                    <a href="{{ route('teams.create') }}"
                       class="mt-3 text-xs text-indigo-600 font-semibold hover:text-indigo-800">Создать команду →</a>
                </div>
            @else
                @foreach($user->mentorTeams as $team)
                    <div
                        class="flex items-center justify-between px-6 py-4 border-b border-gray-50 last:border-0 hover:bg-gray-50 transition">
                        <div class="flex items-center gap-3 min-w-0">
                            <div
                                class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center flex-shrink-0">
                                <span
                                    class="text-white font-bold text-sm">{{ mb_strtoupper(mb_substr($team->name, 0, 1)) }}</span>
                            </div>
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-gray-900 truncate">{{ $team->name }}</div>
                                <div class="text-xs text-gray-400">
                                    {{ $team->grade ? $team->grade.' класс' : '' }}
                                    {{ $team->grade && $team->municipality ? ' • ' : '' }}
                                    {{ $team->municipality->name ?? '' }}
                                    • 👥 {{ $team->members->where('is_active', true)->count() }} участников
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('teams.show', $team) }}"
                           class="flex-shrink-0 px-3 py-1.5 text-xs font-semibold text-indigo-600 border border-indigo-200 rounded-lg hover:bg-indigo-50 transition">
                            Открыть
                        </a>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Участники --}}
        @if($participants->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900">👥 Мои участники</h2>
                    <span
                        class="px-2.5 py-0.5 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full">{{ $participants->count() }}</span>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach($participants as $participant)
                        <div class="flex items-center justify-between px-6 py-3.5 hover:bg-gray-50 transition">
                            <div class="flex items-center gap-3 min-w-0">
                                <div
                                    class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-semibold text-xs">
                                    {{ mb_strtoupper(mb_substr($participant->first_name,0,1).mb_substr($participant->last_name,0,1)) }}
                                </span>
                                </div>
                                <div class="min-w-0">
                                    <div
                                        class="text-sm font-semibold text-gray-900 truncate">{{ $participant->full_name }}</div>
                                    <div class="text-xs text-gray-400">
                                        {{ $participant->grade ? $participant->grade.' кл.' : '' }}
                                        {{ $participant->team->name ?? '' }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0 ml-3">
                                @if($participant->marked_for_deletion)
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-orange-100 text-orange-700">⏳ Ожидает</span>
                                @else
                                    <span
                                        class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700">Активен</span>
                                    <button
                                        onclick="openModal({{ $participant->id }}, '{{ addslashes($participant->full_name) }}')"
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                        title="Пометить на удаление">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- Модальное окно --}}
    <div id="deletionModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full overflow-hidden">
            <form method="POST" id="deletionForm">
                @csrf
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-base font-semibold text-gray-900">Пометить на удаление</h3>
                    <button type="button" onclick="closeModal()"
                            class="p-1 text-gray-400 hover:text-gray-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <div class="p-3 bg-red-50 rounded-xl text-sm text-red-700">
                        Участник <strong id="userName"></strong> будет помечен на удаление и ожидать подтверждения
                        организатора.
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Причина <span
                                class="text-red-500">*</span></label>
                        <textarea name="deletion_reason" rows="3" required maxlength="500"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-red-500 resize-none"
                                  placeholder="Укажите причину..."></textarea>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="closeModal()"
                            class="px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition">
                        Отмена
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-xl hover:bg-red-700 transition">
                        Пометить
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(userId, userName) {
            document.getElementById('userName').textContent = userName;
            document.getElementById('deletionForm').action = `/users/${userId}/mark-for-deletion`;
            document.getElementById('deletionModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('deletionModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeModal();
        });
    </script>
@endsection
