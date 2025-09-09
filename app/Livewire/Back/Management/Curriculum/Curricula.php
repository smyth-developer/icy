<?php

namespace App\Livewire\Back\Management\Curriculum;

use Livewire\Component;
use Livewire\Attributes\Title;

#[title('Giáo trình')]
class Curricula extends Component
{

    public function render()
    {
        return view('livewire.back.management.curriculum.curricula');
    }
}
