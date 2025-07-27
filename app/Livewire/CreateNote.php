<?php

namespace App\Livewire;

use App\Models\Note;
use Flux\Flux;
use Livewire\Component;
use App\Repositories\Contracts\NoteRepositoryInterface;

class CreateNote extends Component
{
    public $title;
    public $content;

    public function rules()
    {
        return [
            'title' => 'required|string|max:255|unique:notes,title',
            'content' => 'required|string',
        ];
    }

    public function save()
    {
        $this->validate();

        app(NoteRepositoryInterface::class)->create([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        session()->flash('success', 'Note created successfully.');

        // Reset fields after saving
        $this->reset(['title', 'content']);
        Flux::modal('create-note')->close();

        $this->redirectRoute('management.notes', navigate: true); // Redirect to the notes page after saving
    }
    public function render()
    {
        return view('livewire.create-note');
    }
}
