<?php

namespace App\Livewire\Back\Access\Role;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Flux\Flux;
use Livewire\Attributes\Title;

#[Title('Vai trò')]
class Roles extends Component
{
    use WithPagination;
    
    public function addRole()
    {
        $this->dispatch('add-role'); 
    }

    public function deleteRole($id)
    {
        $this->dispatch('delete-role', $id);
    }

    public function editRole($id)
    {
        $this->dispatch('edit-role', $id);
    }

    public function mount()
    {
        $this->dispatch('turnOnBankTransfer');
    }

    public function render()
    {
        $roles = app(RoleRepositoryInterface::class)->getAll(10);
        return view('livewire.back.access.role.roles',[
            'roles' => $roles,
        ]);
    }
}
