<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\ProgramRepositoryInterface;
use App\Models\Program;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Exception;
use Throwable;

class ProgramRepository implements ProgramRepositoryInterface
{

    protected array $programCache = [];

    protected function prepareData(array $data): array
    {
        $data['name'] = trim($data['name']);
        $data['english_name'] = trim($data['english_name']);
        return $data;
    }

    public function getProgramById(int $id): Program
    {
        return $this->programCache[$id] ??= Program::findOrFail($id);
    }

    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return Program::orderBy('ordering', 'asc')->paginate($perPage);
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

    public function delete(int $id): void
    {
        try {
            $program = $this->getProgramById($id);
            $program->delete();
            $remainingIds = Program::orderBy('ordering')->pluck('id')->toArray();
            $this->updateOrdering($remainingIds);
        } catch (Throwable $e) {
            report($e);
            throw new Exception("Lỗi khi xoá chương trình: " . $e->getMessage());
        }
    }

    public function updateOrdering(array $orderedIds): void
    {
        foreach ($orderedIds as $index => $id) {
            Program::where('id', $id)->update(['ordering' => $index + 1]);
        }
    }
}
