<?php

namespace App\Livewire\Back\Personnel\Student;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Repositories\Contracts\UserRepositoryInterface;

#[Title('Học viên')]
class Students extends Component
{
    public function addStudent()
    {
        $this->dispatch('add-student');
    }

    public function editStudent($studentId)
    {
        $this->dispatch('edit-student', $studentId);
    }

    public function viewStudent($studentId)
    {
        $this->dispatch('view-student', $studentId);
    }

    public function deleteStudent($studentId)
    {
        $this->dispatch('delete-student', $studentId);
    }

    public function render()
    {
        $students = app(UserRepositoryInterface::class)->getStudentsOfLocation();
        return view('livewire.back.personnel.student.students', [
            'students' => $students,
        ]);
    }
}
