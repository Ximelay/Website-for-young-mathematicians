@extends('layouts.app')

@section('title', 'Тестовая страница')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">🎉 Моя первая страница!</h1>

        <x-card title="Пример карточки">
            <p class="text-gray-600">Это тестовый контент. Я использую готовые компоненты!</p>
        </x-card>

        <div class="mt-6">
            <x-button variant="primary">Нажми меня</x-button>
            <x-button variant="secondary">Или меня</x-button>
        </div>

        <x-alert type="success" class="mt-4">
            Всё работает! ✅
        </x-alert>
    </div>
@endsection
