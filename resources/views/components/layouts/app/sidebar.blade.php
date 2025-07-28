<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <div class="flex min-h-screen">
        {{-- Sidebar bên trái --}}
        <flux:sidebar sticky stashable
            class="w-[290px] border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">

                    <flux:navlist.item icon="home" :href="route('dashboard')"
                        :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('dashboard.Dashboard') }}
                    </flux:navlist.item>

                    <flux:navlist.item icon="notebook-pen" :href="route('management.notes')"
                        :current="request()->routeIs('management.notes')" wire:navigate>
                        {{ __('dashboard.Notes') }}
                    </flux:navlist.item>

                </flux:navlist.group>

                <flux:navlist.group :heading="__('Management')" class="grid">

                    <flux:navlist.item icon="map-pin-house" :href="route('management.locations')"
                        :current="request()->routeIs('management.locations')" wire:navigate>
                        {{ __('dashboard.location') }}
                    </flux:navlist.item>

                    <flux:navlist.item icon="calendar-cog" :href="route('management.seasons')"
                        :current="request()->routeIs('management.seasons')" wire:navigate>
                        Học kỳ
                    </flux:navlist.item>

                    <flux:navlist.item icon="book-marked" :href="route('management.courses')"
                        :current="request()->routeIs('management.courses')" wire:navigate>
                        Khoá học
                    </flux:navlist.item>

                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />


            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile :name="auth()->user()->name" avatar="{{ auth()->user()->detail?->avatar }}"
                    icon:trailing="chevrons-up-down" />
                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar src="{{ auth()->user()->detail?->avatar }}" />
                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                            Cài đặt</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                            class="w-full">
                            Đăng xuất
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <div class="flex flex-col flex-1 min-h-screen">
            {{-- Mobile header --}}
            <flux:header class="lg:hidden">
                <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
                <flux:spacer />
                <flux:dropdown position="top" align="end">
                    <flux:profile avatar="{{ auth()->user()->detail?->avatar }}" icon-trailing="chevron-down" />

                    <flux:menu>
                        <flux:menu.radio.group>
                            <div class="p-0 text-sm font-normal">
                                <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                   <flux:avatar src="{{ auth()->user()->detail?->avatar }}" />
                                    <div class="grid flex-1 text-start text-sm leading-tight">
                                        <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                                Cài đặt</flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                class="w-full">
                                Đăng xuất
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </flux:header>

            {{-- Nội dung --}}
            <main class="flex-grow p-4">
                {{ $slot }}
            </main>

            {{-- Footer --}}
            @include('components.layouts.app.footer')
        </div>
    </div>

    @fluxScripts
</body>


</html>
