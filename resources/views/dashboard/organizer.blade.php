@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if (session('success'))
        <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
    @endif

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Добро пожаловать, {{ $user->first_name }}!</h1>
        <p class="text-gray-500 mt-1">Личный кабинет — Организатор</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <x-card title="👥 Пользователи">
            <p class="text-3xl font-bold text-indigo-600 mb-2">—</p>
            <p class="text-gray-500 text-sm">Управление участниками, наставниками и координаторами</p>
            <div class="mt-4">
                <x-button variant="outline" class="w-full justify-center text-sm">Перейти</x-button>
            </div>
        </x-card>

        <x-card title="📅 События">
            <p class="text-3xl font-bold text-green-600 mb-2">—</p>
            <p class="text-gray-500 text-sm">Создание и управление событиями турнира</p>
            <div class="mt-4">
                <x-button variant="outline" class="w-full justify-center text-sm">Перейти</x-button>
            </div>
        </x-card>

        <x-card title="📰 Новости">
            <p class="text-3xl font-bold text-purple-600 mb-2">—</p>
            <p class="text-gray-500 text-sm">Публикация новостей и объявлений</p>
            <div class="mt-4">
                <x-button variant="outline" class="w-full justify-center text-sm">Перейти</x-button>
            </div>
        </x-card>
    </div>

    <x-card title="Быстрые действия">
        <div class="flex flex-wrap gap-3">
            <x-button variant="primary">Добавить событие</x-button>
            <x-button variant="success">Опубликовать новость</x-button>
            <x-button variant="secondary">Управление командами</x-button>
            <x-button variant="outline">Результаты этапов</x-button>
        </div>
    </x-card>

</div>
@endsection
