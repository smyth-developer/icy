<?php

namespace App\Livewire\Back\Personnel\Registration;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Repositories\Contracts\StaffRepositoryInterface;

#[Title('Đăng ký nhân viên')]
class StaffsRegistration extends Component
{
    public function render()
    {
        $staffs = app(StaffRepositoryInterface::class)->getAllStaffsPendingOfLocation();
        return view('livewire.back.personnel.registration.staffs-registration', [
            'staffs' => $staffs,
        ]);
    }

    public function addStaffRegistration()
    {
        $this->dispatch('add-staff');
    }

    public function editStaffRegistration($staffId)
    {
        $this->dispatch('edit-staff', $staffId);
    }

    public function viewStaffRegistration($staffId)
    {
        $this->dispatch('view-staff', $staffId);
    }

    public function deleteStaffRegistration($staffId)
    {
        $this->dispatch('delete-staff', $staffId);
    }

    public function approveStaffRegistration($staffId)
    {
        $this->dispatch('approve-staff', $staffId);
    }
}
