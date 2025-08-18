<div class="relative mb-4 w-full">
    <div class="flex items-center justify-between mb-6">
        <div>
            <flux:heading size="xl" level="1">Syllabus</flux:heading>
            <flux:breadcrumbs class="mt-2">
                <flux:breadcrumbs.item href="{{ route('dashboard') }}">Bảng điều khiển</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Syllabus</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <livewire:back.management.syllabus.actions-syllabus />
    </div>

    <flux:separator variant="subtle" />

    <!-- Search and Filter Section -->
    <div class="mt-6">
        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tìm kiếm</label>
                    <input 
                        wire:model.live="search" 
                        type="text" 
                        id="search"
                        placeholder="Tìm theo bài học, nội dung, mục tiêu..."
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100"
                    >
                </div>
                
                <!-- Subject Filter -->
                <div>
                    <label for="subjectFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lọc theo môn học</label>
                    <select 
                        wire:model.live="subjectFilter" 
                        id="subjectFilter"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100"
                    >
                        <option value="">Tất cả môn học</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->code }})</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Per Page -->
                <div>
                    <label for="perPage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Số dòng mỗi trang</label>
                    <select 
                        wire:model.live="perPage" 
                        id="perPage"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100"
                    >
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Syllabus Table -->
    <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider w-16">
                            STT
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                            Môn học
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                            Bài học
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                            Nội dung
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                            Mục tiêu
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                            Thao tác
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($syllabi as $syllabus)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-center font-medium">
                                {{ $syllabus->ordering }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $syllabus->subject->name }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $syllabus->subject->code }}
                                        @if($syllabus->subject->program)
                                            - {{ $syllabus->subject->program->name }}
                                        @endif
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $syllabus->lesson_number }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                <div class="max-w-xs truncate" title="{{ $syllabus->content }}">
                                    {{ Str::limit($syllabus->content, 100) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                <div class="max-w-xs truncate" title="{{ $syllabus->objectives }}">
                                    {{ Str::limit($syllabus->objectives, 100) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <flux:button size="sm" variant="primary" icon="eye"
                                        title="Xem chi tiết"
                                        class="cursor-pointer">
                                        Xem
                                    </flux:button>
                                    <flux:button size="sm" variant="primary" icon="square-pen"
                                        wire:click="$dispatch('edit-syllabus', { syllabusId: {{ $syllabus->id }} })"
                                        class="cursor-pointer">
                                        Sửa
                                    </flux:button>
                                    <flux:button size="sm" variant="danger" icon="trash"
                                        wire:click="deleteSyllabus({{ $syllabus->id }})"
                                        wire:confirm="Bạn có chắc chắn muốn xóa syllabus này?"
                                        class="cursor-pointer">
                                        Xóa
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center">
                                    <flux:icon.book-open
                                        class="w-8 h-8 text-gray-400 dark:text-gray-600 mb-2" />
                                    <div class="text-sm">Không có syllabus nào</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($syllabi->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800">
                {{ $syllabi->links() }}
            </div>
        @endif
    </div>

    <!-- Summary -->
    <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
        Hiển thị {{ $syllabi->firstItem() ?? 0 }} đến {{ $syllabi->lastItem() ?? 0 }} trong tổng số {{ $syllabi->total() }} syllabus
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="fixed top-4 right-4 z-50">
            <div class="bg-green-100 dark:bg-green-900/20 border border-green-400 dark:border-green-500 text-green-700 dark:text-green-400 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </span>
            </div>
        </div>
    @endif
</div>
