<div class="relative mb-4 w-full">

    {{-- Header Section --}}
    <div class="bg-gray-900 dark:bg-gray-900 rounded-2xl p-8 mb-8 shadow-2xl">
        <div class="flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold">Môn học</h1>
                        <p class="text-white text-sm">Quản lý các môn học trong hệ thống</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2 text-sm text-white">
                    <a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Bảng điều khiển</a>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Các môn học</span>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2">
                    <span class="text-white text-sm font-medium">
                        {{ $subjects->total() ?? 0 }} môn học
                    </span>
                </div>
                <button wire:click="addSubject" 
                    class="bg-white text-gray-900 hover:bg-gray-100 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Thêm môn học</span>
                </button>
            </div>
        </div>
    </div>

    <livewire:back.management.subject.actions-subject />

    {{-- Main content area --}}
    <div class="mt-6">
        <div x-data="{
            initSortable() {
                const el = document.getElementById('sortable-subject');
                if (el && !el.sortableInstance) {
                    el.sortableInstance = new Sortable(el, {
                        animation: 150,
                        handle: '.drag-handle',
                        onEnd: function() {
                            let orderedIds = [];
                            el.querySelectorAll('[data-id]').forEach(item => {
                                orderedIds.push(item.getAttribute('data-id'));
                            });
                            $wire.updateSubjectOrdering(orderedIds);
                        }
                    });
                }
            },
            destroySortable() {
                const el = document.getElementById('sortable-subject');
                if (el && el.sortableInstance) {
                    el.sortableInstance.destroy();
                    el.sortableInstance = null;
                }
            }
        }" 
        x-init="initSortable()"
        @program-changed.window="destroySortable(); setTimeout(() => initSortable(), 100)">
            <div class="flex flex-col lg:flex-row gap-8">
                {{-- Enhanced Sidebar with programs --}}
                <div class="lg:w-80 flex-shrink-0" wire:key="programs-sidebar">
                    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-xl overflow-hidden">
                        <div class="bg-gray-800 dark:bg-gray-800 px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white">Chương trình</h3>
                                    <p class="text-white text-xs">{{ $programs->count() }} chương trình</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="space-y-2">
                                @forelse ($programs as $program)
                                    <div wire:key="program-{{ $program->id }}" class="group">
                                        <button wire:click="selectProgram({{ $program->id }})"
                                            class="w-full text-left px-4 py-3 rounded-xl text-sm transition-all duration-300 transform hover:scale-[1.02] {{ (int) $selectedProgramId === (int) $program->id ? 'bg-gray-700 dark:bg-gray-700 text-pink-500 shadow-lg' : 'text-white dark:text-white hover:bg-gray-800 dark:hover:bg-gray-800 border border-transparent hover:border-gray-600 dark:hover:border-gray-600' }}">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ (int) $selectedProgramId === (int) $program->id ? 'bg-white/20' : 'bg-gray-700 dark:bg-gray-700' }}">
                                                    <svg class="w-4 h-4 {{ (int) $selectedProgramId === (int) $program->id ? 'text-pink-500' : 'text-white dark:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="font-medium truncate">{{ $program->name }}</p>
                                                    @if($program->english_name)
                                                        <p class="text-xs opacity-75 truncate">{{ $program->english_name }}</p>
                                                    @endif
                                                </div>
                                                @if((int) $selectedProgramId === (int) $program->id)
                                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                                @endif
                                            </div>
                                        </button>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Không có chương trình nào</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Enhanced Card Layout --}}
                <div class="flex-1 min-w-0" wire:key="subjects-content-{{ $selectedProgramId }}">


                    {{-- Subjects Grid --}}
                    <div id="sortable-subject" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" wire:key="subjects-grid-{{ $selectedProgramId }}">
                        @forelse ($subjects as $subject)
                            <div wire:key="subject-{{ $subject->id }}" data-id="{{ $subject->id }}"
                                class="group bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.02] cursor-move drag-handle overflow-hidden">
                                
                                {{-- Card Header --}}
                                <div class="bg-gray-800 dark:bg-gray-800 p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                                <span class="text-white font-bold text-lg">{{ $subject->ordering }}</span>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-bold text-white truncate">{{ $subject->name }}</h3>
                                                @if($subject->code)
                                                    <p class="text-white text-sm">{{ $subject->code }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Card Body --}}
                                <div class="p-6">
                                    @if($subject->description)
                                        <div class="mb-4">
                                            <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-3">
                                                {{ $subject->description }}
                                            </p>
                                        </div>
                                    @endif

                                    {{-- Actions --}}
                                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-800">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Hoạt động</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button wire:click="editSubject({{ $subject->id }})"
                                                class="p-2 text-pink-500 hover:text-pink-600 hover:bg-pink-50 dark:hover:bg-pink-900/20 rounded-lg transition-all duration-200 transform hover:scale-110">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button wire:click="deleteSubject({{ $subject->id }})"
                                                class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all duration-200 transform hover:scale-110">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full">
                                <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-lg p-12 text-center">
                                    <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Chưa có môn học nào</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mb-6">Hãy thêm môn học đầu tiên cho chương trình này</p>
                                    <button wire:click="addSubject" 
                                        class="bg-gray-800 dark:bg-gray-800 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center space-x-2 mx-auto">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        <span>Thêm môn học</span>
                                    </button>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if ($subjects->hasPages())
                        <div class="mt-8 flex justify-center" wire:key="pagination-{{ $selectedProgramId }}">
                            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-lg p-4">
                                {{ $subjects->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
