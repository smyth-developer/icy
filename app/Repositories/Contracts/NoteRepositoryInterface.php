<?php
namespace App\Repositories\Contracts;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface NoteRepositoryInterface
{
    public function getAll(int $perPage): LengthAwarePaginator;
    public function getNoteById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
