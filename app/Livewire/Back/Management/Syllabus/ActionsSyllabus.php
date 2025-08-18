<?php

namespace App\Livewire\Back\Management\Syllabus;

use App\Repositories\Contracts\SyllabusRepositoryInterface;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use App\Support\Validation\SyllabusRules;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Flux\Flux;

class ActionsSyllabus extends Component
{
    use WithFileUploads;

    public $syllabusId;
    public $subject_id;
    public $lesson_number;
    public $content;
    public $objectives;
    public $vocabulary;
    public $assignment;
    public $student_task;
    public $lecturer_task;
    public $lecture_slide;
    public $audio_file;
    public $ordering;

    public $isEditing = false;

    protected SyllabusRepositoryInterface $syllabusRepository;

    public function boot(SyllabusRepositoryInterface $syllabusRepository)
    {
        $this->syllabusRepository = $syllabusRepository;
    }

    protected function rules()
    {
        return SyllabusRules::rules($this->syllabusId);
    }

    protected function messages()
    {
        return SyllabusRules::messages();
    }

    protected function attributes()
    {
        return SyllabusRules::attributes();
    }

    #[On('add-syllabus')]
    public function addSyllabus()
    {
        $this->resetErrorBag();
        $this->reset(['syllabusId', 'subject_id', 'lesson_number', 'content', 'objectives', 'vocabulary', 'assignment', 'student_task', 'lecturer_task', 'lecture_slide', 'audio_file', 'ordering']);
        $this->isEditing = false;
        Flux::modal('modal-syllabus')->show();
    }

    public function createSyllabus()
    {
        $this->validate();
        
        $this->syllabusRepository->create([
            'subject_id' => $this->subject_id,
            'lesson_number' => $this->lesson_number,
            'content' => $this->content,
            'objectives' => $this->objectives,
            'vocabulary' => $this->vocabulary,
            'assignment' => $this->assignment,
            'student_task' => $this->student_task,
            'lecturer_task' => $this->lecturer_task,
            'lecture_slide' => $this->lecture_slide,
            'audio_file' => $this->audio_file,
            'ordering' => $this->ordering,
        ]);

        session()->flash('message', 'Syllabus đã được tạo thành công!');
        $this->reset(['syllabusId', 'subject_id', 'lesson_number', 'content', 'objectives', 'vocabulary', 'assignment', 'student_task', 'lecturer_task', 'lecture_slide', 'audio_file', 'ordering']);
        Flux::modal('modal-syllabus')->close();
        
        $this->dispatch('syllabus-saved');
    }

    #[On('edit-syllabus')]
    public function editSyllabus($syllabusId)
    {
        $this->resetErrorBag();
        $this->syllabusId = $syllabusId;
        $this->loadSyllabus();
        $this->isEditing = true;
        Flux::modal('modal-syllabus')->show();
    }

    public function updateSyllabus()
    {
        $this->validate();
        
        $this->syllabusRepository->update($this->syllabusId, [
            'subject_id' => $this->subject_id,
            'lesson_number' => $this->lesson_number,
            'content' => $this->content,
            'objectives' => $this->objectives,
            'vocabulary' => $this->vocabulary,
            'assignment' => $this->assignment,
            'student_task' => $this->student_task,
            'lecturer_task' => $this->lecturer_task,
            'lecture_slide' => $this->lecture_slide,
            'audio_file' => $this->audio_file,
            'ordering' => $this->ordering,
        ]);

        session()->flash('message', 'Syllabus đã được cập nhật thành công!');
        $this->reset(['syllabusId', 'subject_id', 'lesson_number', 'content', 'objectives', 'vocabulary', 'assignment', 'student_task', 'lecturer_task', 'lecture_slide', 'audio_file', 'ordering']);
        Flux::modal('modal-syllabus')->close();
        
        $this->dispatch('syllabus-saved');
    }

    public function loadSyllabus()
    {
        $syllabus = $this->syllabusRepository->getSyllabusById($this->syllabusId);
        $this->subject_id = $syllabus->subject_id;
        $this->lesson_number = $syllabus->lesson_number;
        $this->content = $syllabus->content;
        $this->objectives = $syllabus->objectives;
        $this->vocabulary = $syllabus->vocabulary;
        $this->assignment = $syllabus->assignment;
        $this->student_task = $syllabus->student_task;
        $this->lecturer_task = $syllabus->lecturer_task;
        $this->lecture_slide = $syllabus->lecture_slide;
        $this->audio_file = $syllabus->audio_file;
        $this->ordering = $syllabus->ordering;
    }



    public function render()
    {
        $subjects = app(SubjectRepositoryInterface::class)->getAll();

        return view('livewire.back.management.syllabus.actions-syllabus', [
            'subjects' => $subjects,
        ]);
    }
}
