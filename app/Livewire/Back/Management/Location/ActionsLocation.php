<?php

namespace App\Livewire\Back\Management\Location;

use Livewire\Component;
use Livewire\Attributes\On;
use Flux\Flux;
use App\Support\Validation\LocationRules;
use App\Repositories\Contracts\LocationRepositoryInterface;

class ActionsLocation extends Component
{
    public $locationId;
    public $name;
    public $address;
    public $isEditLocationMode = false;

    public function rules()
    {
        return LocationRules::rules($this->locationId);
    }

    public function messages()
    {
        return LocationRules::messages();
    }

    #[On('add-location')]
    public function addLocation()
    {
        $this->resetErrorBag();
        $this->reset(['locationId', 'name', 'address']);
        $this->isEditLocationMode = false;
        Flux::modal('modal-location')->show();
    }

    public function createLocation()
    {
        $this->locationId = null;
        $this->validate();
        app(LocationRepositoryInterface::class)->create([
            'name' => $this->name,
            'address' => $this->address,
        ]);
        session()->flash('success', 'Tạo cơ sở thành công.');
        $this->reset(['locationId', 'name', 'address']);
        Flux::modal('modal-location')->close();
        $this->redirectRoute('admin.management.locations', navigate: true);
    }

    #[On('edit-location')]
    public function editLocation($id)
    {
        $this->resetErrorBag();
        $this->locationId = $id;
        $location = app(LocationRepositoryInterface::class)->getLocationById($id);
        $this->name = $location->name;
        $this->address = $location->address;
        $this->isEditLocationMode = true;
        Flux::modal('modal-location')->show();
    }

    public function updateLocation()
    {
        $this->validate();
        $update =app(LocationRepositoryInterface::class)->update($this->locationId, [
            'name' => $this->name,
            'address' => $this->address,
        ]);
        
        if ($update) {
            session()->flash('success', 'Cập nhật cơ sở thành công.');
        } else {
            session()->flash('error', 'Cập nhật cơ sở thất bại.');
        }

        Flux::modal('modal-location')->close();
        $this->redirectRoute('admin.management.locations', navigate: true);
    }

    #[On('delete-location')]
    public function deleteLocation($id)
    {
        $this->locationId = $id;
        Flux::modal('delete-location')->show();
    }

    public function deleteLocationConfirm()
    {
        $delete = app(LocationRepositoryInterface::class)->delete($this->locationId);
        if ($delete) {
            session()->flash('success', 'Xoá cơ sở thành công.');
        }
        Flux::modal('delete-location')->close();
        $this->redirectRoute('admin.management.locations', navigate: true);
    }

    public function render()
    {
        return view('livewire.back.management.location.actions-location');
    }
}
