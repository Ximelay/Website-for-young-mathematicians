@extends('layouts.app')
@section('title', 'Редактировать событие')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold mb-8">Редактировать событие</h1>

        <form action="{{ route('events.update', $event) }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="title" class="block text-gray-700 font-medium mb-2">Название события</label>
                <input type="text" id="title" name="title" value="{{ $event->title }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-gray-700 font-medium mb-2">Описание</label>
                <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>{{ $event->description }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="start_date" class="block text-gray-700 font-medium mb-2">Дата начала</label>
                    <input type="datetime-local" id="start_date" name="start_date" value="{{ $event->start_date->format('Y-m-d\TH:i') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>

                <div>
                    <label for="end_date" class="block text-gray-700 font-medium mb-2">Дата окончания</label>
                    <input type="datetime-local" id="end_date" name="end_date" value="{{ $event->end_date->format('Y-m-d\TH:i') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
            </div>

            <div class="mb-6">
                <label for="location" class="block text-gray-700 font-medium mb-2">Место проведения</label>
                <input type="text" id="location" name="location" value="{{ $event->location }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <div class="mb-6">
                <label for="type" class="block text-gray-700 font-medium mb-2">Тип события</label>
                <select id="type" name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <option value="municipal_stage" {{ $event->type == 'municipal_stage' ? 'selected' : '' }}>Муниципальный этап</option>
                    <option value="regional_stage" {{ $event->type == 'regional_stage' ? 'selected' : '' }}>Региональный этап</option>
                    <option value="meeting" {{ $event->type == 'meeting' ? 'selected' : '' }}>Встреча</option>
                    <option value="deadline" {{ $event->type == 'deadline' ? 'selected' : '' }}>Дедлайн</option>
                    <option value="other" {{ $event->type == 'other' ? 'selected' : '' }}>Другое</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg hover:bg-indigo-700 transition">
                Обновить событие
            </button>
        </form>
    </div>
@endsection
