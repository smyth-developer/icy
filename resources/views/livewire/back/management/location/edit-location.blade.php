<div>
    <flux:modal :dismissible="false" name="edit-location" class="md:w-900">
        <div class="space-y-6">
            <div>
                <flux:heading class="font-bold" size="lg">Cập nhật cơ sở</flux:heading>
                <flux:text class="mt-2">Cập nhật thông tin cho chi nhánh.</flux:text>
            </div>

            <div class="form-group">
                <flux:input label="Tên cơ sở" wire:model='name' placeholder="Điền tên cơ sở mới" />
            </div>
            <div class="form-group">
                <flux:textarea label="Địa chỉ cơ sở" wire:model='address' placeholder="Điền địa chỉ cơ sở" />
            </div>

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" class="cursor-pointer" variant="primary" wire:click='updateLocation'>Cập
                    nhật</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
