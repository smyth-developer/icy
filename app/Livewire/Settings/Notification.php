<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Cài đặt thông báo')]
class Notification extends Component
{
    public $soundEnabled = true;

    public function mount()
    {
        // Lấy cài đặt từ user preferences hoặc sử dụng giá trị mặc định
        $this->soundEnabled = session('notification_sound_enabled', true);
    }

    public function toggleSound()
    {
        $this->soundEnabled = !$this->soundEnabled;
        
        // Lưu vào session để sử dụng trong toàn bộ ứng dụng
        session(['notification_sound_enabled' => $this->soundEnabled]);
        
        // Dispatch event để cập nhật JavaScript
        $this->dispatch('sound-setting-changed', enabled: $this->soundEnabled);
        
        session()->flash('success', 'Cài đặt thông báo đã được cập nhật.');
    }

    public function render()
    {
        return view('livewire.settings.notification');
    }
}
