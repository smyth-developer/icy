<?php

namespace App\Livewire\Back\Management\Program;

use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Repositories\Contracts\ProgramRepositoryInterface;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

#[Title('Chương trình học')]
class Programs extends Component
{
    use WithPagination, WithoutUrlPagination;

    // addProgram
    public function addProgram()
    {
        $this->dispatch('add-program');
    }

    //editProgram
    public function editProgram($id)
    {
        $this->dispatch('edit-program', $id);
    }

    //deleteProgram
    public function deleteProgram($id)
    {
        $this->dispatch('delete-program',$id);
    }

    public function updateProgramOrdering(array $orderedIds)
    {
        app(ProgramRepositoryInterface::class)->updateOrdering(
            $orderedIds
        );
        session()->flash('success', 'Sắp xếp chương trình học thành công.');
        $this->redirectRoute('admin.management.programs', navigate: true);
    }

    public function render()
    {
        $programs = app(ProgramRepositoryInterface::class)->getAll(10);
        return view('livewire.back.management.program.programs', [
            'programs' => $programs,
        ]);
    }
}
