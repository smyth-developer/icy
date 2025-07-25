<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\LocationRepositoryInterface;
use App\Models\Location;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class LocationRepository implements LocationRepositoryInterface
{
    protected array $locationCache = [];

    protected function prepareDataBeforeCreate(array $data): array
    {
        $data['name'] = ucwords(strtolower(trim($data['name'])));
        $data['address'] = ucwords(strtolower(trim($data['address'])));
        $data['created_by'] = $data['created_by'] ?? Auth::id();
        return $data;
    }

    protected function prepareDataBeforeUpdate(array $data): array
    {
        $data['name'] = ucwords(strtolower(trim($data['name'])));
        $data['address'] = ucwords(strtolower(trim($data['address'])));
        $data['created_by'] = $data['created_by'] ?? Auth::id();
        return $data;
    }

    public function getLocationById(int $id): ?Location
    {
        return $this->locationCache[$id] ??= Location::with('createdBy')->findOrFail($id);
    }

    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return Location::with('createdBy')->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function create(array $data)
    {
        return Location::create($this->prepareDataBeforeCreate($data));
    }

    public function update(int $id, array $data)
    {
        $location = $this->getLocationById($id);
        $location->update($this->prepareDataBeforeUpdate($data));
        return $location;
    }

    public function delete(int $id)
    {
        return $this->getLocationById($id)->delete();
    }

    public function showName(string $name): string
    {
        return Location::where('name', $name)->value('name');
    }
}
