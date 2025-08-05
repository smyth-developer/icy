<?php

namespace App\Repositories\Contracts;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CurriculumRepositoryInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator;
    public function create(array $data);
}