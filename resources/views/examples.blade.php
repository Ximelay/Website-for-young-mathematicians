@extends('layouts.app')

@section('title', 'Примеры компонентов')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Примеры компонентов</h1>

    <!-- Alerts -->
    <div class="mb-12">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Alerts (Уведомления)</h2>
        <div class="space-y-4">
            <x-alert type="success">
                <strong>Успех!</strong> Операция выполнена успешно.
            </x-alert>

            <x-alert type="info">
                <strong>Информация:</strong> Это информационное сообщение.
            </x-alert>

            <x-alert type="warning">
                <strong>Внимание!</strong> Пожалуйста, проверьте введенные данные.
            </x-alert>

            <x-alert type="danger">
                <strong>Ошибка!</strong> Произошла ошибка при выполнении операции.
            </x-alert>
        </div>
    </div>

    <!-- Buttons -->
    <div class="mb-12">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Buttons (Кнопки)</h2>
        <div class="flex flex-wrap gap-4">
            <x-button variant="primary">
                Primary Button
            </x-button>

            <x-button variant="secondary">
                Secondary Button
            </x-button>

            <x-button variant="success">
                Success Button
            </x-button>

            <x-button variant="danger">
                Danger Button
            </x-button>

            <x-button variant="outline">
                Outline Button
            </x-button>
        </div>
    </div>

    <!-- Cards -->
    <div class="mb-12">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Cards (Карточки)</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <x-card title="Простая карточка">
                <p class="text-gray-600">Это содержимое простой карточки без иконки.</p>
            </x-card>

            <x-card title="Карточка с иконкой">
                <x-slot name="icon">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </x-slot>
                <p class="text-gray-600">Карточка с иконкой в заголовке.</p>
            </x-card>

            <x-card>
                <p class="text-gray-600">Карточка без заголовка, только с содержимым.</p>
            </x-card>
        </div>
    </div>

    <!-- Forms -->
    <div class="mb-12">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Forms (Формы)</h2>
        <x-card title="Пример формы">
            <form class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Имя
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Введите имя"
                    >
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="example@email.com"
                    >
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                        Роль
                    </label>
                    <select
                        id="role"
                        name="role"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                        <option value="">Выберите роль</option>
                        <option value="participant">Участник</option>
                        <option value="mentor">Наставник</option>
                        <option value="coordinator">Координатор</option>
                        <option value="organizer">Организатор (админ)</option>
                    </select>
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                        Сообщение
                    </label>
                    <textarea
                        id="message"
                        name="message"
                        rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Введите текст..."
                    ></textarea>
                </div>

                <div class="flex items-center">
                    <input
                        type="checkbox"
                        id="agree"
                        name="agree"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                    >
                    <label for="agree" class="ml-2 block text-sm text-gray-700">
                        Я согласен с условиями
                    </label>
                </div>

                <div class="flex gap-4">
                    <x-button type="submit" variant="primary">
                        Отправить
                    </x-button>
                    <x-button type="button" variant="outline">
                        Отмена
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>

    <!-- Badges -->
    <div class="mb-12">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Badges (Значки)</h2>
        <div class="flex flex-wrap gap-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                Организатор
            </span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                Координатор
            </span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                Наставник
            </span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                Участник
            </span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                Неактивен
            </span>
        </div>
    </div>

    <!-- Tables -->
    <div class="mb-12">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Tables (Таблицы)</h2>
        <x-card>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Имя
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Роль
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Действия
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                Иван Иванов
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ivan@example.com
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Наставник
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Изменить</a>
                                <a href="#" class="text-red-600 hover:text-red-900">Удалить</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                Петр Петров
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                petr@example.com
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Участник
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Изменить</a>
                                <a href="#" class="text-red-600 hover:text-red-900">Удалить</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</div>
@endsection
