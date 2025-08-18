<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\SubjectRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Subject;

class SubjectRepository implements SubjectRepositoryInterface
{

    protected array $subjectCache = [];

    protected function prepareData(array $data): array
    {

        $name = strtolower(trim($data['name']));
        $name = preg_replace('/\bicy\b/i', '', $name);
        $name = 'ICY ' . ucwords(trim($name));

        $data['name'] = $name;
        $data['code'] = strtoupper(trim($data['code']));
        $data['description'] = trim($data['description']);
        return $data;
    }

    public function getAll(?int $perPage = null)
    {
        $query = Subject::with('program')
            ->select('subjects.*')
            ->join('programs', 'programs.id', '=', 'subjects.program_id')
            ->orderBy('programs.ordering')
            ->orderBy('subjects.ordering');

        return $perPage ? $query->paginate($perPage) : $query->get();
    }


    public function create(array $data, $programId)
    {
        $data = $this->prepareData($data);
        $data['program_id'] = $programId;

        $maxOrdering = Subject::where('program_id', $programId)->max('ordering') ?? 0;
        $data['ordering'] = $maxOrdering + 1;
        return Subject::create($data);
    }

    public function delete(int $id): void
    {
        $subject = $this->getSubjectById($id);
        $subject->delete();
        $remainingIds = Subject::where('program_id', $subject->program_id)
            ->orderBy('ordering')
            ->pluck('id')
            ->toArray();
        $this->updateOrdering($remainingIds);
    }

    public function getSubjectById(int $id): Subject
    {
        return $this->subjectCache[$id] ??= Subject::findOrFail($id);
    }

    public function update(int $id, array $data): Subject
    {
        $subject = $this->getSubjectById($id);
        $data = $this->prepareData($data);
        $subject->update($data);
        return $subject;
    }

    public function updateOrdering(array $ids): void
    {
        foreach ($ids as $index => $id) {
            Subject::where('id', $id)->update(['ordering' => $index + 1]);
        }
    }
}
