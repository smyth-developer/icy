<?php

namespace App\Repositories\Eloquent;

use App\Models\Bank;
use App\Support\Bank\BankHelper;
use App\Repositories\Contracts\BankRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BankRepository implements BankRepositoryInterface
{

    public function prepareData(array $data)
    {
        return [
            'bank_name' => trim($data['bank_name']),
            'bank_code' => BankHelper::getBankCode($data['bank_name']),
            'account_name' => BankHelper::nonAccent($data['account_name']),
            'account_number' => $data['account_number'],
            'status' => $data['status'],
            'description' => $data['description'],
        ];
    }

    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return Bank::query()->latest()->paginate($perPage);
    }

    public function getById(int $id)
    {
        return Bank::findOrFail($id);
    }

    public function getActiveBanks()
    {
        return Bank::where('status', 'active')->orderBy('bank_name')->get();
    }

    public function create(array $data)
    {
        $data = $this->prepareData($data);
        return Bank::create($data);
    }

    public function update(int $id, array $data)
    {
        $bank = $this->getById($id);
        $bank->update($this->prepareData($data));
        return $bank;
    }

    public function delete(int $id): bool
    {
        $bank = $this->getById($id);
        return (bool) $bank->delete();
    }
}
