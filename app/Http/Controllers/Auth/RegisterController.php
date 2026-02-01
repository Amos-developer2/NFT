<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerificationCode;
use App\Mail\VerificationCodeMail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle step 1: Validate data and send verification code.
     */
    public function register(Request $request)
    {
        // Step 1: Validate registration data

        $this->validator($request->all())->validate();

        // Generate verification code
        $verification = VerificationCode::generateCode($request->email, 'registration');

        // Always generate a unique referral code for the new user
        $uniqueReferralCode = User::generateReferralCode();

        // Create user immediately with verification_code and verification_expires_at
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referral_code' => $uniqueReferralCode,
            'verification_code' => $verification->code,
            'verification_expires_at' => $verification->expires_at,
        ]);

        // Send verification email
        try {
            Mail::to($request->email)->send(new VerificationCodeMail($verification->code, $request->name));
        } catch (\Exception $e) {
            \Log::error('Failed to send verification email: ' . $e->getMessage());
        }

        // Store user id in session for verification step
        session(['registration_user_id' => $user->id]);

        return redirect()->route('register.verify');
    }

    /**
     * Show verification code form.
     */
    public function showVerificationForm()
    {
        $userId = session('registration_user_id');
        $user = $userId ? User::find($userId) : null;
        if (!$user) {
            return redirect()->route('register');
        }
        return view('auth.verify', [
            'email' => $user->email,
        ]);
    }

    /**
     * Verify code and create user.
     */
    public function verifyAndCreate(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|string|size:6',
        ]);

        $userId = session('registration_user_id');
        $user = $userId ? User::find($userId) : null;
        if (!$user) {
            return redirect()->route('register')->withErrors(['email' => 'Session expired. Please register again.']);
        }

        // Verify the code
        $verification = \App\Models\VerificationCode::where('email', $user->email)
            ->where('code', $request->verification_code)
            ->where('type', 'registration')
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            return back()->withErrors(['verification_code' => 'Invalid or expired verification code.']);
        }

        $verification->update(['is_used' => true]);

        // Mark user as verified (set email_verified_at and clear verification_code)
        $user->email_verified_at = now();
        $user->verification_code = null;
        $user->save();

        // Clear session
        session()->forget(['registration_user_id', 'verification_code_preview']);

        // Fire registered event and login
        event(new Registered($user));
        $this->guard()->login($user);

        return redirect($this->redirectPath());
    }

    /**
     * Resend verification code.
     */
    public function resendCode(Request $request)
    {
        $registrationData = session('registration_data');

        if (!$registrationData) {
            return redirect()->route('register');
        }

        $verification = VerificationCode::generateCode($registrationData['email'], 'registration');

        // Send verification email
        try {
            Mail::to($registrationData['email'])->send(new VerificationCodeMail($verification->code, $registrationData['name']));
        } catch (\Exception $e) {
            \Log::error('Failed to resend verification email: ' . $e->getMessage());
        }

        return back()->with('status', 'A new verification code has been sent to your email.');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:users',
                'regex:/^(?=.*[A-Za-z])[A-Za-z0-9 _.-]+$/'
            ],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'referral_code' => ['required', 'string', 'exists:users,referral_code'],
            'terms' => ['accepted'],
        ], [
            'name.regex' => 'Name must contain at least one English letter and may include numbers, spaces, and .-_ characters. It cannot be only numbers or only special characters.',
            'name.unique' => 'This username is already taken.',
            'terms.accepted' => 'You must accept the terms and conditions.',
            'referral_code.required' => 'A referral code is required to register.',
            'referral_code.exists' => 'Invalid referral code. Please check and try again.',
        ]);
    }

    protected function create(array $data)
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verified_at' => now(), // Mark as verified since they verified the code
        ];

        // Add verification_code and verification_expires_at if present
        if (isset($data['verification_code'])) {
            $userData['verification_code'] = $data['verification_code'];
        }
        if (isset($data['verification_expires_at'])) {
            $userData['verification_expires_at'] = $data['verification_expires_at'];
        }

        // Check if user was referred by someone
        if (!empty($data['referral_code'])) {
            $referrer = User::findByReferralCode($data['referral_code']);
            if ($referrer) {
                $userData['referred_by'] = $referrer->id;
                // Increment referrer's referral count
                $referrer->increment('referral_count');
            }
        }

        return User::create($userData);
    }
}
