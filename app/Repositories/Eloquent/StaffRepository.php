<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\StaffRepositoryInterface;

class StaffRepository implements StaffRepositoryInterface
{
    public function getAllStaffsPendingOfLocation()
    {
        $locations = app(UserRepositoryInterface::class)->getCurrentUserLocations();
        if ($locations->isEmpty()) {
            return collect();
        }
        $staffOfLocations = User::with(['locations', 'roles'])
            ->whereHas('locations', function ($query) use ($locations) {
                $query->whereIn('locations.id', $locations->pluck('id'));
            })
            ->where('status', 'pending')
            ->whereHas('roles', function ($query) {
                $query->whereNotIn('name', ['student']);
            })
            ->get()
            ->sortBy(function ($user) {
                return [
                    $user->locations->pluck('id')->first(),
                    $user->roles->pluck('id')->first(),
                ];
            });
        return $staffOfLocations;
    }

    public function getStaffsOfLocationWithFilters(array $filters = [])
    {
        $locations = app(UserRepositoryInterface::class)->getCurrentUserLocations();
        if ($locations->isEmpty()) {
            return collect();
        }

        $query = User::with(['locations', 'roles', 'detail'])
            ->whereHas('roles', function ($q) {
                $q->whereNotIn('name', ['student','BOD']);
            })
            ->whereHas('locations', function ($q) use ($locations) {
                $q->whereIn('locations.id', $locations->pluck('id'));
            });

        if (!empty($filters['location_id'])) {
            $query->whereHas('locations', function ($q) use ($filters) {
                $q->where('locations.id', $filters['location_id']);
            });
        }

        if (!empty($filters['role_id'])) {
            $query->whereHas('roles', function ($q) use ($filters) {
                $q->where('roles.id', $filters['role_id']);
            });
        }

        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('account_code', 'like', "%{$search}%");
            });
        }

        return $query->get()->sortBy(function ($user) {
            return [
                $user->locations->pluck('id')->first(),
                $user->roles->pluck('id')->first(),
            ];
        });
    }

}