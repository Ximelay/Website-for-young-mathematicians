@extends('layouts.app')

@section('title', 'Профиль — ' . $user->full_name)

@section('content')
@php
    $roleLabels = [
        'organizer'             => ['label' => 'Организатор',  'badge' => 'bg-purple-100 text-purple-700'],
        'municipal_coordinator' => ['label' => 'Координатор',  'badge' => 'bg-blue-100 text-blue-700'],
        'mentor'                => ['label' => 'Наставник',    'badge' => 'bg-green-100 text-green-700'],
        'participant'           => ['label' => 'Участник',     'badge' => 'bg-yellow-100 text-yellow-700'],
    ];
    $isPendingMentor = $user->hasRole('mentor') && ! $user->is_active && ! $user->marked_for_deletion;
@endphp

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Хлебные крошки --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Кабинет</a>
        <span>/</span>
        <a href="{{ route('users.index') }}" class="hover:text-indigo-600 transition">Пользователи</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">{{ $user->full_name }}</span>
    </nav>

    @if (session('success'))
        <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
    @endif

    {{-- Баннер ожидания --}}
    @if($isPendingMentor)
        <div class="flex items-start gap-3 p-4 bg-amber-50 border border-amber-200 rounded-2xl mb-6">
            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-amber-800">Ожидает одобрения</p>
                <p class="text-xs text-amber-700 mt-0.5">Наставник зарегистрировался и ожидает активации аккаунта</p>
            </div>
            <form method="POST" action="{{ route('users.approve', $user) }}">
                @csrf
                <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white text-xs font-semibold rounded-xl hover:bg-green-700 transition whitespace-nowrap">
                    ✓ Одобрить
                </button>
            </form>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Шапка --}}
        <div class="px-6 py-6 border-b border-gray-100">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br
                        {{ $user->is_active ? 'from-indigo-400 to-purple-500' : 'from-gray-300 to-gray-400' }}
                        flex items-center justify-center flex-shrink-0 shadow-sm">
                        <span class="text-2xl font-bold text-white">
                            {{ mb_strtoupper(mb_substr($user->first_name, 0, 1) . mb_substr($user->last_name, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">{{ $user->full_name }}</h1>
                        <p class="text-sm text-gray-500 mt-0.5">{{ $user->email }}</p>
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            {{-- Роли --}}
                            @foreach($user->roles as $role)
                                @php $rc = $roleLabels[$role->name] ?? ['label' => $role->name, 'badge' => 'bg-gray-100 text-gray-700']; @endphp
                                <span class="px-2.5 py-0.5 text-xs rounded-full font-medium {{ $rc['badge'] }}">
                                    {{ $rc['label'] }}
                                </span>
                            @endforeach
                            {{-- Статус --}}
                            @if($user->marked_for_deletion)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> К удалению
                                </span>
                            @elseif($user->is_active)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Активен
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    {{ $isPendingMentor ? 'Ожидает одобрения' : 'Неактивен' }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- Кнопка редактировать --}}
                <a href="{{ route('users.edit', $user) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 transition shadow-sm flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Редактировать
                </a>
            </div>
        </div>

        {{-- Данные --}}
        <div class="divide-y divide-gray-50">

            {{-- Личные данные --}}
            <div class="px-6 py-5">
                <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-4">Личные данные</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">Фамилия</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $user->last_name ?: '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">Имя</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $user->first_name ?: '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">Отчество</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $user->middle_name ?: '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">Телефон</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $user->phone ?: '—' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs text-gray-400 mb-0.5">Email</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $user->email }}</dd>
                    </div>
                    @if($user->position)
                        <div class="sm:col-span-2">
                            <dt class="text-xs text-gray-400 mb-0.5">Должность</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $user->position }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Привязка к структуре --}}
            <div class="px-6 py-5">
                <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-4">Привязка к структуре</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">Муниципалитет</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $user->municipality->name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">Организация</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $user->organization->name ?? '—' }}</dd>
                    </div>
                    @if($user->locality)
                        <div>
                            <dt class="text-xs text-gray-400 mb-0.5">Населённый пункт</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $user->locality }}</dd>
                        </div>
                    @endif
                    @if($user->grade)
                        <div>
                            <dt class="text-xs text-gray-400 mb-0.5">Класс</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $user->grade }} класс</dd>
                        </div>
                    @endif
                    @if($user->team)
                        <div class="sm:col-span-2">
                            <dt class="text-xs text-gray-400 mb-0.5">Команда</dt>
                            <dd class="text-sm font-medium text-gray-900">
                                <a href="{{ route('teams.show', $user->team) }}"
                                   class="text-indigo-600 hover:underline">
                                    {{ $user->team->name }}
                                </a>
                                @if($user->team->mentor)
                                    <span class="text-gray-400 text-xs ml-1">· наставник: {{ $user->team->mentor->full_name }}</span>
                                @endif
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Системная информация --}}
            <div class="px-6 py-5">
                <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-4">Системная информация</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">Дата регистрации</dt>
                        <dd class="text-sm font-medium text-gray-900">
                            {{ $user->created_at->format('d.m.Y, H:i') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">Последнее обновление</dt>
                        <dd class="text-sm font-medium text-gray-900">
                            {{ $user->updated_at->format('d.m.Y, H:i') }}
                        </dd>
                    </div>
                    @if($user->marked_for_deletion && $user->deletion_reason)
                        <div class="sm:col-span-2">
                            <dt class="text-xs text-gray-400 mb-0.5">Причина удаления</dt>
                            <dd class="text-sm font-medium text-red-700">{{ $user->deletion_reason }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

        </div>

        {{-- Кнопки внизу --}}
        <div class="px-6 py-5 bg-gray-50 border-t border-gray-100 flex items-center justify-between gap-3">
            <a href="{{ route('users.index') }}"
               class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-indigo-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Назад к списку
            </a>
            <div class="flex gap-2">
                @if($isPendingMentor)
                    <form method="POST" action="{{ route('users.approve', $user) }}">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-xl hover:bg-green-700 transition">
                            ✓ Одобрить наставника
                        </button>
                    </form>
                @endif
                <a href="{{ route('users.edit', $user) }}"
                   class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition">
                    Редактировать
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
