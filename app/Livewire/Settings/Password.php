<?php

namespace App\Livewire\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Quản lý mật khẩu')]
class Password extends Component
{
    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', PasswordRule::defaults()->min(8)->letters()->numbers()->symbols()->uncompromised(), 'confirmed'],
            ], [
                'current_password.required' => 'Mật khẩu hiện tại là bắt buộc',
                'current_password.string' => 'Mật khẩu hiện tại phải là chuỗi',
                'current_password.current_password' => 'Mật khẩu hiện tại không chính xác',
                'password.required' => 'Mật khẩu mới là bắt buộc',
                'password.string' => 'Mật khẩu mới phải là chuỗi',
                'password.confirmed' => 'Mật khẩu mới và xác nhận không khớp',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
                'password.letters' => 'Mật khẩu phải có ít nhất 1 chữ cái',
                'password.numbers' => 'Mật khẩu phải có ít nhất 1 số',
                'password.symbols' => 'Mật khẩu phải có ít nhất 1 ký tự đặc biệt',
                'password.uncompromised' => 'Mật khẩu đã bị rò rỉ',
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');
            throw $e;
        }

        $user = Auth::user();
        $user->password = Hash::make($validated['password']);
        $user->save();

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}
