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
    public $programs;

    public function mount()
    {
        $programId = request('program') ?? Program::first()?->id;
        $this->selectedProgramId = $programId ? (int)$programId : null;
        $this->loadPrograms();
    }

    public function updatingSelectedProgramId()
    {
        $this->resetPage();
    }

    public function selectProgram($programId)
    {
        $this->selectedProgramId = (int)$programId;
        $this->dispatch('update-selected-program', $programId);
        $this->loadPrograms();
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
        $this->loadPrograms();
    }

    public function loadPrograms()
    {
        $this->programs = Program::orderBy('ordering', 'asc')->get();
    }

    public function render()
    {
        $subjects = Subject::where('program_id', $this->selectedProgramId)
            ->orderBy('ordering')
            ->paginate(10);

        // Đảm bảo programs được load
        if (!$this->programs) {
            $this->loadPrograms();
        }

        return view('livewire.back.management.subject.subjects', [
            'subjects' => $subjects,
            'programs' => $this->programs,
            'selectedProgramId' => $this->selectedProgramId,
        ]);
    }
}
