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

    {{-- Main content area --}}
    <div class="mt-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-16">Mã</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden sm:table-cell">Tên học kỳ</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Trạng thái</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($seasons as $season)
                            <tr wire:key="season-{{ $season->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-center font-medium">
                                    {{ $season->code }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white hidden sm:table-cell">
                                    {{ $season->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <flux:badge variant="solid" color="{{ $season->status_badge_color }}">
                                        {{ $season->status_badge_label }}
                                    </flux:badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <flux:button size="sm" variant="primary" icon="square-pen"
                                            wire:click="editSeason({{ $season->id }})" class="cursor-pointer">
                                            Sửa
                                        </flux:button>
                                        <flux:button size="sm" variant="danger" icon="trash"
                                            wire:click="deleteSeason({{ $season->id }})" class="cursor-pointer">
                                            Xóa
                                        </flux:button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <flux:icon.calendar class="w-8 h-8 text-gray-400 dark:text-gray-500 mb-2" />
                                        <div class="text-sm">Không có học kỳ nào</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($seasons->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $seasons->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
