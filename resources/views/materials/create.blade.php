@extends('layouts.app')

@section('title', 'Загрузка материала')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if (session('success'))
            <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
        @endif

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">📁 Загрузка материала</h1>
            <p class="text-gray-500 mt-1">Добавление нового учебного материала</p>
        </div>

        <x-card>
            <form method="POST" action="{{ route('materials.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Название -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Название материала *
                    </label>
                    <input type="text"
                           name="title"
                           required
                           value="{{ old('title') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                           placeholder="Например: Методические рекомендации">
                    @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Описание -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Описание
                    </label>
                    <textarea name="description"
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                              placeholder="Краткое описание материала...">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Файл -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Файл *
                    </label>
                    <input type="file"
                           name="file"
                           required
                           accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">
                        Допустимые форматы: PDF, DOC, DOCX, PPT, XLS, ZIP (макс. 10MB)
                    </p>
                    @error('file')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Опубликовать -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox"
                               name="is_published"
                               value="1"
                               {{ old('is_published') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                        <span class="ml-2 text-sm text-gray-700">Опубликовать сразу</span>
                    </label>
                </div>

                <!-- Кнопки -->
                <div class="flex gap-3">
                    <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                        💾 Загрузить
                    </button>
                    <a href="{{ route('materials.index') }}"
                       class="px-6 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                        Отмена
                    </a>
                </div>
            </form>
        </x-card>

    </div>
@endsection
