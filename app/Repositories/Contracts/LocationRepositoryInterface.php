<?php
namespace App\Repositories\Contracts;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface LocationRepositoryInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator;
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getLocationById(int $id);
    public function showName(string $name);
}
