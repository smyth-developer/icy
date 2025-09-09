<?php

namespace App\Livewire\Back\Management\Location;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\Contracts\LocationRepositoryInterface;
use Flux\Flux;
use Livewire\Attributes\Title;

#[Title('Cơ sở')]
class Locations extends Component
{
    use WithPagination;

    public function addLocation()
    {
        $this->dispatch('add-location');
    }

    public function editLocation($id)
    {
        $this->dispatch('edit-location', $id);
    }

    public function deleteLocation($id)
    {
        $this->dispatch('delete-location', $id);
    }

    public function render()
    {
        $locations = app(LocationRepositoryInterface::class)->getAll(5);
        return view('livewire.back.management.location.locations', [
            'locations' => $locations,
        ]);
    }
}
