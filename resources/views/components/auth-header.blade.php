@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <flux:heading size="xl" class="text-pink-500 dark:text-white text-xl sm:text-2xl font-black">{{ $title }}</flux:heading>
    <flux:subheading class="text-pink-500 dark:text-white font-bold text-sm sm:text-base">{{ $description }}</flux:subheading>
</div>
