<?php
namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function getAll();
    public function getCurrentUserLocations();
    public function getUserById(int $id);
    public function getStudentsOfLocation();
    public function searchStudents(string $searchTerm, int $limit = 10);

    public function create(array $data);
    public function delete(int $id);
    public function update(int $id, array $data);
}
