<?php

namespace App\Livewire\Back\Finance\Tuition;

use Livewire\Component;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\SeasonRepositoryInterface;
use App\Repositories\Contracts\ProgramRepositoryInterface;
use App\Repositories\Contracts\TuitionRepositoryInterface;
use Livewire\Attributes\Title;

#[Title('Lịch sử đóng học phí')]
class TuitionsHistory extends Component
{
    public $tuitions = [];
    public $search = '';
    public $filterLocationId = null;
    public $filterProgramId = null;
    public $filterSeasonId = null;
    public $filterPaymentMethod = null;
    public $filterMonth = null;

    public function mount()
    {
        $this->loadTuitions();
    }

    public function updatedSearch()
    {
        $this->loadTuitions();
    }

    public function updatedFilterLocationId()
    {
        $this->loadTuitions();
    }

    public function updatedFilterProgramId()
    {
        $this->loadTuitions();
    }

    public function updatedFilterSeasonId()
    {
        $this->loadTuitions();
    }

    public function updatedFilterPaymentMethod()
    {
        $this->loadTuitions();
    }

    public function updatedFilterMonth()
    {
        $this->loadTuitions();
    }

    public function loadTuitions()
    {
        $filters = [
            'search' => $this->search,
            'location_id' => $this->filterLocationId,
            'program_id' => $this->filterProgramId,
            'season_id' => $this->filterSeasonId,
            'payment_method' => $this->filterPaymentMethod,
            'month' => $this->filterMonth,
        ];

        $this->tuitions = app(TuitionRepositoryInterface::class)->getTuitionsWithFilters($filters);
    }

    public function addTuition()
    {
        session()->flash('success', 'Cập nhật cơ sở thành công.');
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->filterLocationId = null;
        $this->filterProgramId = null;
        $this->filterSeasonId = null;
        $this->filterPaymentMethod = null;
        $this->filterMonth = null;
        $this->loadTuitions();
    }
    public function render()
    {
        $locations = app(UserRepositoryInterface::class)->getCurrentUserLocations();
        $programs = app(ProgramRepositoryInterface::class)->getAllPrograms();
        $seasons = app(SeasonRepositoryInterface::class)->getAllSeasons();
        return view('livewire.back.finance.tuition.tuitions-history',[
            'tuitions' => $this->tuitions,
            'locations' => $locations,
            'programs' => $programs,
            'seasons' => $seasons,
        ]);
    }
}
