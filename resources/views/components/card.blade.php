{{-- Card Component --}}
@props([
    'title' => '',
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow overflow-hidden']) }}>
    @if($title || $icon)
        <div class="px-6 py-5 border-b border-gray-200">
            <div class="flex items-center">
                @if($icon)
                    <div class="flex-shrink-0 mr-3">
                        {!! $icon !!}
                    </div>
                @endif
                @if($title)
                    <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
                @endif
            </div>
        </div>
    @endif

    <div class="p-6">
        {{ $slot }}
    </div>
</div>
