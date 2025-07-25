<?php

namespace App\Livewire\Back\Management\Location;

use Livewire\Component;
use App\Repositories\Contracts\LocationRepositoryInterface;
use Flux\Flux;
use App\Support\Validation\LocationRules;

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
        session()->flash('success', 'Tạo cơ sở '. app(LocationRepositoryInterface::class)->showName($this->name) .' thành công.');
        $this->redirectRoute('locations', navigate: true);
    }

    public function render()
    {
        return view('livewire.back.management.location.create-location');
    }
}
