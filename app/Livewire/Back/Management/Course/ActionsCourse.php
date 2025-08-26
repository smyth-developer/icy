<?php

namespace App\Livewire\Back\Management\Course;
use Livewire\Attributes\On;
use App\Support\Validation\CourseRules;

use Flux\Flux;

use Livewire\Component;

class ActionsCourse extends Component
{
    public $courseId;
    public $name, $description;
    public $isEditCourseMode = false;

    #[On('add-course')]
    public function addCourse()
    {
        $this->resetErrorBag();
        $this->reset(['courseId', 'name', 'description']);
        $this->isEditCourseMode = false;
        Flux::modal('modal-course')->show();
    }

    public function rules()
    {
        return CourseRules::rules($this->courseId);
    }

    public function messages()
    {
        return CourseRules::messages();
    }

    public function render()
    {
        return view('livewire.back.management.course.actions-course');
    }
}
