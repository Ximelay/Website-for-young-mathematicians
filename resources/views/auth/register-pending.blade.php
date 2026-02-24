@extends('layouts.app')

@section('title', 'Регистрация отправлена на проверку')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">

        {{-- Карточка --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-center">

            {{-- Иконка --}}
            <div class="px-8 pt-10 pb-6">
                <div class="w-20 h-20 rounded-2xl bg-amber-100 flex items-center justify-center mx-auto mb-5">
                    <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <h1 class="text-2xl font-bold text-gray-900 mb-2">
                    Заявка отправлена!
                </h1>

                <p class="text-gray-500 text-sm leading-relaxed">
                    @if(session('pending_name'))
                        <span class="font-medium text-gray-700">{{ session('pending_name') }}</span>, ваша
                    @else
                        Ваша
                    @endif
                    заявка на регистрацию как <span class="font-semibold text-green-700">наставник</span>
                    находится на проверке у организатора.
                </p>
            </div>

            {{-- Шаги --}}
            <div class="mx-6 mb-6 rounded-xl bg-gray-50 border border-gray-100 divide-y divide-gray-100">
                <div class="flex items-center gap-3 px-4 py-3">
                    <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-700">Аккаунт создан</p>
                </div>
                <div class="flex items-center gap-3 px-4 py-3">
                    <div class="w-7 h-7 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-700">
                        Ожидает одобрения организатора
                        <span class="ml-1 text-xs text-amber-600 font-medium">● В процессе</span>
                    </p>
                </div>
                <div class="flex items-center gap-3 px-4 py-3 opacity-50">
                    <div class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500">Вход в кабинет</p>
                </div>
            </div>

            {{-- Подсказка --}}
            <div class="mx-6 mb-8 p-4 rounded-xl bg-blue-50 border border-blue-100 text-left">
                <p class="text-xs text-blue-700 leading-relaxed">
                    💡 После одобрения вы сможете войти в систему с указанными email и паролем.
                    Свяжитесь с организатором если ожидание затянулось.
                </p>
            </div>

            {{-- Кнопка --}}
            <div class="px-6 pb-8">
                <a href="{{ route('login') }}"
                   class="block w-full py-3 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition text-center">
                    Перейти к входу
                </a>
            </div>

        </div>

        {{-- Ссылка назад --}}
        <p class="mt-4 text-center text-sm text-gray-400">
            <a href="{{ route('register') }}" class="hover:text-indigo-600 transition">← Выбор роли</a>
        </p>

    </div>
</div>
@endsection
