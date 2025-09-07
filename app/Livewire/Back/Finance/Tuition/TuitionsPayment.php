<?php

namespace App\Livewire\Back\Finance\Tuition;

use Livewire\Component;
use App\Repositories\Contracts\ProgramRepositoryInterface;

class TuitionsPayment extends Component
{
    // Search
    public $searchProgram = '';
    public $programs = [];
    public $filteredPrograms = [];
    
    // Selected items
    public $selectedItems = [];
    
    // Payment
    public $totalAmount = 0;
    public $discountAmount = 0;
    public $discountType = 'vnd'; // 'vnd' or 'percent'
    public $finalAmount = 0;
    public $note = '';
    public $paymentMethod = 'cash';

    public function mount()
    {
        $this->loadPrograms();
    }

    public function loadPrograms()
    {
        $this->programs = app(ProgramRepositoryInterface::class)->getAllPrograms()->toArray();
        $this->filteredPrograms = $this->programs;
    }

    public function updatedSearchProgram()
    {
        if (empty($this->searchProgram)) {
            $this->filteredPrograms = $this->programs;
        } else {
            $this->filteredPrograms = array_filter($this->programs, function($program) {
                return stripos($program['name'], $this->searchProgram) !== false;
            });
        }
    }

    public function addProgram($programId)
    {
        $program = collect($this->programs)->firstWhere('id', $programId);
        if ($program) {
            $existingIndex = $this->getProgramIndex($programId);
            if ($existingIndex !== false) {
                // Tăng số lượng nếu đã tồn tại
                $this->selectedItems[$existingIndex]['quantity']++;
            } else {
                // Thêm mới nếu chưa tồn tại
                $this->selectedItems[] = [
                    'id' => $program['id'],
                    'name' => $program['name'],
                    'price' => $program['price'],
                    'quantity' => 1,
                    'type' => 'program'
                ];
            }
            $this->calculateTotal();
        }
    }

    public function removeItem($index)
    {
        if (isset($this->selectedItems[$index])) {
            unset($this->selectedItems[$index]);
            $this->selectedItems = array_values($this->selectedItems);
            $this->calculateTotal();
        }
    }

    public function getProgramIndex($programId)
    {
        foreach ($this->selectedItems as $index => $item) {
            if ($item['id'] == $programId && $item['type'] == 'program') {
                return $index;
            }
        }
        return false;
    }

    public function isProgramSelected($programId)
    {
        return $this->getProgramIndex($programId) !== false;
    }

    public function increaseQuantity($index)
    {
        if (isset($this->selectedItems[$index])) {
            $this->selectedItems[$index]['quantity']++;
            $this->calculateTotal();
        }
    }

    public function decreaseQuantity($index)
    {
        if (isset($this->selectedItems[$index])) {
            if ($this->selectedItems[$index]['quantity'] > 1) {
                $this->selectedItems[$index]['quantity']--;
            } else {
                // Xóa item nếu số lượng = 1
                $this->removeItem($index);
                return;
            }
            $this->calculateTotal();
        }
    }

    public function calculateTotal()
    {
        $this->totalAmount = 0;
        foreach ($this->selectedItems as $item) {
            $this->totalAmount += $item['price'] * $item['quantity'];
        }
        
        if ($this->discountType === 'percent') {
            // Tính giảm giá theo phần trăm
            $discountValue = ($this->totalAmount * $this->discountAmount) / 100;
            $this->finalAmount = $this->totalAmount - $discountValue;
        } else {
            // Tính giảm giá theo VNĐ
            $this->finalAmount = $this->totalAmount - $this->discountAmount;
        }
    }

    public function updatedDiscountAmount()
    {
        $this->calculateTotal();
    }

    public function updatedDiscountType()
    {
        // Reset discount amount khi thay đổi loại giảm giá
        $this->discountAmount = 0;
        $this->calculateTotal();
    }

    public function processPayment()
    {
        // Logic xử lý thanh toán sẽ được thêm sau
        $this->dispatch('payment-processed');
    }

    public function render()
    {
        return view('livewire.back.finance.tuition.tuitions-payment');
    }
}