<?php

namespace App\Livewire\Back\Finance\Bank;

use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Support\Bank\BankHelper;
use App\Support\Validation\BankRules;
use App\Repositories\Contracts\BankRepositoryInterface;

class ActionsAccountBank extends Component
{
    public $bankId;
    public $bank_name;
    public $account_number;
    public $account_name;
    public $status = 'active';
    public $description;
    public $isEditMode = false;

    public function rules()
    {
        return BankRules::rules($this->bankId);
    }

    public function messages()
    {
        return BankRules::messages();
    }

    #[On('add-bank')]
    public function addBank()
    {
        $this->resetErrorBag();
        $this->reset(['bankId','bank_name','account_number','account_name','status','description']);
        $this->status = 'active';
        $this->isEditMode = false;
        Flux::modal('modal-bank')->show();
    }

    public function createBank()
    {
        $this->bankId = null;
        $this->validate();
        app(BankRepositoryInterface::class)->create([
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'account_name' => $this->account_name,
            'status' => $this->status,
            'description' => $this->description,
        ]);
        session()->flash('success', 'Tạo tài khoản ngân hàng thành công.');
        $this->reset(['bankId','bank_name','account_number','account_name','status','description']);
        Flux::modal('modal-bank')->close();
        $this->redirectRoute('admin.finance.bank-accounts', navigate: true);
    }

    #[On('edit-bank')]
    public function editBank($id)
    {
        $this->resetErrorBag();
        $this->bankId = $id;
        $bank = app(BankRepositoryInterface::class)->getById($id);
        $this->bank_name = $bank->bank_name;
        $this->account_number = $bank->account_number;
        $this->account_name = $bank->account_name;
        $this->status = $bank->status;
        $this->description = $bank->description;
        $this->isEditMode = true;
        Flux::modal('modal-bank')->show();
    }

    public function updateBank()
    {
        $this->validate();
        app(BankRepositoryInterface::class)->update($this->bankId, [
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'account_name' => $this->account_name,
            'status' => $this->status,
            'description' => $this->description,
        ]);
        session()->flash('success', 'Cập nhật tài khoản ngân hàng thành công.');
        Flux::modal('modal-bank')->close();
        $this->redirectRoute('admin.finance.bank-accounts', navigate: true);
    }

    #[On('delete-bank')]
    public function deleteBank($id)
    {
        $this->bankId = $id;
        Flux::modal('delete-bank')->show();
    }

    public function deleteBankConfirm()
    {
        app(BankRepositoryInterface::class)->delete($this->bankId);
        session()->flash('success', 'Xoá tài khoản ngân hàng thành công.');
        Flux::modal('delete-bank')->close();
        $this->redirectRoute('admin.finance.bank-accounts', navigate: true);
    }

    public function render()
    {
        $banks = BankHelper::getBanks();
        $listBank = collect($banks)->pluck('shortName')->toArray();
        
        return view('livewire.back.finance.bank.actions-account-bank',[
            'listBank' => $listBank,
        ]);
    }
}
