<?php

namespace App\Livewire\Back\Access\Permission;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use Livewire\Attributes\Title;

#[Title('Permission')]
class Permissions extends Component
{
    use WithPagination;

    public function mount()
    {
        $this->dispatch('turnOnBankTransfer');
    }

    public function addPermission()
    {
        $this->dispatch('add-permission');
    }

    public function deletePermission($id)
    {
        $this->dispatch('delete-permission', $id);
    }

    public function editPermission($id)
    {
        $this->dispatch('edit-permission', $id);
    }

    public function render()
    {
        $permissions = app(PermissionRepositoryInterface::class)->getAll(10);
        return view('livewire.back.access.permission.permissions', [
            'permissions' => $permissions,
        ]);
    }
}
