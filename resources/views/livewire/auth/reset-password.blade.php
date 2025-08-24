<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Đặt lại mật khẩu')" :description="__('Vui lòng nhập mật khẩu mới của bạn dưới đây')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="resetPassword" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email')"
            type="email"
            required
            autocomplete="email"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Mật khẩu')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Xác nhận mật khẩu')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Xác nhận mật khẩu')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Đặt lại mật khẩu') }}
            </flux:button>
        </div>
    </form>
</div>
