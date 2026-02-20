@extends('layouts.app')

@section('title', 'Личный кабинет — Участник')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if (session('success'))
        <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
    @endif

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Добро пожаловать, {{ $user->first_name }}!</h1>
        <p class="text-gray-500 mt-1">Личный кабинет — Участник</p>
        <div class="flex flex-wrap gap-2 mt-2">
            @if ($user->municipality)
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                    🏛️ {{ $user->municipality->name }}
                </span>
            @endif
            @if ($user->organization)
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                    🏫 {{ $user->organization->name }}
                </span>
            @endif
            @if ($user->grade)
                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">
                    {{ $user->grade }} класс
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Команда --}}
        <x-card title="🏅 Моя команда">
            @if ($user->team)
                <p class="text-lg font-semibold text-gray-900 mb-1">{{ $user->team->name }}</p>
                <p class="text-sm text-gray-500">Вы состоите в команде</p>
                <div class="mt-4">
                    <x-button variant="outline" class="w-full justify-center text-sm">Подробнее</x-button>
                </div>
            @else
                <x-alert type="warning">
                    Вы ещё не в команде. Обратитесь к наставнику для добавления в команду.
                </x-alert>
            @endif
        </x-card>

        {{-- Материалы --}}
        <x-card title="📚 Материалы">
            <p class="text-gray-500 text-sm mb-4">Учебные материалы и задания</p>
            <x-button variant="outline" class="w-full justify-center text-sm">Смотреть материалы</x-button>
        </x-card>
    </div>

</div>
@endsection
