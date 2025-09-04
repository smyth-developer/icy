@php
    $lastUser = null;
    if (Cookie::has('last_user')) {
        try {
            $lastUser = json_decode(decrypt(Cookie::get('last_user')), true);
        } catch (\Exception $e) {
            $lastUser = null;
        }
    }
@endphp

<div class="flex flex-col gap-4 sm:gap-6">
    <!-- Nếu có last_user thì hiển thị avatar -->
    @if ($lastUser)
    <x-auth-header :title="__('Đăng nhập hệ thống')" :description="__('')" />
        <div class="text-center">
            <img src="{{ $lastUser['avatar'] ?? '/storage/images/avatars/default-avatar.png' }}" alt="avatar"
                class="w-20 h-20 rounded-full mx-auto mb-3">
            <h2 class="font-bold text-lg dark:text-white">{{ $lastUser['name'] ?? 'User' }}</h2>

            <form wire:submit="login" class="flex flex-col gap-4 sm:gap-6">
                <input type="hidden" wire:model="login_id" value="{{ $lastUser['email'] ?? $lastUser['username'] }}">
                <x-auth-session-status class="text-center" :status="session('status')" />
                <!-- Password -->
                <flux:input wire:model="password" :label="__('Password')" type="password" required
                    autocomplete="current-password" :placeholder="__('Mật khẩu')" viewable />

                <flux:button variant="primary" color="pink" type="submit" class="w-full cursor-pointer">
                    {{ __('Đăng nhập lại') }}
                </flux:button>
            </form>

            <flux:link color="pink" class="text-sm text-gray-500 mt-2 inline-block cursor-pointer dark:text-white" wire:click="clearLastUser" wire:navigate>
                {{ __('Đăng nhập bằng tài khoản khác') }}
            </flux:link>
        </div>
    @else
    <x-auth-header :title="__('Đăng nhập hệ thống')" :description="__('Sử dụng Username và Email để đăng nhập.')" />
        <!-- Form login gốc -->
        <x-auth-session-status class="text-center" :status="session('status')" />
        <form wire:submit="login" class="flex flex-col gap-4 sm:gap-6">
            <flux:input wire:model="login_id" :label="__('Địa chỉ Email / Username')" type="text" required
                placeholder="email@example.com / Username" autofocus />

            <flux:input wire:model="password" :label="__('Password')" type="password" required
                autocomplete="current-password" placeholder="Mật khẩu" viewable />

            <flux:checkbox wire:model="remember" :label="__('Ghi nhớ đăng nhập')" />

            <flux:button variant="primary" color="pink" type="submit" class="w-full">
                {{ __('Đăng nhập') }}
            </flux:button>
        </form>
    @endif
</div>
