<?php

namespace App\Livewire\Back\Management\Location;

use Livewire\Component;
use App\Repositories\Contracts\LocationRepositoryInterface;
use Flux\Flux;
use Livewire\Attributes\Title;

#[Title('Cơ sở')]
class Locations extends Component
{
    public $locationId;
    public $name;
    public $address;

    public function editLocation($id)
    {
        $this->dispatch('edit-location',$id); 
    }

    public function deleteLocation($id)
    {
        $this->locationId = $id;
        Flux::modal('delete-location')->show();
    }

    public function deleteLocationConfirm()
    {
        app(LocationRepositoryInterface::class)->delete($this->locationId);
        Flux::modal('delete-location')->close();
        session()->flash('success', 'Xoá cơ sở thành công.');
        $this->redirectRoute('management.locations', navigate: true);
    }

    public function render()
    {
        $locations = app(LocationRepositoryInterface::class)->getAll(5);
        return view('livewire.back.management.location.locations',[
            'locations' => $locations,
        ]);
    }
}
