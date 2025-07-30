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

    <x-alert-toastr />

    <livewire:back.management.program.actions-program />

    {{-- table --}}

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

        <div class="overflow-x-auto border rounded-xl shadow-md mt-2 bg-gray-100 dark:bg-gray-800">
            <table class=" min-w-full table-auto divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class=" text-gray-700 dark:text-gray-300 font-bold border-b text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-center">STT</th>
                        <th class="px-6 py-3 text-center">Chương trình học</th>
                        <th class="px-6 py-3 text-center hidden sm:table-cell">Mô tả</th>
                        <th class="px-6 py-3 text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody id="sortable-program"
                    class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($programs as  $program)
                        <tr wire:key="role-{{ $program->id }}" data-id="{{ $program->id }}"
                            class="hover:bg-gray-100 dark:hover:bg-gray-800 transition cursor-move drag-handle">
                            <td class="px-3 py-2 text-gray-900 dark:text-white text-center">{{ $program->ordering }}</td>
                            <td class="px-3 py-2 text-gray-900 dark:text-white">{{ $program->name }}</td>
                            <td class="px-3 py-2 text-gray-900 dark:text-white hidden sm:table-cell">
                                {{ $program->description }}</td>
                            </td>
                            <td class="px-3 py-2 text-center">
                                <div class="text-center gap-2">
                                    <flux:button class="my-0.5 cursor-pointer" variant="primary" icon="square-pen"
                                        wire:click="editProgram({{ $program->id }})">Sửa
                                    </flux:button>
                                    <flux:button class="my-0.5 cursor-pointer" variant="danger" icon="trash"
                                        wire:click="deleteProgram({{ $program->id }})">Xóa
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-5 text-center text-red-500">
                                <flux:text class="flex items-center justify-center text-red-500">
                                    <flux:icon.exclamation-triangle class="mr-1" />Không có khoá học nào
                                </flux:text>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>


            <div class="my-2 mx-3">
                {{ $programs->links() }}
            </div>
        </div>
    </div>
</div>
