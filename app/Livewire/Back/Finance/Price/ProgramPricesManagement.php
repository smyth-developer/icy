<?php

namespace App\Livewire\Back\Finance\Price;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Repositories\Contracts\ProgramLocationPriceRepositoryInterface;
use App\Repositories\Contracts\ProgramRepositoryInterface;
use App\Repositories\Contracts\LocationRepositoryInterface;

#[Title('Quản lý giá tiền chương trình')]
class ProgramPricesManagement extends Component
{
    use WithPagination;

    public $prices = [];
    public $editingPrices = [];
    public $newPrices = [];
    public $bulkUpdateMode = false;

    protected $rules = [
        'editingPrices.*.price' => 'required|numeric|min:0',
        'newPrices.*.*' => 'nullable|numeric|min:0',
    ];

    protected $messages = [
        'editingPrices.*.price.required' => 'Giá tiền không được để trống',
        'editingPrices.*.price.numeric' => 'Giá tiền phải là số',
        'editingPrices.*.price.min' => 'Giá tiền phải lớn hơn 0',
        'newPrices.*.*.numeric' => 'Giá tiền phải là số',
        'newPrices.*.*.min' => 'Giá tiền phải lớn hơn 0',
    ];

    public function mount()
    {
        $this->loadPrices();
    }

    public function loadPrices()
    {
        $this->prices = app(ProgramLocationPriceRepositoryInterface::class)
            ->getPricesWithProgramsAndLocations()
            ->toArray();
    }

    public function getFilteredPrices()
    {
        return collect($this->prices);
    }

    public function getPrograms()
    {
        return app(ProgramRepositoryInterface::class)->getAllPrograms();
    }

    public function getLocations()
    {
        return \App\Models\Location::all();
    }

    public function startProgramEdit($programId)
    {
        $programPrices = collect($this->prices)->where('program_id', $programId);

        foreach ($programPrices as $price) {
            $this->editingPrices[$price['id']] = [
                'id' => $price['id'],
                'price' => $price['price'],
                'program_name' => $price['program']['name'],
                'location_name' => $price['location']['name']
            ];
        }
    }

    public function cancelProgramEdit($programId)
    {
        $programPrices = collect($this->prices)->where('program_id', $programId);

        foreach ($programPrices as $price) {
            unset($this->editingPrices[$price['id']]);
        }

        // Clear new prices for this program
        unset($this->newPrices[$programId]);
    }

    public function saveProgramPrices($programId)
    {
        $programPrices = collect($this->prices)->where('program_id', $programId);

        // Validate existing prices
        foreach ($programPrices as $price) {
            if (isset($this->editingPrices[$price['id']])) {
                $this->validate([
                    "editingPrices.{$price['id']}.price" => 'required|numeric|min:0'
                ]);
            }
        }

        // Validate new prices
        if (isset($this->newPrices[$programId])) {
            foreach ($this->newPrices[$programId] as $locationId => $price) {
                if ($price !== null && $price !== '') {
                    $this->validate([
                        "newPrices.{$programId}.{$locationId}" => 'required|numeric|min:0'
                    ]);
                }
            }
        }

        try {
            $pricesToUpdate = [];
            $pricesToCreate = [];

            // Handle existing prices
            foreach ($programPrices as $price) {
                if (isset($this->editingPrices[$price['id']])) {
                    $pricesToUpdate[] = [
                        'id' => $price['id'],
                        'price' => $this->editingPrices[$price['id']]['price']
                    ];
                }
            }

            // Handle new prices
            if (isset($this->newPrices[$programId])) {
                foreach ($this->newPrices[$programId] as $locationId => $price) {
                    if ($price !== null && $price !== '') {
                        $pricesToCreate[] = [
                            'program_id' => $programId,
                            'location_id' => $locationId,
                            'price' => $price
                        ];
                    }
                }
            }

            // Update existing prices
            if (!empty($pricesToUpdate)) {
                app(ProgramLocationPriceRepositoryInterface::class)->bulkUpdate($pricesToUpdate);
            }

            // Create new prices
            if (!empty($pricesToCreate)) {
                foreach ($pricesToCreate as $priceData) {
                    \App\Models\ProgramLocationPrice::create($priceData);
                }
            }

            session()->flash('success', 'Cập nhật giá tiền chương trình thành công!');
            $this->loadPrices();
            $this->cancelProgramEdit($programId);
            $this->redirectRoute('admin.finance.program-prices', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Có lỗi xảy ra khi cập nhật giá tiền: ' . $e->getMessage());
        }
    }

    public function toggleBulkUpdate()
    {
        $this->bulkUpdateMode = !$this->bulkUpdateMode;
        if (!$this->bulkUpdateMode) {
            $this->editingPrices = [];
        }
    }

    public function startBulkEdit()
    {
        $this->editingPrices = [];
        foreach ($this->getFilteredPrices() as $price) {
            $this->editingPrices[$price['id']] = [
                'id' => $price['id'],
                'price' => $price['price'],
                'program_name' => $price['program']['name'],
                'location_name' => $price['location']['name']
            ];
        }
    }

    public function saveBulkPrices()
    {
        $this->validate();

        $pricesToUpdate = [];
        foreach ($this->editingPrices as $priceData) {
            $pricesToUpdate[] = [
                'id' => $priceData['id'],
                'price' => $priceData['price']
            ];
        }

        try {
            $success = app(ProgramLocationPriceRepositoryInterface::class)
                ->bulkUpdate($pricesToUpdate);

            if ($success) {
                session()->flash('success', 'Cập nhật hàng loạt thành công!');
                $this->loadPrices();
                $this->editingPrices = [];
                $this->bulkUpdateMode = false;
                $this->redirectRoute('admin.finance.program-prices', navigate: true);
            } else {
                session()->flash('error', 'Có lỗi xảy ra khi cập nhật hàng loạt!');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Có lỗi xảy ra khi cập nhật hàng loạt: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.back.finance.price.program-prices-management', [
            'filteredPrices' => $this->getFilteredPrices(),
            'programs' => $this->getPrograms(),
            'locations' => $this->getLocations(),
        ]);
    }
}
