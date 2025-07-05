<?php

namespace App\Livewire\Back\Management;

use Flux\Flux;
use Livewire\Component;

class Locations extends Component
{
    public $location;
    public $name, $address;
    public $isUpdateMode = false;
    public function addLocation()
    {
        $this->reset('name', 'address');
        $this->isUpdateMode = false;
        Flux::modal('location-modal')->show();
    }

    public function render()
    {
        return view('livewire.back.management.locations');
    }
}
