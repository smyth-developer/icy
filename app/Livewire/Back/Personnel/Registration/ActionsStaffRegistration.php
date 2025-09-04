<?php

namespace App\Livewire\Back\Personnel\Registration;

use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Support\User\UserHelper;
use Illuminate\Support\Facades\Hash;
use App\Support\Validation\UserRules;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;

class ActionsStaffRegistration extends Component
{

    public $isEditStaffMode = false;
    public $location_id;
    public $role_id;
    public $staffId;
    // File upload
    public $avatarFile;

    // User fields
    public $name, $email, $username, $password, $account_code;

    // UserDetail fields
    public $phone, $address, $birthday, $avatar, $id_card, $gender = false, $guardian_name, $guardian_phone;

    public function render()
    {
        $roleStaff = app(RoleRepositoryInterface::class)->managerAccessPersonnel();
        return view('livewire.back.personnel.registration.actions-staff-registration', [
            'roleStaff' => $roleStaff,
        ]);
    }

    public function resetForm()
    {
        $this->reset([
            'name',
            'email',
            'username',
            'password',
            'account_code',
            'phone',
            'address',
            'birthday',
            'avatar',
            'id_card',
            'gender',
            'guardian_name',
            'guardian_phone',
            'location_id',
            'role_id',
        ]);
        $this->isEditStaffMode = false;
    }

    public function rules()
    {
        $userRules = UserRules::rules($this->staffId);
        $detailRules = UserRules::detailRules($this->staffId);
        $roleRules = [
            'role_id' => ['required', 'exists:roles,id'],
            'id_card' => ['required'],
        ];
        return array_merge($userRules, $detailRules, $roleRules);
    }

    public function messages()
    {
        return array_merge(UserRules::messages(), [
            'role_id.required' => 'Vai trò là bắt buộc.',
            'role_id.exists' => 'Vai trò không hợp lệ.',
            'id_card.required' => 'Số CCCD là bắt buộc.',
        ]);
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

    #[On('add-staff-registration')]
    public function addStaff()
    {
        $this->resetForm();
        Flux::modal('modal-staff')->show();
    }

    public function createStaff()
    {
        $this->validate();
        $selectedLocationId = $this->location_id;
        if (!$selectedLocationId) {
            $location = app(UserRepositoryInterface::class)->getCurrentUserLocations()->first();
            $selectedLocationId = $location?->id;
        }

        $role = app(RoleRepositoryInterface::class)->getRoleById($this->role_id);

        $this->account_code = UserHelper::randomAccountCode();

        $staff = app(UserRepositoryInterface::class)->create([
            'user' => [
                'name' => $this->name,
                'email' => $this->email,
                'username' => $this->username,
                'account_code' => $this->account_code,
                'password' => Hash::make($this->account_code),
                'status' => 'pending',
            ],
            'locations' => [$selectedLocationId],
            'roles' => [$role->name],
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

        if ($staff) {
            session()->flash('success', 'Thêm nhân viên thành công.');
        } else {
            session()->flash('error', 'Thêm nhân viên thất bại.');
        }
        Flux::modal('modal-staff')->close();
        $this->redirectRoute('admin.personnel.staff-registration', navigate: true);
    }

    #[On('delete-staff-registration')]
    public function deleteStaff($id)
    {
        $this->resetForm();
        $this->staffId = $id;
        Flux::modal('delete-staff')->show();
    }

    public function deleteStaffConfirm()
    {
        app(UserRepositoryInterface::class)->delete($this->staffId);
        session()->flash('success', 'Xóa nhân viên thành công.');
        Flux::modal('delete-staff')->close();
        $this->redirectRoute('admin.personnel.staff-registration', navigate: true);
    }

    #[On('edit-staff-registration')]
    public function editStaff($id)
    {
        $this->resetForm();
        $staff = app(UserRepositoryInterface::class)->getUserById($id);
        $this->staffId = $staff->id;
        $this->name = $staff->name;
        $this->email = $staff->email;
        $this->username = $staff->username;
        $this->account_code = $staff->account_code;
        $this->phone = $staff->detail->phone;
        $this->address = $staff->detail->address;
        $this->birthday = $staff->detail->birthday;
        $this->id_card = $staff->detail->id_card;
        $this->gender = $staff->detail->gender;
        $this->guardian_name = $staff->detail->guardian_name;
        $this->guardian_phone = $staff->detail->guardian_phone;
        $this->location_id = $staff->locations->first()->id;
        $this->role_id = $staff->roles->first()->id;
        $this->isEditStaffMode = true;
        Flux::modal('modal-staff')->show();
    }

    public function updateStaff()
    {
        $this->validate();
        $staff = app(UserRepositoryInterface::class)->update($this->staffId, [
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
            'roles' => [$this->role_id],
        ]);
        if ($staff) {
            session()->flash('success', 'Cập nhật nhân viên thành công.');
        } else {
            session()->flash('error', 'Cập nhật nhân viên thất bại.');
        }
        Flux::modal('modal-staff')->close();
        $this->redirectRoute('admin.personnel.staff-registration', navigate: true);
    }

    #[On('approve-staff-registration')]
    public function approveStaff($id)
    {
        $this->resetForm();
        $this->staffId = $id;
        $this->approveStaffConfirm();
    }

    public function approveStaffConfirm()
    {
        $staff = app(UserRepositoryInterface::class)->getUserById($this->staffId);
        $staff->update([
            'status' => 'active',
        ]);
        if ($staff) {
            session()->flash('success', 'Xét duyệt nhân viên thành công.');
        } else {
            session()->flash('error', 'Xét duyệt nhân viên thất bại.');
        }
        $this->redirectRoute('admin.personnel.staff-registration', navigate: true);
    }
}
