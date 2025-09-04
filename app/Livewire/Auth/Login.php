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
use Exception;

#[Layout('components.layouts.auth')]
#[Title('Đăng nhập')]
class Login extends Component
{
    // Constants for better maintainability
    private const MAX_LOGIN_ATTEMPTS = 5;
    private const COOKIE_EXPIRY_DAYS = 7;
    private const COOKIE_EXPIRY_MINUTES = 60 * 24 * 7;
    
    // User status constants
    private const STATUS_PENDING = 'pending';
    private const STATUS_LOCKED = 'locked';
    private const STATUS_RESIGNED = 'resigned';
    
    // Error messages
    private const ERROR_INVALID_CREDENTIALS = 'Thông tin đăng nhập không chính xác.';
    private const ERROR_ACCOUNT_PENDING = 'Tài khoản của bạn đang chờ xét duyệt.';
    private const ERROR_ACCOUNT_LOCKED = 'Tài khoản của bạn đã bị khóa.';
    private const ERROR_ACCOUNT_RESIGNED = 'Tài khoản của bạn đã không còn sử dụng.';

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

        $loginField = $this->determineLoginField();
        
        if (!$this->attemptAuthentication($loginField)) {
            $this->handleFailedLogin();
            return;
        }

        $user = Auth::user();
        
        if (!$this->validateUserStatus($user)) {
            return;
        }

        $this->handleSuccessfulLogin($user);
    }

    /**
     * Determine if login_id is email or username
     */
    private function determineLoginField(): string
    {
        return filter_var($this->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    }

    /**
     * Attempt user authentication
     */
    private function attemptAuthentication(string $loginField): bool
    {
        return Auth::attempt([
            $loginField => $this->login_id,
            'password' => $this->password
        ], $this->remember);
    }

    /**
     * Handle failed login attempt
     */
    private function handleFailedLogin(): void
    {
        RateLimiter::hit($this->throttleKey());

        if ($this->shouldLog()) {
            $this->authLogService->logFailedLogin(
                $this->login_id,
                'Invalid credentials',
                request()
            );
        }

        $this->password = '';

        throw ValidationException::withMessages([
            'login_id' => self::ERROR_INVALID_CREDENTIALS,
        ]);
    }

    /**
     * Validate user status and handle invalid statuses
     */
    private function validateUserStatus($user): bool
    {
        $statusMessages = [
            self::STATUS_PENDING => self::ERROR_ACCOUNT_PENDING,
            self::STATUS_LOCKED => self::ERROR_ACCOUNT_LOCKED,
            self::STATUS_RESIGNED => self::ERROR_ACCOUNT_RESIGNED,
        ];

        if (isset($statusMessages[$user->status])) {
            Session::flash('status', $statusMessages[$user->status]);
            Auth::logout();
            return false;
        }

        return true;
    }

    /**
     * Handle successful login process
     */
    private function handleSuccessfulLogin($user): void
    {
        $this->clearRateLimit();
        $this->regenerateSession();
        $this->logSuccessfulLogin($user);
        $this->handleOtherSessions($user);
        $this->setRememberCookie();
        $this->setLastUserCookie($user);
        
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Clear rate limiting for successful login
     */
    private function clearRateLimit(): void
    {
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Regenerate session for security
     */
    private function regenerateSession(): void
    {
        Session::regenerate();
    }

    /**
     * Log successful login
     */
    private function logSuccessfulLogin($user): void
    {
        if ($this->shouldLog()) {
            $this->authLogService->logSuccessfulLogin($user, request());
        }
    }

    /**
     * Handle other user sessions (force logout)
     */
    private function handleOtherSessions($user): void
    {
        $currentSessionId = session()->getId();
        
        $otherSessions = $this->getOtherSessions($user->id, $currentSessionId);
        
        $this->logForcedLogouts($user, $otherSessions);
        $this->deleteOtherSessions($user->id, $currentSessionId);
    }

    /**
     * Get other user sessions
     */
    private function getOtherSessions(int $userId, string $currentSessionId)
    {
        return DB::table('sessions')
            ->where('user_id', $userId)
            ->where('id', '!=', $currentSessionId)
            ->get();
    }

    /**
     * Log forced logouts for other sessions
     */
    private function logForcedLogouts($user, $otherSessions): void
    {
        if ($this->shouldLog()) {
            foreach ($otherSessions as $session) {
                $this->authLogService->logForcedLogout($user, $session);
            }
        }
    }

    /**
     * Delete other user sessions
     */
    private function deleteOtherSessions(int $userId, string $currentSessionId): void
    {
        DB::table('sessions')
            ->where('user_id', $userId)
            ->where('id', '!=', $currentSessionId)
            ->delete();
    }

    /**
     * Set remember cookie
     */
    private function setRememberCookie(): void
    {
        $rememberKey = 'remember_web_' . sha1(config('app.key'));
        $rememberValue = Cookie::get($rememberKey);
        
        if ($rememberValue) {
            Cookie::queue($rememberKey, $rememberValue, self::COOKIE_EXPIRY_MINUTES);
        }
    }

    /**
     * Set last user cookie for quick login
     */
    private function setLastUserCookie($user): void
    {
        try {
            $userData = $this->prepareUserData($user);
            Cookie::queue('last_user', encrypt(json_encode($userData)), self::COOKIE_EXPIRY_MINUTES);
        } catch (Exception $e) {
            // Log error but don't break login flow
            if ($this->shouldLog()) {
                logger()->error('Failed to set last user cookie: ' . $e->getMessage());
            }
        }
    }

    /**
     * Prepare user data for cookie storage
     */
    private function prepareUserData($user): array
    {
        $detail = $user->detail()->first();
        
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->username,
            'avatar' => $detail->avatar ?? '/default-avatar.png',
        ];
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), self::MAX_LOGIN_ATTEMPTS)) {
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
        return Str::transliterate(Str::lower($this->login_id) . '|' . request()->ip());
    }

    public function mount(): void
    {
        $this->loadLastUserFromCookie();
    }

    /**
     * Load last user information from cookie for quick login
     */
    private function loadLastUserFromCookie(): void
    {
        if (!empty($this->login_id) || !Cookie::has('last_user')) {
            return;
        }

        try {
            $lastUser = json_decode(decrypt(Cookie::get('last_user')), true);
            
            if (is_array($lastUser) && isset($lastUser['email'])) {
                $this->login_id = $lastUser['email'];
            } elseif (is_array($lastUser) && isset($lastUser['username'])) {
                $this->login_id = $lastUser['username'];
            }
        } catch (Exception $e) {
            // Clear invalid cookie
            Cookie::queue(Cookie::forget('last_user'));
            
            if ($this->shouldLog()) {
                logger()->warning('Invalid last_user cookie detected and cleared: ' . $e->getMessage());
            }
        }
    }

    /**
     * Clear last user cookie and reset login form
     */
    public function clearLastUser(): void
    {
        Cookie::queue(Cookie::forget('last_user'));
        $this->login_id = '';
        $this->redirectIntended(default: route('login', absolute: false), navigate: true);
    }
}
