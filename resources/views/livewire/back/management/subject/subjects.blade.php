<div class="relative mb-4 w-full">

    <div class="flex items-center justify-between mb-6">
        <div>
            <flux:heading size="xl" level="1">Môn học</flux:heading>
            <flux:breadcrumbs class="mt-2">
                <flux:breadcrumbs.item href="{{ route('dashboard') }}">Bảng điều khiển</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Các môn học</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <flux:button wire:click="addSubject" icon="plus-circle" class="cursor-pointer">Thêm môn học</flux:button>

    </div>

    <flux:separator variant="subtle" />

    <livewire:back.management.subject.actions-subject />

    {{-- Main content area --}}
    <div class="mt-6">
        <div x-data x-init="const el = document.getElementById('sortable-subject');
        new Sortable(el, {
            animation: 150,
            handle: '.drag-handle',
            onEnd: function() {
                let orderedIds = [];
                el.querySelectorAll('[data-id]').forEach(item => {
                    orderedIds.push(item.getAttribute('data-id'));
                });
        
                $wire.updateSubjectOrdering(orderedIds);
            }
        });">
            <div class="flex flex-col lg:flex-row gap-6">
                {{-- Sidebar with programs --}}
                <div class="lg:w-80 flex-shrink-0" wire:key="programs-sidebar">
                    <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800">
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Chương trình</h3>
                        </div>
                        <div class="p-2">
                            <ul class="space-y-1">
                                @forelse ($programs as $program)
                                    <li wire:key="program-{{ $program->id }}">
                                        <button wire:click="selectProgram({{ $program->id }})"
                                            class="w-full text-left px-3 py-2 rounded-md text-sm transition-colors duration-200 {{ (int) $selectedProgramId === (int) $program->id ? 'bg-pink-100 dark:bg-pink-500/20 text-pink-600 dark:text-pink-400 font-medium' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                                            {{ $program->name }}
                                        </button>
                                    </li>
                                @empty
                                    <li>
                                        <div class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">Không có chương
                                            trình nào.</div>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Table content --}}
                <div class="flex-1 min-w-0" wire:key="table-{{ $selectedProgramId }}">
                    <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 overflow-hidden"
                        wire:key="table-container-{{ $selectedProgramId }}">
                        <div class="overflow-x-auto">
                            <table class="w-full divide-y divide-gray-200 dark:divide-gray-800"
                                wire:key="table-inner-{{ $selectedProgramId }}">
                                <thead class="bg-gray-50 dark:bg-gray-800" wire:key="thead-{{ $selectedProgramId }}">
                                    <tr>
                                        <th
                                            class="px-3 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider w-16">
                                            STT</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                            Tên môn học</th>
                                            <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                            Học phí</th>
                                        
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider hidden 2xl:table-cell">
                                            Mô tả</th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                            Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable-subject"
                                    class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800"
                                    wire:key="tbody-{{ $selectedProgramId }}">
                                    @forelse ($subjects as $subject)
                                        <tr wire:key="subject-{{ $subject->id }}" data-id="{{ $subject->id }}"
                                            class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200 cursor-move drag-handle">
                                            <td
                                                class="px-3 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-center">
                                                {{ $subject->ordering }}</td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 font-medium">
                                                {{ $subject->name }}</td>
                                                <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 font-medium">
                                                {{ $subject->price }}</td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300 hidden 2xl:table-cell">
                                                {{ $subject->description }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <flux:button size="sm" variant="primary" icon="square-pen"
                                                        wire:click="editSubject({{ $subject->id }})"
                                                        class="cursor-pointer">
                                                        Sửa
                                                    </flux:button>
                                                    <flux:button size="sm" variant="danger" icon="trash"
                                                        wire:click="deleteSubject({{ $subject->id }})"
                                                        class="cursor-pointer">
                                                        Xóa
                                                    </flux:button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"
                                                class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                                <div class="flex flex-col items-center">
                                                    <flux:icon.book-open
                                                        class="w-8 h-8 text-gray-400 dark:text-gray-600 mb-2" />
                                                    <div class="text-sm">Không có môn học nào</div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($subjects->hasPages())
                            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800"
                                wire:key="pagination-{{ $selectedProgramId }}">
                                {{ $subjects->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
