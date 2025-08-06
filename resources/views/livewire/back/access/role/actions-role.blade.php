<div>
    {{-- Create and Update Role Modal --}}
    <flux:modal :dismissible="false" name="modal-role" class="md:w-900">
        <form wire:submit='{{ $isEditRoleMode ? 'updateRole' : 'createRole' }}' class="space-y-6">
            <div>
                <flux:heading class="font-bold" size="lg">
                    {{ $isEditRoleMode ? 'Cập nhật vai trò' : 'Tạo mới vai trò' }}
                </flux:heading>
                <flux:text class="mt-2">{{ $isEditRoleMode ? 'Chỉnh sửa thông tin vai trò' : 'Thêm mới vai trò' }}.
                </flux:text>
            </div>

            @if ($isEditRoleMode)
                <input type="text" wire:model='roleId' hidden />
            @endif

            <div class="form-group">
                <flux:input label="Tên vai trò" placeholder="Nhập tên vai trò..." wire:model='name' />
            </div>

            <div class="form-group">
                <flux:textarea label="Mô tả" placeholder="Nhập mô tả vai trò..." wire:model='description' rows="4" />
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" class="cursor-pointer" variant="primary">
                    {{ $isEditRoleMode ? 'Cập nhật' : 'Thêm mới' }}
                </flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- Delete Role Modal --}}
    <flux:modal name="delete-role" class="min-w-[22rem]">
        <form wire:submit='deleteRoleConfirm' class="space-y-6">
            <div>
                <flux:text class="mt-2">
                    <p>Bạn có muốn xoá vai trò này không?</p>
                    <p>Hành động này không thể hoàn tác.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Huỷ</flux:button>
                </flux:modal.close>

                <flux:button type="submit" class="cursor-pointer" variant="danger">Xoá
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
