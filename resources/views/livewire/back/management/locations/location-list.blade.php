<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('Cơ sở') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Quản lý cơ sở') }}</flux:subheading>
    <flux:separator variant="subtle" />

    <x-alert-toastr />

    <livewire:back.management.locations.create-location />

    <flux:modal.trigger name="create-location">
        <flux:button class="mt-2">Thêm cơ sở</flux:button>
    </flux:modal.trigger>

    {{-- table --}}
    <table class="hidden md:table w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4 text-sm">
        <thead
            class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-bold text-xs uppercase tracking-wider">
            <tr>
                <th class="px-6 py-3 text-left">Title</th>
                <th class="px-6 py-3 text-left">Content</th>
                <th class="px-6 py-3 text-center">Action</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse ($locations as  $location)
                <tr wire:key="role-{{ $location->id }}" class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="px-6 py-5 text-gray-900 dark:text-white">{{ $location->name }}</td>
                    <td class="px-6 py-5 text-gray-900 dark:text-white">{{ $location->address }}</td>
                    <td class="px-6 py-5 text-center">
                        <div class="text-center gap-2">
                            <flux:button variant="primary" icon="square-pen" wire:click="editLocation({{ $location->id }})">Sửa
                            </flux:button>
                            <flux:button variant="danger" icon="trash" wire:click="deleteLocation({{ $location->id }})">Xóa
                            </flux:button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-5 text-center text-red-500">Không có dữ liệu.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $locations->links() }}
    </div>

        <flux:modal name="delete-location" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Xóa cơ sở này?</flux:heading>

                <flux:text class="mt-2">
                    <p>Bạn có chắc chắn muốn xóa cơ sở này không?</p>
                    <p>Hành động này không thể hoàn tác.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Hủy</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger" wire:click='deleteLocationConfirm'>Xóa</flux:button>
            </div>
        </div>
    </flux:modal>

</div>
