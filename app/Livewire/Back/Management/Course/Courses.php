<?php

namespace App\Livewire\Back\Management\Course;

use Livewire\Component;
use Livewire\Attributes\Title;

use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use App\Repositories\Contracts\CourseRepositoryInterface;

#[Title('Khoá học')]
class Courses extends Component
{
    use WithPagination, WithoutUrlPagination;


    public function addCourse()
    {
        $this->dispatch('add-course');
    }

    public function render()
    {
        $courses = app(CourseRepositoryInterface::class)->getAll(5);
        return view('livewire.back.management.course.courses',[
            'courses' => $courses,
        ]);
    }
}
