@extends('layouts.app')

@section('title', 'Редактирование команды: ' . $team->name)

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Хлебные крошки --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Кабинет</a>
        <span>/</span>
        <a href="{{ route('teams.index') }}" class="hover:text-indigo-600 transition">Команды</a>
        <span>/</span>
        <a href="{{ route('teams.show', $team) }}" class="hover:text-indigo-600 transition">{{ $team->name }}</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">Редактирование</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h1 class="text-xl font-bold text-gray-900">✏️ Редактирование команды</h1>
            <p class="text-sm text-gray-500 mt-0.5">Измените информацию о команде «{{ $team->name }}»</p>
        </div>

        <form method="POST" action="{{ route('teams.update', $team) }}" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <x-alert type="danger">
                    <ul class="list-disc list-inside space-y-0.5 text-sm">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </x-alert>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Название команды <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $team->name) }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-400 @enderror"
                       placeholder="Например: Команда школы №1">
                @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Муниципалитет <span class="text-red-500">*</span></label>
                    <select name="municipality_id" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 @error('municipality_id') border-red-400 @enderror">
                        <option value="">— Выберите —</option>
                        @foreach($municipalities as $mun)
                            <option value="{{ $mun->id }}" {{ old('municipality_id', $team->municipality_id) == $mun->id ? 'selected' : '' }}>
                                {{ $mun->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('municipality_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Организация <span class="text-red-500">*</span></label>
                    <select name="organization_id" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 @error('organization_id') border-red-400 @enderror">
                        <option value="">— Выберите —</option>
                        @foreach(\App\Models\Organization::orderBy('name')->get() as $org)
                            <option value="{{ $org->id }}" {{ old('organization_id', $team->organization_id) == $org->id ? 'selected' : '' }}>
                                {{ $org->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('organization_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Класс <span class="text-red-500">*</span></label>
                <select name="grade" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 @error('grade') border-red-400 @enderror">
                    <option value="">— Выберите класс —</option>
                    @for($i = 1; $i <= 11; $i++)
                        <option value="{{ $i }}" {{ old('grade', $team->grade) == $i ? 'selected' : '' }}>{{ $i }} класс</option>
                    @endfor
                </select>
                @error('grade')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Описание</label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 resize-none @error('description') border-red-400 @enderror"
                          placeholder="Краткое описание команды...">{{ old('description', $team->description) }}</textarea>
                @error('description')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="flex items-center gap-3 cursor-pointer select-none">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $team->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                    <span class="text-sm font-medium text-gray-700">Команда активна</span>
                </label>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition shadow-sm">
                    Сохранить изменения
                </button>
                <a href="{{ route('teams.show', $team) }}"
                   class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition">
                    Отмена
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
