@php use App\Models\Team;use App\Models\User; @endphp
@extends('layouts.app')

@section('title', 'Личный кабинет — Координатор')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if (session('success'))
            <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
        @endif
        @if (session('error'))
            <x-alert type="danger" class="mb-6">{{ session('error') }}</x-alert>
        @endif

        @php
            $municipalityId = $user->municipality_id;
            $stats = [
                'users' => User::where('municipality_id', $municipalityId)->where('is_active', true)->count(),
                'teams' => Team::whereHas('members', fn($q) => $q->where('municipality_id', $municipalityId))->count(),
                'organizations' => User::where('municipality_id', $municipalityId)->whereNotNull('organization_id')->distinct('organization_id')->count(),
            ];
            $users = User::where('municipality_id', $municipalityId)
                ->with('roles', 'organization', 'team')
                ->where('is_active', true)
                ->latest()
                ->paginate(15);
        @endphp

        {{-- Шапка --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-blue-600 flex items-center justify-center shadow flex-shrink-0">
                    <span
                        class="text-2xl font-bold text-white">{{ mb_strtoupper(mb_substr($user->first_name, 0, 1)) }}</span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $user->full_name }}</h1>
                    <div class="flex flex-wrap items-center gap-2 mt-1">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Координатор</span>
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
        <div class="grid grid-cols-3 gap-4 mb-6">
            @php
                $statCards = [
                    ['label' => 'Пользователей', 'value' => $stats['users'],         'color' => 'indigo'],
                    ['label' => 'Команд',         'value' => $stats['teams'],         'color' => 'green'],
                    ['label' => 'Организаций',    'value' => $stats['organizations'], 'color' => 'purple'],
                ];
            @endphp
            @foreach($statCards as $s)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <p class="text-3xl font-bold text-gray-900 mb-0.5">{{ $s['value'] }}</p>
                    <p class="text-sm text-gray-500">{{ $s['label'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Быстрые действия --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
            <h2 class="font-semibold text-gray-900 mb-3">⚡ Действия</h2>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('teams.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition shadow-sm">
                    🏆 Команды
                </a>
                <a href="{{ route('materials.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-600 text-white text-sm font-semibold rounded-xl hover:bg-green-700 transition shadow-sm">
                    📁 Загрузить материал
                </a>
                <a href="{{ route('calendar') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 transition shadow-sm">
                    📅 Календарь
                </a>
            </div>
        </div>

        {{-- Пользователи муниципалитета --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-900">👥 Пользователи муниципалитета</h2>
                <span
                    class="px-2.5 py-0.5 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full">{{ $users->total() }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Пользователь
                        </th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Роль
                        </th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">
                            Организация
                        </th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                            Команда
                        </th>
                        <th class="px-5 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Действие
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($users as $userItem)
                        @php
                            $roleColors = ['organizer'=>'bg-purple-100 text-purple-700','municipal_coordinator'=>'bg-blue-100 text-blue-700','mentor'=>'bg-green-100 text-green-700','participant'=>'bg-yellow-100 text-yellow-700'];
                            $roleLabels = ['organizer'=>'Организатор','municipal_coordinator'=>'Координатор','mentor'=>'Наставник','participant'=>'Участник'];
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-semibold text-xs">
                                            {{ mb_strtoupper(mb_substr($userItem->first_name,0,1).mb_substr($userItem->last_name,0,1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div
                                            class="text-sm font-semibold text-gray-900">{{ $userItem->full_name }}</div>
                                        <div class="text-xs text-gray-400">{{ $userItem->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($userItem->roles as $role)
                                        <span
                                            class="px-2 py-0.5 text-xs rounded-full font-medium {{ $roleColors[$role->name] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ $roleLabels[$role->name] ?? $role->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600 hidden md:table-cell">
                                {{ $userItem->organization->name ?? '—' }}
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600 hidden lg:table-cell">
                                {{ $userItem->team->name ?? '—' }}
                            </td>
                            <td class="px-5 py-4 text-right">
                                @if(!$userItem->marked_for_deletion && !$userItem->hasRole('organizer'))
                                    <button
                                        onclick="openModal({{ $userItem->id }}, '{{ addslashes($userItem->full_name) }}')"
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                        title="Пометить на удаление">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                @elseif($userItem->marked_for_deletion)
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-orange-100 text-orange-700">⏳ Ожидает</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-gray-500 text-sm">Пользователи не
                                найдены
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50">{{ $users->links() }}</div>
            @endif
        </div>
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
                        Пользователь <strong id="userName"></strong> будет помечен на удаление и ожидать подтверждения
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
