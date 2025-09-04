<div>
    {{-- Create & Update Bank Modal (match Location structure) --}}
    <flux:modal :dismissible="false" name="modal-bank" class="md:w-900">
        <form wire:submit='{{ $isEditMode ? 'updateBank' : 'createBank' }}' class="space-y-6">
            <div>
                <flux:heading class="font-bold" size="lg">
                    {{ $isEditMode ? 'Cập nhật tài khoản ngân hàng' : 'Thêm tài khoản ngân hàng' }}
                </flux:heading>
                <flux:text class="mt-2">{{ $isEditMode ? 'Chỉnh sửa thông tin tài khoản ngân hàng.' : 'Nhập thông tin cho tài khoản ngân hàng mới.' }}</flux:text>
            </div>

            <div class="form-group grid grid-cols-1 md:grid-cols-6 gap-4">
                <div class="md:col-span-4">
                    <flux:input label="Số tài khoản" wire:model='account_number' placeholder="Nhập số tài khoản" />
                </div>
                <div class="md:col-span-2">
                    <flux:input label="Ngân hàng" wire:model='bank_name'  placeholder="VD: Vietcombank" list="bank-suggestions" />
                    <datalist id="bank-suggestions">
                        @foreach($listBank as $bank)
                            <option value="{{ $bank }}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div class="md:col-span-4">
                    <flux:input label="Chủ tài khoản" wire:model='account_name' placeholder="Nhập tên chủ tài khoản" />
                </div>
                <div class="md:col-span-2">
                    <flux:select label="Trạng thái" wire:model='status'>
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Ngưng</option>
                    </flux:select>
                </div>
            </div>

            <div class="form-group">
                <flux:textarea label="Ghi chú" wire:model='description' placeholder="Ghi chú thêm (không bắt buộc)" />
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" class="cursor-pointer" variant="primary">
                    {{ $isEditMode ? 'Cập nhật' : 'Thêm mới' }}
                </flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- Delete Bank Modal (match gradient design) --}}
    <flux:modal name="delete-bank" class="md:w-[500px]">
        <div class="bg-gradient-to-br from-red-50 via-white to-pink-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 rounded-2xl">
            <div class="relative px-8 py-6 bg-gradient-to-r from-red-500 via-pink-500 to-red-600 rounded-t-2xl">
                <div class="absolute inset-0 bg-black/10 rounded-t-2xl"></div>
                <div class="relative flex items-center">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <flux:heading class="font-bold text-white text-xl">🗑️ Xác nhận xóa tài khoản ngân hàng</flux:heading>
                        <flux:text class="mt-1 text-red-100">Hành động này không thể hoàn tác</flux:text>
                    </div>
                </div>
            </div>

            <form wire:submit='deleteBankConfirm' class="px-8 py-6 space-y-6">
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-red-800 dark:text-red-200">Cảnh báo xóa dữ liệu</h3>
                            <div class="mt-2 text-red-700 dark:text-red-300">
                                <p class="mb-2">Bạn có chắc chắn muốn xóa tài khoản ngân hàng này không?</p>
                                <ul class="list-disc list-inside space-y-1 text-sm">
                                    <li>Thông tin tài khoản sẽ bị xóa vĩnh viễn</li>
                                    <li>Các giao dịch liên quan có thể bị ảnh hưởng</li>
                                    <li>Hành động này không thể hoàn tác</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <flux:modal.close>
                        <flux:button variant="ghost" class="px-6 py-2 rounded-xl border border-gray-300 hover:bg-gray-50 transition-all duration-300">↩️ Hủy bỏ</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="danger" class="cursor-pointer px-8 py-2 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">🗑️ Xóa vĩnh viễn</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
