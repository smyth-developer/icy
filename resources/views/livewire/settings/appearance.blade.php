<section class="max-w-3xl">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Giao diện')" :subheading=" __('Cập nhật cài đặt giao diện cho tài khoản của bạn')">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">Sáng</flux:radio>
            <flux:radio value="dark" icon="moon">Tối</flux:radio>
            <flux:radio value="system" icon="computer-desktop">Hệ thống</flux:radio>
        </flux:radio.group>
    </x-settings.layout>
</section>
