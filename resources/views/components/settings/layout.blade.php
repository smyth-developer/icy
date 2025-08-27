<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <flux:navlist>
            <flux:navlist.item :href="route('admin.settings.profile')" :current="request()->routeIs('admin.settings.profile')" wire:navigate>Hồ sơ</flux:navlist.item>
            <flux:navlist.item :href="route('admin.settings.password')" :current="request()->routeIs('admin.settings.password')" wire:navigate>Mật khẩu</flux:navlist.item>
            <flux:navlist.item :href="route('admin.settings.appearance')" :current="request()->routeIs('admin.settings.appearance')" wire:navigate>Giao diện</flux:navlist.item>
            {{--<flux:navlist.item :href="route('admin.settings.notification')" :current="request()->routeIs('admin.settings.notification')" wire:navigate>Thông báo</flux:navlist.item>--}}
            <flux:navlist.item :href="route('admin.settings.authentication-logs')" :current="request()->routeIs('admin.settings.authentication-logs*')" wire:navigate>Nhật ký đăng nhập</flux:navlist.item>
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full">
            {{ $slot }}
        </div>
    </div>
</div>
