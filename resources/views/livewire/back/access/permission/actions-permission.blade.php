<div>
    {{-- Create and Update Permission Modal --}}
    <flux:modal :dismissible="false" name="modal-permission" class="md:w-900">
        <form wire:submit='{{ $isEditPermissionMode ? 'updatePermission' : 'createPermission' }}' class="space-y-6">
            <div>
                <flux:heading class="font-bold" size="lg">
                    {{ $isEditPermissionMode ? 'Cập nhật Permission' : 'Tạo mới Permission' }}
                </flux:heading>
                <flux:text class="mt-2">
                    {{ $isEditPermissionMode ? 'Chỉnh sửa thông tin permission:' . $router : 'Thêm mới permission' }}
                </flux:text>
            </div>

            @if ($isEditPermissionMode)
                <input type="text" wire:model='permissionId' hidden />
            @else
                <div class="form-group">
                    <flux:select label="Router" placeholder="Chọn router..." wire:model='router'
                        :disabled="$isEditPermissionMode">
                        <flux:select.option value="">Chọn router</flux:select.option>
                        @foreach ($routeOptions as $route)
                            <flux:select.option value="{{ $route }}">{{ $route }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            @endif

            <div class="form-group">
                <flux:input label="Tên hiển thị" placeholder="Nhập tên hiển thị..." wire:model='displayName' />
            </div>

            <div class="form-group">
                <flux:checkbox label="Hiển thị" wire:model='isShow' />
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" class="cursor-pointer" variant="primary">
                    {{ $isEditPermissionMode ? 'Cập nhật' : 'Thêm mới' }}
                </flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- Delete Permission Modal --}}
    <flux:modal name="delete-permission" class="min-w-[22rem]">
        <form wire:submit='deletePermissionConfirm' class="space-y-6">
            <div>
                <flux:text class="mt-2">
                    <p>Bạn có muốn xoá permission này không?</p>
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
