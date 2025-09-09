<?php

namespace App\Livewire\Back\Management\Syllabus;

use App\Models\Syllabus;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Repositories\Contracts\SubjectRepositoryInterface;

#[Title('Syllabus')]
class Syllabi extends Component
{
    use WithPagination;

    public $search = '';
    public $subjectFilter = '';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'subjectFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSubjectFilter()
    {
        $this->resetPage();
    }

    public function deleteSyllabus($syllabusId)
    {
        $syllabus = Syllabus::findOrFail($syllabusId);
        $syllabus->delete();
        
        session()->flash('message', 'Syllabus đã được xóa thành công!');
    }

    public function render()
    {
        $syllabi = Syllabus::with(['subject.program'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('lesson_number', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%')
                      ->orWhere('objectives', 'like', '%' . $this->search . '%')
                      ->orWhereHas('subject', function ($subjectQuery) {
                          $subjectQuery->where('name', 'like', '%' . $this->search . '%')
                                      ->orWhere('code', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->subjectFilter, function ($query) {
                $query->whereHas('subject', function ($subjectQuery) {
                    $subjectQuery->where('id', $this->subjectFilter);
                });
            })
            ->orderBy('ordering')
            ->paginate($this->perPage);

            $subjects = app(SubjectRepositoryInterface::class)->getAll();
        

        return view('livewire.back.management.syllabus.syllabi', [
            'syllabi' => $syllabi,
            'subjects' => $subjects,
        ]);
    }
}
