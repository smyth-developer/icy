<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('Cơ sở') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Quản lý các cơ sở') }}</flux:subheading>
    <flux:separator variant="subtle" />

    <x-alert-toastr />

    <flux:button class="mt-2" wire:click='addLocation'>Thêm cơ sở</flux:button>

    <flux:modal name="location-modal" class="md:w-900">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $isUpdateMode ? 'Cập nhật cơ sở' : 'Tạo mới cơ sở' }}</flux:heading>
                <flux:text class="mt-2">Quản lý các cơ sở hiện đang hoạt động.</flux:text>
            </div>

            <flux:input label="Tên cơ sở" wire:model='name' placeholder="Enter note title" />

            <flux:textarea label="Địa chỉ cơ sở" wire:model='address' placeholder="Enter note content" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary" wire:click='save'>Save changes</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- table --}}


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
