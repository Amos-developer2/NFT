<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AccountController extends Controller
{

    /**
     * Send a verification code to the user's email for password change.
     */
    public function sendVerificationCode(Request $request)
    {
        $user = Auth::user();
        $code = random_int(100000, 999999);
        session(['password_verification_code' => $code]);

        // Send code via email (simple mail for demo)
        \Mail::raw("Your password change verification code is: $code", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Password Change Verification Code');
        });

        return response()->json(['sent' => true]);
    }

    /**
     * Verify the code entered by the user for password change.
     */
    public function verifyVerificationCode(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);
        $valid = session('password_verification_code') && $request->code == session('password_verification_code');
        if ($valid) {
            session(['password_verification_code_verified' => true]);
        }
        return response()->json(['valid' => $valid]);
    }
    /**
     * Display the account settings page.
     */
    public function index()
    {
        return view('account');
    }

    /**
     * Display the profile edit page.
     */
    public function editProfile()
    {
        return view('account-profile');
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        if ($user->name === $request->name) {
            return redirect()->back()->withErrors(['name' => 'The new name must be different from the current name.']);
        }
        $user->name = $request->name;
        $user->save();
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Display the password change page.
     */
    public function editPassword()
    {
        return view('account-password');
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('account')->with('success', 'Password updated successfully!');
    }

    /**
     * Display the PIN edit page.
     */
    public function editPin()
    {
        return view('account-pin');
    }

    /**
     * Update user withdrawal PIN.
     */
    public function updatePin(Request $request)
    {
        $user = Auth::user();

        // If user has existing PIN, require current PIN
        if ($user->withdrawal_pin) {
            $request->validate([
                'current_pin' => 'required|digits:4',
                'pin' => 'required|digits:4|confirmed',
            ]);

            if ($user->withdrawal_pin !== $request->current_pin) {
                return back()->withErrors(['current_pin' => 'Current PIN is incorrect.']);
            }
        } else {
            $request->validate([
                'pin' => 'required|digits:4|confirmed',
            ]);
        }

        $user->withdrawal_pin = $request->pin;
        $user->save();

        return redirect()->route('account')->with('success', 'Withdrawal PIN updated successfully!');
    }
}
