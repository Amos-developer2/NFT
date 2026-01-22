<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Log;


class ForgotPasswordController extends Controller
{

    /**
     * Show the form to request a password reset code (email input).
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }


    /**
     * Handle the code verification POST.
     */
    public function verifyCode(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
            'email' => 'required|email',
        ]);
        $email = $request->email;
        $code = $request->code;
        $verification = \App\Models\VerificationCode::where('email', $email)
            ->where('code', $code)
            ->where('type', 'password_reset')
            ->where('is_used', false)
            ->first();

        if (!$verification) {
            return back()->withErrors(['code' => 'Invalid code. Please check your email and try again.'])->withInput();
        }
        if ($verification->expires_at->isPast()) {
            return back()->withErrors(['code' => 'This code has expired. Please request a new one.'])->withInput();
        }
        $verification->update(['is_used' => true]);
        // Automatically log in the user
        $user = \App\Models\User::where('email', $email)->first();
        if ($user) {
            \Auth::login($user);
        }
        session(['password_reset_verified' => true]);
        return redirect()->route('home');
    }

    /**
     * Show the form to enter the 6-digit reset code.
     */
    public function showCodeForm()
    {
        $email = session('password_reset_email');
        if (!$email) {
            return redirect()->route('password.request');
        }
        return view('auth.passwords.code', ['email' => $email]);
    }


    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */


    /**
     * Override to check if email exists before sending reset link.
     */
    public function sendResetLinkEmail(\Illuminate\Http\Request $request)
    {
        // Log password reset request
        Log::info('Password reset requested', [
            'email' => $request->input('email'),
            'ip' => $request->ip(),
            'timestamp' => now()->toDateTimeString()
        ]);
        $request->validate(['email' => 'required|email']);
        // Rate limit: max 5 requests per 10 minutes per IP
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts('password-reset:' . $request->ip(), 5)) {
            return back()->withErrors(['email' => 'Too many password reset requests. Please try again later.'])->withInput();
        }
        \Illuminate\Support\Facades\RateLimiter::hit('password-reset:' . $request->ip(), 600);
        $email = $request->input('email');
        if (!\App\Models\User::where('email', $email)->exists()) {
            return back()->withErrors(['email' => 'If your email is registered, you will receive a password reset code.'])->withInput();
        }
        // Generate and store code in verification_codes table
        $code = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        \App\Models\VerificationCode::generateCode($email, 'password_reset', $code);
        session(['password_reset_code' => $code, 'password_reset_email' => $email]);
        \Mail::raw("Your password reset code is: $code", function ($message) use ($email) {
            $message->to($email)
                ->subject('Password Reset Code');
        });
        // Notify user of password reset request
        \Mail::raw("A password reset was requested for your account. If this was not you, please ignore this email.", function ($message) use ($email) {
            $message->to($email)
                ->subject('Password Reset Requested');
        });
        return redirect()->route('password.code');
    }
}
