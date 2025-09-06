<?php

namespace App\Repositories\Eloquent;

use App\Models\Tuition;
use App\Repositories\Contracts\TuitionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class TuitionRepository implements TuitionRepositoryInterface
{
    public function getAllTuitions(): Collection
    {
        return Tuition::with(['user', 'program', 'season', 'bank'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getTuitionsByUserId(int $userId): Collection
    {
        return Tuition::with(['user', 'program', 'season', 'bank'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getTuitionsWithFilters(array $filters): Collection
    {
        $query = Tuition::with(['user', 'program', 'season', 'bank']);

        // Lọc theo tên học viên hoặc account code
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('account_code', 'like', "%{$search}%");
            });
        }

        // Lọc theo location (nếu user có nhiều location)
        if (!empty($filters['location_id'])) {
            $query->whereHas('user.locations', function ($q) use ($filters) {
                $q->where('location_id', $filters['location_id']);
            });
        }

        // Lọc theo chương trình
        if (!empty($filters['program_id'])) {
            $query->where('program_id', $filters['program_id']);
        }

        // Lọc theo học kỳ
        if (!empty($filters['season_id'])) {
            $query->where('season_id', $filters['season_id']);
        }

        // Lọc theo phương thức thanh toán
        if (!empty($filters['payment_method'])) {
            $query->where('payment_method', $filters['payment_method']);
        }

        // Lọc theo tháng
        if (!empty($filters['month'])) {
            switch ($filters['month']) {
                case 'this_month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', now()->subMonth()->month)
                          ->whereYear('created_at', now()->subMonth()->year);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', now()->year);
                    break;
                case 'last_year':
                    $query->whereYear('created_at', now()->subYear()->year);
                    break;
            }
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function create(array $data): object
    {
        return Tuition::create($data);
    }

    public function update(int $id, array $data): bool
    {
        try {
            $tuition = Tuition::findOrFail($id);
            return $tuition->update($data);
        } catch (Throwable $e) {
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $tuition = Tuition::findOrFail($id);
            return $tuition->delete();
        } catch (Throwable $e) {
            return false;
        }
    }
}