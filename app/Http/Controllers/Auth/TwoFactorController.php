<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function index()
    {
        if (!session('2fa:user:id')) {
            return redirect()->route('login');
        }
        return view('auth.2fa');
    }

    public function verify(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);
        $userId = session('2fa:user:id');
        if (!$userId) {
            return redirect()->route('login');
        }
        $user = \App\Models\User::find($userId);
        if (!$user || !$user->two_factor_enabled) {
            return redirect()->route('login');
        }
        $google2fa = app('pragmarx.google2fa');
        if ($google2fa->verifyKey($user->google2fa_secret, $request->otp)) {
            Auth::login($user);
            session()->forget('2fa:user:id');
            return redirect()->intended('/');
        } else {
            return back()->with('error', 'Invalid authentication code.');
        }
    }
}
