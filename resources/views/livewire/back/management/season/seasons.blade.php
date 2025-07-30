<div class="relative mb-4 w-full">

    <div class="flex items-center justify-between mb-6">
        <div>
            <flux:heading size="xl" level="1">{{ __('Học kỳ ') }}</flux:heading>
            <flux:breadcrumbs class="mt-2">
                <flux:breadcrumbs.item href="{{ route('dashboard') }}">Bảng điều khiển</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Học kỳ</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <flux:button wire:click='addSeason' icon="plus-circle" class="cursor-pointer">Thêm học kỳ</flux:button>
    </div>

    <flux:separator variant="subtle" />

    <livewire:back.management.season.actions-season />

    {{-- alert toastr --}}

    <x-alert-toastr />

    {{-- table --}}
    <div class="overflow-x-auto w-full">
        <table class=" w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4 text-sm">
            <thead
                class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-bold text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-3 py-3 text-center">Mã</th>
                    <th class="px-3 py-3 text-center hidden sm:table-cell">Tên học kỳ</th>
                    <th class="px-3 py-3 text-center">Trạng thái</th>
                    <th class="px-3 py-3 text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($seasons as  $season)
                    <tr wire:key="role-{{ $season->id }}" class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <td class="px-3 py-3 text-gray-900 dark:text-white text-center">{{ $season->code }}</td>
                        <td class="px-3 py-3 text-gray-900 dark:text-white hidden sm:table-cell">{{ $season->name }}</td>
                        <td class="px-3 py-3 text-center text-gray-900 dark:text-white">
                            <flux:badge variant="solid" color="{{ $season->status_badge_color }}">
                                {{ $season->status_badge_label }}
                            </flux:badge>
                        </td>
                        <td class="px-3 py-3 text-center">
                            <div class="text-center gap-2">
                                <flux:button class='my-0.5 mx-0.5 cursor-pointer' variant="primary" icon="square-pen"
                                    wire:click="editSeason({{ $season->id }})">Sửa
                                </flux:button>
                                <flux:button class='my-0.5 mx-0.5 cursor-pointer' variant="danger" icon="trash"
                                    wire:click="deleteSeason({{ $season->id }})">
                                    Xóa
                                </flux:button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-5 text-center text-red-500 underline">Không có học kỳ nào.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $seasons->links() }}
        </div>
    </div>


</div>
