<?php

namespace App\Services;

use App\Mail\OtpMail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    private const TTL_MINUTES = 10;

    private const PREFIX = 'otp:';

    /**
     * Generate a 6-digit OTP, store it in cache, and send it by email.
     */
    public function send(string $email, string $purpose = 'login'): string
    {
        $code = (string) random_int(100000, 999999);
        $key = $this->key($email);
        Cache::put($key, $code, now()->addMinutes(self::TTL_MINUTES));
        Mail::to($email)->send(new OtpMail($code, $purpose));
        return $code;
    }

    /**
     * Verify the OTP for the given email. Returns true if valid.
     */
    public function verify(string $email, string $code): bool
    {
        $key = $this->key($email);
        $stored = Cache::get($key);
        if ($stored === null || $stored !== $code) {
            return false;
        }
        Cache::forget($key);
        return true;
    }

    /**
     * Check if an OTP is still pending for the email (e.g. to allow resend cooldown).
     */
    public function hasPending(string $email): bool
    {
        return Cache::has($this->key($email));
    }

    private function key(string $email): string
    {
        return self::PREFIX . strtolower($email);
    }
}
