<?php

namespace App\Livewire\Back\Management\Season;

use Livewire\Component;
use Livewire\Attributes\On;
use Flux\Flux;
use App\Support\Validation\SeasonRules;
use App\Repositories\Contracts\SeasonRepositoryInterface;
use App\Support\Season\SeasonHelper;
use Illuminate\Support\Facades\Auth;

class ActionsSeason extends Component
{
    public $seasonId;
    public $name, $code, $start_date, $end_date, $status, $note;
    public $years = [];
    public $yearModal;
    public $seasonModal;
    public $isEditSeasonMode = false;

    public function rules()
    {
        return SeasonRules::rules($this->seasonId);
    }

    public function messages()
    {
        return SeasonRules::messages();
    }

    #[On('add-season')]
    public function addSeason()
    {
        $this->resetErrorBag();
        $this->reset(['seasonId', 'name', 'code', 'start_date', 'end_date', 'status', 'note']);
        $this->isEditSeasonMode = false;
        $this->handleChange();
        Flux::modal('modal-season')->show();
    }

    public function createSeason()
    {
        $this->seasonId = null;
        $this->validate();
        app(SeasonRepositoryInterface::class)->create([
            'name' => $this->name,
            'code' => $this->code,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => SeasonHelper::getSeasonStatus($this->start_date, $this->end_date),
            'note' => $this->note,
        ]);

        session()->flash('success', 'Học kỳ đã được thêm thành công.');
        $this->reset([
            'seasonId',
            'name',
            'code',
            'start_date',
            'end_date',
            'status',
            'note'
        ]);
        Flux::modal('modal-season')->close();

        $this->redirectRoute('admin.management.seasons', navigate: true);
    }

    #[On('edit-season')]
    public function editSeason($id)
    {
        $this->resetErrorBag();
        $this->seasonId = $id;
        $season = app(SeasonRepositoryInterface::class)->getSeasonById($id);
        $this->name = $season->name;
        $this->code = $season->code;
        $this->start_date = $season->formatted_start_date;
        $this->end_date = $season->formatted_end_date;
        $this->status = $season->status;
        $this->note = $season->note;
        $this->yearModal = 2000 + (int) substr($season->code, 2);
        $this->seasonModal = substr($season->code, 0, 2);
        $this->isEditSeasonMode = true;
        Flux::modal('modal-season')->show();
    }

    public function updateSeason()
    {
        $this->validate();

        if(!$this->note) {
            $this->note = Auth::user()->name . ' đã cập nhật học kỳ này vào ngày '. now()->format('Y-m-d') .'.';
        }

        app(SeasonRepositoryInterface::class)->update($this->seasonId, [
            'name' => $this->name,
            'code' => $this->code,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => SeasonHelper::getSeasonStatus($this->start_date, $this->end_date),
            'note' => $this->note,
        ]);

        session()->flash('success', 'Học kỳ đã được cập nhật thành công.');
        Flux::modal('modal-season')->close();
        $this->redirectRoute('admin.management.seasons', navigate: true);
    }

    #[On('delete-season')]
    public function deleteSeason($id)
    {
        $this->seasonId = $id;
        Flux::modal('delete-season')->show();
    }

    public function deleteSeasonConfirm()
    {
        $delete = app(SeasonRepositoryInterface::class)->delete($this->seasonId);
        if ($delete) {
            session()->flash('success', 'Học kỳ đã được xóa thành công.');
        } else {
            session()->flash('error', 'Học kỳ đã được xóa thành công.');
        }
        Flux::modal('delete-season')->close();
        $this->redirectRoute('admin.management.seasons', navigate: true);
    }

    public function mount()
    {
        $current = now()->year;
        $this->years = range($current, $current + 1);
        $this->yearModal = $current;
        $this->seasonModal = SeasonHelper::getCurrentSeason();
        $this->handleChange();
    }

    public function handleChange()
    {
        $seasonDates = SeasonHelper::getSeasonDate($this->seasonModal, $this->yearModal);

        $this->start_date = $seasonDates['start_date'];
        $this->end_date = $seasonDates['end_date'];
        $data = SeasonHelper::getSeasonNameAndCode($this->yearModal, $this->seasonModal);
        $this->code = $data['code'];
        $this->name = $data['name'];
    }

    public function render()
    {
        return view('livewire.back.management.season.actions-season');
    }
}
