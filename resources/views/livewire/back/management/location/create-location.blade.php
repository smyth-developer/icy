<div>
    <flux:modal :dismissible="false" name="create-location" class="md:w-900">
        <form wire:submit='createLocation' class="space-y-6">
            <div>
                <flux:heading size="lg">Tạo cơ sở mới</flux:heading>
                <flux:text class="mt-2">Thông tin cho chi nhánh mới.</flux:text>
            </div>

            <flux:input label="Tên cơ sở" wire:model='name' placeholder="Điền tên cơ sở mới" />

            <flux:textarea label="Địa chỉ cơ sở" wire:model='address' placeholder="Điền địa chỉ cơ sở" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary" >Thêm mới</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
