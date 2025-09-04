<?php

namespace App\Livewire\Back\Personnel\Student;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Repositories\Contracts\UserRepositoryInterface;

#[Title('Học viên')]
class Students extends Component
{
    public function render()
    {
        $students = app(UserRepositoryInterface::class)->getStudentsOfLocation();
        return view('livewire.back.personnel.student.students', [
            'students' => $students,
        ]);
    }
}
