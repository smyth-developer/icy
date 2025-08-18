<div>
    <!-- Modal Trigger Button -->
    <flux:button wire:click="addSyllabus" icon="plus-circle" class="cursor-pointer">
        Thêm Syllabus mới
    </flux:button>

    <!-- Create and Update Syllabus Modal -->
    <flux:modal :dismissible="false" name="modal-syllabus" class="md:w-900">
        <form wire:submit='{{ $isEditing ? "updateSyllabus" : "createSyllabus" }}' class="space-y-6">
            <div>
                <flux:heading class="font-bold" size="lg">
                    {{ $isEditing ? 'Cập nhật Syllabus' : 'Tạo mới Syllabus' }}
                </flux:heading>
                <flux:text class="mt-2">
                    {{ $isEditing ? 'Chỉnh sửa thông tin syllabus' : 'Thêm mới syllabus' }}.
                </flux:text>
            </div>

            @if ($isEditing)
                <input type="text" wire:model='syllabusId' hidden />
            @endif

            <div class="form-group">
                <flux:select 
                    wire:model="subject_id" 
                    label="Môn học"
                    placeholder="Chọn môn học"
                >
                    <option value="">Chọn môn học</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">
                            {{ $subject->name }} ({{ $subject->code }})
                        </option>
                    @endforeach
                </flux:select>
            </div>

            <div class="flex gap-4">
                <div class="form-group w-1/2">
                    <flux:input 
                        wire:model="lesson_number" 
                        label="Số bài học"
                        placeholder="VD: Bài 1, Lesson 1..."
                    />
                </div>

                <div class="form-group w-1/2">
                    <flux:input 
                        wire:model="ordering" 
                        label="Thứ tự"
                        type="number"
                        min="1"
                        placeholder="1, 2, 3..."
                    />
                </div>
            </div>

            <div class="form-group">
                <flux:textarea 
                    wire:model="content" 
                    label="Nội dung"
                    rows="4"
                    placeholder="Nhập nội dung bài học..."
                />
            </div>

            <div class="form-group">
                <flux:textarea 
                    wire:model="objectives" 
                    label="Mục tiêu"
                    rows="3"
                    placeholder="Nhập mục tiêu bài học..."
                />
            </div>

            <div class="form-group">
                <flux:textarea 
                    wire:model="vocabulary" 
                    label="Từ vựng"
                    rows="3"
                    placeholder="Nhập từ vựng..."
                />
            </div>

            <div class="form-group">
                <flux:textarea 
                    wire:model="assignment" 
                    label="Bài tập"
                    rows="3"
                    placeholder="Nhập bài tập..."
                />
            </div>

            <div class="flex gap-4">
                <div class="form-group w-1/2">
                    <flux:textarea 
                        wire:model="student_task" 
                        label="Nhiệm vụ học sinh"
                        rows="3"
                        placeholder="Nhiệm vụ cho học sinh..."
                    />
                </div>

                <div class="form-group w-1/2">
                    <flux:textarea 
                        wire:model="lecturer_task" 
                        label="Nhiệm vụ giảng viên"
                        rows="3"
                        placeholder="Nhiệm vụ cho giảng viên..."
                    />
                </div>
            </div>

            <div class="flex gap-4">
                <div class="form-group w-1/2">
                    <flux:input 
                        wire:model="lecture_slide" 
                        label="Slide bài giảng"
                        placeholder="Link hoặc tên file slide..."
                    />
                </div>

                <div class="form-group w-1/2">
                    <flux:input 
                        wire:model="audio_file" 
                        label="File âm thanh"
                        placeholder="Link hoặc tên file âm thanh..."
                    />
                </div>
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" class="cursor-pointer" variant="primary">
                    {{ $isEditing ? 'Cập nhật' : 'Thêm mới' }}
                </flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Listen for edit events -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('edit-syllabus', (event) => {
                @this.editSyllabus(event.syllabusId);
            });
        });
    </script>
</div>
