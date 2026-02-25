@extends('layouts.app')

@section('title', 'Создание регионального этапа')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('stages.index') }}" class="hover:text-indigo-600 transition">Этапы</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">Новый региональный этап</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h1 class="text-xl font-bold text-gray-900">⭐ Создание регионального этапа</h1>
        </div>

        <form method="POST" action="{{ route('stages.regional.store') }}" class="p-6 space-y-5">
            @csrf

            @if($errors->any())
                <x-alert type="danger">
                    <ul class="list-disc list-inside text-sm space-y-0.5">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </x-alert>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Год проведения <span class="text-red-500">*</span></label>
                <input type="number" name="year" value="{{ old('year', date('Y')) }}" required min="2000" max="2100"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 @error('year') border-red-400 @enderror">
                @error('year')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Дата проведения <span class="text-red-500">*</span></label>
                    <input type="date" name="event_date" value="{{ old('event_date') }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 @error('event_date') border-red-400 @enderror">
                    @error('event_date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Время начала</label>
                    <input type="time" name="event_time" value="{{ old('event_time') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Место проведения <span class="text-red-500">*</span></label>
                <input type="text" name="venue" value="{{ old('venue') }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 @error('venue') border-red-400 @enderror"
                       placeholder="Например: Дворец молодёжи">
                @error('venue')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Адрес</label>
                <input type="text" name="venue_address" value="{{ old('venue_address') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Контактная информация</label>
                <textarea name="contact_info" rows="2"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 resize-none"
                          placeholder="ФИО контактного лица, телефон...">{{ old('contact_info') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Статус <span class="text-red-500">*</span></label>
                <select name="status" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="planned" {{ old('status', 'planned') == 'planned' ? 'selected' : '' }}>Запланирован</option>
                    <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Идёт</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Завершён</option>
                </select>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="px-6 py-2.5 bg-purple-600 text-white text-sm font-semibold rounded-xl hover:bg-purple-700 transition shadow-sm">
                    Создать этап
                </button>
                <a href="{{ route('stages.index') }}"
                   class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition">
                    Отмена
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
