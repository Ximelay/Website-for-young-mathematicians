@extends('layouts.app')

@section('title', 'Личный кабинет — Участник')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if (session('success'))
            <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
        @endif

        <!-- Заголовок -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">🎓 Мой кабинет участника</h1>
            <p class="text-gray-500 mt-1">Добро пожаловать, {{ $user->first_name }}!</p>

            <div class="flex flex-wrap gap-2 mt-3">
                @if ($user->municipality)
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">
                    🏛️ {{ $user->municipality->name }}
                </span>
                @endif
                @if ($user->organization)
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                    🏫 {{ $user->organization->name }}
                </span>
                @endif
                @if ($user->grade)
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">
                    {{ $user->grade }} класс
                </span>
                @endif
            </div>
        </div>

        <!-- Профиль участника -->
        <x-card title="👤 Мой профиль" class="mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">ФИО:</span>
                    <span class="font-medium">{{ $user->getFullNameAttribute() }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Email:</span>
                    <span class="font-medium">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Телефон:</span>
                    <span class="font-medium">{{ $user->phone }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Населённый пункт:</span>
                    <span class="font-medium">{{ $user->locality ?? 'Не указан' }}</span>
                </div>
            </div>
        </x-card>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

            {{-- Команда --}}
            <x-card title="🏅 Моя команда">
                @if ($user->team)
                    <div class="space-y-3">
                        <div>
                            <p class="text-lg font-semibold text-gray-900">{{ $user->team->name }}</p>
                            <p class="text-sm text-gray-500">Вы состоите в команде</p>
                        </div>

                        @if($user->team->mentor)
                            <div class="flex items-center gap-2 text-sm">
                                <span class="text-gray-500">👨‍🏫 Наставник:</span>
                                <span class="font-medium">{{ $user->team->mentor->getFullNameAttribute() }}</span>
                            </div>
                        @endif

                        @php
                            $teammates = $user->team->members->where('is_active', true)->where('id', '!=', $user->id);
                        @endphp
                        @if($teammates->count() > 0)
                            <div>
                                <p class="text-sm text-gray-500 mb-2">👥 Участники ({{ $teammates->count() + 1 }}):</p>
                                <ul class="space-y-1">
                                    <li class="text-sm font-medium text-indigo-600">• {{ $user->getFullNameAttribute() }} (вы)</li>
                                    @foreach($teammates as $teammate)
                                        <li class="text-sm text-gray-700">• {{ $teammate->getFullNameAttribute() }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mt-4">
                            <a href="#" class="block w-full text-center px-4 py-2 border-2 border-indigo-600 text-indigo-600 font-semibold rounded-lg hover:bg-indigo-600 hover:text-white transition">
                                Подробнее о команде →
                            </a>
                        </div>
                    </div>
                @else
                    <x-alert type="warning" class="mb-4">
                        Вы ещё не в команде.
                    </x-alert>

                    {{-- 🔗 Кнопка выбора команды --}}
                    <a href="{{ route('teams.public') }}"
                       class="block w-full text-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition mb-3">
                        🏆 Выбрать команду
                    </a>

                    <p class="text-xs text-gray-500 text-center">
                        Или обратитесь к наставнику для добавления вручную
                    </p>
                @endif
            </x-card>

            {{-- Материалы --}}
            <x-card title="📚 Учебные материалы">
                @php
                    $materials = \App\Models\Material::published()->latest()->take(3)->get();
                @endphp

                @forelse($materials as $material)
                    <div class="mb-3 pb-3 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                        <a href="{{ route('materials.download', $material) }}" target="_blank"
                           class="text-sm font-medium text-gray-900 hover:text-indigo-600 flex items-center gap-2">
                            @if(str_contains($material->file_type, 'pdf'))
                                <span class="text-red-500">📄</span>
                            @else
                                <span class="text-blue-500">📎</span>
                            @endif
                            {{ $material->title }}
                        </a>
                        @if($material->description)
                            <p class="text-xs text-gray-500 mt-1">{{ Str::limit($material->description, 60) }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Материалов пока нет</p>
                @endforelse

                <div class="mt-4">
                    <a href="{{ route('materials.index') }}" class="block w-full text-center px-4 py-2 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                        Все материалы →
                    </a>
                </div>
            </x-card>
        </div>

        <!-- Новости и этапы -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            {{-- Новости --}}
            <x-card title="📰 Новости турнира">
                @php
                    $news = \App\Models\News::published()->latest()->take(3)->get();
                @endphp

                @forelse($news as $item)
                    <div class="mb-3 pb-3 border-b border-gray-100 last:border-0">
                        <a href="{{ route('news.show', $item) }}" class="text-sm font-medium text-gray-900 hover:text-indigo-600">
                            {{ $item->title }}
                        </a>
                        <p class="text-xs text-gray-500 mt-1">{{ $item->published_at->format('d.m.Y') }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Новостей пока нет</p>
                @endforelse

                <a href="{{ route('news.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium mt-2 inline-block">
                    Все новости →
                </a>
            </x-card>

            {{-- Этапы турнира --}}
            <x-card title="📅 Мои этапы">
                <div class="space-y-4">

                    <!-- Муниципальный этап -->
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <span class="text-indigo-600 font-bold">1</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">Муниципальный этап</p>
                            <p class="text-sm text-gray-500">
                                @if($user->team?->municipalStages?->count() > 0)
                                    <span class="text-green-600 font-medium">✓ Участвуете</span>
                                @else
                                    <span class="text-gray-400">Ожидается</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Региональный этап -->
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="text-purple-600 font-bold">2</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">Региональный этап</p>
                            <p class="text-sm text-gray-500">
                                @if($user->team?->regionalStages?->count() > 0)
                                    <span class="text-green-600 font-medium">✓ Участвуете</span>
                                @else
                                    <span class="text-gray-400">Квалификация после муниципального</span>
                                @endif
                            </p>
                        </div>
                    </div>

                </div>
            </x-card>
        </div>

        <!-- Быстрые действия -->
        <x-card title="⚡ Быстрые действия">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('materials.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-lg border-2 border-indigo-600 hover:bg-white hover:text-indigo-600 transition">
                    📚 Материалы
                </a>
                <a href="{{ route('news.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 text-white font-medium rounded-lg border-2 border-green-600 hover:bg-white hover:text-green-600 transition">
                    📰 Новости
                </a>
                <a href="#"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-600 text-white font-medium rounded-lg border-2 border-gray-600 hover:bg-white hover:text-gray-600 transition">
                    👥 Моя команда
                </a>
            </div>
        </x-card>

    </div>
@endsection
