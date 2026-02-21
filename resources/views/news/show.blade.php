@extends('layouts.app')

@section('title', $news->title)

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Карточка новости -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Заголовок -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white mb-2">{{ $news->title }}</h1>
                    <div class="flex items-center gap-4 text-indigo-100 text-sm">
                        <span>📅 {{ $news->published_at->format('d.m.Y H:i') }}</span>
                        <span>👤 {{ $news->author->getFullNameAttribute() }}</span>
                    </div>
                </div>
                @extends('layouts.app')

                @section('title', $news->title)

                @section('content')
                    <div class="min-h-screen bg-gray-50 py-12">
                        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                                <!-- Заголовок с градиентом -->
                                <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 px-8 py-8">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h1 class="text-3xl font-bold text-white mb-4">{{ $news->title }}</h1>
                                            <div class="flex flex-wrap items-center gap-6 text-indigo-100 text-sm">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span>{{ $news->published_at?->format('d.m.Y H:i') ?? 'Дата не указана' }}</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    <span>{{ $news->author?->getFullNameAttribute() ?? 'Автор' }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Кнопки для организатора -->
                                        @auth
                                            @if(auth()->user()->hasRole('organizer'))
                                                <div class="flex gap-3">
                                                    <a href="{{ route('news.edit', $news) }}"
                                                       class="px-5 py-2 bg-white text-indigo-600 font-semibold rounded-lg border-2 border-white hover:bg-gray-100 transition shadow-lg flex items-center gap-2">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        Редактировать
                                                    </a>
                                                    <form method="POST" action="{{ route('news.destroy', $news) }}"
                                                          onsubmit="return confirm('Вы уверены, что хотите удалить эту новость?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="px-5 py-2 bg-white text-red-600 font-semibold rounded-lg border-2 border-white hover:bg-red-50 transition shadow-lg flex items-center gap-2">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            Удалить
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>
                                </div>

                                <!-- Изображение новости (если есть) -->
                                @if($news->image_path)
                                    <div class="w-full h-64 bg-gray-200">
                                        <img src="{{ asset('storage/' . $news->image_path) }}"
                                             alt="{{ $news->title }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                @endif

                                <!-- Контент новости -->
                                <div class="px-8 py-8">
                                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                                        {!! nl2br(e($news->content)) !!}
                                    </div>
                                </div>

                                <!-- Кнопка назад -->
                                <div class="px-8 py-6 bg-gray-50 border-t border-gray-200">
                                    <a href="{{ route('news.index') }}"
                                       class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium transition">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                        </svg>
                                        Назад к списку новостей
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endsection

                <!-- Контент -->
                <div class="px-8 py-8">
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($news->content)) !!}
                    </div>
                </div>

                <!-- Кнопка назад -->
                <div class="px-8 py-6 bg-gray-50 border-t border-gray-200">
                    <a href="{{ route('news.index') }}"
                       class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium">
                        ← Назад к списку новостей
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
