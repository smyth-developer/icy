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

    public function getCoursesBySeasonAndProgram(int $seasonId, int $programId)
    {
        return Course::where('season_id', $seasonId)
            ->where('program_id', $programId)
            ->with(['program', 'season'])
            ->get();
    }

    public function getCourseById(int $id)
    {
        return Course::with(['program', 'season'])->find($id);
    }

    public function getAvailableCoursesForStudent(int $studentId, int $seasonId, int $programId)
    {
        return Course::where('season_id', $seasonId)
            ->where('program_id', $programId)
            ->whereDoesntHave('tuitions', function($query) use ($studentId) {
                $query->where('user_id', $studentId)
                      ->where('status', 'paid');
            })
            ->with(['program', 'season'])
            ->get();
    }
}