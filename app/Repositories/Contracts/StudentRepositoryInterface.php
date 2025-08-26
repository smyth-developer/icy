<?php

namespace App\Repositories\Contracts;

interface StudentRepositoryInterface
{
    public function getCurrentStudentLocations();
    public function getAllStudentsPendingOfLocation();
    public function getStudentById(int $id);
    public function createStudent(array $data);
}


