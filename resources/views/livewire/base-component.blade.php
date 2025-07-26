<div class="relative mb-4 w-full">

    <div class="flex items-center justify-between mb-6">
        <div>
            <flux:heading size="xl" level="1">{{ __('Học kỳ ') }}</flux:heading>
            <flux:breadcrumbs class="mt-2">
                <flux:breadcrumbs.item href="{{route('dashboard')}}">Bảng điều khiển</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>học kỳ</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <flux:modal.trigger name="create-season">
            <flux:button>Thêm học kỳ</flux:button>
        </flux:modal.trigger>
    </div>

    <flux:separator variant="subtle" />

    <x-alert-toastr />


    {{-- table --}}
    <table class=" w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4 text-sm">
        <thead
            class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-bold text-xs uppercase tracking-wider">
            <tr>
                <th class="px-6 py-3 text-center">Tên học kỳ</th>
                <th class="px-6 py-3 text-center">Địa chỉ</th>
                <th class="px-6 py-3 text-center">Người tạo</th>
                <th class="px-6 py-3 text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse ($seasons as  $season)
                <tr wire:key="role-{{ $season->id }}" class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="px-6 py-5 text-gray-900 dark:text-white">{{ $season->name }}</td>
                    <td class="px-6 py-5 text-gray-900 dark:text-white">{{ $season->address }}</td>
                    <td class="px-6 py-5 text-center text-gray-900 dark:text-white">{{ $season->createdBy->name }}</td>
                    <td class="px-6 py-5 text-center">
                        <div class="text-center gap-2">
                            <flux:button variant="primary" icon="square-pen"
                                wire:click="editseason({{ $season->id }})">Sửa
                            </flux:button>
                            <flux:button variant="danger" icon="trash"
                                wire:click="deleteseason({{ $season->id }})">Xóa
                            </flux:button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-5 text-center text-red-500 underline">Không có học kỳ nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $seasons->links() }}
    </div>

</div>
