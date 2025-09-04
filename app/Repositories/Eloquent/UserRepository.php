<?php
namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function getAll()
    {
        return User::all()->toArray();
    }

    public function getCurrentUserLocations()
    {
        $user = Auth::user();
        if (!$user) {
            return collect();
        }
        return $user->locations;
    }

    public function getUserById(int $id)
    {
        return User::find($id);
    }

    public function create(array $data)
    {

        $user = User::create($data['user']);
        $user->detail()->create($data['detail']);
        $user->locations()->attach($data['locations']);
        $roles = Role::whereIn('name', $data['roles'])->get();
        $user->roles()->attach($roles);
        //Tạo tài khoản người dùng
        return $user;
    }

    public function delete(int $id)
    {
        $user = User::find($id);
        $user->delete();
        return  $user->delete();
    }

    public function update(int $id, array $data)
    {
        $user = User::find($id);
        $user->update($data['user']);
        $user->detail()->update($data['detail']);
        $user->locations()->sync($data['locations']);

        return $user;
    }
}
