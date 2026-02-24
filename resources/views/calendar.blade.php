@extends('layouts.app')
@section('title', 'Календарь событий')
@section('content')
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold mb-8">Календарь событий</h1>

        @if(auth()->user()->hasRole('organizer'))
            <div class="mb-8">
                <a href="{{ route('events.create') }}" class="bg-indigo-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-indigo-700 transition inline-block">
                    Добавить событие
                </a>
            </div>
        @endif

        @if($events->isEmpty())
            <div class="text-center py-12 text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="mt-4">События не запланированы</p>
                <p class="text-sm">Календарь событий будет доступен позже</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($events as $event)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-xl font-semibold mb-2">{{ $event->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ $event->description }}</p>

                        <div class="flex items-center mb-2">
                            <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-gray-700">{{ $event->start_date->format('d.m.Y H:i') }}</span>
                        </div>

                        <div class="flex items-center mb-2">
                            <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-gray-700">{{ $event->location }}</span>
                        </div>

                        <div class="flex items-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                {{ $event->getTypeName() }}
                            </span>
                        </div>
                    </div>
                    @if(auth()->user()->hasRole('organizer'))
                        <div class="mt-4 flex space-x-2">
                            <!--кнопка редактирования-->
                            <a href="{{ route('events.edit', $event) }}"
                               class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Редактировать
                            </a>
                            <!--кнопка удаления с подтвержением действия-->
                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                        onclick="return confirm('Вы уверены, что хотите удалить это событие?')">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endsection
