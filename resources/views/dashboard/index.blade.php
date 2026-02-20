@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if (session('success'))
        <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
    @endif

    <x-card title="Личный кабинет">
        <x-alert type="warning">
            Вашему аккаунту не назначена роль. Обратитесь к организатору.
        </x-alert>
        <div class="mt-4">
            <p class="text-gray-600">Email: <strong>{{ $user->email }}</strong></p>
        </div>
    </x-card>

</div>
@endsection
