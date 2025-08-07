<?php

namespace App\Livewire\Back\Personnel\Student;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Học sinh')]
class Students extends Component
{
    public function render()
    {
        return view('livewire.back.personnel.student.students');
    }
}
