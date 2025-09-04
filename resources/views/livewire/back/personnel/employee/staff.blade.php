<div class="relative mb-4 w-full">

    <livewire:back.personnel.employee.actions-staff />

    <div class="flex items-center justify-between mb-6">
        <div>
            <flux:heading size="xl" level="1">{{ __('Nhân viên') }}</flux:heading>
            <flux:breadcrumbs class="mt-2">
                <flux:breadcrumbs.item href="{{ route('dashboard') }}">Bảng điều khiển</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Danh sách nhân viên</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

    </div>

    <div class="mt-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <flux:input
                    wire:model.live="search"
                    placeholder="Tìm theo họ và tên hoặc Account code..."
                    icon="magnifying-glass"
                    class="w-full" />
            </div>
            <div>
                <flux:select wire:model.live="filterLocationId" placeholder="Lọc theo cơ sở">
                    <flux:select.option :value='null' label="Tất cả cơ sở" />
                    @foreach ($locations as $location)
                        <flux:select.option :value="$location->id" label="{{ $location->name }}" />
                    @endforeach
                </flux:select>
            </div>
            <div>
                <flux:select wire:model.live="filterRoleId" placeholder="Lọc theo chức vụ">
                    <flux:select.option :value='null' label="Tất cả chức vụ" />
                    @foreach ($roles as $role)
                        <flux:select.option :value="$role->id" label="{{ $role->name }}" />
                    @endforeach
                </flux:select>
            </div>
        </div>
    </div>

    <flux:separator variant="subtle" />

    <div class="mt-6">
        <div
            class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th
                                class="px-3 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider w-16">
                                STT</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                Họ và tên</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider hidden md:table-cell">
                                Số điện thoại</th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                Cơ sở</th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider hidden sm:table-cell">
                                Chức vụ</th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($staffs as $index => $staff)
                            <tr wire:key="staff-{{ $staff->id }}"
                                class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
                                <td
                                    class="px-3 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-center font-medium">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    <div class="flex items-center gap-3">
                                        <img class="h-8 w-8 rounded-full object-cover"
                                            src="{{ $staff->detail?->avatar ?? asset('images/default-avatar.png') }}"
                                            alt="{{ $staff->name }}">
                                        <div>
                                            <div class="font-medium">{{ $staff->name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">ID:
                                                {{ $staff->account_code }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300 hidden md:table-cell">
                                    {{ $staff->detail?->phone ?? 'Chưa cập nhật' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if ($staff->locations->count() > 0)
                                        @foreach ($staff->locations as $location)
                                            <flux:badge color="blue" size="sm" class="mb-1">
                                                {{ $location->name }}
                                            </flux:badge>
                                            @if (!$loop->last)
                                                <br>
                                            @endif
                                        @endforeach
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400 text-xs">Chưa có cơ sở</span>
                                    @endif
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300 text-center hidden sm:table-cell">
                                    <div>
                                        {{ $staff->roles->pluck('name')->implode(', ') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <flux:button size="sm" variant="primary" icon="pencil"
                                            wire:click="editStaff({{ $staff->id }})"
                                            class="cursor-pointer">
                                            Sửa thông tin
                                        </flux:button>

                                        <flux:button size="sm" variant="danger" icon="trash"
                                            wire:click="deleteStaff({{ $staff->id }})"
                                            class="cursor-pointer">
                                            Xóa
                                        </flux:button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <flux:icon.users class="w-8 h-8 text-gray-400 dark:text-gray-600 mb-2" />
                                        <div class="text-sm">Không có nhân viên nào</div>
                                        <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                            Hiện tại không có nhân viên nào trong các cơ sở của bạn
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination if needed --}}
            {{-- @if ($staffs->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800">
                    {{ $staffs->links() }}
                </div>
            @endif --}}
        </div>
    </div>

</div>
