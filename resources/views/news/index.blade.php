@extends('layouts.app')

@section('title', 'Новости - Турнир юных математиков')

@section('content')
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Новости турнира</h1>
                <p class="mt-2 text-gray-600">Актуальная информация о турнире и его участниках</p>
            </div>
            @auth
                @if(auth()->user()->hasRole('organizer'))
                    <div class="mb-6 text-right">
                        <a href="{{ route('news.create') }}"
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Создать новость
                        </a>
                    </div>
                @endif
            @endauth
            <!-- News Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($news as $item)
                    <!-- News Card (динамическая) -->
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition transform hover:-translate-y-1">
                        <!-- Изображение или градиент-заглушка -->
                        <div class="h-48 {{ $item->image_path ? '' : 'bg-gradient-to-r from-indigo-500 to-purple-600' }}">
                            @if($item->image_path)
                                <img src="{{ asset('storage/' . $item->image_path) }}"
                                     alt="{{ $item->title }}"
                                     class="w-full h-full object-cover">
                            @endif
                        </div>

                        <div class="p-6">
                            <!-- Дата и автор -->
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $item->published_at->format('d.m.Y') }}</span>
                                </div>
                                <span class="text-indigo-600 font-medium">{{ $item->author->first_name }} {{ mb_substr($item->author->last_name, 0, 1) }}.</span>
                            </div>

                            <!-- Заголовок и текст -->
                            <h3 class="text-xl font-semibold text-gray-900 mb-2 hover:text-indigo-600 transition">
                                <a href="{{ route('news.show', $item) }}">
                                    {{ $item->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($item->content), 150) }}
                            </p>

                            <!-- Кнопка -->
                            <a href="{{ route('news.show', $item) }}" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center">
                                Читать далее
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <!-- Пустое состояние -->
                    <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-12 text-center col-span-full">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Новостей пока нет</h3>
                        <p class="mt-2 text-gray-500">Скоро здесь появятся актуальные новости турнира</p>
                    </div>
                @endforelse
            </div>

            <!-- Пагинация -->
            @if($news->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $news->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
