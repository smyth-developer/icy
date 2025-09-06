<div class="relative mb-4 w-full">

    <livewire:back.finance.tuition.actions-tuition />

    <div class="flex items-center justify-between mb-6">
        <div>
            <flux:heading size="xl" level="1">{{ __('Lịch sử đóng học phí') }}</flux:heading>
            <flux:breadcrumbs class="mt-2">
                <flux:breadcrumbs.item href="{{ route('dashboard') }}">Bảng điều khiển</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Lịch sử đóng học phí</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <div class="flex items-center gap-3">
            <flux:button icon="arrow-path" wire:click="loadTuitions" variant="outline">
                Làm mới
            </flux:button>
            <flux:button wire:click="addTuition" icon="plus-circle" class="cursor-pointer">
                Thêm giao dịch
            </flux:button>
            <flux:button wire:click="clearFilters" variant="outline" icon="x-mark">
                Xóa bộ lọc
            </flux:button>
        </div>
    </div>

    <flux:separator variant="subtle" />

    <!-- Bộ lọc -->
    <div class="mt-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-3">
            <!-- Tìm kiếm theo tên -->
            <div>
                <flux:input wire:model.live="search" placeholder="Tìm theo tên hoặc mã học viên..."
                    icon="magnifying-glass" class="w-full" clearable />
            </div>

            <!-- Lọc theo cơ sở -->
            @if ($locations->count() > 1)
                <div>
                    <flux:select wire:model.live="filterLocationId" placeholder="Lọc theo cơ sở">
                        <flux:select.option :value='null' label="Tất cả cơ sở" />
                        @foreach ($locations as $location)
                            <flux:select.option :value="$location->id" label="{{ $location->name }}" />
                        @endforeach
                    </flux:select>
                </div>
            @endif

            <!-- Lọc theo chương trình -->
            <div>
                <flux:select wire:model.live="filterProgramId" placeholder="Lọc theo chương trình">
                    <flux:select.option :value='null' label="Tất cả chương trình" />
                    @foreach ($programs as $program)
                        <flux:select.option :value="$program->id" label="{{ $program->name }}" />
                    @endforeach
                </flux:select>
            </div>

            <!-- Lọc theo học kỳ -->
            <div>
                <flux:select wire:model.live="filterSeasonId" placeholder="Lọc theo học kỳ">
                    <flux:select.option :value='null' label="Tất cả học kỳ" />
                    @foreach ($seasons as $season)
                        <flux:select.option :value="$season->id" label="{{ $season->name }}" />
                    @endforeach
                </flux:select>
            </div>

            <!-- Lọc theo phương thức thanh toán -->
            <div>
                <flux:select wire:model.live="filterPaymentMethod" placeholder="Phương thức thanh toán">
                    <flux:select.option :value='null' label="Tất cả phương thức" />
                    <flux:select.option value="cash" label="Tiền mặt" />
                    <flux:select.option value="bank_transfer" label="Chuyển khoản" />
                </flux:select>
            </div>

            <!-- Lọc theo thời gian -->
            <div>
                <flux:select wire:model.live="filterMonth" placeholder="Lọc theo thời gian">
                    <flux:select.option :value='null' label="Tất cả thời gian" />
                    <flux:select.option value="this_month" label="Tháng này" />
                    <flux:select.option value="last_month" label="Tháng trước" />
                    <flux:select.option value="this_year" label="Năm nay" />
                    <flux:select.option value="last_year" label="Năm trước" />
                </flux:select>
            </div>
        </div>
    </div>

    <flux:separator variant="subtle" />

    <!-- Bảng lịch sử đóng tiền -->
    <div class="mt-6">
        <div
            class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th
                                class="px-3 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider w-16">
                                STT
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                Học viên
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider hidden lg:table-cell">
                                Chương trình
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider hidden md:table-cell">
                                Học kỳ
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider hidden xl:table-cell">
                                Số biên lai
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                Số tiền
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                Trạng thái
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider hidden sm:table-cell">
                                Phương thức
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider hidden 2xl:table-cell">
                                Ngày đóng
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse($tuitions as $index => $tuition)
                            <tr wire:key="tuition-{{ $tuition->id }}"
                                class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
                                <td
                                    class="px-3 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-gray-100 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    <div class="flex items-center gap-3">
                                        <img class="h-8 w-8 rounded-full object-cover"
                                            src="{{ $tuition->user->detail?->avatar ?? asset('storage/images/avatars/default-avatar.png') }}"
                                            alt="{{ $tuition->user->name }}">
                                        <div>
                                            <div class="font-medium">{{ $tuition->user->name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">ID:
                                                {{ $tuition->user->account_code }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                                    <div class="text-sm text-gray-900 dark:text-gray-100 font-medium">
                                        {{ $tuition->program->name ?? 'N/A' }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $tuition->program->english_name ?? '' }}
                                    </div>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-gray-100 hidden md:table-cell">
                                    {{ $tuition->season->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center hidden xl:table-cell">
                                    <div class="text-sm font-mono text-gray-900 dark:text-gray-100">
                                        {{ $tuition->receipt_number ?? 'Chưa có' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm font-bold text-green-600 dark:text-green-400">
                                        {{ $tuition->price_formatted }} VNĐ
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @switch($tuition->status)
                                        @case('paid')
                                            <flux:badge color="green" size="sm">Đã thanh toán</flux:badge>
                                        @break

                                        @case('pending')
                                            <flux:badge color="yellow" size="sm">Chờ xử lý</flux:badge>
                                        @break

                                        @case('failed')
                                            <flux:badge color="red" size="sm">Thất bại</flux:badge>
                                        @break

                                        @default
                                            <flux:badge color="gray" size="sm">{{ $tuition->status }}</flux:badge>
                                    @endswitch
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-gray-100 hidden sm:table-cell">
                                    @switch($tuition->payment_method)
                                        @case('cash')
                                            <div class="flex items-center justify-center">
                                                <flux:icon.banknotes class="size-4 mr-1 text-green-600" />
                                                <span class="text-xs">Tiền mặt</span>
                                            </div>
                                        @break

                                        @case('bank_transfer')
                                            <div class="flex items-center justify-center">
                                                <flux:icon.credit-card class="size-4 mr-1 text-blue-600" />
                                                <span class="text-xs">Chuyển khoản</span>
                                            </div>
                                        @break

                                        @default
                                            <span class="text-xs">{{ $tuition->payment_method }}</span>
                                    @endswitch
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400 hidden 2xl:table-cell">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $tuition->created_at->format('d/m/Y') }}</span>
                                        <span class="text-xs">{{ $tuition->created_at->format('H:i:s') }}</span>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <flux:icon.document-text
                                                class="size-12 text-gray-400 dark:text-gray-500 mb-4" />
                                            <flux:heading size="lg" class="text-gray-500 dark:text-gray-400 mb-2">
                                                Chưa có lịch sử đóng tiền
                                            </flux:heading>
                                            <flux:text class="text-gray-400 dark:text-gray-500">
                                                Học viên chưa thực hiện giao dịch đóng học phí nào
                                            </flux:text>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($tuitions->count() > 0)
                    <div class="bg-gray-50 dark:bg-gray-800 px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Tổng cộng: <span
                                    class="font-medium text-gray-900 dark:text-gray-100">{{ $tuitions->count() }}</span>
                                giao dịch
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Tổng tiền: <span class="font-bold text-green-600 dark:text-green-400">
                                    {{ number_format($tuitions->sum('price'), 0, ',', '.') }} VNĐ
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
