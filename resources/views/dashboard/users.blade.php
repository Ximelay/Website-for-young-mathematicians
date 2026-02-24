@extends('layouts.app')

@section('title', 'Управление пользователями')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

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
        <span class="text-gray-900 font-medium">Пользователи</span>
    </nav>

    {{-- Заголовок --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">👥 Пользователи</h1>
            <p class="text-sm text-gray-500 mt-0.5">Всего в системе: {{ $users->total() }}</p>
        </div>
    </div>

    {{-- Таблица --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Пользователь</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Роль</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Муниципалитет</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Организация</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Статус</th>
                        <th class="px-5 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $u)
                        @php
                            $roleColors = ['organizer'=>'bg-purple-100 text-purple-700','municipal_coordinator'=>'bg-blue-100 text-blue-700','mentor'=>'bg-green-100 text-green-700','participant'=>'bg-yellow-100 text-yellow-700'];
                            $roleLabels = ['organizer'=>'Организатор','municipal_coordinator'=>'Координатор','mentor'=>'Наставник','participant'=>'Участник'];
                        @endphp
                        <tr class="hover:bg-gray-50 transition {{ $u->marked_for_deletion ? 'bg-red-50 hover:bg-red-50' : '' }}">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br
                                        {{ $u->is_active ? 'from-indigo-400 to-purple-500' : 'from-gray-300 to-gray-400' }}
                                        flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-semibold text-xs">
                                            {{ mb_strtoupper(mb_substr($u->first_name,0,1).mb_substr($u->last_name,0,1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $u->full_name }}</div>
                                        <div class="text-xs text-gray-400">{{ $u->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($u->roles as $role)
                                        <span class="px-2 py-0.5 text-xs rounded-full font-medium {{ $roleColors[$role->name] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ $roleLabels[$role->name] ?? $role->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-400">—</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600 hidden md:table-cell">
                                {{ $u->municipality->name ?? '—' }}
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600 hidden lg:table-cell">
                                {{ $u->organization->name ?? '—' }}
                            </td>
                            <td class="px-5 py-4">
                                @if($u->marked_for_deletion)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> К удалению
                                    </span>
                                @elseif($u->is_active)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Активен
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Деактивирован
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($u->marked_for_deletion)
                                        <form method="POST" action="{{ route('users.confirm-deletion', $u) }}">
                                            @csrf
                                            <button type="submit"
                                                    onclick="return confirm('Деактивировать {{ addslashes($u->full_name) }}?')"
                                                    class="px-3 py-1.5 bg-red-600 text-white text-xs font-semibold rounded-lg hover:bg-red-700 transition">
                                                Подтвердить
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('users.cancel-deletion', $u) }}">
                                            @csrf
                                            <button class="px-3 py-1.5 bg-white border border-gray-200 text-gray-600 text-xs font-semibold rounded-lg hover:bg-gray-50 transition">
                                                Отмена
                                            </button>
                                        </form>
                                    @elseif($u->id !== auth()->id())
                                        <form method="POST" action="{{ route('users.toggle-active', $u) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                    onclick="return confirm('{{ $u->is_active ? 'Деактивировать' : 'Активировать' }} пользователя?')"
                                                    class="px-3 py-1.5 text-xs font-semibold rounded-lg border transition
                                                        {{ $u->is_active
                                                            ? 'bg-white border-orange-200 text-orange-600 hover:bg-orange-50'
                                                            : 'bg-white border-green-200 text-green-600 hover:bg-green-50' }}">
                                                {{ $u->is_active ? 'Деактивировать' : 'Активировать' }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center">
                                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 font-medium">Пользователи не найдены</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 bg-gray-50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
