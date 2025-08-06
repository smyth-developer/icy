<?php

namespace App\Livewire\Back\Access\Role;

use Livewire\Component;
use Livewire\Attributes\On;
use Flux\Flux;
use App\Support\Validation\RoleRules;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ActionsRole extends Component
{
    public $roleId;
    public $name, $description, $type;
    public $isEditRoleMode = false;

    public function rules()
    {
        return RoleRules::rules($this->roleId);
    }

    public function messages()
    {
        return RoleRules::messages();
    }

    #[On('add-role')]
    public function addRole()
    {
        $this->resetErrorBag();
        $this->reset(['roleId', 'name', 'description', 'type']);
        $this->isEditRoleMode = false;
        Flux::modal('modal-role')->show();
    }

    public function createRole()
    {
        $this->roleId = null;
        $this->validate();
        app(RoleRepositoryInterface::class)->create([
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type ?? 'custom',
        ]);

        session()->flash('success', 'Vai trò đã được thêm thành công.');
        $this->reset([
            'roleId',
            'name',
            'description',
            'type'
        ]);
        Flux::modal('modal-role')->close();

        $this->redirectRoute('admin.access.roles', navigate: true);
    }

    #[On('edit-role')]
    public function editRole($id)
    {
        $this->resetErrorBag();
        $this->roleId = $id;
        $role = app(RoleRepositoryInterface::class)->getRoleById($id);
        $this->name = $role->name;
        $this->description = $role->description;
        $this->type = $role->type;
        $this->isEditRoleMode = true;
        Flux::modal('modal-role')->show();
    }

    public function updateRole()
    {
        $this->validate();

        app(RoleRepositoryInterface::class)->update($this->roleId, [
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type ?? 'custom',
        ]);

        session()->flash('success', 'Vai trò đã được cập nhật thành công.');
        Flux::modal('modal-role')->close();
        $this->redirectRoute('admin.access.roles', navigate: true);
    }

    #[On('delete-role')]
    public function deleteRole($id)
    {
        $this->roleId = $id;
        Flux::modal('delete-role')->show();
    }

    public function deleteRoleConfirm()
    {
        app(RoleRepositoryInterface::class)->delete($this->roleId);
        session()->flash('success', 'Vai trò đã được xóa thành công.');
        Flux::modal('delete-role')->close();
        $this->redirectRoute('admin.access.roles', navigate: true);
    }

    public function render()
    {
        return view('livewire.back.access.role.actions-role');
    }
}
