@php $attributes = $unescapedForwardedAttributes ?? $attributes; @endphp
@props([
    'variant' => 'outline', // Các biến thể: outline, mini, micro
])

@php
    if ($variant === 'solid') {
        throw new \Exception('The "solid" variant is not supported in Lucide.');
    }

    $classes = Flux::classes('shrink-0')->add(
        match ($variant) {
            'outline' => '[:where(&)]:size-6',
            'mini' => '[:where(&)]:size-5',
            'micro' => '[:where(&)]:size-4',
            default => '[:where(&)]:size-6',
        },
    );

    $strokeWidth = match ($variant) {
        'outline' => 2,
        'mini' => 2.25,
        'micro' => 2.5,
        default => 2,
    };
@endphp

<svg {{ $attributes->class($classes) }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
    stroke="currentColor" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" stroke-linejoin="round"
    aria-hidden="true" data-slot="icon" data-flux-icon>
    <circle cx="10" cy="7" r="4" />
    <path d="M10.3 15H7a4 4 0 0 0-4 4v2" />
    <path d="M15 15.5V14a2 2 0 0 1 4 0v1.5" />
    <rect width="8" height="5" x="13" y="16" rx=".899" />
</svg>
