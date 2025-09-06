<?php
namespace App\Repositories\Contracts;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProgramRepositoryInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator;
    public function getAllPrograms();
    public function create(array $data);
    public function updateOrdering(array $orderedIds);
    public function update(int $id, array $data);
    public function delete(int $id): bool;
    public function getProgramById(int $id);
    //public function showName(string $name);
}
