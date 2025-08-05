<div>
    {{-- Create and Update Program Modal --}}
    <flux:modal :dismissible="false" name="modal-program" class="md:w-900">
        <form wire:submit='{{ $isEditProgramMode ? 'updateProgram' : 'createProgram' }}' class="space-y-6">
            <div>
                <flux:heading class="font-bold" size="lg">
                    {{ $isEditProgramMode ? 'Cập nhật chương trình học' : 'Tạo mới chương trình học' }}
                </flux:heading>
                <flux:text class="mt-2">
                    {{ $isEditProgramMode ? 'Chỉnh sửa thông tin chương trình học' : 'Thêm mới chương trình học' }}.
                </flux:text>
            </div>

            <flux:separator />

            <div class="flex gap-2">
                <div class="form-group w-3/5" >
                    <flux:input wire:model='name' autocomplete="off" clearable label="Tên chương trình"></flux:input>
                </div>
                <div class="form-group w-2/5">
                    <flux:input wire:model='english_name' autocomplete="off" clearable label="Tên tiếng anh">
                    </flux:input>
                </div>
            </div>

            <div class="form-group ">
                <flux:textarea wire:model='description' placeholder="Nhập thông tin chương trình áp dụng cho ai?"
                    label="Mô tả chương trình"></flux:textarea>
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" class="cursor-pointer" variant="primary">
                    {{ $isEditProgramMode ? 'Cập nhật' : 'Thêm mới' }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
    {{-- Delete Season Modal --}}
    <flux:modal name="delete-program" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading class="font-bold" size="lg">Xoá chương trình học?</flux:heading>

                <flux:text class="mt-2">
                    <p>Bạn có muốn xoá chương trình học này không?</p>
                    <p>Hành động này không thể hoàn tác.</p>
            </div>
            </flux:text>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button class="cursor-pointer" variant="ghost">Huỷ</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger" class="cursor-pointer" wire:click='deleteProgramConfirm'>
                    Xoá
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
