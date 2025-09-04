<?php

namespace App\Livewire\Back\Personnel\Employee;

use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Support\Validation\UserRules;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;

class ActionsStaff extends Component
{
    public $isEditStaffMode = false;
    public $staffId;
    public $name, $email, $username, $password, $account_code;
    public $phone, $address, $birthday, $avatar, $id_card, $gender = false, $guardian_name, $guardian_phone;
    public $location_id;
    public $role_id;
    public $avatarFile;

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
            'avatarFile',
        ]);
        $this->isEditStaffMode = false;
    }

    public function render()
    {
        $roleStaff = app(RoleRepositoryInterface::class)->getRoleStaff();
        return view('livewire.back.personnel.employee.actions-staff', [
            'roleStaff' => $roleStaff,
        ]);
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

    #[On('edit-staff')]
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
        Flux::modal('modal-employee')->show();
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
        Flux::modal('modal-employee')->close();
        $this->redirectRoute('admin.personnel.staff-registration', navigate: true);
    }
}
