<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('Notes') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Manage notes') }}</flux:subheading>
    <flux:separator variant="subtle" />

    <x-alert-toastr />

    <flux:modal.trigger name="create-note">
        <flux:button class="mt-2">Create Note</flux:button>
    </flux:modal.trigger>

    <livewire:create-note />
    <livewire:edit-note />


    {{-- table --}}
    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4 text-sm">
        <thead
            class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-bold text-xs uppercase tracking-wider">
            <tr>
                <th class="px-6 py-3 text-left">Title</th>
                <th class="px-6 py-3 text-left">Content</th>
                <th class="px-6 py-3 text-center">Action</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse ($notes as  $note)
                <tr wire:key="role-{{ $note->id }}" class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="px-6 py-5 text-gray-900 dark:text-white">{{ $note->title }}</td>
                    <td class="px-6 py-5 text-gray-900 dark:text-white">{{ $note->content }}</td>
                    <td class="px-6 py-5 text-center">
                        <div class="text-center gap-2">
                            <flux:button class="my-0.5" variant="primary" icon="square-pen" wire:click="edit({{ $note->id }})">Sửa
                            </flux:button>
                            <flux:button class="my-0.5" variant="danger" icon="trash" wire:click="delete({{ $note->id }})">Xóa
                            </flux:button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-5 text-center text-red-500">Không có dữ liệu.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $notes->links() }}
    </div>

    <flux:modal name="delete-note" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete note?</flux:heading>

                <flux:text class="mt-2">
                    <p>You're about to delete this note.</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger" wire:click='deleteNote'>Delete note</flux:button>
            </div>
        </div>
    </flux:modal>

</div>
