<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OtpController extends Controller
{
    public function __construct(
        private OtpService $otpService
    ) {}

    /**
     * Show the OTP verification form.
     */
    public function show(Request $request): View|RedirectResponse
    {
        $email = $request->session()->get('otp_email');
        $purpose = $request->session()->get('otp_purpose', 'login');

        if (! $email) {
            return redirect()->route('login')->with('error', 'Session expired. Please try again.');
        }

        return view('auth.verify-otp', [
            'email' => $email,
            'purpose' => $purpose,
        ]);
    }

    /**
     * Verify the OTP and complete login or registration.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $email = $request->input('email');
        $otp = $request->input('otp');

        if ($request->session()->get('otp_email') !== $email) {
            throw ValidationException::withMessages([
                'email' => 'Email does not match the one we sent the code to.',
            ]);
        }

        if (! $this->otpService->verify($email, $otp)) {
            throw ValidationException::withMessages([
                'otp' => 'The verification code is invalid or has expired.',
            ]);
        }

        $purpose = $request->session()->get('otp_purpose', 'login');

        if ($purpose === 'register') {
            $data = $request->session()->get('pending_registration');
            $request->session()->forget(['otp_email', 'otp_purpose', 'otp_remember', 'pending_registration']);
            if (! $data || ($data['email'] ?? '') !== $email) {
                return redirect()->route('register')->with('error', 'Registration session expired. Please register again.');
            }
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            Auth::login($user);
            return redirect(route('dashboard', absolute: false));
        }

        $request->session()->forget(['otp_email', 'otp_purpose', 'otp_remember']);
        $user = User::query()->where('email', $email)->first();
        if (! $user) {
            return redirect()->route('login')->with('error', 'User not found. Please log in again.');
        }

        Auth::login($user, $request->session()->get('otp_remember', false));
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Resend the OTP email.
     */
    public function resend(Request $request): RedirectResponse
    {
        $email = $request->session()->get('otp_email');
        $purpose = $request->session()->get('otp_purpose', 'login');

        if (! $email) {
            return redirect()->route('login')->with('error', 'Session expired. Please try again.');
        }

        $this->otpService->send($email, $purpose);

        return back()->with('status', 'A new verification code has been sent to your email.');
    }
}
