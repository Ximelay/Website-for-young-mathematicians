@extends('layouts.app')

@section('title', 'Редактирование муниципального этапа')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('stages.index') }}" class="hover:text-indigo-600 transition">Этапы</a>
        <span>/</span>
        <a href="{{ route('stages.municipal.show', $stage) }}" class="hover:text-indigo-600 transition">{{ $stage->municipality->name }}</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">Редактирование</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h1 class="text-xl font-bold text-gray-900">✏️ Редактирование муниципального этапа</h1>
        </div>

        <form method="POST" action="{{ route('stages.municipal.update', $stage) }}" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            @if($errors->any())
                <x-alert type="danger">
                    <ul class="list-disc list-inside text-sm space-y-0.5">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </x-alert>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Муниципалитет <span class="text-red-500">*</span></label>
                <select name="municipality_id" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">— Выберите —</option>
                    @foreach($municipalities as $m)
                        <option value="{{ $m->id }}" {{ old('municipality_id', $stage->municipality_id) == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Дата проведения <span class="text-red-500">*</span></label>
                    <input type="date" name="event_date"
                           value="{{ old('event_date', $stage->event_date->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Время начала</label>
                    <input type="time" name="event_time"
                           value="{{ old('event_time', $stage->event_time ? \Carbon\Carbon::parse($stage->event_time)->format('H:i') : '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Место проведения <span class="text-red-500">*</span></label>
                <input type="text" name="venue" value="{{ old('venue', $stage->venue) }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Адрес</label>
                <input type="text" name="venue_address" value="{{ old('venue_address', $stage->venue_address) }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Контактная информация</label>
                <textarea name="contact_info" rows="2"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 resize-none">{{ old('contact_info', $stage->contact_info) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Статус <span class="text-red-500">*</span></label>
                <select name="status" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="planned" {{ old('status', $stage->status) == 'planned' ? 'selected' : '' }}>Запланирован</option>
                    <option value="ongoing" {{ old('status', $stage->status) == 'ongoing' ? 'selected' : '' }}>Идёт</option>
                    <option value="completed" {{ old('status', $stage->status) == 'completed' ? 'selected' : '' }}>Завершён</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Итоги / результаты</label>
                <textarea name="results" rows="3"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 resize-none"
                          placeholder="Краткое описание результатов этапа...">{{ old('results', $stage->results) }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition shadow-sm">
                    Сохранить изменения
                </button>
                <a href="{{ route('stages.municipal.show', $stage) }}"
                   class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition">
                    Отмена
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
