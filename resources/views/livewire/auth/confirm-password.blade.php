<div class="flex flex-col gap-6">
    <x-auth-header
        :title="__('Xác nhận mật khẩu')"
        :description="__('Đây là khu vực an toàn của ứng dụng. Vui lòng xác nhận mật khẩu của bạn trước khi tiếp tục.')"
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="confirmPassword" class="flex flex-col gap-6">
        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Mật khẩu')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Mật khẩu')"
            viewable
        />

        <flux:button variant="primary" type="submit" class="w-full">{{ __('Xác nhận') }}</flux:button>
    </form>
</div>
