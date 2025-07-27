<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Flux\Flux;
use App\Repositories\Contracts\NoteRepositoryInterface;

class Notes extends Component
{
    use WithPagination;
    public $NoteId;

    public function edit($id)
    {
        $this->dispatch('edit-note',$id); 
    }

    public function delete($id)
    {
        $this->NoteId = $id;
        Flux::modal('delete-note')->show();
    }

    public function deleteNote()
    {
        app(NoteRepositoryInterface::class)->delete($this->NoteId);
        Flux::modal('delete-note')->close();
        session()->flash('success', 'Note deleted successfully.');
        $this->redirectRoute('management.notes', navigate: true);
    }

    public function render()
    {
        $note = app(NoteRepositoryInterface::class)->getAll(5);
        return view('livewire.notes',[
            'notes' => $note,
        ]);
    }
}
