<div>
    <flux:modal :dismissible="false" name="modal-course" class="md:w-900">
        <form wire:submit='{{ $isEditCourseMode ? 'updateCourse' : 'createCourse' }}' class="space-y-6">
            <div>
                <flux:heading class="font-bold" size="lg">{{ $isEditCourseMode ? 'Cập nhật khoá học' : 'Tạo mới khoá học' }}
                </flux:heading>
                <flux:text class="mt-2">{{ $isEditCourseMode ? 'Chỉnh sửa thông tin khoá học' : 'Thêm mới khoá học' }}.
                </flux:text>
            </div>

            <div class="form-group">
                <flux:select wire:model="location_id" placeholder="Chọn cơ sở" label="Cơ sở">
                    <flux:select.option value="">Chọn cơ sở</flux:select.option>
                    <flux:select.option value="">Chọn cơ sở</flux:select.option>
                </flux:select>
            </div>



            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" class="cursor-pointer" variant="primary">{{ $isEditCourseMode ? 'Cập nhật' : 'Thêm mới' }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
