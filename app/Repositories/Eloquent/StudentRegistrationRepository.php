<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\StudentRegistrationRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StudentRegistrationRepository implements StudentRegistrationRepositoryInterface
{

    public function prepareStudentData(array $data)
    {
        $data['name'] = ucwords(trim($data['name']));
       
        return $data;
    }

    public function getCurrentUserLocations()
    {
        $user = Auth::user();
        if (!$user) {
            return collect();
        }
        return $user->locations; //lấy tất cả locations của user
    }

    public function getAllStudentsPendingOfLocation()
    {
        $locations = $this->getCurrentUserLocations();
        
        // Nếu user không có locations hoặc chưa đăng nhập
        if ($locations->isEmpty()) {
            return collect();
        }

        $studentOfLocations = User::with(['locations', 'roles'])
            ->whereHas('locations', function ($query) use ($locations) {
                $query->whereIn('locations.id', $locations->pluck('id'));
            })//lấy tất cả users có locations trong locations
            ->where('status', 'pending') //lấy tất cả users có status là pending
            ->whereHas('roles', function ($query) {
                $query->where('name', 'student');
            }) //lấy tất cả users có role là student
            ->get()
            ->sortBy(function ($user) {
                return [
                    $user->locations->pluck('id')->first(),
                    $user->roles->pluck('id')->first(),
                ]; //sắp xếp theo locations và roles
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