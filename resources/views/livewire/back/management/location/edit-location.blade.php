<div>
    <flux:modal :dismissible="false" name="edit-location" class="md:w-900">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Cập nhật cơ sở</flux:heading>
                <flux:text class="mt-2">Cập nhật thông tin cho chi nhánh.</flux:text>
            </div>

            <flux:input label="Tên cơ sở" wire:model='name' placeholder="Điền tên cơ sở mới" />

            <flux:textarea label="Địa chỉ cơ sở" wire:model='address' placeholder="Điền địa chỉ cơ sở" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary" wire:click='updateLocation'>Cập nhật</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
