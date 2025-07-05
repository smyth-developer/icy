<div>
    <flux:modal name="create-note" class="md:w-900">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Update Note</flux:heading>
                <flux:text class="mt-2">Make changes to your personal details.</flux:text>
            </div>

            <flux:input label="Title" wire:model='title' placeholder="Enter note title" />

            <flux:textarea label="Content" wire:model='content' placeholder="Enter note content" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary" wire:click='save'>Save changes</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
