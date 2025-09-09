<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\ProgramLocationPriceRepositoryInterface;
use App\Models\ProgramLocationPrice;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProgramLocationPriceRepository implements ProgramLocationPriceRepositoryInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return ProgramLocationPrice::with(['program', 'location'])
            ->orderBy('program_id')
            ->orderBy('location_id')
            ->paginate($perPage);
    }

    public function getByProgramAndLocation(int $programId, int $locationId)
    {
        return ProgramLocationPrice::where('program_id', $programId)
            ->where('location_id', $locationId)
            ->first();
    }

    public function getPriceByProgramAndLocation(int $programId, int $locationId)
    {
        return ProgramLocationPrice::where('program_id', $programId)
            ->where('location_id', $locationId)
            ->first();
    }

    public function create(array $data)
    {
        return ProgramLocationPrice::create($data);
    }

    public function update(int $id, array $data)
    {
        $price = ProgramLocationPrice::findOrFail($id);
        $price->update($data);
        return $price;
    }

    public function delete(int $id): bool
    {
        try {
            $price = ProgramLocationPrice::findOrFail($id);
            $price->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function bulkUpdate(array $prices): bool
    {
        try {
            DB::beginTransaction();
            
            foreach ($prices as $priceData) {
                if (isset($priceData['id']) && isset($priceData['price'])) {
                    $this->update($priceData['id'], ['price' => $priceData['price']]);
                }
            }
            
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function getPricesWithProgramsAndLocations()
    {
        return ProgramLocationPrice::with(['program', 'location'])
            ->orderBy('program_id')
            ->orderBy('location_id')
            ->get();
    }
}
