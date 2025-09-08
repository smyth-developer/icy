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

    public function getAllSeasons()
    {
        return Season::orderByRaw("
            RIGHT(code, 2) DESC,                      
            FIELD(LEFT(code, 2), 'WI', 'FA', 'SU', 'SP') 
        ")->get();
    }


    public function create(array $data)
    {
        return Season::create($data);
    }

    public function update(int $id, array $data)
    {

        //Check status finished
        if ($data['status'] == 'finished') {
            session()->flash('error', 'Mùa này đã kết thúc');
            return;
        }

        //Check status ongoing
        if ($data['status'] == 'ongoing') {
            session()->flash('error', 'Mùa này đang diễn ra');
            return;
        }

        //Check status upcoming
        $season = $this->getSeasonById($id);
        $season->update($data);
        return $season;
    }

    public function delete(int $id)
    {
        $season = $this->getSeasonById($id);
        //Check status finished
        if ($season->status == 'finished') {
            session()->flash('error', 'Mùa này đã kết thúc');
            return;
        }

        //Check status ongoing
        if ($season->status == 'ongoing') {
            session()->flash('error', 'Mùa này đang diễn ra');
            return;
        }

        //Check status upcoming
        return $season->delete();
    }

    public function showName(string $name): string
    {
        return Season::where('name', $name)->value('name');
    }

    public function getSeasonAvailable()
    {
        return Season::whereIn('status', ['ongoing', 'upcoming'])->get();
    }
}
