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
