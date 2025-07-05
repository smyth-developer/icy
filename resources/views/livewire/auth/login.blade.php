<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Đăng nhập hệ thống')" :description="__('Sử dụng Username và Email để đăng nhập.')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="login_id"
            :label="__('Địa chỉ Email / Username')"
            type="text"
            required
            autofocus
            placeholder="email@example.com / Username"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Mật khẩu')"
                viewable
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('Quên mật khẩu?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Ghi nhớ đăng nhập')" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Đăng nhập') }}</flux:button>
        </div>
    </form>
</div>
