<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\SyllabusRepositoryInterface;
use App\Models\Syllabus;

class SyllabusRepository implements SyllabusRepositoryInterface
{
    protected array $syllabusCache = [];

    protected function prepareData(array $data): array
    {
        return [
            'subject_id' => $data['subject_id'],
            'lesson_number' => trim($data['lesson_number']),
            'content' => trim($data['content']),
            'objectives' => trim($data['objectives']),
            'vocabulary' => isset($data['vocabulary']) ? trim($data['vocabulary']) : null,
            'assignment' => isset($data['assignment']) ? trim($data['assignment']) : null,
            'student_task' => isset($data['student_task']) ? trim($data['student_task']) : null,
            'lecturer_task' => isset($data['lecturer_task']) ? trim($data['lecturer_task']) : null,
            'lecture_slide' => isset($data['lecture_slide']) ? trim($data['lecture_slide']) : null,
            'audio_file' => isset($data['audio_file']) ? trim($data['audio_file']) : null,
            'ordering' => $data['ordering'] ?? $this->getNextOrdering($data['subject_id']),
        ];
    }

    protected function getNextOrdering(int $subjectId): int
    {
        $maxOrdering = Syllabus::where('subject_id', $subjectId)->max('ordering') ?? 0;
        return $maxOrdering + 1;
    }

    public function getAll(?int $perPage = null)
    {
        $query = Syllabus::with(['subject.program'])
            ->orderBy('ordering');

        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public function create(array $data): Syllabus
    {
        $data = $this->prepareData($data);
        return Syllabus::create($data);
    }

    public function update(int $id, array $data): Syllabus
    {
        $syllabus = $this->getSyllabusById($id);
        $data = $this->prepareData($data);
        $syllabus->update($data);
        
        // Clear cache
        unset($this->syllabusCache[$id]);
        
        return $syllabus;
    }

    public function delete(int $id): void
    {
        $syllabus = $this->getSyllabusById($id);
        $subjectId = $syllabus->subject_id;
        $syllabus->delete();
        
        // Reorder remaining syllabi in the same subject
        $remainingIds = Syllabus::where('subject_id', $subjectId)
            ->orderBy('ordering')
            ->pluck('id')
            ->toArray();
        $this->updateOrdering($remainingIds);
        
        // Clear cache
        unset($this->syllabusCache[$id]);
    }

    public function getSyllabusById(int $id): Syllabus
    {
        return $this->syllabusCache[$id] ??= Syllabus::with(['subject.program'])->findOrFail($id);
    }

    public function getBySubject(int $subjectId, ?int $perPage = null)
    {
        $query = Syllabus::with(['subject.program'])
            ->where('subject_id', $subjectId)
            ->orderBy('ordering');

        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public function search(string $search, ?int $perPage = null)
    {
        $query = Syllabus::with(['subject.program'])
            ->where(function ($q) use ($search) {
                $q->where('lesson_number', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%')
                  ->orWhere('objectives', 'like', '%' . $search . '%')
                  ->orWhereHas('subject', function ($subjectQuery) use ($search) {
                      $subjectQuery->where('name', 'like', '%' . $search . '%')
                                  ->orWhere('code', 'like', '%' . $search . '%');
                  });
            })
            ->orderBy('ordering');

        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public function updateOrdering(array $orderedIds): void
    {
        foreach ($orderedIds as $index => $id) {
            Syllabus::where('id', $id)->update(['ordering' => $index + 1]);
        }
    }
}
