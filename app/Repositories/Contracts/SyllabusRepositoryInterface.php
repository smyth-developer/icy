<?php

namespace App\Repositories\Contracts;

interface SyllabusRepositoryInterface
{
    public function getAll(?int $perPage = null);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getSyllabusById(int $id);
    public function getBySubject(int $subjectId, ?int $perPage = null);
    public function search(string $search, ?int $perPage = null);
    public function updateOrdering(array $orderedIds);
}
