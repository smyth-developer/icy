<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    protected array $roleCache = [];

    protected function prepareDataBeforeCreate(array $data): array
    {
        $data['name'] = strtoupper(trim($data['name']));
        $data['description'] = trim($data['description']);
        $data['created_by'] = $data['created_by'] ?? Auth::id();
        return $data;
    }

    protected function prepareDataBeforeUpdate(array $data): array
    {
        $data['name'] = strtoupper(trim($data['name']));
        $data['description'] = trim($data['description']);
        return $data;
    }

    public function getAll($perPage = null)
    {
        $query = Role::with('createdBy:id,name')->orderBy('id', 'asc');

        if ($perPage) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    public function create(array $data)
    {
        return Role::create($this->prepareDataBeforeCreate($data));
    }

    public function update(int $id, array $data)
    {
        $role = $this->getRoleById($id);
        $role->update($this->prepareDataBeforeUpdate($data));
        return $role;
    }

    public function delete(int $id)
    {
        return $this->getRoleById($id)->delete();
    }

    public function getRoleById(int $id): Role
    {
        return $this->roleCache[$id] ??= Role::with('createdBy:id,name')->findOrFail($id);
    }

    public function managerAccessPersonnel(): Collection
    {
        $name = Auth::user()->roles->first()->name;

        switch ($name) {
            case 'BOD':
                return Role::whereNotIn('name', ['Student', 'BOD'])->get();

            case 'CENTER MANAGER':
                return Role::whereNotIn('name', [
                    'BOD',
                    'Student',
                    'Center Manager',
                ])->get();

            default:
                return new Collection();
        }
    }
}
