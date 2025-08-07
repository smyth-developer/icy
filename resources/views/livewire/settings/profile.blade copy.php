<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Hồ sơ')" :subheading="__('Cập nhật thông tin hồ sơ của bạn')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Họ và tên')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            Email của bạn chưa được xác thực.
                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                Nhấn vào đây để gửi lại email xác thực.
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                Một liên kết xác thực mới đã được gửi đến địa chỉ email của bạn.
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Lưu') }}</flux:button>
                </div>

                <x-action-message class="me-3 text-green-500" on="profile-updated">
                    {{ __('Đã lưu.') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>
