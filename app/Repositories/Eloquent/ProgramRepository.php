<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\ProgramRepositoryInterface;
use App\Models\Program;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Throwable;

class ProgramRepository implements ProgramRepositoryInterface
{

    protected array $programCache = [];

    protected function prepareData(array $data): array
    {
        $data['name'] = ucfirst(trim($data['name']));
        $data['english_name'] = ucwords(trim($data['english_name']));
        return $data;
    }

    public function getProgramById(int $id): Program
    {
        return $this->programCache[$id] ??= Program::findOrFail($id);
    }

    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return Program::with(['programLocationPrices.location'])
            ->orderBy('ordering', 'asc')
            ->paginate($perPage);
    }

    public function getAllPrograms()
    {
        return Program::orderBy('ordering', 'asc')->get();
    }

    public function create(array $data)
    {
        $data = $this->prepareData($data);
        $maxOrdering = Program::max('ordering') ?? 0;
        $data['ordering'] = $maxOrdering + 1;
        return Program::create($data);
    }

    public function update(int $id, array $data)
    {
        $program = $this->getProgramById($id);
        $program->update($this->prepareData($data));
        return $program;
    }

    public function delete(int $id): bool
    {
        try {
            $program = $this->getProgramById($id);

            if ($program->subjects()->count() > 0) {
                return false;
            }

            $program->delete();
            $remainingIds = Program::orderBy('ordering')->pluck('id')->toArray();
            $this->updateOrdering($remainingIds);
            return true;
        } catch (Throwable $e) {
            return false;
        }
    }

    public function updateOrdering(array $orderedIds): void
    {
        foreach ($orderedIds as $index => $id) {
            Program::where('id', $id)->update(['ordering' => $index + 1]);
        }
    }
}
