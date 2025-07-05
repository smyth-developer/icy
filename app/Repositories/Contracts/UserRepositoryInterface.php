<?php
namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function getAll();
    public function create(array $data);
}
