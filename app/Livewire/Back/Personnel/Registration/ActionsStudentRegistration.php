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
use App\Repositories\Contracts\StudentRepositoryInterface;

class ActionsStudentRegistration extends Component
{
    use WithFileUploads;

    public $studentId;
    public $isEditStudentMode = false;
    public $hasWebcam = false; // Thêm thuộc tính kiểm tra webcam

    // User fields
    public $name, $email, $username, $password, $account_code, $id_card;

    // UserDetail fields  
    public $phone, $address, $birthday, $avatar;

    // Location fields
    public $location_id;

    // File upload
    public $avatarFile;

    public function mount()
    {
        // Kiểm tra webcam khi component được mount
        $this->checkWebcamAvailability();
    }

    public function checkWebcamAvailability()
    {
        // Kiểm tra xem có thể truy cập webcam không
        if (request()->isMethod('get')) {
            $this->hasWebcam = true; // Mặc định true, sẽ được cập nhật bởi JavaScript
        }
    }

    public function checkWebcamStatus()
    {
        // Phương thức này sẽ được gọi từ JavaScript để cập nhật trạng thái webcam
        $this->dispatch('check-webcam-status');
    }

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
        // Không cần thiết lập avatar mặc định vì accessor sẽ xử lý
        $this->avatar = null;
        $this->checkWebcamStatus();
        Flux::modal('modal-student')->show();

    }

    public function createStudent()
    {
        $this->studentId = null;
        $this->validate();

        // Handle avatar upload
        $filename = null;
        
        if ($this->avatarFile) {
            // Handle file upload
            $extension = $this->avatarFile->getClientOriginalExtension();
            $filename = $this->account_code . '-' . uniqid() . '.' . $extension;
            $this->avatarFile->storeAs('images/avatars', $filename, 'public');
        } elseif ($this->avatar && str_starts_with($this->avatar, 'data:image')) {
            // Handle webcam image (data URL) - save as file
            $imageData = str_replace('data:image/png;base64,', '', $this->avatar);
            $imageData = str_replace(' ', '+', $imageData);
            $image = base64_decode($imageData);
            
            $filename = $this->account_code . '-' . uniqid() . '.png';
            $path = storage_path('app/public/images/avatars/' . $filename);
            
            // Ensure directory exists
            if (!File::exists(dirname($path))) {
                File::makeDirectory(dirname($path), 0755, true);
            }
            
            file_put_contents($path, $image);
        }

        // Create user
        $user = app(StudentRepositoryInterface::class)->createStudent([
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
            $location = app(StudentRepositoryInterface::class)->getCurrentStudentLocations()->first();
            $selectedLocationId = $location?->id;
        }

        if ($selectedLocationId) {
            $user->locations()->syncWithoutDetaching([$selectedLocationId]);
        }

        session()->flash('success', 'Học viên đã được thêm thành công.');
        $this->reset(['studentId', 'name', 'email', 'username', 'password', 'account_code', 'phone', 'address', 'birthday', 'avatar', 'avatarFile', 'location_id', 'id_card']);
        Flux::modal('modal-student')->close();

        $this->redirectRoute('admin.personnel.student-registration', navigate: false);
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
            // Lấy tên file gốc từ database (không qua accessor)
            $this->avatar = $student->detail?->getRawOriginal('avatar');
            $this->id_card = $student->detail?->id_card;
            $this->location_id = $student->locations->first()?->id;
        }

        $this->isEditStudentMode = true;
        Flux::modal('modal-student')->show();
        // Kiểm tra trạng thái webcam khi mở modal
        $this->checkWebcamStatus();
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
                $path = storage_path('app/public/images/avatars/' . $filename);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            $extension = $this->avatarFile->getClientOriginalExtension();
            $filename = $user->account_code . '-' . uniqid() . '.' . $extension;
            $this->avatarFile->storeAs('images/avatars', $filename, 'public');
        } elseif ($this->avatar && str_starts_with($this->avatar, 'data:image')) {
            // Handle webcam image (data URL) - save as file
            // Delete old avatar if exists
            if ($filename) {
                $path = storage_path('app/public/images/avatars/' . $filename);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }
            
            $imageData = str_replace('data:image/png;base64,', '', $this->avatar);
            $imageData = str_replace(' ', '+', $imageData);
            $image = base64_decode($imageData);
            
            $filename = $user->account_code . '-' . uniqid() . '.png';
            $path = storage_path('app/public/images/avatars/' . $filename);
            
            // Ensure directory exists
            if (!File::exists(dirname($path))) {
                File::makeDirectory(dirname($path), 0755, true);
            }
            
            file_put_contents($path, $image);
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
        // Reset avatar và avatarFile để có thể chụp ảnh mới từ webcam trong lần edit tiếp theo
        $this->avatar = null;
        $this->avatarFile = null;
        Flux::modal('modal-student')->close();
        $this->redirectRoute('admin.personnel.student-registration', navigate: false);
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
        $this->redirectRoute('admin.personnel.student-registration', navigate: false);
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
