<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\NoteRepositoryInterface;
use App\Models\Note;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NoteRepository implements NoteRepositoryInterface
{
    protected function prepareData(array $data): array
    {
        $data['title'] = ucwords(strtolower(trim($data['title'])));
        $data['content'] = ucfirst(strtolower(trim($data['content'])));

        return $data;
    }
    public function getAll(int $perPage): LengthAwarePaginator
    {
        return Note::orderBy("created_at", "desc")->paginate($perPage);
    }

    public function create(array $data)
    {
        return Note::create($this->prepareData($data));
    }

    public function update(int $id, array $data)
    {
        $note = $this->getNoteById($id);
        $note->update($this->prepareData($data));
        return $note;
    }

    public function delete(int $id)
    {
        return $this->getNoteById($id)->delete();
    }

    public function getNoteById(int $id)
    {
        return Note::find($id);
    }
}
