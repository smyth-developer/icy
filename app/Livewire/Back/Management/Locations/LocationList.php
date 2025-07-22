<?php

namespace App\Livewire\Back\Management\Locations;

use Livewire\Component;
use App\Repositories\Contracts\LocationRepositoryInterface;
use Flux\Flux;

class LocationList extends Component
{

    public $locationId;

    public function deleteLocation($id)
    {
        $this->locationId = $id;
        Flux::modal('delete-location')->show();
    }
    
    public function deleteLocationConfirm()
    {
        app(LocationRepositoryInterface::class)->delete($this->locationId);
        Flux::modal('delete-location')->close();
        session()->flash('success', 'Location deleted successfully.');
        $this->redirectRoute('locations', navigate: true);
    }

    public function render()
    {
        $locations = app(LocationRepositoryInterface::class)->getAll(10);
        return view('livewire.back.management.locations.location-list',[
            'locations'=> $locations
        ]);
    }
}
