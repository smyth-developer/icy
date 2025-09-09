<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProgramLocationPriceRepositoryInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator;
    public function getByProgramAndLocation(int $programId, int $locationId);
    public function getPriceByProgramAndLocation(int $programId, int $locationId);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id): bool;
    public function bulkUpdate(array $prices): bool;
    public function getPricesWithProgramsAndLocations();
}
