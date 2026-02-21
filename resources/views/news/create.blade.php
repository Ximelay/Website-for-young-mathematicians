@extends('layouts.app')

@section('title', 'Создать новость')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Заголовок -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">📝 Создать новость</h1>
                <p class="text-gray-600 mt-2">Заполните форму для публикации новости</p>
            </div>

            <!-- Форма -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <form method="POST" action="{{ route('news.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Заголовок -->
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                            Заголовок новости *
                        </label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            required
                            value="{{ old('title') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition @error('title') border-red-300 @enderror"
                            placeholder="Введите заголовок..."
                        >
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Изображение -->
                    <div>
                        <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                            Изображение (необязательно)
                        </label>
                        <input
                            type="file"
                            name="image"
                            id="image"
                            accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition @error('image') border-red-300 @enderror"
                        >
                        <p class="mt-1 text-xs text-gray-500">Макс. размер: 2 МБ. Форматы: JPG, PNG, GIF</p>
                        @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Контент -->
                    <div>
                        <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">
                            Текст новости *
                        </label>
                        <textarea
                            name="content"
                            id="content"
                            rows="10"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition @error('content') border-red-300 @enderror"
                            placeholder="Введите текст новости..."
                        >{{ old('content') }}</textarea>
                        @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Кнопки -->
                    <div class="flex gap-4 pt-4">
                        <button
                            type="submit"
                            class="flex-1 py-3 px-4 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 transition transform hover:scale-[1.02] shadow-lg"
                        >
                            🚀 Опубликовать новость
                        </button>
                        <a href="{{ route('news.index') }}"
                           class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                            Отмена
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
