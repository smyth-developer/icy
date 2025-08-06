<div class="relative mb-4 w-full">

    <div class="flex items-center justify-between mb-6">
        <div>
            <flux:heading size="xl" level="1">Chương trình học</flux:heading>
            <flux:breadcrumbs class="mt-2">
                <flux:breadcrumbs.item href="{{ route('dashboard') }}">Bảng điều khiển</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Các chương trình học</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <flux:button wire:click="addProgram" icon="plus-circle" class="cursor-pointer">Thêm khoá học</flux:button>

    </div>

    <flux:separator variant="subtle" />



    <livewire:back.management.program.actions-program />

    {{-- Main content area --}}
    <div class="mt-6">
        <div x-data x-init="const el = document.getElementById('sortable-program');
        new Sortable(el, {
            animation: 150,
            handle: '.drag-handle',
            onEnd: function() {
                let orderedIds = [];
                el.querySelectorAll('[data-id]').forEach(item => {
                    orderedIds.push(item.getAttribute('data-id'));
                });
        
                $wire.updateProgramOrdering(orderedIds);
            }
        });">

            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-800">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider w-16">STT</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider w-30">Chương trình học</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider hidden 2xl:table-cell">Mô tả</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-program" class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                            @forelse ($programs as $program)
                                <tr wire:key="program-{{ $program->id }}" data-id="{{ $program->id }}"
                                    class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200 cursor-move drag-handle">
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-center">
                                        {{ $program->ordering }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{ $program->name }}</span>
                                            <span class="ml-2 text-xs text-pink-500 dark:text-pink-400 font-medium">
                                                ({{ $program->english_name }})
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300 hidden 2xl:table-cell">
                                        <div class=" truncate" title="{{ $program->description }}">
                                            {{ $program->description }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <flux:button size="sm" variant="primary" icon="square-pen"
                                                wire:click="editProgram({{ $program->id }})" class="cursor-pointer">
                                                Sửa
                                            </flux:button>
                                            <flux:button size="sm" variant="danger" icon="trash"
                                                wire:click="deleteProgram({{ $program->id }})" class="cursor-pointer">
                                                Xóa
                                            </flux:button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <flux:icon.exclamation-triangle class="w-8 h-8 text-gray-400 dark:text-gray-600 mb-2" />
                                            <div class="text-sm">Không có khoá học nào</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($programs->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800">
                        {{ $programs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>