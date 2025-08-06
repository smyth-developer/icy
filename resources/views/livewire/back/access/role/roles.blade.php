<div class="relative mb-4 w-full">

    <div class="flex items-center justify-between mb-6">
        <div>
            <flux:heading size="xl" level="1">{{ __('Vai trò ') }}</flux:heading>
            <flux:breadcrumbs class="mt-2">
                <flux:breadcrumbs.item href="{{ route('dashboard') }}">Bảng điều khiển</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Vai trò</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>

        <flux:button wire:click='addRole' icon="plus-circle" class="cursor-pointer">Thêm vai trò</flux:button>
    </div>

    <flux:separator variant="subtle" />

    <livewire:back.access.role.actions-role />

    {{-- Main content area --}}
    <div class="mt-6">
        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider w-16">ID</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider ">Tên vai trò</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider hidden sm:table-cell">Mô tả</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Loại</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider hidden sm:table-cell">Người tạo</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($roles as $role)
                            <tr wire:key="role-{{ $role->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-center font-medium">
                                    {{ $role->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 ">
                                    {{ $role->name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 hidden sm:table-cell">
                                    {{ Str::limit($role->description, 70) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <flux:badge variant="solid" color="{{ $role->type === 'system' ? 'green' : 'zinc' }}">
                                        {{ $role->type }}
                                    </flux:badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-center hidden sm:table-cell">
                                    {{ $role->createdBy->name ?? 'Hệ thống' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if ($role->type === 'custom')
                                    <div class="flex items-center justify-center gap-2">
                                        <flux:button size="sm" variant="primary" icon="square-pen"
                                            wire:click="editRole({{ $role->id }})" class="cursor-pointer" >
                                            Sửa
                                        </flux:button>
                                        <flux:button size="sm" variant="danger" icon="trash"
                                            wire:click="deleteRole({{ $role->id }})" class="cursor-pointer">
                                            Xóa
                                        </flux:button>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <x-flux::icon.user-lock class="w-8 h-8 text-gray-400 dark:text-gray-600 mb-2" />
                                        <div class="text-sm">Không có vai trò nào</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($roles->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800">
                    {{ $roles->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
