@extends('layouts.app')

@section('title', 'Вход — Турнир юных математиков')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <!-- Логотип и заголовок -->
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center mb-8">
            <div class="flex justify-center mb-6">
                <!-- ПРОСТАЯ ИКОНКА с inline стилями -->
                <div style="
            width: 160px;
            height: 160px;
            background: linear-gradient(135deg, #4f46e5 0%, #9333ea 50%, #ec4899 100%);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 4px solid white;
        ">
                    <span style="font-size: 96px; line-height: 1;">🎓</span>
                </div>
            </div>
            <h2 class="text-4xl font-bold text-gray-900 mb-2">
                С возвращением!
            </h2>
            <p class="text-gray-600">
                Войдите в свой аккаунт Турнира юных математиков
            </p>
            <p class="mt-3 text-sm text-gray-600">
                Нет аккаунта?
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition">
                    Зарегистрироваться
                </a>
            </p>
        </div>

        <!-- Форма входа -->
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white rounded-2xl shadow-xl px-8 py-10">
                {{-- Глобальные ошибки --}}
                @if ($errors->any())
                    <div class="mb-6">
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <ul class="list-disc list-inside space-y-1 text-sm text-red-700">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Сообщение об успехе --}}
                @if (session('status'))
                    <div class="mb-6">
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">{{ session('status') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="flex items-center gap-2 block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Email адрес
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            value="{{ old('email') }}"
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition @error('email') border-red-300 @enderror"
                            placeholder="you@example.com"
                        >
                        @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Пароль --}}
                    <div>
                        <label for="password" class="flex items-center gap-2 block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Пароль
                        </label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition @error('password') border-red-300 @enderror"
                            placeholder="••••••••"
                        >
                        @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Запомнить меня --}}
                    <div class="flex items-center">
                        <input
                            id="remember"
                            name="remember"
                            type="checkbox"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded cursor-pointer"
                        >
                        <label for="remember" class="ml-2 block text-sm text-gray-700 cursor-pointer">
                            Запомнить меня
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="w-full flex justify-center py-3 px-4 border-2 border-indigo-600 rounded-lg shadow-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 hover:shadow-2xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:scale-[1.02]"
                    >
                        Войти в аккаунт
                    </button>
                </form>
            </div>

            <!-- Дополнительная информация -->
            <div class="mt-8 text-center">
                <p class="text-xs text-gray-500">
                    © {{ date('Y') }} Турнир юных математиков памяти А.А. Кошкина
                </p>
            </div>
        </div>
    </div>
@endsection
