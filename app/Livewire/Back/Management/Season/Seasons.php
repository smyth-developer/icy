<?php

namespace App\Livewire\Back\Management\Season;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\Contracts\SeasonRepositoryInterface;
use Flux\Flux;
use Livewire\Attributes\Title;

#[Title('Học kỳ')]
class Seasons extends Component
{
    use WithPagination;
    
    public function addSeason()
    {
        $this->dispatch('add-season'); 
    }

    public function deleteSeason($id)
    {
        $this->dispatch('delete-season', $id);
    }

    public function editSeason($id)
    {
        $this->dispatch('edit-season', $id);
    }

    public function render()
    {
        $seasons = app(SeasonRepositoryInterface::class)->getAll(5);
        return view('livewire.back.management.season.seasons',[
            'seasons' => $seasons,
        ]);
    }
}
