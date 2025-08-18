<?php

namespace App\Repositories\Contracts;
//use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface StudentRegistrationRepositoryInterface
{
    public function getCurrentUserLocations();
    public function getAllStudentsPendingOfLocation();
    public function getStudentById(int $id);
    public function createStudent(array $data);
}