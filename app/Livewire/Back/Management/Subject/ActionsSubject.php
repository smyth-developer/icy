<?php

namespace App\Livewire\Back\Management\Subject;

use Livewire\Component;
use Livewire\Attributes\On;
use Flux\Flux;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use App\Repositories\Contracts\ProgramRepositoryInterface;
use App\Support\Validation\SubjectRules;
use Throwable;


class ActionsSubject extends Component
{
    public $subjectId;
    public $name;
    public $code;
    public $description;
    public $program_id;
    public $isEditSubjectMode = false;

    #[On('add-subject')]
    public function addSubject()
    {
        $this->reset(['name', 'code', 'description', 'program_id', 'isEditSubjectMode']);
        Flux::modal('modal-subject')->show();
    }

    public function createSubject()
    {
        $this->validate();

        app(SubjectRepositoryInterface::class)->create([
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
        ], $this->program_id);

        session()->flash('success', 'Môn học đã được tạo thành công.');
        Flux::modal('modal-subject')->close();
        $this->dispatch('subject-created', $this->program_id);
        $this->reset(['name', 'code', 'description', 'program_id']);
    }

    #[On('edit-subject')]
    public function editSubject($subjectId)
    {
        $subject = app(SubjectRepositoryInterface::class)->getSubjectById($subjectId);
        $this->subjectId = $subject->id;
        $this->name = trim(str_replace('ICY', '', $subject->name));
        $this->code = $subject->code;
        $this->description = $subject->description;
        $this->program_id = $subject->program_id;
        $this->isEditSubjectMode = true;
        
        Flux::modal('modal-subject')->show();
    }

    public function updateSubject()
    {
        $this->validate();

        app(SubjectRepositoryInterface::class)->update($this->subjectId, [
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'program_id' => $this->program_id,
        ]);

        session()->flash('success', 'Môn học đã được cập nhật thành công.');
        Flux::modal('modal-subject')->close();
        $this->dispatch('subject-created', $this->program_id);
        $this->reset(['subjectId', 'name', 'code', 'description', 'program_id', 'isEditSubjectMode']);
    }

    #[On('delete-subject')]
    public function deleteSubject($subjectId)
    {
        $this->subjectId = $subjectId;
        Flux::modal('modal-delete-subject')->show();
    }

    public function deleteSubjectConfirm()
    {
        try {
            $subject = app(SubjectRepositoryInterface::class)->getSubjectById($this->subjectId);
            $programId = $subject->program_id;
            
            app(SubjectRepositoryInterface::class)->delete($this->subjectId);
            session()->flash('success', 'Xoá môn học thành công.');
            $this->reset(['subjectId']);
            $this->dispatch('subject-created', $programId);
        } catch (Throwable $e) {
            session()->flash('error', 'Đã có lỗi xảy ra. Vui lòng thử lại sau.');
            return;
        }
        Flux::modal('modal-delete-subject')->close();
    }

    public function rules()
    {
        return SubjectRules::rules($this->subjectId);
    }

    public function messages()
    {
        return SubjectRules::messages();
    }

    public function render()
    {
        $programs = app(ProgramRepositoryInterface::class)->getAll(100);
        return view('livewire.back.management.subject.actions-subject', [
            'programs' => $programs,
        ]);
    }
}
