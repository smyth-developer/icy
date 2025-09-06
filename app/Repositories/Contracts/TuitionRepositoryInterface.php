<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TuitionRepositoryInterface
{
    public function getAllTuitions(): Collection;
    public function getTuitionsByUserId(int $userId): Collection;
    public function getTuitionsWithFilters(array $filters): Collection;
    public function create(array $data): object;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}