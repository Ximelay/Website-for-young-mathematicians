@extends('layouts.app')

@section('title', 'Личный кабинет — Наставник')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if (session('success'))
        <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
    @endif

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Добро пожаловать, {{ $user->first_name }}!</h1>
        <p class="text-gray-500 mt-1">Личный кабинет — Наставник</p>
        @if ($user->organization)
            <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                🏫 {{ $user->organization->name }}
            </span>
        @endif
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
                            Участников: <span class="font-semibold">{{ $team->participants->count() }}</span>
                        </p>
                        <x-button variant="outline" class="w-full justify-center text-sm">Открыть команду</x-button>
                    </x-card>
                @endforeach
            </div>
        @endif
    </div>

    <div class="flex gap-3">
        <x-button variant="primary">Создать команду</x-button>
        <x-button variant="success">Загрузить материал</x-button>
    </div>

</div>
@endsection
