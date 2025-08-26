<?php

namespace App\Livewire\Back\Finance\Bank;

use Livewire\Component;
use Livewire\WithPagination;

use App\Repositories\Contracts\BankRepositoryInterface;
use Livewire\Attributes\Title;

#[Title('Tài khoản ngân hàng')]
class AccountsBank extends Component
{
    use WithPagination;

    public function addBank()
    {
        $this->dispatch('add-bank');
    }

    public function editBank($id)
    {
        $this->dispatch('edit-bank', $id);
    }

    public function deleteBank($id)
    {
        $this->dispatch('delete-bank', $id);
    }

    public function render()
    {
        $banks = app(BankRepositoryInterface::class)->paginate(10);
        return view('livewire.back.finance.bank.accounts-bank', compact('banks'));
    }
}
