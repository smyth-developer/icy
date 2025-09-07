<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BankRepositoryInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator;
    public function getById(int $id);
    public function getActiveBanks();
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id): bool;
}


