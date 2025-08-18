<?php

namespace App\Livewire\Back\Personnel\Registration;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Flux\Flux;
use App\Models\User;
use App\Support\Validation\UserRules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Support\User\UserHelper;
use App\Repositories\Contracts\StudentRegistrationRepositoryInterface;

class ActionsStudentRegistration extends Component
{
    use WithFileUploads;

    public $studentId;
    public $isEditStudentMode = false;

    // User fields
    public $name, $email, $username, $password, $account_code, $id_card;

    // UserDetail fields  
    public $phone, $address, $birthday, $avatar;

    // File upload
    public $avatarFile;

    public function rules()
    {
        // Get base user rules
        $userRules = UserRules::rules($this->studentId);
        
        // Get user detail rules
        $detailRules = UserRules::detailRules();
        

        return array_merge($userRules, $detailRules);
    }

    public function messages()
    {
        return UserRules::messages();
    }

    #[On('add-student')]
    public function addStudent()
    {
        $this->resetErrorBag();
        $this->reset(['studentId', 'name', 'email', 'username', 'password', 'account_code', 'phone', 'address', 'birthday', 'avatar', 'avatarFile', 'id_card']);
        $this->account_code = UserHelper::randomAccountCode();
        $this->isEditStudentMode = false;
        $this->password = UserHelper::randomPassword(10);
        Flux::modal('modal-student')->show();
    }

    public function createStudent()
    {
        $this->studentId = null;
        $this->validate();

        // Handle avatar upload
        $filename = $this->avatar ?? null;
        if ($this->avatarFile) {
            $extension = $this->avatarFile->getClientOriginalExtension();
            $filename = $this->account_code . '-' . uniqid() . '.' . $extension;
            $this->avatarFile->storeAs('images/avatars', $filename, 'public');
        }

        // Create user
        $user = app(StudentRegistrationRepositoryInterface::class)->createStudent([
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'account_code' => $this->account_code,
            'password' => Hash::make($this->password),
            'status' => 'pending',
        ]);

        // Create user detail
        $user->detail()->create([
            'phone' => $this->phone,
            'id_card' => $this->id_card,
            'address' => $this->address,
            'birthday' => $this->birthday,
            'avatar' => $filename,
        ]);

        // Assign student role
        $studentRole = \App\Models\Role::where('name', 'student')->first();
        if ($studentRole) {
            $user->roles()->attach($studentRole->id);
        }

        session()->flash('success', 'Học viên đã được thêm thành công.');
        $this->reset(['studentId', 'name', 'email', 'username', 'password', 'account_code', 'phone', 'address', 'birthday', 'avatar', 'avatarFile']);
        Flux::modal('modal-student')->close();

        $this->redirectRoute('admin.personnel.student-registration', navigate: true);
    }

    #[On('edit-student')]
    public function editStudent($id)
    {
        $this->resetErrorBag();
        $this->studentId = $id;

        $student = User::with('detail')->find($id);
        if ($student) {
            $this->name = $student->name;
            $this->email = $student->email;
            $this->username = $student->username;
            $this->account_code = $student->account_code;
            $this->phone = $student->detail?->phone;
            $this->address = $student->detail?->address;
            $this->birthday = $student->detail?->birthday;
            $this->avatar = $student->detail?->avatar;
        }

        $this->isEditStudentMode = true;
        Flux::modal('modal-student')->show();
    }

    public function updateStudent()
    {
        $this->validate();

        $user = User::find($this->studentId);
        if (!$user) {
            session()->flash('error', 'Không tìm thấy học viên.');
            return;
        }

        $filename = $user->detail?->avatar; // Giữ avatar cũ mặc định

        if ($this->avatarFile) {
            // Delete old avatar if exists
            if ($filename) {
                $path = public_path('images/avatars/' . $filename);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            $extension = $this->avatarFile->getClientOriginalExtension();
            $filename = $user->account_code . '-' . uniqid() . '.' . $extension;
            $this->avatarFile->storeAs('images/avatars', $filename, 'public');
        }

        // Update user
        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'account_code' => $this->account_code,
        ];

        if ($this->password) {
            $userData['password'] = Hash::make($this->password);
        }

        $user->update($userData);

        // Update user detail
        $user->detail()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $this->phone,
                'address' => $this->address,
                'birthday' => $this->birthday,
                'avatar' => $filename, // sẽ luôn giữ avatar cũ nếu không upload mới
            ]
        );

        session()->flash('success', 'Học viên đã được cập nhật thành công.');
        Flux::modal('modal-student')->close();
        $this->redirectRoute('admin.personnel.student-registration', navigate: true);
    }

    #[On('delete-student')]
    public function deleteStudent($id)
    {
        $this->studentId = $id;
        Flux::modal('delete-student')->show();
    }

    public function deleteStudentConfirm()
    {
        $user = User::find($this->studentId);
        if ($user) {
            // Delete avatar if exists
            if ($user->detail?->avatar) {
                $avatarPath = public_path('images/avatars/' . $user->detail->avatar);
                if (File::exists($avatarPath)) {
                    File::delete($avatarPath);
                }
            }

            $user->delete();
        }

        session()->flash('success', 'Học viên đã được xóa thành công.');
        Flux::modal('delete-student')->close();
        $this->redirectRoute('admin.personnel.student-registration', navigate: true);
    }

    public function updateUsername()
    {
        $this->username = UserHelper::randomUsername($this->name);
    }

    public function render()
    {
        return view('livewire.back.personnel.registration.actions-student-registration');
    }
}
