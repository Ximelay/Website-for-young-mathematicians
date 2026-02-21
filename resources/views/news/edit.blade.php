@extends('layouts.app')

@section('title', 'Редактировать новость')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Заголовок -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">✏️ Редактировать новость</h1>
                <p class="text-gray-600 mt-2">Внесите изменения в новость</p>
            </div>

            <!-- Форма -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <form method="POST" action="{{ route('news.update', $news) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

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
                            value="{{ old('title', $news->title) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition @error('title') border-red-300 @enderror"
                            placeholder="Введите заголовок..."
                        >
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Текущее изображение -->
                    @if($news->image_path)
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Текущее изображение
                            </label>
                            <div class="relative w-full h-48 bg-gray-100 rounded-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $news->image_path) }}"
                                     alt="{{ $news->title }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Загрузите новое изображение, чтобы заменить</p>
                        </div>
                    @endif

                    <!-- Новое изображение -->
                    <div>
                        <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                            Загрузить новое изображение (необязательно)
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
                        >{{ old('content', $news->content) }}</textarea>
                        @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Кнопки -->
                    <div class="flex gap-4 pt-4">
                        <button
                            type="submit"
                            class="flex-1 py-3 px-4 border-2 border-indigo-600 rounded-lg shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:bg-indigo-700 hover:shadow-2xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:scale-[1.02]"
                        >
                            💾 Сохранить изменения
                        </button>
                        <a href="{{ route('news.show', $news) }}"
                           class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                            Отмена
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
