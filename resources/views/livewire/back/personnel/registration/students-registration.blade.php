<div class="relative mb-4 w-full">

    <livewire:back.personnel.registration.actions-student-registration />

    <div class="flex items-center justify-between mb-6">
        <div>
            <flux:heading size="xl" level="1">{{ __('Đăng ký học viên') }}</flux:heading>
            <flux:breadcrumbs class="mt-2">
                <flux:breadcrumbs.item href="{{ route('dashboard') }}">Bảng điều khiển</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Đăng ký học viên</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <flux:button wire:click="addStudentRegistration()" icon="plus-circle" class="cursor-pointer">Thêm học viên</flux:button>
    </div>

    <flux:separator variant="subtle" />

    {{-- Main content area --}}
    <div class="mt-6">
        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider w-16">STT</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Họ và tên</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider hidden md:table-cell">Số điện thoại</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider hidden lg:table-cell">Địa chỉ</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Cơ sở</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider hidden sm:table-cell">Ngày đăng ký</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($students as $index => $student)
                            <tr wire:key="student-{{ $student->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-center font-medium">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    <div class="flex items-center gap-3">
                                        <img class="h-8 w-8 rounded-full object-cover" 
                                             src="{{ $student->detail?->avatar ?? asset('images/default-avatar.png') }}" 
                                             alt="{{ $student->name }}">
                                        <div>
                                            <div class="font-medium">{{ $student->name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">ID: {{ $student->account_code }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300 hidden md:table-cell">
                                    {{ $student->detail?->phone ?? 'Chưa cập nhật' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300 hidden lg:table-cell">
                                    <div class="max-w-xs truncate">
                                        {{ $student->detail?->address ?? 'Chưa cập nhật' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($student->locations->count() > 0)
                                        @foreach($student->locations as $location)
                                            <flux:badge color="blue" size="sm" class="mb-1">
                                                {{ $location->name }}
                                            </flux:badge>
                                            @if(!$loop->last) <br> @endif
                                        @endforeach
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400 text-xs">Chưa có cơ sở</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300 text-center hidden sm:table-cell">
                                    <div>
                                        {{ $student->created_at->format('d/m/Y') }}
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $student->created_at->format('H:i') }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <flux:button size="sm" variant="primary" icon="pencil"
                                            wire:click="editStudentRegistration({{ $student->id }})" class="cursor-pointer">
                                            Sửa thông tin
                                        </flux:button>

                                        <flux:button size="sm" variant="danger" icon="trash"
                                            wire:click="deleteStudentRegistration({{ $student->id }})" class="cursor-pointer">
                                            Xóa
                                        </flux:button>

                                        @if(auth()->user()->hasRole('BOD') || auth()->user()->hasRole('Manager Center'))
                                            <flux:button color="green" size="sm" variant="primary" icon="check-circle"
                                                wire:click="approveStudentRegistration({{ $student->id }})" class="cursor-pointer">
                                                Xét duyệt
                                            </flux:button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <flux:icon.users class="w-8 h-8 text-gray-400 dark:text-gray-600 mb-2" />
                                        <div class="text-sm">Không có học viên nào chờ phê duyệt</div>
                                        <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                            Hiện tại không có học viên nào trong trạng thái pending tại các cơ sở của bạn
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination if needed --}}
            {{-- @if($students->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800">
                    {{ $students->links() }}
                </div>
            @endif --}}
        </div>
    </div>
</div>