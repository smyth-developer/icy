<?php

namespace App\Livewire\Back\Management\Locations;

use Livewire\Component;
use App\Repositories\Contracts\LocationRepositoryInterface;
use App\Support\Validation\LocationRules;
use Flux\Flux;

class CreateLocation extends Component
{
    public $name;
    public $address;

    public function rules()
    {
        return LocationRules::rules();
    }

    public function messages()
    {
        return LocationRules::messages();
    }

    public function createLocation()
    {
        $this->validate();

        app(LocationRepositoryInterface::class)->create([
            'name' => $this->name,
            'address' => $this->address,
        ]);

        session()->flash('success', 'Location created successfully.');

        // Reset fields after saving
        $this->reset(['name', 'address']);
        Flux::modal('create-location')->close();

        $this->redirectRoute('locations', navigate: true); // Redirect to the locations page after saving
    }

    public function render()
    {
        return view('livewire.back.management.locations.create-location');
    }
}
