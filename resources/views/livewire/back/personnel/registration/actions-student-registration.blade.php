<div>
    {{-- Create and Update Student Modal --}}
    <flux:modal :dismissible="false" name="modal-student"
        class="w-full max-w-[90vw] md:max-w-[720px] lg:max-w-[800px] max-h-[90vh] overflow-y-auto">

        <!-- Header -->
        <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700">
            <flux:heading class="font-bold text-gray-800 dark:text-gray-200 text-xl">
                {{ $isEditStudentMode ? '✏️ Cập nhật học viên' : '➕ Thêm mới học viên' }}
            </flux:heading>
            <flux:text class="mt-1 text-gray-600 dark:text-gray-400">
                {{ $isEditStudentMode ? 'Chỉnh sửa thông tin học viên trong hệ thống' : 'Thêm mới học viên vào hệ thống quản lý' }}
            </flux:text>
        </div>

        <form wire:submit.prevent='{{ $isEditStudentMode ? 'updateStudent' : 'createStudent' }}'
            class="px-8 py-6 space-y-8">
            @if ($isEditStudentMode)
                <input type="hidden" wire:model='studentId' />
            @endif

            {{-- Personal Information --}}

            <div class="mb-4 text-center">
                <flux:heading size="md" class="text-gray-800 dark:text-gray-200 font-semibold">
                    Thông tin cá nhân
                </flux:heading>
            </div>

            @if (auth()->user()->locations()->count() > 1)
                <div class="space-y-6">
                    <div class="form-group">
                        <flux:select wire:model='location_id' label="🏢 Cơ sở" placeholder="Chọn cơ sở"
                            class="rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-all duration-300">
                            <flux:select.option :value='null' label="Không chọn cơ sở" />
                            @foreach (auth()->user()->locations as $location)
                                <flux:select.option :value="$location->id" label="{{ $location->name }}" />
                            @endforeach
                        </flux:select>
                    </div>
                </div>
            @endif

            <div class="space-y-2">
                {{-- Name and Username --}}
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="form-group md:col-span-3">
                        <flux:input wire:model='name' label="👨‍🎓 Họ và tên 🚩" placeholder="Nhập họ và tên đầy đủ"
                            wire:change='updateUsername'
                            class="rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-all duration-300"
                            autofocus />
                    </div>
                    <div class="form-group md:col-span-2">
                        <flux:input wire:model='username' label="🔑 Tên đăng nhập" placeholder="username" disabled
                            class="rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-all duration-300" />
                    </div>
                </div>

                {{-- Email and Account Code --}}
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="form-group md:col-span-3">
                        <flux:input type="email" wire:model='email' label="📧 Email" placeholder="example@email.com"
                            class="rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-all duration-300" />
                    </div>

                    <div class="form-group md:col-span-2">
                        <flux:input wire:model='id_card' label="🏷️ CCCD/CMND" placeholder="Nhập số CCCD/CMND"
                            class="rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-all duration-300" />
                    </div>

                </div>


                {{-- Phone and Birthday --}}
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">

                    {{-- Gender (UI only) --}}
                    <div class="form-group md:col-span-2">
                        <label for="gender_female"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Giới tính</label>
                        <div class="flex items-center space-x-2">
                            <input name="gender" wire:model='gender' type="checkbox"
                                class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" />
                            <span class="text-gray-700 dark:text-gray-300">Nữ</span>
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-red-500">Bỏ chọn nếu là nam.</p>
                    </div>
                    <div class="form-group md:col-span-2">
                        <flux:input type="tel" wire:model='phone' label="📱 Số điện thoại" placeholder="0123456789"
                            class="rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500 transition-all duration-300" />
                    </div>
                    <div class="form-group md:col-span-2">
                        <flux:input type="date" wire:model='birthday' label="🎂 Ngày sinh"
                            max="{{ now()->format('Y-m-d') }}"
                            class="rounded-xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 transition-all duration-300" />
                    </div>

                </div>



                {{-- Address --}}
                <div class="form-group">
                    <flux:input wire:model='address' label="🏠 Địa chỉ" placeholder="Nhập địa chỉ chi tiết"
                        class="rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-300" />
                </div>

                <flux:separator class="my-4" />

                {{-- Parent Information --}}
                <div class="mb-4 text-center">
                    <flux:heading size="md" class="text-gray-800 dark:text-gray-200 font-semibold">
                        Thông tin người giám hộ
                    </flux:heading>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <flux:input wire:model='guardian_name' wire:change='updateGuardian'
                            label="Họ và tên người giám hộ 🚩" placeholder="Nhập tên"
                            class="rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500 transition-all duration-300" />
                    </div>
                    <div class="form-group">
                        <flux:input wire:model='guardian_phone' label="📱 Số điện thoại 🚩" placeholder="0123456789"
                            class="rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500 transition-all duration-300" />
                    </div>
                </div>

            </div>


            {{-- Action Buttons --}}
            <div class="flex justify-end items-center pt-6 border-t border-gray-200 dark:border-gray-700">

                <div class="flex space-x-3">
                    <flux:modal.close>
                        <flux:button variant="ghost"
                            class="px-6 py-2 rounded-xl border border-gray-300 hover:bg-gray-50 transition-all duration-300">
                            ❌ Hủy
                        </flux:button>
                    </flux:modal.close>

                    <flux:button type="submit" variant="primary"
                        class="cursor-pointer px-8 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        {{ $isEditStudentMode ? '✅ Cập nhật' : '➕ Thêm mới' }}
                    </flux:button>
                </div>
            </div>

            <div class="flex items-center pt-6 border-t border-gray-200 dark:border-gray-700">
                <span class="inline-flex items-center px-4 py-2 bg-yellow-50 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-200 rounded-xl text-sm font-medium shadow-sm">
                    <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V7h2v2z"/>
                    </svg>
                    Các trường có dấu <span class="font-bold text-red-500 mx-1">🚩</span> là bắt buộc.
                </span>
            </div>
        </form>

    </flux:modal>

    {{-- Delete Student Modal --}}
    <flux:modal name="delete-student" class="md:w-[500px]">
        <div
            class="bg-gradient-to-br from-red-50 via-white to-pink-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 rounded-2xl">
            <!-- Header với gradient background -->
            <div class="relative px-8 py-6 bg-gradient-to-r from-red-500 via-pink-500 to-red-600 rounded-t-2xl">
                <div class="absolute inset-0 bg-black/10 rounded-t-2xl"></div>
                <div class="relative flex items-center">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd">
                            </path>
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <flux:heading class="font-bold text-white text-xl">
                            🗑️ Xác nhận xóa học viên
                        </flux:heading>
                        <flux:text class="mt-1 text-red-100">
                            Hành động này không thể hoàn tác
                        </flux:text>
                    </div>
                </div>
            </div>

            <form wire:submit='deleteStudentConfirm' class="px-8 py-6 space-y-6">
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-red-800 dark:text-red-200">
                                Cảnh báo xóa dữ liệu
                            </h3>
                            <div class="mt-2 text-red-700 dark:text-red-300">
                                <p class="mb-2">Bạn có chắc chắn muốn xóa học viên này không?</p>
                                <ul class="list-disc list-inside space-y-1 text-sm">
                                    <li>Tất cả thông tin học viên sẽ bị xóa vĩnh viễn</li>
                                    <li>Ảnh đại diện sẽ bị xóa khỏi hệ thống</li>
                                    <li>Hành động này không thể hoàn tác</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <flux:modal.close>
                        <flux:button variant="ghost"
                            class="px-6 py-2 rounded-xl border border-gray-300 hover:bg-gray-50 transition-all duration-300">
                            ↩️ Hủy bỏ
                        </flux:button>
                    </flux:modal.close>

                    <flux:button type="submit" variant="danger"
                        class="cursor-pointer px-8 py-2 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        🗑️ Xóa vĩnh viễn
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>

@push('scripts')
    <script></script>
@endpush
