<?php

namespace App\Listeners;

use App\Services\AuthenticationLogService;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Events\Dispatcher;

class LogAuthenticationEvents
{
    
    protected AuthenticationLogService $authLogService;

    public function __construct(AuthenticationLogService $authLogService)
    {
        $this->authLogService = $authLogService;
    }

    /**
     * Kiểm tra có nên log hay không dựa trên môi trường
     */
    protected function shouldLog(): bool
    {
        return app()->environment() !== 'local';
    }

    /**
     * Handle user logout events.
     */
    public function handleLogout(Logout $event): void
    {
        if ($event->user && $this->shouldLog()) {
            $this->authLogService->logLogout($event->user);
        }
    }

    /**
     * Handle user lockout events.
     */
    public function handleLockout(Lockout $event): void
    {
        if (!$this->shouldLog()) {
            return;
        }

        $request = $event->request;
        $identifier = $request->input('email') ?? $request->input('username') ?? $request->input('login_id') ?? 'unknown';
        
        $this->authLogService->logBlockedLogin(
            $identifier,
            'Tài khoản đã bị khóa do quá nhiều lần đăng nhập thất bại',
            $request
        );
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            Logout::class => 'handleLogout',
            Lockout::class => 'handleLockout',
        ];
    }

}
