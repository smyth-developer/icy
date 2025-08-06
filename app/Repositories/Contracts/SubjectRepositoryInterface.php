<?php

namespace App\Repositories\Contracts;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


interface SubjectRepositoryInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator;
    public function create(array $data, $programId);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getSubjectById(int $id);
    public function updateOrdering(array $orderedIds);
    //public function showName(string $name);
}
