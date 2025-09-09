<?php

namespace App\Livewire\Back\Management\Program;

use Livewire\Component;
use Livewire\Attributes\On;
use Flux\Flux;
use App\Repositories\Contracts\ProgramRepositoryInterface;
use App\Support\Validation\ProgramRules;


class ActionsProgram extends Component
{

    public $programId;
    public $name;
    public $english_name;
    public $description;
    public $isEditProgramMode = false;

    public function resetForm()
    {
        $this->reset(['programId', 'name', 'english_name', 'description']);
        $this->isEditProgramMode = false;
    }

    #[On('add-program')]
    public function addProgram()
    {
        $this->resetForm();
        Flux::modal('modal-program')->show();
    }

    public function createProgram()
    {
        $this->validate();
        app(ProgramRepositoryInterface::class)->create([
            'name' => $this->name,
            'description' => $this->description,
            'english_name' => $this->english_name,
        ]);
        session()->flash('success', 'Thêm chương trình học thành công.');
        Flux::modal('modal-program')->close();
        $this->redirectRoute('admin.management.programs', navigate: true);
    }

    #[On('edit-program')]
    public function editProgram($id)
    {
        $this->resetForm();
        $program = app(ProgramRepositoryInterface::class)->getProgramById($id);
        $this->programId = $program->id;
        $this->name = $program->name;
        $this->english_name = $program->english_name;
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
            'english_name' => $this->english_name,
        ]);
        session()->flash('success', 'Cập nhật chương trình học thành công.');
        Flux::modal('modal-program')->close();
        $this->redirectRoute('admin.management.programs', navigate: true);
    }

    #[On('delete-program')]
    public function deleteProgram($id)
    {
        $this->resetForm();
        $this->programId = $id;
        Flux::modal('delete-program')->show();
    }

    public function deleteProgramConfirm()
    {
        $program = app(ProgramRepositoryInterface::class)->getProgramById($this->programId);
        
        // Kiểm tra xem có môn học nào đang sử dụng chương trình này không
        if ($program->subjects()->count() > 0) {
            session()->flash('error', 'Không thể xóa chương trình học này vì có môn học đang sử dụng.');
            Flux::modal('delete-program')->close();
            return;
        }

        $delete = app(ProgramRepositoryInterface::class)->delete($this->programId);
        if ($delete) {
            session()->flash('success', 'Xoá chương trình học thành công.');
            $this->redirectRoute('admin.management.programs', navigate: true);
        } else {
            session()->flash('error', 'Xoá chương trình học thất bại.');
        }

        $this->reset(['programId']);
        Flux::modal('delete-program')->close();
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
