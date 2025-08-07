<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Hồ sơ')" :subheading="__('Cập nhật thông tin hồ sơ của bạn')">
        <div class="grid grid-cols-1 2xl:grid-cols-5 gap-2">
            <!-- Card 1: Profile Display -->
            <div class="2xl:col-span-2 bg-white dark:bg-gray-900 rounded-2xl shadow-xl border-0 overflow-hidden backdrop-blur-sm">
                <!-- Header với gradient -->
                <div class="h-20 bg-gradient-to-r from-pink-400 via-rose-400 to-pink-500 relative">
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-white dark:from-gray-900"></div>
                </div>

                <div class="relative -mt-16 px-8 pb-8">
                    <!-- Avatar Section -->
                    <div class="flex flex-col items-center mb-8">
                        <div class="relative group mb-6">
                            <div class=" mt-4 w-32 h-32 md:w-48 md:h-48 rounded-full overflow-hidden border-4 border-white dark:border-gray-800 shadow-2xl bg-white dark:bg-gray-800 relative">
                                <img src="{{ auth()->user()->detail->avatar ?? asset('images/default-avatar.png') }}" 
                                     alt="Avatar" 
                                     class="object-cover w-full h-full">
                            </div>
                        </div>

                        <!-- User info display -->
                        <div class="text-center">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ auth()->user()->name ?? 'Người dùng' }}
                            </h2>

                            @if (auth()->user()->hasVerifiedEmail())
                                <p class="text-gray-600 dark:text-gray-400 mb-4">
                                    {{ auth()->user()->email }}
                                </p>
                            @endif
                            
                            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && auth()->user()->hasVerifiedEmail())
                                <div class="inline-flex items-center px-4 py-2 bg-pink-100 dark:bg-pink-900/30 text-pink-800 dark:text-pink-300 rounded-full text-sm font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Email đã xác thực
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Personal Information Form -->
            <div class="2xl:col-span-3 bg-white dark:bg-gray-900 rounded-2xl shadow-xl border-0 overflow-hidden backdrop-blur-sm">
                <!-- Header với gradient -->
                <div class="h-20 bg-gradient-to-r from-pink-400 via-rose-400 to-pink-500 relative">
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-white dark:from-gray-900"></div>
                </div>

                <form wire:submit="updateProfileInformation" class="relative -mt-16 p-8 h-full flex flex-col">
                    <!-- Form Header -->
                    <div class="text-center mb-8">
                        <h3 class="text-xl font-semibold text-pink-600 dark:text-pink-400 mb-2">
                            Thông tin cá nhân
                        </h3>
                        <div class="w-16 h-1 bg-gradient-to-r from-pink-400 to-rose-500 rounded-full mx-auto"></div>
                    </div>

                    <!-- Form Fields -->
                    <div class="space-y-6 flex-1">
                        <div class="space-y-2">
                            <flux:input wire:model="email" 
                                      :label="__('Email')" 
                                      type="email" 
                                      required 
                                      autocomplete="email"
                                      class="w-full rounded-xl border-gray-200 dark:border-gray-700 focus:border-pink-500 focus:ring-pink-500 transition-all duration-200" />
                        </div>

                        <div class="space-y-2">
                            <flux:input wire:model="phone" 
                                      :label="__('Số điện thoại')" 
                                      type="tel" 
                                      autocomplete="tel"
                                      class="w-full rounded-xl border-gray-200 dark:border-gray-700 focus:border-pink-500 focus:ring-pink-500 transition-all duration-200" />
                        </div>

                        <div class="space-y-2">
                            <flux:input wire:model="address" 
                                      :label="__('Địa chỉ')" 
                                      type="text" 
                                      autocomplete="street-address"
                                      class="w-full rounded-xl border-gray-200 dark:border-gray-700 focus:border-pink-500 focus:ring-pink-500 transition-all duration-200" />
                        </div>

                        @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                            <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 border border-amber-200 dark:border-amber-700 rounded-xl p-6">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/50 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-amber-800 dark:text-amber-200 font-semibold mb-2">
                                            Email chưa được xác thực
                                        </h4>
                                        <p class="text-amber-700 dark:text-amber-300 text-sm mb-3">
                                            Vui lòng kiểm tra email và nhấn vào liên kết xác thực để hoàn tất quá trình đăng ký.
                                        </p>
                                        <flux:button variant="filled" 
                                                   size="sm"
                                                   icon="envelope"
                                                   wire:click.prevent="resendVerificationNotification"
                                                   class="bg-amber-600 hover:bg-amber-700 text-white">
                                            Gửi lại email xác thực
                                        </flux:button>

                                        @if (session('status') === 'verification-link-sent')
                                            <div class="mt-4 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700 rounded-lg">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-emerald-800 dark:text-emerald-200 font-medium text-sm">
                                                        Email xác thực đã được gửi thành công!
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <!-- Submit Button -->
                        <div class="flex justify-center">
                            <flux:button variant="primary" 
                                       type="submit"
                                       icon="check"
                                       class="!bg-gradient-to-r !from-pink-500 !to-rose-500 hover:!from-pink-600 hover:!to-rose-600 !border-0 !shadow-lg hover:!shadow-xl hover:!shadow-pink-500/25 !transition-all !duration-300 hover:!scale-105 !rounded-2xl mb-4">
                                {{ __('Lưu thay đổi') }}
                            </flux:button>
                        </div>
                        <!-- Success Message -->
                        <x-action-message class="text-emerald-600 dark:text-emerald-400 font-medium flex items-center justify-center bg-emerald-50 dark:bg-emerald-900/20 px-4 py-2 rounded-lg" on="profile-updated">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('Đã lưu thành công!') }}
                        </x-action-message>
                    </div>
                </form>
            </div>
        </div>
    </x-settings.layout>
</section>