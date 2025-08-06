<div>
    {{-- Create and Update Location Modal --}}
    <flux:modal :dismissible="false" name="modal-location" class="md:w-900">
        <form wire:submit='{{ $isEditLocationMode ? 'updateLocation' : 'createLocation' }}' class="space-y-6">
            <div>
                <flux:heading class="font-bold" size="lg">
                    {{ $isEditLocationMode ? 'Cập nhật cơ sở' : 'Tạo cơ sở mới' }}
                </flux:heading>
                <flux:text class="mt-2">{{ $isEditLocationMode ? 'Chỉnh sửa thông tin chi nhánh.' : 'Thông tin cho chi nhánh mới.' }}</flux:text>
            </div>
            <div class="form-group">
                <flux:input label="Tên cơ sở" wire:model='name' placeholder="Điền tên cơ sở mới" />
            </div>
            <div class="form-group">
                <flux:textarea label="Địa chỉ cơ sở" wire:model='address' placeholder="Điền địa chỉ cơ sở" />
            </div>
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" class="cursor-pointer" variant="primary">
                    {{ $isEditLocationMode ? 'Cập nhật' : 'Thêm mới' }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
    {{-- Delete Location Modal --}}
    <flux:modal name="delete-location" class="min-w-[22rem]">
        <form wire:submit='deleteLocationConfirm' class="space-y-6">
            <div>
                <flux:text class="mt-2">
                    <p>Bạn có muốn xoá cơ sở này không?</p>
                    <p>Hành động này không thể hoàn tác.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Huỷ</flux:button>
                </flux:modal.close>
                <flux:button type="submit" class="cursor-pointer" variant="danger">Xoá</flux:button>
            </div>
        </form>
    </flux:modal>
</div>