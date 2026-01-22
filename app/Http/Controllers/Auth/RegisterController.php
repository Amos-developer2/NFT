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
        // Check if this is verification step
        if ($request->has('verification_code')) {
            return $this->verifyAndCreate($request);
        }

        // Step 1: Validate registration data
        $this->validator($request->all())->validate();

        // Generate verification code
        $verification = VerificationCode::generateCode($request->email, 'registration');

        // Send verification email
        try {
            Mail::to($request->email)->send(new VerificationCodeMail($verification->code, $request->name));
        } catch (\Exception $e) {
            // Log the error but continue (for development without mail setup)
            \Log::error('Failed to send verification email: ' . $e->getMessage());
        }

        // Store registration data in session
        session([
            'registration_data' => [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'referral_code' => $request->referral_code,
            ],
        ]);

        return redirect()->route('register.verify');
    }

    /**
     * Show verification code form.
     */
    public function showVerificationForm()
    {
        if (!session('registration_data')) {
            return redirect()->route('register');
        }

        return view('auth.verify', [
            'email' => session('registration_data.email'),
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

        $registrationData = session('registration_data');

        if (!$registrationData) {
            return redirect()->route('register')->withErrors(['email' => 'Session expired. Please register again.']);
        }

        // Verify the code
        if (!VerificationCode::verifyCode($registrationData['email'], $request->verification_code, 'registration')) {
            return back()->withErrors(['verification_code' => 'Invalid or expired verification code.']);
        }

        // Create the user
        $user = $this->create($registrationData);

        // Clear session
        session()->forget(['registration_data', 'verification_code_preview']);

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
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'referral_code' => ['required', 'string', 'exists:users,referral_code'],
            'terms' => ['accepted'],
        ], [
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
