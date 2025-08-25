<?php

namespace App\Livewire\Back\Personnel\Registration;

use Flux\Flux;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Support\User\UserHelper;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Support\Validation\UserRules;
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

    // Location fields
    public $location_id;

    // File upload
    public $avatarFile;

    public function rules()
    {
        // Get base user rules
        $userRules = UserRules::rules($this->studentId);

        // Get user detail rules (pass current student id to handle unique rules)
        $detailRules = UserRules::detailRules($this->studentId);


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
            'birthday' => $this->birthday ?: null,
            'avatar' => $filename,
        ]);

        // Assign student role
        $studentRole = Role::where('name', 'student')->first();
        if ($studentRole) {
            $user->roles()->attach($studentRole->id);
        }

        // Assign location
        $selectedLocationId = $this->location_id;
        if (!$selectedLocationId) {
            $location = app(StudentRegistrationRepositoryInterface::class)->getCurrentUserLocations()->first();
            $selectedLocationId = $location?->id;
        }

        if ($selectedLocationId) {
            $user->locations()->syncWithoutDetaching([$selectedLocationId]);
        }

        session()->flash('success', 'Học viên đã được thêm thành công.');
        $this->reset(['studentId', 'name', 'email', 'username', 'password', 'account_code', 'phone', 'address', 'birthday', 'avatar', 'avatarFile', 'location_id', 'id_card']);
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
            $this->id_card = $student->detail?->id_card;
            $this->location_id = $student->locations->first()?->id;
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

        // Lấy tên file avatar gốc (không qua accessor trả về URL)
        $filename = $user->detail?->getRawOriginal('avatar');

        if ($this->avatarFile) {
            // Delete old avatar if exists
            if ($filename) {
                $path = public_path('storage/images/avatars/' . $filename);
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
                'birthday' => $this->birthday ?: null,
                'avatar' => $filename, // lưu tên file, giữ avatar cũ nếu không upload mới
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
        $this->name = ucwords(trim($this->name));
    }

    public function render()
    {
        return view('livewire.back.personnel.registration.actions-student-registration');
    }
}
