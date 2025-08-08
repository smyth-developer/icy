<?php

namespace App\Services;

use App\Models\AuthenticationLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationLogService
{
    /**
     * Log a successful login attempt.
     */
    public function logSuccessfulLogin(User $user, Request $request): AuthenticationLog
    {
        return $this->createLog([
            'user_id' => $user->id,
            'email' => $user->email,
            'username' => $user->username,
            'login_type' => $this->getLoginType($request),
            'status' => 'success',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device' => $this->getDeviceType($request->userAgent()),
            'login_at' => now(),
        ]);
    }

    /**
     * Log a failed login attempt.
     */
    public function logFailedLogin(string $identifier, string $reason, Request $request): AuthenticationLog
    {
        $loginType = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        return $this->createLog([
            $loginType => $identifier,
            'login_type' => $loginType,
            'status' => 'failed',
            'failure_reason' => $reason,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device' => $this->getDeviceType($request->userAgent()),
            'login_at' => now(),
        ]);
    }

    /**
     * Log a blocked login attempt.
     */
    public function logBlockedLogin(string $identifier, string $reason, Request $request): AuthenticationLog
    {
        $loginType = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        return $this->createLog([
            $loginType => $identifier,
            'login_type' => $loginType,
            'status' => 'blocked',
            'failure_reason' => $reason,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device' => $this->getDeviceType($request->userAgent()),
            'login_at' => now(),
        ]);
    }

    /**
     * Log a forced logout (when user logs in and other sessions are terminated).
     */
    public function logForcedLogout(User $user, $session): AuthenticationLog
    {
        return $this->createLog([
            'user_id' => $user->id,
            'email' => $user->email,
            'username' => $user->username,
            'status' => 'logout',
            'ip_address' => $session->ip_address ?? null,
            'user_agent' => $session->user_agent ?? null,
            'device' => $this->getDeviceType($session->user_agent ?? null),
            'failure_reason' => 'Đăng xuất tự động - đăng nhập từ thiết bị khác',
            'login_at' => now(),
            'logout_at' => now(),
        ]);
    }

    /**
     * Log a logout.
     */
    public function logLogout(?User $user = null): ?AuthenticationLog
    {
        $user = $user ?? Auth::user();
        
        if (!$user) {
            return null;
        }

        // Find the most recent successful login for this user that hasn't been logged out yet
        $lastLogin = AuthenticationLog::where('user_id', $user->id)
            ->where('status', 'success')
            ->whereNull('logout_at')
            ->latest('login_at')
            ->first();

        if ($lastLogin) {
            $lastLogin->update([
                'logout_at' => now(),
            ]);
            return $lastLogin;
        }

        // Only create a new logout log if there's no recent logout within the last minute
        // This prevents duplicate logout logs
        $recentLogout = AuthenticationLog::where('user_id', $user->id)
            ->where('status', 'logout')
            ->where('created_at', '>=', now()->subMinute())
            ->exists();

        if ($recentLogout) {
            return null; // Don't create duplicate logout logs
        }

        // If no recent login found and no recent logout, create a logout log
        return $this->createLog([
            'user_id' => $user->id,
            'email' => $user->email,
            'username' => $user->username,
            'status' => 'logout',
            'login_at' => now(),
            'logout_at' => now(),
        ]);
    }

    /**
     * Get recent failed login attempts for an identifier.
     */
    public function getRecentFailedAttempts(string $identifier, int $minutes = 15): int
    {
        $loginType = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        return AuthenticationLog::where($loginType, $identifier)
            ->where('status', 'failed')
            ->where('login_at', '>=', now()->subMinutes($minutes))
            ->count();
    }

    /**
     * Get recent failed login attempts by IP.
     */
    public function getRecentFailedAttemptsByIp(string $ipAddress, int $minutes = 15): int
    {
        return AuthenticationLog::where('ip_address', $ipAddress)
            ->where('status', 'failed')
            ->where('login_at', '>=', now()->subMinutes($minutes))
            ->count();
    }

    /**
     * Check if an IP address is suspicious based on failed attempts.
     */
    public function isSuspiciousIp(string $ipAddress, int $threshold = 5, int $minutes = 15): bool
    {
        return $this->getRecentFailedAttemptsByIp($ipAddress, $minutes) >= $threshold;
    }

    /**
     * Get authentication logs for a user.
     */
    public function getUserLogs(User $user, int $limit = 50)
    {
        return AuthenticationLog::where('user_id', $user->id)
            ->orderBy('login_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Create an authentication log entry.
     */
    private function createLog(array $data): AuthenticationLog
    {
        return AuthenticationLog::create($data);
    }

    /**
     * Determine the login type based on the request.
     */
    private function getLoginType(Request $request): string
    {
        $identifier = $request->input('email') ?? $request->input('username') ?? $request->input('login');
        
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }
        
        return 'username';
    }

    /**
     * Determine device type from user agent.
     */
    private function getDeviceType(?string $userAgent): ?string
    {
        if (!$userAgent) {
            return null;
        }

        return $this->parseUserAgent($userAgent);
    }

    /**
     * Parse user agent to get browser and OS information.
     */
    private function parseUserAgent(string $userAgent): string
    {
        $browser = $this->getBrowser($userAgent);
        $os = $this->getOperatingSystem($userAgent);
        
        return $browser . ' on ' . $os;
    }

    /**
     * Get browser name from user agent.
     */
    private function getBrowser(string $userAgent): string
    {
        if (preg_match('/Edg\//i', $userAgent)) {
            return 'Edge';
        }
        if (preg_match('/Chrome\//i', $userAgent) && !preg_match('/Edg\//i', $userAgent)) {
            return 'Chrome';
        }
        if (preg_match('/Firefox\//i', $userAgent)) {
            return 'Firefox';
        }
        if (preg_match('/Safari\//i', $userAgent) && !preg_match('/Chrome\//i', $userAgent)) {
            return 'Safari';
        }
        if (preg_match('/Opera|OPR\//i', $userAgent)) {
            return 'Opera';
        }
        if (preg_match('/MSIE|Trident\//i', $userAgent)) {
            return 'Internet Explorer';
        }
        
        return 'Unknown Browser';
    }

    /**
     * Get operating system from user agent.
     */
    private function getOperatingSystem(string $userAgent): string
    {
        if (preg_match('/Windows/i', $userAgent)) {
            return 'Windows';
        }
        if (preg_match('/Mac OS X|Macintosh/i', $userAgent)) {
            return 'macOS';
        }
        if (preg_match('/Linux/i', $userAgent)) {
            return 'Linux';
        }
        if (preg_match('/Android/i', $userAgent)) {
            return 'Android';
        }
        if (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
            return 'iOS';
        }
        
        return 'Unknown OS';
    }
}
