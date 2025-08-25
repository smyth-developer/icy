<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800 ">
    <div class="flex min-h-screen">
        {{-- Sidebar bên trái --}}
        <flux:sidebar sticky stashable
            class="w-[290px] border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline" class="[&_[data-flux-icon]]:!size-5">
                <flux:navlist.group :heading="__('General')" class="grid">

                    <flux:navlist.item icon="home" :href="route('dashboard')"
                        :current="request()->routeIs('dashboard')" wire:navigate>
                        Bảng điều khiển
                    </flux:navlist.item>

                </flux:navlist.group>

                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">

                <flux:navlist.group :heading="__('Management')" class="grid">

                    <flux:navlist.item icon="map-pin-house" :href="route('admin.management.locations')"
                        :current="request()->routeIs('admin.management.locations')" wire:navigate>
                        Cơ sở
                    </flux:navlist.item>

                    <flux:navlist.item icon="calendar" :href="route('admin.management.seasons')"
                        :current="request()->routeIs('admin.management.seasons')" wire:navigate>
                        Học kỳ
                    </flux:navlist.item>

                    <flux:navlist.item icon="book-marked" :href="route('admin.management.programs')"
                        :current="request()->routeIs('admin.management.programs')" wire:navigate>
                        Chương trình học
                    </flux:navlist.item>

                    <flux:navlist.item icon="book-open" :href="route('admin.management.subjects')"
                        :current="request()->routeIs('admin.management.subjects')" wire:navigate>
                        Môn học
                    </flux:navlist.item>

                    <flux:navlist.item icon="academic-cap" :href="route('admin.management.courses')"
                        :current="request()->routeIs('admin.management.courses')" wire:navigate>
                        Lớp học
                    </flux:navlist.item>

                    <flux:navlist.item icon="list-bullet" :href="route('admin.management.syllabi')"
                        :current="request()->routeIs('admin.management.syllabi')" wire:navigate>
                        Syllabus
                    </flux:navlist.item>

                    <flux:navlist.item icon="book-open-text" :href="route('admin.management.curricula')"
                        :current="request()->routeIs('admin.management.curricula')" wire:navigate>
                        Giáo trình
                    </flux:navlist.item>

                </flux:navlist.group>

                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">

                <flux:navlist.group :heading="__('Arrangement')" class="grid">

                    <flux:navlist.item icon="adjustments-horizontal"
                        :current="request()->routeIs('')" wire:navigate>
                        Xếp lớp học
                    </flux:navlist.item>

                    <flux:navlist.item icon="calendar-days"
                        :current="request()->routeIs('')" wire:navigate>
                       Xếp lịch học
                    </flux:navlist.item>

                </flux:navlist.group>

                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">

                <flux:navlist.group :heading="__('Access')" class="grid">

                    <flux:navlist.item icon="user-lock" :href="route('admin.access.roles')"
                        :current="request()->routeIs('admin.access.roles')" wire:navigate>
                        Chức vụ
                    </flux:navlist.item>

                    <flux:navlist.item icon="shield-check" :href="route('admin.access.permissions')"
                        :current="request()->routeIs('admin.access.permissions')" wire:navigate>
                        Quyền
                    </flux:navlist.item>

                </flux:navlist.group>

                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">

                <flux:navlist.group :heading="__('Human resources')" class="grid">

                    <flux:navlist.item icon="users" :href="route('admin.personnel.staff')"
                        :current="request()->routeIs('admin.personnel.staff')" wire:navigate>
                        Nhân viên
                    </flux:navlist.item>

                    <flux:navlist.item icon="user-group" :href="route('admin.personnel.students')"
                        :current="request()->routeIs('admin.personnel.students')" wire:navigate>
                        Học viên
                    </flux:navlist.item>

                    <flux:navlist.item icon="user-pen" :href="route('admin.personnel.student-registration')"
                        :current="request()->routeIs('admin.personnel.student-registration')" wire:navigate>
                        Đăng ký học viên
                    </flux:navlist.item>

                    <flux:navlist.item icon="user-plus" :href="route('admin.personnel.staff-registration')"
                        :current="request()->routeIs('admin.personnel.staff-registration')" wire:navigate>
                        Đăng ký nhân viên
                    </flux:navlist.item>

                </flux:navlist.group>

            </flux:navlist>

            <flux:spacer />

            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile :name="auth()->user()->name" avatar="{{ auth()->user()->detail?->avatar }}"
                    icon:trailing="chevrons-up-down" />
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
                        <flux:menu.item :href="route('admin.settings.profile')" icon="cog" wire:navigate>
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
                <flux:dropdown  class="cursor-pointer" position="top" align="end">
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
                            <flux:menu.item :href="route('admin.settings.profile')" icon="cog" wire:navigate>
                                Cài đặt</flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                class="w-full ">
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

            {{-- Alert Messages --}}
            <x-alert-toastr />

            {{-- Footer --}}
            @include('components.layouts.app.footer')
            {{-- @include('components.layouts.app.dial') --}}
        </div>
    </div>
    @stack('scripts')
    @fluxScripts
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <audio id="sound-success" preload="auto" src="{{ asset('storage/audio/success.mp3') }}"></audio>
</body>


</html>
