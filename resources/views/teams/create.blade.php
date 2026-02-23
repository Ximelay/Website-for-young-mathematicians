@extends('layouts.app')

@section('title', 'Создание команды')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if (session('success'))
            <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
        @endif

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">🏆 Создание команды</h1>
            <p class="text-gray-500 mt-1">Заполните информацию о новой команде</p>
        </div>

        <x-card>
            <form method="POST" action="{{ route('teams.store') }}">
                @csrf

                <!-- Название -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Название команды *
                    </label>
                    <input type="text"
                           name="name"
                           required
                           value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                           placeholder="Например: Команда школы №1">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Муниципалитет -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Муниципалитет *
                    </label>
                    <select name="municipality_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600">
                        <option value="">— Выберите муниципалитет —</option>
                        @foreach($municipalities as $mun)
                            <option value="{{ $mun->id }}" {{ old('municipality_id') == $mun->id ? 'selected' : '' }}>
                                {{ $mun->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('municipality_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Организация -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Организация *
                    </label>
                    <select name="organization_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600">
                        <option value="">— Выберите организацию —</option>
                        @foreach(\App\Models\Organization::all() as $org)
                            <option value="{{ $org->id }}" {{ old('organization_id') == $org->id ? 'selected' : '' }}>
                                {{ $org->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('organization_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Класс -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Класс *
                    </label>
                    <select name="grade" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600">
                        <option value="">— Выберите класс —</option>
                        @for($i = 1; $i <= 11; $i++)
                            <option value="{{ $i }}" {{ old('grade') == $i ? 'selected' : '' }}>
                                {{ $i }} класс
                            </option>
                        @endfor
                    </select>
                    @error('grade')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Описание -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Описание
                    </label>
                    <textarea name="description"
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                              placeholder="Краткое описание команды...">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Кнопки -->
                <div class="flex gap-3">
                    <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                        💾 Создать команду
                    </button>
                    <a href="{{ route('teams.index') }}"
                       class="px-6 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                        Отмена
                    </a>
                </div>
            </form>
        </x-card>

    </div>
@endsection
