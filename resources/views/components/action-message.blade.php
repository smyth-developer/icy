@props([
    'on',
])

<div
    x-data="{ shown: false, timeout: null }"
    x-init="@this.on('{{ $on }}', () => { clearTimeout(timeout); shown = true; try { const el = document.getElementById('sound-success'); if (el) { el.cloneNode(true).play(); } else { new Audio('{{ asset('storage/audio/success.mp3') }}').play(); } } catch(e){} timeout = setTimeout(() => { shown = false }, 2000); })"
    x-show.transition.out.opacity.duration.1500ms="shown"
    x-transition:leave.opacity.duration.1500ms
    style="display: none"
    {{ $attributes->merge(['class' => 'text-sm']) }}
>
    {{ $slot->isEmpty() ? __('Saved.') : $slot }}
</div>
