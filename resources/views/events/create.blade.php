@extends('layouts.app')

@section('title', 'Создать событие')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-12">
        <a href="{{ route('calendar') }}" class="text-sm text-indigo-600 hover:text-indigo-800 mb-4 inline-block">← Назад к календарю</a>
        <h1 class="text-3xl font-bold mb-8">Создать новое событие</h1>

        @if ($errors->any())
            <x-alert type="danger" class="mb-6">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <form action="{{ route('events.store') }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-gray-700 font-medium mb-2">Название события <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('title') border-red-400 @enderror" required>
                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="description" class="block text-gray-700 font-medium mb-2">Описание <span class="text-red-500">*</span></label>
                <textarea id="description" name="description" rows="4"
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('description') border-red-400 @enderror" required>{{ old('description') }}</textarea>
                @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-gray-700 font-medium mb-2">Дата начала <span class="text-red-500">*</span></label>
                    <input type="datetime-local" id="start_date" name="start_date" value="{{ old('start_date') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('start_date') border-red-400 @enderror" required>
                    @error('start_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="end_date" class="block text-gray-700 font-medium mb-2">Дата окончания <span class="text-red-500">*</span></label>
                    <input type="datetime-local" id="end_date" name="end_date" value="{{ old('end_date') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('end_date') border-red-400 @enderror" required>
                    @error('end_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="location" class="block text-gray-700 font-medium mb-2">Место проведения <span class="text-red-500">*</span></label>
                <input type="text" id="location" name="location" value="{{ old('location') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('location') border-red-400 @enderror" required>
                @error('location')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="type" class="block text-gray-700 font-medium mb-2">Тип события <span class="text-red-500">*</span></label>
                <select id="type" name="type"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('type') border-red-400 @enderror" required>
                    <option value="">— Выберите тип —</option>
                    <option value="municipal_stage" {{ old('type') == 'municipal_stage' ? 'selected' : '' }}>Муниципальный этап</option>
                    <option value="regional_stage"  {{ old('type') == 'regional_stage'  ? 'selected' : '' }}>Региональный этап</option>
                    <option value="meeting"         {{ old('type') == 'meeting'         ? 'selected' : '' }}>Встреча</option>
                    <option value="deadline"        {{ old('type') == 'deadline'        ? 'selected' : '' }}>Дедлайн</option>
                    <option value="other"           {{ old('type') == 'other'           ? 'selected' : '' }}>Другое</option>
                </select>
                @error('type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg hover:bg-indigo-700 transition">
                Создать событие
            </button>
        </form>
    </div>
@endsection
