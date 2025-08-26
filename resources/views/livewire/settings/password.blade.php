<section class="max-w-3xl">
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
                wire:model.live="password"
                :label="__('Mật khẩu mới')"
                type="password"
                required
                autocomplete="new-password"
                viewable
            />

            <!-- Password Requirements -->
            <div class="space-y-2">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Điều kiện mật khẩu:') }}</p>
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center {{ $this->hasMinLength() ? 'bg-green-500 border-green-500' : 'border-gray-300 dark:border-gray-600' }}">
                            @if($this->hasMinLength())
                                <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </div>
                        <span class="text-sm {{ $this->hasMinLength() ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                            {{ __('Ít nhất 8 ký tự') }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center {{ $this->hasLowercase() ? 'bg-green-500 border-green-500' : 'border-gray-300 dark:border-gray-600' }}">
                            @if($this->hasLowercase())
                                <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </div>
                        <span class="text-sm {{ $this->hasLowercase() ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                            {{ __('Ít nhất 1 chữ thường (a-z)') }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center {{ $this->hasUppercase() ? 'bg-green-500 border-green-500' : 'border-gray-300 dark:border-gray-600' }}">
                            @if($this->hasUppercase())
                                <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </div>
                        <span class="text-sm {{ $this->hasUppercase() ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                            {{ __('Ít nhất 1 chữ hoa (A-Z)') }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center {{ $this->hasNumber() ? 'bg-green-500 border-green-500' : 'border-gray-300 dark:border-gray-600' }}">
                            @if($this->hasNumber())
                                <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </div>
                        <span class="text-sm {{ $this->hasNumber() ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                            {{ __('Ít nhất 1 số (0-9)') }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center {{ $this->hasSpecialChar() ? 'bg-green-500 border-green-500' : 'border-gray-300 dark:border-gray-600' }}">
                            @if($this->hasSpecialChar())
                                <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </div>
                        <span class="text-sm {{ $this->hasSpecialChar() ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                            {{ __('Ít nhất 1 ký tự đặc biệt (@$!%*?&)') }}
                        </span>
                    </div>
                </div>
            </div>

            <flux:input
                wire:model.live="password_confirmation"
                :label="__('Xác nhận mật khẩu')"
                type="password"
                required
                autocomplete="new-password"
                viewable
            />

            <!-- Password Match Indicator -->
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center {{ $this->passwordsMatch() ? 'bg-green-500 border-green-500' : 'border-gray-300 dark:border-gray-600' }}">
                    @if($this->passwordsMatch())
                        <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    @endif
                </div>
                <span class="text-sm {{ $this->passwordsMatch() ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                    {{ __('Mật khẩu khớp') }}
                </span>
            </div>

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
