<?php
namespace App\Repositories\Contracts;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SeasonRepositoryInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator;
    public function getAllSeasons();
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getSeasonById(int $id);
    public function showName(string $name);

    public function getSeasonAvailable();
}
