<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\CurriculumRepositoryInterface;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Curriculum;

class CurriculumRepository implements CurriculumRepositoryInterface
{
    protected function prepareData(array $data): array
    {
        $data['name'] = trim($data['name']);
        $data['english_name'] = trim($data['english_name']);
        return $data;
    }

    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return Curriculum::orderBy('ordering', 'asc')->paginate($perPage);
    }

    public function create(array $data) 
    {
        $data = $this->prepareData($data);
        $maxOrdering = Curriculum::max('ordering') ?? 0;
        $data['ordering'] = $maxOrdering + 1;
        return Curriculum::create($data);
    }
}
