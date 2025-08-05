<div>
    {{-- Create and Update Subject Modal --}}
    <flux:modal :dismissible="false" name="modal-subject" class="md:w-900">
        <form wire:submit='{{ $isEditSubjectMode ? 'updateSubject' : 'createSubject' }}' class="space-y-6">
            <div>
                <flux:heading class="font-bold" size="lg">
                    {{ $isEditSubjectMode ? 'Cập nhật môn học' : 'Tạo mới môn học' }}
                </flux:heading>
                <flux:text class="mt-2">
                    {{ $isEditSubjectMode ? 'Chỉnh sửa thông tin môn học' : 'Thêm mới môn học' }}.
                </flux:text>
            </div>

            <flux:separator />

            <div class="flex gap-2">
                <div class="form-group w-3/5">
                    <flux:label>Tên môn học</flux:label>
                    <flux:input.group>
                        <flux:input.group.prefix>ICY</flux:input.group.prefix>
                        <flux:input wire:model='name' placeholder="Nhập Tên môn học (ICY)" />
                    </flux:input.group>
                </div>

                <div class="form-group w-2/5">
                    <flux:input wire:model='code' label="Mã môn học" />
                </div>
            </div>

            <div class="form-group">
                <flux:select wire:model="program_id" placeholder="Chọn chương trình học" label="Chương trình học">
                    <flux:select.option value="">Chọn chương trình học</flux:select.option>
                    @forelse ($programs as $program)
                        <flux:select.option :value="$program->id">{{ $program->name }}</flux:select.option>
                    @empty
                        <flux:select.option value="">Không có chương trình học</flux:select.option>
                    @endforelse
                </flux:select>
            </div>

            <div class="form-group">
                <flux:textarea wire:model='description' label="Mô tả môn học" />
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" class="cursor-pointer" variant="primary">
                    {{ $isEditSubjectMode ? 'Cập nhật' : 'Thêm mới' }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
    {{-- Delete Subject Modal --}}
    <flux:modal name="modal-delete-subject" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading class="font-bold" size="lg">Xoá môn học?</flux:heading>

                <flux:text class="mt-2">
                    <p>Bạn có muốn xoá môn học này không?</p>
                    <p>Hành động này không thể hoàn tác.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button class="cursor-pointer" variant="ghost">Huỷ</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger" class="cursor-pointer" wire:click='deleteSubjectConfirm'>
                    Xoá
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
