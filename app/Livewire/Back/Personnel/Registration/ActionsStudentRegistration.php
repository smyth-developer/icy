<?php

namespace App\Livewire\Back\Personnel\Registration;

use Flux\Flux;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Support\User\UserHelper;
use Illuminate\Support\Facades\Hash;
use App\Support\Validation\UserRules;
use App\Repositories\Contracts\UserRepositoryInterface;

class ActionsStudentRegistration extends Component
{

    public $studentId;
    public $isEditStudentMode = false;

    // User fields
    public $name, $email, $username, $password, $account_code;

    // UserDetail fields  
    public $phone, $address, $birthday, $avatar, $id_card, $gender = false, $guardian_name, $guardian_phone;

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

        $rules = array_merge($userRules, $detailRules);

        // Override to require guardian info when adding student
        $rules['guardian_name'] = [
            'required',
            'string',
            'max:255',
        ];
        $rules['guardian_phone'] = [
            'required',
            'string',
            'regex:/^(\+84|0)[0-9]{9,10}$/',
        ];

        return $rules;
    }

    public function messages()
    {
        return array_merge(UserRules::messages(), [
            'guardian_name.required' => 'Họ và tên người giám hộ là bắt buộc.',
            'guardian_phone.required' => 'Số điện thoại người giám hộ là bắt buộc.',
        ]);
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->reset([
            'studentId',
            'name',
            'email',
            'username',
            'password',
            'account_code',
            'phone',
            'address',
            'birthday',
            'avatar',
            'avatarFile',
            'id_card',
            'guardian_name',
            'guardian_phone',
            'location_id',
        ]);
        $this->isEditStudentMode = false;
    }

    #[On('add-student')]
    public function addStudent()
    {
        $this->resetForm();
        Flux::modal('modal-student')->show();
    }

    public function createStudent()
    {
        $this->validate();
        $selectedLocationId = $this->location_id;
        if (!$selectedLocationId) {
            $location = app(UserRepositoryInterface::class)->getCurrentUserLocations()->first();
            $selectedLocationId = $location?->id;
        }

        $this->account_code = UserHelper::randomAccountCode();

        $student = app(UserRepositoryInterface::class)->create([
            'user' => [
                'name' => $this->name,
                'email' => $this->email,
                'username' => $this->username,
                'account_code' => $this->account_code,
                'password' => Hash::make($this->account_code),
                'status' => 'pending',
            ],
            'locations' => [$selectedLocationId],
            'roles' => ['Student'],
            'detail' => [
                'phone' => $this->phone,
                'address' => $this->address,
                'birthday' => $this->birthday,
                'avatar' => $this->avatar,
                'id_card' => $this->id_card,
                'gender' => $this->gender,
                'guardian_name' => $this->guardian_name,
                'guardian_phone' => $this->guardian_phone,
            ]
        ]);

        if ($student) {
            session()->flash('success', 'Thêm học viên thành công.');
        } else {
            session()->flash('error', 'Thêm học viên thất bại.');
        }
        Flux::modal('modal-student')->close();
        $this->redirectRoute('admin.personnel.student-registration', navigate: true);
    }

    #[On('edit-student')]
    public function editStudent($id)
    {
        $student = app(UserRepositoryInterface::class)->getUserById($id);
        $this->studentId = $student->id;
        $this->name = $student->name;
        $this->email = $student->email;
        $this->username = $student->username;
        $this->account_code = $student->account_code;
        $this->phone = $student->detail->phone;
        $this->address = $student->detail->address;
        $this->birthday = $student->detail->birthday;
        $this->id_card = $student->detail->id_card;
        $this->gender = $student->detail->gender;
        $this->guardian_name = $student->detail->guardian_name;
        $this->guardian_phone = $student->detail->guardian_phone;
        $this->location_id = $student->locations->first()->id;
        $this->isEditStudentMode = true;
        Flux::modal('modal-student')->show();
    }

    public function updateStudent()
    {
        $this->validate();
        $student = app(UserRepositoryInterface::class)->update($this->studentId, [
            'user' => [
                'name' => $this->name,
                'email' => $this->email,
                'username' => $this->username,
            ],
            'detail' => [
                'phone' => $this->phone,
                'address' => $this->address,
                'birthday' => $this->birthday ?: null,
                'id_card' => $this->id_card,
                'gender' => $this->gender,
                'guardian_name' => $this->guardian_name,
                'guardian_phone' => $this->guardian_phone,
            ],
            'locations' => [$this->location_id],
        ]);
        if ($student) {
            session()->flash('success', 'Cập nhật học viên thành công.');
        } else {
            session()->flash('error', 'Cập nhật học viên thất bại.');
        }
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
        app(UserRepositoryInterface::class)->delete($this->studentId);
        session()->flash('success', 'Xóa học viên thành công.');
        Flux::modal('delete-student')->close();
        $this->redirectRoute('admin.personnel.student-registration', navigate: true);
    }

    #[On('approve-student')]
    public function approveStudent($id)
    {
        $this->resetForm();
        $this->studentId = $id;
        $this->approveStudentConfirm();
    }

    public function approveStudentConfirm()
    {
        $student = app(UserRepositoryInterface::class)->getUserById($this->studentId);
        $student->update([
            'status' => 'active',
        ]);

        if ($student) {
            session()->flash('success', 'Xét duyệt học viên thành công.');
        } else {
            session()->flash('error', 'Xét duyệt học viên thất bại.');
        }
        $this->redirectRoute('admin.personnel.student-registration', navigate: true);
    }

    public function updateUsername()
    {
        $this->username = UserHelper::randomUsername($this->name);
        $this->name = ucwords(trim($this->name));
    }

    public function updateGuardian()
    {
        $this->guardian_name = ucwords(trim($this->guardian_name));
    }

    public function render()
    {
        return view('livewire.back.personnel.registration.actions-student-registration');
    }
}
