<?php

namespace App\Livewire\Auth;

use App\Services\AuthenticationLogService;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

#[Layout('components.layouts.auth')]
#[Title('Đăng nhập')]
class Login extends Component
{
    #[Validate('required|string')]
    public string $login_id = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    protected AuthenticationLogService $authLogService;

    public function boot(AuthenticationLogService $authLogService)
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
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        // Determine if the login_id is an email or username
        if (filter_var($this->login_id, FILTER_VALIDATE_EMAIL)) {
            $login_id = 'email';
        } else {
            $login_id = 'username';
        }

        if (! Auth::attempt([$login_id => $this->login_id, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            // Log failed login attempt
            if ($this->shouldLog()) {
                $this->authLogService->logFailedLogin(
                    $this->login_id,
                    'Invalid credentials',
                    request()
                );
            }

            throw ValidationException::withMessages([
                'login_id' => ('Thông tin đăng nhập không chính xác.'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        // Log successful login
        if ($this->shouldLog()) {
            $this->authLogService->logSuccessfulLogin(Auth::user(), request());
        }

        $currentSessionId = session()->getId();
        
        // Get other sessions before deleting them to log forced logouts
        $otherSessions = DB::table('sessions')
            ->where('user_id', Auth::user()->id)
            ->where('id', '!=', $currentSessionId)
            ->get();

        // Log forced logout for each other session
        if ($this->shouldLog()) {
            foreach ($otherSessions as $session) {
                $this->authLogService->logForcedLogout(Auth::user(), $session);
            }
        }

        // Delete other sessions (force logout other devices)
        DB::table('sessions')
            ->where('user_id', Auth::user()->id)
            ->where('id', '!=', $currentSessionId)
            ->delete();

        Cookie::queue('remember_web_' . sha1(config('app.key')), Cookie::get('remember_web_' . sha1(config('app.key'))), 60 * 24 * 7);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        // Log blocked login attempt
        if ($this->shouldLog()) {
            $this->authLogService->logBlockedLogin(
                $this->login_id,
                'Rate limited - too many attempts',
                request()
            );
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->login_id).'|'.request()->ip());
    }
}
