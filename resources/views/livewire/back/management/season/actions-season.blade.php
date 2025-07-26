<div>
    {{-- Create and Update Season Modal --}}
    <flux:modal :dismissible="false" name="modal-season" class="md:w-900">
        <form wire:submit='{{ $isEditSeasonMode ? 'updateSeason' : 'createSeason' }}' class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $isEditSeasonMode ? 'Cập nhật học kỳ' : 'Tạo mới học kì' }}
                </flux:heading>
                <flux:text class="mt-2">{{ $isEditSeasonMode ? 'Chỉnh sửa thông tin học kỳ' : 'Thêm mới học kì' }}.
                </flux:text>
            </div>

            @if ($isEditSeasonMode)
                <input type="text" wire:model='seasonId' hidden />
            @else
                <div class="flex gap-4">
                    <div class="w-1/3">
                        <flux:select wire:model="yearModal" wire:change='handleChange' placeholder="Chọn năm học...">
                            @foreach ($years as $item)
                                <flux:select.option value="{{ $item }}">{{ $item }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div class="w-2/3">
                        <flux:select wire:model="seasonModal" wire:change='handleChange' placeholder="Chọn mùa...">
                            <flux:select.option value="SP">SPRING</flux:select.option>
                            <flux:select.option value="SU">SUMMER</flux:select.option>
                            <flux:select.option value="FA">FALL</flux:select.option>
                            <flux:select.option value="WI">WINTER</flux:select.option>
                        </flux:select>
                    </div>
                </div>
            @endif


            <div class="flex gap-4">

                <div class="w-1/3">
                    <flux:input readonly variant="filled" wire:model='code' label="Mã học kỳ" />
                </div>

                <div class="w-2/3">
                    <flux:input readonly variant="filled" wire:model='name' label="Tên học kỳ" />
                </div>

            </div>

            <flux:input type="date" max="2999-12-31" label="Ngày bắt đầu" wire:model='start_date' />

            <flux:input type="date" max="2999-12-31" label="Ngày kết thúc" wire:model='end_date' />


            @if ($isEditSeasonMode)
                <flux:input label="Ghi chú" placeholder="Ghi chú lý do chỉnh sửa." wire:model='note'/>
            @endif

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">{{ $isEditSeasonMode ? 'Cập nhật' : 'Thêm mới' }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
    {{-- Delete Season Modal --}}
    <flux:modal name="delete-season" class="min-w-[22rem]">
        <form wire:submit='deleteSeasonConfirm' class="space-y-6">
            <div>
                <flux:heading size="lg">Xoá học kì?</flux:heading>

                <flux:text class="mt-2">
                    <p>Bạn có muốn xoá học kỳ này không?</p>
                    <p>Hành động này không thể hoàn tác.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Huỷ</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger">Xoá
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
