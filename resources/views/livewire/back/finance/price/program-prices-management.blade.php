<div class="relative mb-4 w-full">

    <div class="flex items-center justify-between mb-6">
        <div>
            <flux:heading size="xl" level="1">💰 Quản lý giá tiền chương trình</flux:heading>
            <flux:breadcrumbs class="mt-2">
                <flux:breadcrumbs.item href="{{ route('dashboard') }}">Bảng điều khiển</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="{{ route('admin.management.programs') }}">Chương trình học</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Quản lý giá tiền</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <div class="flex gap-3">
            @if(!$bulkUpdateMode)
                <flux:button wire:click="toggleBulkUpdate" variant="primary" class="cursor-pointer">
                    Chỉnh sửa hàng loạt
                </flux:button>
            @else
                <flux:button wire:click="startBulkEdit" variant="primary" class="cursor-pointer">
                    Bắt đầu chỉnh sửa
                </flux:button>
                <flux:button wire:click="saveBulkPrices" color="green" variant="primary" class="cursor-pointer">
                    Lưu tất cả
                </flux:button>
                <flux:button wire:click="toggleBulkUpdate" color="red" variant="primary" class="cursor-pointer">
                    Hủy
                </flux:button>
            @endif
        </div>
    </div>

    <flux:separator variant="subtle" />


    <!-- Bảng quản lý giá tiền -->
    <div class="mt-6">
        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm">
            <div class="overflow-x-auto max-h-[calc(100vh-300px)]">
                <table class="w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-800 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider bg-gray-50 dark:bg-gray-800">
                                Chương trình
                            </th>
                            @foreach($locations as $location)
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider bg-gray-50 dark:bg-gray-800">
                                    {{ $location->name }}
                                </th>
                            @endforeach
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider bg-gray-50 dark:bg-gray-800">
                                Thao tác
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($programs as $program)
                            <tr wire:key="program-{{ $program->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    <div>
                                        <div class="font-medium">{{ $program->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $program->english_name }}
                                        </div>
                                    </div>
                                </td>
                            
                            @foreach($locations as $location)
                                @php
                                    $price = $filteredPrices->where('program_id', $program->id)->where('location_id', $location->id)->first();
                                @endphp
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    @if($price)
                                        @if(isset($editingPrices[$price['id']]))
                                            {{-- Edit Mode --}}
                                            <div class="flex items-center justify-center space-x-1">
                                                <input type="number" 
                                                    wire:model="editingPrices.{{ $price['id'] }}.price"
                                                    class="w-24 px-2 py-1 text-xs border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <span class="text-xs text-gray-500 dark:text-gray-400">đ</span>
                                            </div>
                                            @error("editingPrices.{$price['id']}.price")
                                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                            @enderror
                                        @else
                                            {{-- Display Mode --}}
                                            <div class="text-sm font-bold text-green-600 dark:text-green-400">
                                                {{ number_format($price['price'], 0, ',', '.') }} VNĐ
                                            </div>
                                        @endif
                                    @else
                                        {{-- No Price Data - Show Input for New Price --}}
                                        @php
                                            $isEditingProgram = $filteredPrices->where('program_id', $program->id)->whereIn('id', array_keys($editingPrices))->count() > 0;
                                        @endphp
                                        
                                        @if($isEditingProgram)
                                            {{-- Edit Mode for New Price --}}
                                            <div class="flex items-center justify-center space-x-1">
                                                <input type="number" 
                                                    wire:model="newPrices.{{ $program->id }}.{{ $location->id }}"
                                                    placeholder="0"
                                                    class="w-24 px-2 py-1 text-xs border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <span class="text-xs text-gray-500 dark:text-gray-400">đ</span>
                                            </div>
                                            @error("newPrices.{$program->id}.{$location->id}")
                                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                            @enderror
                                        @else
                                            {{-- Display Mode - Show Add Button --}}
                                            <button type="button"
                                                wire:click="startProgramEdit({{ $program->id }})"
                                                class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 underline">
                                                Thêm giá
                                            </button>
                                        @endif
                                    @endif
                                </td>
                            @endforeach

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        $programPrices = $filteredPrices->where('program_id', $program->id);
                                        $isEditing = $programPrices->whereIn('id', array_keys($editingPrices))->count() > 0;
                                    @endphp
                                    
                                    @if($isEditing)
                                        {{-- Save/Cancel --}}
                                        <div class="flex items-center justify-center gap-2">
                                            <flux:button size="sm" color="green" variant="primary"
                                                wire:click="saveProgramPrices({{ $program->id }})" class="cursor-pointer">
                                                Lưu
                                            </flux:button>
                                            <flux:button size="sm" color="red" variant="primary"
                                                wire:click="cancelProgramEdit({{ $program->id }})" class="cursor-pointer">
                                                Hủy
                                            </flux:button>
                                        </div>
                                    @else
                                        {{-- Edit Button --}}
                                        <flux:button size="sm" variant="primary"
                                            wire:click="startProgramEdit({{ $program->id }})" class="cursor-pointer">
                                            Chỉnh sửa
                                        </flux:button>
                                    @endif
                                </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($locations) + 2 }}" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        <div class="text-lg font-medium">Không có dữ liệu chương trình</div>
                                        <div class="text-sm">Hãy thêm chương trình và chạy seeder</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Summary --}}
    @if($programs->count() > 0)
        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div class="text-sm text-blue-800 dark:text-blue-200">
                    <span class="font-medium">Tổng số chương trình:</span> {{ $programs->count() }}
                </div>
                <div class="text-sm text-blue-800 dark:text-blue-200">
                    <span class="font-medium">Tổng số cơ sở:</span> {{ $locations->count() }}
                </div>
                <div class="text-sm text-blue-800 dark:text-blue-200">
                    <span class="font-medium">Tổng bản ghi giá:</span> {{ $filteredPrices->count() }}
                </div>
            </div>
        </div>
    @endif
</div>
