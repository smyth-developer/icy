<?php

namespace App\Repositories\Contracts;
//use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface StaffRepositoryInterface
{
    public function getAllStaffsPendingOfLocation();

    /**
     * Get staffs of current user's locations with optional filters.
     * @param array $filters ['location_id' => ?, 'role_id' => ?, 'search' => ?]
     */
    public function getStaffsOfLocationWithFilters(array $filters = []);

}