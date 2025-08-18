<?php

namespace App\Livewire\Back\Personnel\Registration;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Repositories\Contracts\StudentRegistrationRepositoryInterface;
use App\Models\User;

#[Title('Đăng ký học viên')]
class StudentsRegistration extends Component
{

    public function render()
    {
        $students = app(StudentRegistrationRepositoryInterface::class)->getAllStudentsPendingOfLocation();
        return view('livewire.back.personnel.registration.students-registration', [
            'students' => $students,
        ]);
    }

    public function addStudentRegistration()
    {
        $this->dispatch('add-student');
    }

    public function editStudentRegistration($studentId)
    {
        $this->dispatch('edit-student', $studentId);
    }

    public function viewStudentRegistration($studentId)
    {
        $this->dispatch('view-student', $studentId);
    }

    public function deleteStudentRegistration($studentId)
    {
        $this->dispatch('delete-student', $studentId);
    }
}
