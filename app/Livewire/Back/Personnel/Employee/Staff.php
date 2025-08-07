<?php

namespace App\Livewire\Back\Personnel\Employee;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Nhân viên')]
class Staff extends Component
{
    public function render()
    {
        return view('livewire.back.personnel.employee.staff');
    }
}
