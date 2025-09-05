<?php

namespace App\Livewire\Back\Personnel\Employee;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Repositories\Contracts\StaffRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;

#[Title('Nhân viên')]
class Staff extends Component
{
    public $filterLocationId = null;
    public $filterRoleId = null;
    public $search = '';
    public $staffs = [];

    public function updatedSearch()
    {
        $this->staffs = app(StaffRepositoryInterface::class)->getStaffsOfLocationWithFilters([
            'search' => $this->search,
        ]);
    }

    public function updatedFilterLocationId()
    {
        $this->staffs = app(StaffRepositoryInterface::class)->getStaffsOfLocationWithFilters([
            'location_id' => $this->filterLocationId,
        ]);
    }

    public function updatedFilterRoleId()
    {
        $this->staffs = app(StaffRepositoryInterface::class)->getStaffsOfLocationWithFilters([
            'role_id' => $this->filterRoleId,
        ]);
    }

    public function addStaff()
    {
        $this->dispatch('add-staff');
    }

    public function editStaff($staffId)
    {
        $this->dispatch('edit-staff', $staffId);
    }

    public function deleteStaff($staffId)
    {
        $this->dispatch('delete-staff', $staffId);
    }

    public function render()
    {
        $filters = [
            'location_id' => $this->filterLocationId,
            'role_id' => $this->filterRoleId,
            'search' => $this->search,
        ];
        $this->staffs = app(StaffRepositoryInterface::class)->getStaffsOfLocationWithFilters($filters);
        $locations = app(UserRepositoryInterface::class)->getCurrentUserLocations();
        $roles = app(RoleRepositoryInterface::class)->managerAccessPersonnel();
        return view('livewire.back.personnel.employee.staff',[
            'staffs' => $this->staffs,
            'locations' => $locations,
            'roles' => $roles,
        ]);
    }
    
}
