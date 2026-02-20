@extends('layouts.app')

@section('title', 'Личный кабинет — Координатор')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if (session('success'))
        <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
    @endif

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Добро пожаловать, {{ $user->first_name }}!</h1>
        <p class="text-gray-500 mt-1">Личный кабинет — Муниципальный координатор</p>
        @if ($user->municipality)
            <span class="inline-block mt-2 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                🏛️ {{ $user->municipality->name }}
            </span>
        @endif
    </div>

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
            <x-button variant="success">Загрузить материал</x-button>
        </div>
    </x-card>

</div>
@endsection
