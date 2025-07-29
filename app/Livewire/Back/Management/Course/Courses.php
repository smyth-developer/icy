<?php

namespace App\Livewire\Back\Management\Course;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Khoá học')]
class Courses extends Component
{
    public $title;
    public function render()
    {
        return view('livewire.back.management.course.courses')->with('title', $this->title);
    }
}
