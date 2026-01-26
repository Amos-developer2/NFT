<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;


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

            if (!\Hash::check($request->current_pin, $user->withdrawal_pin)) {
                return back()->withErrors(['current_pin' => 'Current PIN is incorrect.']);
            }
        } else {
            $request->validate([
                'pin' => 'required|digits:4|confirmed',
            ]);
        }

        $user->withdrawal_pin = \Hash::make($request->pin);
        $user->save();

        return redirect()->route('account')->with('success', 'Withdrawal PIN updated successfully!');
    }

    /**
     * Display the withdrawal address binding page.
     */
    public function editWithdrawalAddress()
    {
        return view('account-withdrawal-address');
    }

    /**
     * Send verification code for withdrawal address binding.
     */
    public function sendAddressVerificationCode(Request $request)
    {
        $user = Auth::user();
        
        // Check if address is already bound
        if ($user->withdrawal_address) {
            return response()->json(['error' => 'Withdrawal address is already bound.'], 400);
        }
        
        $code = random_int(100000, 999999);
        session(['address_verification_code' => $code, 'address_verification_expires' => now()->addMinutes(10)]);

        Mail::raw("Your withdrawal address binding verification code is: $code\n\nThis code will expire in 10 minutes.", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Withdrawal Address Binding - Verification Code');
        });

        return response()->json(['sent' => true, 'message' => 'Verification code sent to your email.']);
    }

    /**
     * Bind withdrawal address.
     */
    public function bindWithdrawalAddress(Request $request)
    {
        $user = Auth::user();
        
        // Check if address is already bound
        if ($user->withdrawal_address) {
            return back()->withErrors(['address' => 'Withdrawal address is already bound and cannot be changed.']);
        }

        $request->validate([
            'currency_network' => 'required|in:usdt_trc20,usdt_bep20,usdc_bep20,bnb_bsc',
            'address' => 'required|string|min:20|max:100',
            'verification_code' => 'required|digits:6',
            'pin' => 'required|digits:4',
        ]);

        // Validate address format based on network
        $address = $request->address;
        $network = $request->currency_network;
        $addressValid = false;
        $expectedFormat = '';

        switch ($network) {
            case 'usdt_trc20':
                // TRON address: starts with T, 34 characters, Base58
                $addressValid = preg_match('/^T[A-HJ-NP-Za-km-z1-9]{33}$/', $address);
                $expectedFormat = 'TRON address (starts with T, 34 characters)';
                break;
            case 'usdt_bep20':
            case 'usdc_bep20':
            case 'bnb_bsc':
                // BSC/Ethereum address: starts with 0x, 42 characters (40 hex + 0x)
                $addressValid = preg_match('/^0x[a-fA-F0-9]{40}$/', $address);
                $expectedFormat = 'BSC address (starts with 0x, 42 characters)';
                break;
        }

        if (!$addressValid) {
            return back()->withErrors(['address' => "Invalid address format. Expected: {$expectedFormat}"])->withInput();
        }

        // Verify email code
        $sessionCode = session('address_verification_code');
        $expires = session('address_verification_expires');
        
        if (!$sessionCode || $request->verification_code != $sessionCode) {
            return back()->withErrors(['verification_code' => 'Invalid verification code.'])->withInput();
        }
        
        if ($expires && now()->gt($expires)) {
            return back()->withErrors(['verification_code' => 'Verification code has expired.'])->withInput();
        }

        // Verify PIN
        if (!$user->withdrawal_pin) {
            return back()->withErrors(['pin' => 'Please set a withdrawal PIN first.'])->withInput();
        }
        
        if (!Hash::check($request->pin, $user->withdrawal_pin)) {
            return back()->withErrors(['pin' => 'Incorrect withdrawal PIN.'])->withInput();
        }

        // Parse currency and network
        [$currency, $network] = explode('_', $request->currency_network);

        // Bind the address
        $user->withdrawal_address = $request->address;
        $user->withdrawal_currency = strtoupper($currency);
        $user->withdrawal_network = strtoupper($network);
        $user->withdrawal_address_bound_at = now();
        $user->save();

        // Clear session
        session()->forget(['address_verification_code', 'address_verification_expires']);

        return redirect()->route('account')->with('success', 'Withdrawal address bound successfully!');
    }
}
