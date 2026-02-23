@extends('layouts.app')

@section('title', 'Личный кабинет — Наставник')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- ✅ Сообщения: успех и ошибка --}}
        @if (session('success'))
            <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
        @endif
        @if (session('error'))
            <x-alert type="error" class="mb-6">{{ session('error') }}</x-alert>
        @endif

        <!-- Заголовок -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">👨‍🏫 Мой кабинет наставника</h1>
            <p class="text-gray-500 mt-1">Управление вашей командой и участниками</p>
            @if ($user->organization)
                <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                🏫 {{ $user->organization->name }}
            </span>
            @endif
        </div>

        <!-- Статистика -->
        @php
            $teamsCount = $user->mentorTeams->count();
            $participantsCount = $user->mentorTeams->sum(fn($t) => $t->members->where('is_active', true)->count());
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <x-card title="🏆 Мои команды">
                <p class="text-3xl font-bold text-indigo-600 mb-2">{{ $teamsCount }}</p>
                <p class="text-gray-500 text-sm">Команд, которыми вы руководите</p>
            </x-card>
            <x-card title="👥 Активные участники">
                <p class="text-3xl font-bold text-green-600 mb-2">{{ $participantsCount }}</p>
                <p class="text-gray-500 text-sm">Участников в ваших командах</p>
            </x-card>
        </div>

        {{-- Мои команды --}}
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Мои команды</h2>

            @if ($user->mentorTeams->isEmpty())
                <x-alert type="info">
                    У вас пока нет команд. Создайте команду, чтобы добавить участников.
                </x-alert>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($user->mentorTeams as $team)
                        <x-card title="👥 {{ $team->name }}">
                            <p class="text-sm text-gray-500 mb-3">
                                Участников: <span class="font-semibold">{{ $team->members->where('is_active', true)->count() }}</span>
                            </p>
                            <p class="text-xs text-gray-400 mb-4">
                                Класс: {{ $team->grade ?? 'Не указан' }} •
                                Муниципалитет: {{ $team->municipality->name ?? '—' }}
                            </p>
                            <a href="#" class="block w-full text-center px-4 py-2 border-2 border-indigo-600 text-indigo-600 font-semibold rounded-lg hover:bg-indigo-600 hover:text-white transition">
                                Управление командой →
                            </a>
                        </x-card>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Участники моих команд -->
        @php
            $participants = \App\Models\User::whereHas('team', function($q) use ($user) {
                    $q->where('mentor_id', $user->id);
                })
                ->with('team', 'organization')
                ->where('is_active', true)
                ->latest()
                ->get();
        @endphp

        @if($participants->count() > 0)
            <x-card title="👥 Участники моих команд" class="mb-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ФИО</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Класс</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Организация</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Команда</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($participants as $participant)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $participant->getFullNameAttribute() }}</div>
                                    <div class="text-xs text-gray-500">{{ $participant->email }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $participant->grade ?? '—' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $participant->organization->short_name ?? $participant->organization->name ?? '—' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $participant->team->name ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    @if($participant->marked_for_deletion)
                                        <span class="inline-block px-2 py-0.5 text-xs rounded bg-orange-100 text-orange-800">⏳ Ожидает</span>
                                    @else
                                        <span class="inline-block px-2 py-0.5 text-xs rounded bg-green-100 text-green-800">✓ Активен</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if(!$participant->marked_for_deletion)
                                        <button onclick="openModal({{ $participant->id }}, '{{ addslashes($participant->getFullNameAttribute()) }}')"
                                                class="text-red-600 hover:text-red-800 text-sm font-medium inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Пометить
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        @endif

        <!-- Кнопки действий -->
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('teams.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg border-2 border-indigo-600 hover:bg-white hover:text-indigo-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Создать команду
            </a>

            <a href="{{ route('materials.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white font-semibold rounded-lg border-2 border-green-600 hover:bg-white hover:text-green-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                Загрузить материал
            </a>
        </div>

    </div>

    <!-- ✅ Модальное окно: Пометить на удаление -->
    <div id="deletionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
            <form method="POST" id="deletionForm">
                @csrf

                <div class="px-6 py-4 border-b border-gray-200 bg-red-600 rounded-t-xl">
                    <h3 class="text-lg font-bold text-white">⚠️ Пометить на удаление</h3>
                </div>

                <div class="px-6 py-4">
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4 rounded">
                        <p class="text-sm text-red-700">
                            <strong>Внимание!</strong> Вы собираетесь пометить участника <strong id="userName"></strong> на удаление.
                            Это действие потребует подтверждения организатора.
                        </p>
                    </div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">Причина удаления *</label>
                    <textarea
                        name="deletion_reason"
                        rows="4"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent transition"
                        placeholder="Укажите причину, почему участник не принимает участие..."></textarea>
                    <p class="mt-2 text-xs text-gray-500">Максимум 500 символов</p>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 flex gap-3 justify-end rounded-b-xl">
                    <button type="button" onclick="closeModal()"
                            class="px-4 py-2 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                        Отмена
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                        Пометить на удаление
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
            document.body.style.overflow = 'auto';
        }
        document.getElementById('deletionModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    </script>
@endsection
