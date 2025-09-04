<?php

namespace App\Livewire\Back\Finance;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Đóng học phí')]
class Tuitions extends Component
{
    public function render()
    {
        return view('livewire.back.finance.tuitions');
    }
}
