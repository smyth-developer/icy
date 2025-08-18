<?php

namespace App\Livewire\Settings;

use App\Models\AuthenticationLog;
use App\Services\AuthenticationLogService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Nhật ký đăng nhập')]
class AuthenticationLogs extends Component
{
    use WithPagination;

    public $filterStatus = '';
    public $filterDays = 30;
    public $search = '';

    protected AuthenticationLogService $authLogService;

    public function boot(AuthenticationLogService $authLogService)
    {
        $this->authLogService = $authLogService;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterDays()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = AuthenticationLog::where('user_id', Auth::id())
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterDays, function ($query) {
                $query->where('login_at', '>=', now()->subDays($this->filterDays));
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('ip_address', 'like', '%' . $this->search . '%')
                      ->orWhere('device', 'like', '%' . $this->search . '%')
                      ->orWhere('location', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('login_at', 'desc');

        $logs = $query->paginate(10);

        // Get statistics
        $stats = [
            'total_logins' => AuthenticationLog::where('user_id', Auth::id())
                ->where('status', 'success')
                ->where('login_at', '>=', now()->subDays(30))
                ->count(),
            'failed_attempts' => AuthenticationLog::where('user_id', Auth::id())
                ->where('status', 'failed')
                ->where('login_at', '>=', now()->subDays(30))
                ->count(),
            'unique_devices' => AuthenticationLog::where('user_id', Auth::id())
                ->where('login_at', '>=', now()->subDays(30))
                ->distinct('device')
                ->count('device'),
            'unique_ips' => AuthenticationLog::where('user_id', Auth::id())
                ->where('login_at', '>=', now()->subDays(30))
                ->distinct('ip_address')
                ->count('ip_address'),
        ];

        return view('livewire.settings.authentication-logs', [
            'logs' => $logs,
            'stats' => $stats,
        ]);
    }
}
