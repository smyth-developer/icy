<div class="flex flex-col gap-4 sm:gap-6">
    <x-auth-header :title="__('Đăng nhập hệ thống')" :description="__('Sử dụng Username và Email để đăng nhập.')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-4 sm:gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="login_id"
            :label="__('Địa chỉ Email / Username')"
            type="text"
            required
            placeholder="email@example.com / Username"
            labelClass="text-pink-500"
            autofocus
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
                <flux:link class="absolute end-0 top-0 text-xs sm:text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('Quên mật khẩu?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" class="cursor-pointer" :label="__('Ghi nhớ đăng nhập')" />

        <div class="flex items-center justify-end pt-2">
            <flux:button variant="primary" color="pink" type="submit" class="w-full cursor-pointer text-sm sm:text-base">{{ __('Đăng nhập') }}</flux:button>
        </div>
    </form>
</div>
