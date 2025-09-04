<?php
namespace App\Repositories\Contracts;

interface RoleRepositoryInterface
{
    public function getAll($perPage = null);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getRoleById(int $id);
    public function getRoleStaff();
}