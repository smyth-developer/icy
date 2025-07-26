<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <div class="flex min-h-screen">
        {{-- Sidebar bên trái --}}
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('dashboard.Dashboard') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="notebook-pen" :href="route('notes')" :current="request()->routeIs('notes')" wire:navigate>
                        {{ __('dashboard.Notes') }}
                    </flux:navlist.item>
                </flux:navlist.group>
                <flux:navlist.group :heading="__('Management')" class="grid">
                    <flux:navlist.item icon="map-pin-house" :href="route('locations')" :current="request()->routeIs('locations')" wire:navigate>
                        {{ __('dashboard.location') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="calendar-cog" :href="route('seasons')" :current="request()->routeIs('seasons')" wire:navigate>
                        Học kỳ
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            {{-- User dropdown giữ nguyên ở đây --}}
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                {{-- ... --}}
            </flux:dropdown>
        </flux:sidebar>

        {{-- Main content phải nằm bên phải --}}
        <div class="flex flex-col flex-1 min-h-screen">
            {{-- Mobile header --}}
            <flux:header class="lg:hidden">
                <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
                <flux:spacer />
                {{-- User dropdown giữ nguyên --}}
                <flux:dropdown position="top" align="end">
                    {{-- ... --}}
                </flux:dropdown>
            </flux:header>

            {{-- Nội dung --}}
            <main class="flex-grow p-4">
                {{ $slot }}
            </main>

            {{-- Footer --}}
            <footer class="bg-white dark:bg-zinc-900 border-t border-gray-200 dark:border-zinc-700 text-center text-sm text-gray-500 py-4">
                © {{ date('Y') }} ICY. All rights reserved.
            </footer>
        </div>
    </div>

    @fluxScripts
</body>


</html>
