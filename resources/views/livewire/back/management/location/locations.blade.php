<div class="relative mb-4 w-full">

    <div class="flex items-center justify-between mb-6">
        <div>
            <flux:heading size="xl" level="1">{{ __('Cơ sở ') }}</flux:heading>
            <flux:breadcrumbs class="mt-2">
                <flux:breadcrumbs.item href="{{ route('dashboard') }}">Bảng điều khiển</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Cơ sở</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <flux:modal.trigger name="create-location">
            <flux:button icon="plus-circle" class="cursor-pointer">Thêm cơ sở</flux:button>
        </flux:modal.trigger>
    </div>

    <flux:separator variant="subtle" />

    <x-alert-toastr />

    <livewire:back.management.location.create-location />
    <livewire:back.management.location.edit-location />

    {{-- Main content area --}}
    <div class="mt-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tên cơ sở</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Địa chỉ</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden sm:table-cell">Người tạo</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($locations as $location)
                            <tr wire:key="location-{{ $location->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">
                                    {{ $location->name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    <div class="max-w-xs">
                                        {{ $location->address }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-center hidden sm:table-cell">
                                    {{ $location->createdBy->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <flux:button size="sm" variant="primary" icon="square-pen"
                                            wire:click="editLocation({{ $location->id }})" class="cursor-pointer">
                                            Sửa
                                        </flux:button>
                                        <flux:button size="sm" variant="danger" icon="trash"
                                            wire:click="deleteLocation({{ $location->id }})" class="cursor-pointer">
                                            Xóa
                                        </flux:button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <flux:icon.map-pin class="w-8 h-8 text-gray-400 dark:text-gray-500 mb-2" />
                                        <div class="text-sm">Không có cơ sở nào</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($locations->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $locations->links() }}
                </div>
            @endif
        </div>
    </div>

    <flux:modal name="delete-location" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading class="font-bold" size="lg">Xoá cơ sở?</flux:heading>
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

                <flux:button type="submit" class="cursor-pointer" variant="danger" wire:click='deleteLocationConfirm'>Xoá
                </flux:button>
            </div>
        </div>
    </flux:modal>

</div>
