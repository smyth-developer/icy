<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\SeasonRepositoryInterface;
use App\Models\Season;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class SeasonRepository implements SeasonRepositoryInterface
{
    protected array $seasonCache = [];

    public function getSeasonById(int $id): ?Season
    {
        return $this->seasonCache[$id] ??= Season::findOrFail($id);
    }

    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        $now = now();

        return Season::query()
            ->select('*')
            ->selectRaw("
            CASE 
                WHEN start_date > ? THEN 'upcoming'
                WHEN end_date < ? THEN 'finished'
                ELSE 'ongoing'
            END AS season_status
        ", [$now, $now])
            ->orderByRaw("
            RIGHT(code, 2) DESC,                      
            FIELD(LEFT(code, 2), 'WI', 'FA', 'SU', 'SP') 
        ")
            ->paginate($perPage);
    }


    public function create(array $data)
    {
        return Season::create($data);
    }

    public function update(int $id, array $data)
    {
        $season = $this->getSeasonById($id);
        $season->update($data);
        return $season;
    }

    public function delete(int $id)
    {
        return $this->getSeasonById($id)->delete();
    }

    public function showName(string $name): string
    {
        return Season::where('name', $name)->value('name');
    }
}
