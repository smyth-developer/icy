<?php

namespace App\Livewire\Back\Management\Course;

use Livewire\Component;
use Livewire\Attributes\Title;

use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

#[Title('Khoá học')]
class Courses extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function updateCourseOrdering(array $orderedIds)
    {
        //$courseRepository = app(CourseRepositoryInterface::class)->updateCourseOrdering($orderedIds);
    }

    public function addCourse()
    {
        $this->dispatch('add-course');
    }

    public function render()
    {
        $courses = [];
        //$courses = app(CourseRepositoryInterface::class)->getAll(5);
        return view('livewire.back.management.course.courses',[
            'courses' => $courses,
        ]);
    }
}
