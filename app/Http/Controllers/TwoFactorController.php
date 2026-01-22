<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FALaravel\Support\Authenticator;
use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFactorController extends Controller
{
    public function show2faForm(Request $request)
    {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        if (!$user->google2fa_secret) {
            $secret = $google2fa->generateSecretKey();
            $user->google2fa_secret = $secret;
            $user->save();
        } else {
            $secret = $user->google2fa_secret;
        }
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secret
        );
        return view('account-2fa', [
            'user' => $user,
            'qrImage' => $QR_Image,
            'secret' => $secret,
            'enabled' => $user->two_factor_enabled,
        ]);
    }

    public function enable2fa(Request $request)
    {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $request->validate(['otp' => 'required']);
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->otp);
        if ($valid) {
            $user->two_factor_enabled = true;
            $user->save();
            return back()->with('success', 'Two-factor authentication enabled!');
        } else {
            return back()->withErrors(['otp' => 'Invalid code. Please try again.']);
        }
    }

    public function disable2fa(Request $request)
    {
        $user = Auth::user();
        $user->two_factor_enabled = false;
        $user->google2fa_secret = null;
        $user->save();
        return back()->with('success', 'Two-factor authentication disabled.');
    }
}
