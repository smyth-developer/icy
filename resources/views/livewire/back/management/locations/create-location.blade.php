<div>
    <flux:modal name="create-location" class="md:w-900">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Tạo cơ sở mới</flux:heading>
                <flux:text class="mt-2">Thêm cơ sở mới của trung tâm</flux:text>
            </div>

            <flux:input label="Tên cơ sở" wire:model='name' placeholder="Điền tên cơ sở" />

            <flux:textarea label="Địa chỉ" wire:model='address' placeholder="Địa chỉ cơ sở" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary" wire:click='createLocation'>Thêm mới</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
