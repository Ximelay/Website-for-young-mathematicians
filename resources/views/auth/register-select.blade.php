@extends('layouts.app')

@section('title', 'Регистрация — Турнир юных математиков')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="text-4xl">🎓</span>
            <h2 class="mt-4 text-3xl font-bold text-gray-900">Регистрация</h2>
            <p class="mt-2 text-gray-600">Выберите вашу роль в турнире</p>
            <p class="text-sm text-gray-500 mt-1">
                Уже есть аккаунт?
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Войти</a>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Участник --}}
            <a href="{{ route('register.form', 'participant') }}"
               class="block group hover:shadow-xl transition-all duration-200 rounded-lg">
                <x-card class="h-full border-2 border-transparent group-hover:border-yellow-400 transition-colors">
                    <div class="text-center py-4">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 rounded-full mb-4">
                            <span class="text-3xl">🎒</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Участник</h3>
                        <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold mb-4">
                            Школьник
                        </span>
                        <p class="text-gray-500 text-sm">
                            Участвую в турнире в составе команды. Имею доступ к материалам и результатам.
                        </p>
                        <div class="mt-6">
                            <x-button variant="primary" class="w-full justify-center">
                                Зарегистрироваться как участник
                            </x-button>
                        </div>
                    </div>
                </x-card>
            </a>

            {{-- Наставник --}}
            <a href="{{ route('register.form', 'mentor') }}"
               class="block group hover:shadow-xl transition-all duration-200 rounded-lg">
                <x-card class="h-full border-2 border-transparent group-hover:border-green-400 transition-colors">
                    <div class="text-center py-4">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                            <span class="text-3xl">👨‍🏫</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Наставник</h3>
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold mb-4">
                            Педагог / тренер
                        </span>
                        <p class="text-gray-500 text-sm">
                            Руковожу командой участников. Могу загружать материалы и видеть результаты команды.
                        </p>
                        <div class="mt-6">
                            <x-button variant="success" class="w-full justify-center">
                                Зарегистрироваться как наставник
                            </x-button>
                        </div>
                    </div>
                </x-card>
            </a>

            {{-- Координатор --}}
            <a href="{{ route('register.form', 'municipal_coordinator') }}"
               class="block group hover:shadow-xl transition-all duration-200 rounded-lg">
                <x-card class="h-full border-2 border-transparent group-hover:border-blue-400 transition-colors">
                    <div class="text-center py-4">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                            <span class="text-3xl">🏛️</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Координатор</h3>
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold mb-4">
                            Муниципальный
                        </span>
                        <p class="text-gray-500 text-sm">
                            Координирую турнир на уровне муниципалитета. Управляю событиями и командами.
                        </p>
                        <div class="mt-6">
                            <x-button variant="secondary" class="w-full justify-center">
                                Зарегистрироваться как координатор
                            </x-button>
                        </div>
                    </div>
                </x-card>
            </a>
        </div>

        <p class="text-center text-xs text-gray-400 mt-8">
            Организаторы добавляются только администратором системы
        </p>
    </div>
</div>
@endsection
