{{-- Button Component --}}
@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, success, danger
])

@php
    $classes = match($variant) {
        'primary' => 'bg-indigo-600 text-white hover:bg-indigo-700',
        'secondary' => 'bg-gray-600 text-white hover:bg-gray-700',
        'success' => 'bg-green-600 text-white hover:bg-green-700',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        'outline' => 'border border-gray-300 text-gray-700 hover:bg-gray-50',
        default => 'bg-indigo-600 text-white hover:bg-indigo-700',
    };
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => "px-4 py-2 rounded-md font-semibold transition $classes"]) }}
>
    {{ $slot }}
</button>
