<?php

namespace App\Livewire\Back\Personnel\Student;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\StudentRepositoryInterface;

#[Title('Học viên')]
class Students extends Component
{
    public $filterLocationId = null;
    public $search = '';
    public $students = [];

    public function addStudent()
    {
        $this->dispatch('add-student');
    }

    public function editStudent($studentId)
    {
        $this->dispatch('edit-student', $studentId);
    }

    public function actionsTuition($studentId)
    {
        $this->dispatch('add-tuition', $studentId);
        //back/finance/tuition/tuitions
    }

    public function deleteStudent($studentId)
    {
        $this->dispatch('delete-student', $studentId);
    }

    public function updatedSearch()
    {
        $filters = [
            'location_id' => $this->filterLocationId,
            'search' => $this->search,
        ];
        $this->students = app(StudentRepositoryInterface::class)->getStudentsOfLocationWithFilters($filters);
    }

    public function updatedFilterLocationId()
    {
        $filters = [
            'location_id' => $this->filterLocationId,
            'search' => $this->search,
        ];
        $this->students = app(StudentRepositoryInterface::class)->getStudentsOfLocationWithFilters($filters);
    }

    public function render()
    {
        $filters = [
            'location_id' => $this->filterLocationId,
            'search' => $this->search,
        ];
        $this->students = app(StudentRepositoryInterface::class)->getStudentsOfLocationWithFilters($filters);
        $locations = app(UserRepositoryInterface::class)->getCurrentUserLocations();
        return view('livewire.back.personnel.student.students', [
            'students' => $this->students,
            'locations' => $locations,
        ]);
    }
}
