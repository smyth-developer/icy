<?php

namespace App\Livewire\Back\Management\Subject;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use App\Repositories\Contracts\ProgramRepositoryInterface;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use App\Models\Subject;
use App\Models\Program;

#[Title('Môn học')]
class Subjects extends Component
{
    use WithPagination;
    use WithoutUrlPagination;

    public $selectedProgramId;

    public function mount()
    {
        $programId = request('program') ?? Program::first()?->id;
        $this->selectedProgramId = $programId ? (int)$programId : null;
    }

    public function updatingSelectedProgramId()
    {
        $this->resetPage();
    }

    public function selectProgram($programId)
    {
        $this->selectedProgramId = (int)$programId;
        $this->dispatch('update-selected-program', $programId);
    }

    public function addSubject()
    {
        $this->dispatch('add-subject');
    }

    public function deleteSubject($subjectId)
    {
        $this->dispatch('delete-subject', $subjectId);
    }

    public function editSubject($subjectId)
    {
        $this->dispatch('edit-subject', $subjectId);
    }

    #[On('subject-created')]
    public function subjectCreated($programId)
    {
        $this->selectedProgramId = (int)$programId;
        $this->resetPage();
        $this->dispatch('$refresh');
    }

    public function render()
    {
        $subjects = Subject::where('program_id', $this->selectedProgramId)
            ->orderBy('ordering')
            ->paginate(10);

        $programs = app(ProgramRepositoryInterface::class)->getAll(100);

        return view('livewire.back.management.subject.subjects', [
            'subjects' => $subjects,
            'programs' => $programs,
            'selectedProgramId' => $this->selectedProgramId,
        ]);
    }
}
