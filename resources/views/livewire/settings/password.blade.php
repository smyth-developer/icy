<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Cập nhật mật khẩu')" :subheading="__('Đảm bảo tài khoản của bạn sử dụng mật khẩu dài và ngẫu nhiên để đảm bảo an toàn')">
        <form wire:submit="updatePassword" class="mt-6 space-y-6">
            <flux:input
                wire:model="current_password"
                :label="__('Mật khẩu hiện tại')"
                type="password"
                required
                autocomplete="current-password"
            />
            <flux:input
                wire:model="password"
                :label="__('Mật khẩu mới')"
                type="password"
                required
                autocomplete="new-password"
            />
            <flux:input
                wire:model="password_confirmation"
                :label="__('Xác nhận mật khẩu')"
                type="password"
                required
                autocomplete="new-password"
            />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Lưu') }}</flux:button>
                </div>

                <x-action-message class="me-3 text-green-500" on="password-updated">
                    {{ __('Đã lưu.') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>
