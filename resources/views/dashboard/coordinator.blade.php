@extends('layouts.app')

@section('title', 'Личный кабинет — Координатор')

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
            <h1 class="text-3xl font-bold text-gray-900">🏛️ Муниципальный координатор</h1>
            <p class="text-gray-500 mt-1">Управление пользователями вашего муниципалитета</p>
            @if ($user->municipality)
                <span class="inline-block mt-2 px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">
                📍 {{ $user->municipality->name }}
            </span>
            @endif
        </div>

        <!-- Статистика муниципалитета -->
        @php
            $municipalityId = $user->municipality_id;
            $stats = [
                'users' => \App\Models\User::where('municipality_id', $municipalityId)->where('is_active', true)->count(),
               'teams' => \App\Models\Team::whereHas('members', fn($q) =>
    $q->where('municipality_id', $municipalityId)
)->count(),
                'organizations' => \App\Models\User::where('municipality_id', $municipalityId)
                    ->whereNotNull('organization_id')
                    ->distinct('organization_id')
                    ->count(),
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <x-card title="👥 Пользователей">
                <p class="text-3xl font-bold text-indigo-600 mb-2">{{ $stats['users'] }}</p>
                <p class="text-gray-500 text-sm">Активные пользователи в муниципалитете</p>
            </x-card>
            <x-card title="🏆 Команд">
                <p class="text-3xl font-bold text-green-600 mb-2">{{ $stats['teams'] }}</p>
                <p class="text-gray-500 text-sm">Зарегистрированные команды</p>
            </x-card>
            <x-card title="🏫 Организаций">
                <p class="text-3xl font-bold text-purple-600 mb-2">{{ $stats['organizations'] }}</p>
                <p class="text-gray-500 text-sm">Школы и учреждения</p>
            </x-card>
        </div>

        <!-- Список пользователей муниципалитета -->
        <x-card title="👥 Пользователи муниципалитета" class="mb-8">
            @php
                $users = \App\Models\User::where('municipality_id', $municipalityId)
                    ->with('roles', 'organization', 'team')
                    ->where('is_active', true)
                    ->latest()
                    ->paginate(15);
            @endphp

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ФИО</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Роль</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Организация</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Команда</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $userItem)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-gray-900">{{ $userItem->getFullNameAttribute() }}</div>
                                <div class="text-xs text-gray-500">{{ $userItem->email }}</div>
                            </td>
                            <td class="px-4 py-3">
                                @foreach($userItem->roles as $role)
                                    <span class="inline-block px-2 py-0.5 text-xs rounded {{
                                    $role->name === 'participant' ? 'bg-yellow-100 text-yellow-800' :
                                    ($role->name === 'mentor' ? 'bg-green-100 text-green-800' :
                                    ($role->name === 'municipal_coordinator' ? 'bg-blue-100 text-blue-800' :
                                    'bg-purple-100 text-purple-800'))
                                }}">
                                    {{ $role->display_name ?? match($role->name) {
                                        'participant' => 'Участник',
                                        'mentor' => 'Наставник',
                                        'municipal_coordinator' => 'Координатор',
                                        'organizer' => 'Организатор',
                                        default => $role->name
                                    } }}
                                </span>
                                @endforeach
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $userItem->organization->short_name ?? $userItem->organization->name ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $userItem->team->name ?? '—' }}
                            </td>
                            <td class="px-4 py-3">
                                @if($userItem->marked_for_deletion)
                                    <span class="inline-block px-2 py-0.5 text-xs rounded bg-orange-100 text-orange-800">⏳ Ожидает</span>
                                @else
                                    <span class="inline-block px-2 py-0.5 text-xs rounded bg-green-100 text-green-800">✓ Активен</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if(!$userItem->marked_for_deletion && !$userItem->hasRole('organizer'))
                                    <button onclick="openModal({{ $userItem->id }}, '{{ addslashes($userItem->getFullNameAttribute()) }}')"
                                            class="text-red-600 hover:text-red-800 text-sm font-medium inline-flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Пометить
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p class="text-sm">Пользователи не найдены</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Пагинация -->
            @if($users->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                    {{ $users->links() }}
                </div>
            @endif
        </x-card>

        <!-- Карточки действий (твои оригинальные) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <x-card title="🏆 Муниципальный этап">
                <p class="text-gray-500 text-sm mb-4">Управление командами и результатами муниципального этапа</p>
                <x-button variant="primary" class="w-full justify-center">Открыть</x-button>
            </x-card>

            <x-card title="👥 Команды">
                <p class="text-gray-500 text-sm mb-4">Просмотр и управление командами из вашего муниципалитета</p>
                <x-button variant="outline" class="w-full justify-center">Открыть</x-button>
            </x-card>
        </div>

        <x-card title="📁 Материалы">
            <p class="text-gray-500 text-sm">Загрузка и управление учебными материалами</p>
            <div class="mt-4">
                <a href="{{ route('materials.create') }}"
                   class="inline-block px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                     Загрузить материал
                </a>
            </div>
        </x-card>

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
                            <strong>Внимание!</strong> Вы собираетесь пометить пользователя <strong id="userName"></strong> на удаление.
                            Это действие потребует подтверждения организатора.
                        </p>
                    </div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">Причина удаления *</label>
                    <textarea
                        name="deletion_reason"
                        rows="4"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent transition"
                        placeholder="Укажите причину, почему пользователь не принимает участие..."
                    ></textarea>
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

        // Закрытие по клику вне модального окна
        document.getElementById('deletionModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        // Закрытие по Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    </script>
@endsection
