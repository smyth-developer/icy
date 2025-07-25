<?php

namespace App\Livewire\Back\Management\Location;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Repositories\Contracts\LocationRepositoryInterface;
use App\Support\Validation\LocationRules;
use Flux\Flux;

class EditLocation extends Component
{
    public $locationId;
    public $name;
    public $address;

    #[On('edit-location')]
    public function editLocation($id)
    {
        $location = app(LocationRepositoryInterface::class)->getLocationById($id);
        $this->locationId = $location->id;
        $this->name = $location->name;
        $this->address = $location->address;
        Flux::modal('edit-location')->show();
    }

    public function rules()
    {
        return LocationRules::rules($this->locationId);
    }

    public function messages()
    {
        return LocationRules::messages();
    }

    public function updateLocation()
    {
        
        $this->validate();

        app(LocationRepositoryInterface::class)->update($this->locationId, [
            'name' => $this->name,
            'address' => $this->address,
        ]);

        session()->flash('success', 'Cập nhật cơ sở '. app(LocationRepositoryInterface::class)->showName($this->name) .' thành công.');
        Flux::modal('edit-location')->close();
        $this->redirectRoute('locations', navigate: true);
    }

    public function render()
    {
        return view('livewire.back.management.location.edit-location');
    }
}
