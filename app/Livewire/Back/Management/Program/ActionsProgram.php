<?php

namespace App\Livewire\Back\Management\Program;

use Livewire\Component;
use Livewire\Attributes\On;
use Flux\Flux;
use App\Repositories\Contracts\ProgramRepositoryInterface;
use App\Support\Validation\ProgramRules;
use Throwable;

class ActionsProgram extends Component
{

    public $programId;
    public $name;
    public $description;
    public $isEditProgramMode = false;

    #[On('add-program')]
    public function addProgram()
    {
        $this->reset(['programId', 'name', 'description']);
        Flux::modal('modal-program')->show();
    }

    public function createProgram()
    {
        $this->validate();
        app(ProgramRepositoryInterface::class)->create([
            'name' => $this->name,
            'description' => $this->description,
        ]);
        $this->reset(['name', 'description', 'programId']);
        session()->flash('success', 'Thêm chương trình học thành công.');
        Flux::modal('modal-program')->close();
        $this->redirectRoute('management.programs', navigate: true);
    }

    #[On('edit-program')]
    public function editProgram($id)
    {
        $program = app(ProgramRepositoryInterface::class)->getProgramById($id);
        $this->programId = $program->id;
        $this->name = $program->name;
        $this->description = $program->description;
        $this->isEditProgramMode = true;
        Flux::modal('modal-program')->show();
    }

    public function updateProgram()
    {
        $this->validate();
        app(ProgramRepositoryInterface::class)->update($this->programId, [
            'name' => $this->name,
            'description' => $this->description,
        ]);
        session()->flash('success', 'Cập nhật chương trình học thành công.');
        Flux::modal('modal-program')->close();
        $this->redirectRoute('management.programs', navigate: true);
    }

    #[On('delete-program')]
    public function deleteProgram($id)
    {
        $this->programId = $id;
        Flux::modal('delete-program')->show();
    }

    public function deleteProgramConfirm()
    {
        try {
            app(ProgramRepositoryInterface::class)->delete($this->programId);
            session()->flash('success', 'Xoá chương trình học thành công.');
            $this->reset(['programId']);
        } catch (Throwable $e) {
            session()->flash('error', 'Đã có lỗi xảy ra. Vui lòng thử lại sau.');
            return;
        }
        Flux::modal('delete-program')->close();
        $this->redirectRoute('management.programs', navigate: true);
    }


    public function rules()
    {
        return ProgramRules::rules($this->programId);
    }

    public function messages()
    {
        return ProgramRules::messages();
    }

    public function render()
    {
        return view('livewire.back.management.program.actions-program');
    }
}
