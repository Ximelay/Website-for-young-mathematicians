@extends('layouts.app')

@section('title', 'Регистрация — Турнир юных математиков')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 flex flex-col justify-center py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full">

        {{-- Заголовок --}}
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <span class="text-3xl">🎓</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Регистрация</h1>
            <p class="text-gray-500 mt-2">Выберите вашу роль в турнире</p>
            <p class="text-sm text-gray-400 mt-1">
                Уже есть аккаунт?
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Войти</a>
            </p>
        </div>

        {{-- Карточки ролей --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Участник --}}
            <a href="{{ route('register.form', 'participant') }}"
               class="group bg-white rounded-2xl border-2 border-gray-100 shadow-sm hover:border-yellow-400 hover:shadow-lg transition-all p-6 flex flex-col">
                <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-yellow-200 transition">
                    <span class="text-2xl">🎒</span>
                </div>
                <div class="mb-1 flex items-center gap-2">
                    <h2 class="text-lg font-bold text-gray-900">Участник</h2>
                    <span class="px-2 py-0.5 text-xs rounded-full bg-yellow-100 text-yellow-700 font-medium">Школьник</span>
                </div>
                <p class="text-sm text-gray-500 flex-1">
                    Участвую в турнире в составе команды. Имею доступ к материалам и результатам соревнований.
                </p>
                <div class="mt-5 flex items-center gap-2 text-sm font-semibold text-yellow-600 group-hover:text-yellow-700">
                    Зарегистрироваться
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            {{-- Наставник --}}
            <a href="{{ route('register.form', 'mentor') }}"
               class="group bg-white rounded-2xl border-2 border-gray-100 shadow-sm hover:border-green-400 hover:shadow-lg transition-all p-6 flex flex-col">
                <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-green-200 transition">
                    <span class="text-2xl">👨‍🏫</span>
                </div>
                <div class="mb-1 flex items-center gap-2">
                    <h2 class="text-lg font-bold text-gray-900">Наставник</h2>
                    <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700 font-medium">Педагог</span>
                </div>
                <p class="text-sm text-gray-500 flex-1">
                    Руковожу командой участников. Могу загружать материалы и отслеживать результаты своей команды.
                </p>
                <div class="mt-5 flex items-center gap-2 text-sm font-semibold text-green-600 group-hover:text-green-700">
                    Зарегистрироваться
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

        </div>
    </div>
</div>
@endsection
