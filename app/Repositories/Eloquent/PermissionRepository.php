<?php
namespace App\Repositories\Eloquent;

use App\Models\Permission;
use App\Repositories\Contracts\PermissionRepositoryInterface;

class PermissionRepository implements PermissionRepositoryInterface
{
    protected array $permissionCache = [];

    protected function prepareDataBeforeCreate(array $data): array
    {
        $data['router'] = trim($data['router']);
        $data['displayName'] = trim($data['displayName']);
        $data['isShow'] = $data['isShow'] ?? 1;
        return $data;
    }

    protected function prepareDataBeforeUpdate(array $data): array
    {
        $data['router'] = trim($data['router']);
        $data['displayName'] = trim($data['displayName']);
        $data['isShow'] = $data['isShow'] ?? 1;
        return $data;
    }

    public function getAll($perPage = null)
    {
        $query = Permission::orderBy('id', 'asc');
        if ($perPage) {
            return $query->paginate($perPage);
        }
        return $query->get();
    }

    public function create(array $data)
    {
        return Permission::create($this->prepareDataBeforeCreate($data));
    }

    public function update(int $id, array $data)
    {
        $permission = $this->getPermissionById($id);
        $permission->update($this->prepareDataBeforeUpdate($data));
        return $permission;
    }

    public function delete(int $id)
    {
        return $this->getPermissionById($id)->delete();
    }

    public function getPermissionById(int $id): Permission
    {
        return $this->permissionCache[$id] ??= Permission::findOrFail($id);
    }
}