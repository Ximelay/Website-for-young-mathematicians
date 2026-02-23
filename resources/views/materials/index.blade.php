@extends('layouts.app')

@section('title', 'Учебные материалы')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if (session('success'))
            <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
        @endif

        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">📚 Учебные материалы</h1>
                <p class="text-gray-500 mt-1">Библиотека материалов турнира</p>
            </div>
            <a href="{{ route('materials.create') }}"
               class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                ➕ Загрузить материал
            </a>
        </div>

        <x-card>
            @php
                $materials = \App\Models\Material::with('uploadedBy')->latest()->paginate(15);
            @endphp

            @forelse($materials as $material)
                <div class="flex items-center justify-between p-4 border-b border-gray-200 last:border-0 hover:bg-gray-50">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0">
                            @if(str_contains($material->file_type, 'pdf'))
                                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">{{ $material->title }}</h3>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ strtoupper($material->file_type) }} • {{ number_format($material->file_size / 1024, 1) }} KB
                                @if($material->description)
                                    • {{ Str::limit($material->description, 50) }}
                                @endif
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                Загрузил: {{ $material->uploadedBy?->getFullNameAttribute() ?? 'Неизвестно' }}
                                • {{ $material->created_at->format('d.m.Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('materials.download', $material) }}"
                           class="px-3 py-1 text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            Скачать
                        </a>
                        @if(auth()->user()->hasRole('organizer'))
                            <form method="POST" action="{{ route('materials.destroy', $material) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Удалить материал?')"
                                        class="px-3 py-1 text-sm text-red-600 hover:text-red-800 font-medium">
                                    Удалить
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="mt-2 text-gray-500">Материалов пока нет</p>
                    <a href="{{ route('materials.create') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 font-medium">
                        Загрузить первый материал →
                    </a>
                </div>
            @endforelse

            @if($materials->hasPages())
                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $materials->links() }}
                </div>
            @endif
        </x-card>

    </div>
@endsection
