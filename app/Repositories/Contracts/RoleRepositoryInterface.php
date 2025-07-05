<?php
namespace App\Repositories\Contracts;

interface RoleRepositoryInterface
{
    public function getAll();
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getRoleById(int $id);
}