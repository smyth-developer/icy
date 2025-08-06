<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\CourseRepositoryInterface;
use App\Models\Course;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CourseRepository implements CourseRepositoryInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return Course::paginate($perPage);
    }
}