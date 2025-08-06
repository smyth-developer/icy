<?php

namespace App\Livewire\Back\Access\Permission;

use Livewire\Component;
use Livewire\Attributes\On;
use Flux\Flux;
use App\Support\Validation\PermissionRules;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Models\Permission;

class ActionsPermission extends Component
{
    public $permissionId;
    public $router, $displayName, $isShow;
    public $isEditPermissionMode = false;
    public $routeOptions = [];

    public function rules()
    {
        return PermissionRules::rules($this->permissionId);
    }

    public function messages()
    {
        return PermissionRules::messages();
    }

    #[On('add-permission')]
    public function addPermission()
    {
        $this->resetErrorBag();
        $this->reset(['permissionId', 'router', 'displayName', 'isShow']);
        $this->isEditPermissionMode = false;
        $this->routeOptions = $this->getRoutes();
        Flux::modal('modal-permission')->show();
    }

    public function createPermission()
    {
        $this->permissionId = null;
        $this->validate();
        app(PermissionRepositoryInterface::class)->create([
            'router' => $this->router,
            'displayName' => $this->displayName,
            'isShow' => $this->isShow ?? 1,
        ]);
        session()->flash('success', 'Permission đã được thêm thành công.');
        $this->reset(['permissionId', 'router', 'displayName', 'isShow']);
        Flux::modal('modal-permission')->close();
        $this->redirectRoute('admin.access.permissions', navigate: true);
    }

    #[On('edit-permission')]
    public function editPermission($id)
    {
        $this->resetErrorBag();
        $this->permissionId = $id;
        $permission = app(PermissionRepositoryInterface::class)->getPermissionById($id);

        $this->displayName = $permission->displayName;
        $this->isShow = $permission->isShow;
        $this->isEditPermissionMode = true;
        $this->router = $permission->router;
        Flux::modal('modal-permission')->show();
    }

    public function updatePermission()
    {
        $this->validate();
        app(PermissionRepositoryInterface::class)->update($this->permissionId, [
            'router' => $this->router,
            'displayName' => $this->displayName,
            'isShow' => $this->isShow ?? 1,
        ]);
        session()->flash('success', 'Permission đã được cập nhật thành công.');
        Flux::modal('modal-permission')->close();
        $this->redirectRoute('admin.access.permissions', navigate: true);
        $this->reset(['router', 'displayName', 'isShow','permissionId']);
    }

    #[On('delete-permission')]
    public function deletePermission($id)
    {
        $this->permissionId = $id;
        Flux::modal('delete-permission')->show();
    }

    public function deletePermissionConfirm()
    {
        app(PermissionRepositoryInterface::class)->delete($this->permissionId);
        session()->flash('success', 'Permission đã được xóa thành công.');
        Flux::modal('delete-permission')->close();
        $this->redirectRoute('admin.access.permissions', navigate: true);
    }

    public function getRoutes($ignoreId = null)
    {
        $routes = [];
        $router = Route::getRoutes();

        foreach ($router as $route) {
            $routeName = str_replace('/', '.', $route->uri);
            if (Str::contains($routeName, 'admin') && !in_array($routeName, $routes)) {
                $exists = Permission::where('router', $routeName)->exists();
                if (!$exists) {
                    $routes[] = $routeName;
                }
            }
        }

        return $routes;
    }

    public function render()
    {
        return view('livewire.back.access.permission.actions-permission');
    }
}
