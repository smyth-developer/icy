<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\StudentRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StudentRepository implements StudentRepositoryInterface
{
    public function prepareStudentData(array $data)
    {
        $data['name'] = ucwords(trim($data['name']));
        return $data;
    }

    public function getCurrentStudentLocations()
    {
        $user = Auth::user();
        if (!$user) {
            return collect();
        }
        return $user->locations;
    }

    public function getAllStudentsPendingOfLocation()
    {
        $locations = $this->getCurrentStudentLocations();
        if ($locations->isEmpty()) {
            return collect();
        }

        $studentOfLocations = User::with(['locations', 'roles'])
            ->whereHas('locations', function ($query) use ($locations) {
                $query->whereIn('locations.id', $locations->pluck('id'));
            })
            ->where('status', 'pending')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'student');
            })
            ->get()
            ->sortBy(function ($user) {
                return [
                    $user->locations->pluck('id')->first(),
                    $user->roles->pluck('id')->first(),
                ];
            });

        return $studentOfLocations;
    }

    public function getStudentById(int $id)
    {
        return User::find($id);
    }

    public function createStudent(array $data)
    {
        $data = $this->prepareStudentData($data);
        return User::create($data);
    }
}


