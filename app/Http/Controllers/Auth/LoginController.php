<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'name';
    }

    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        // Only allow login if verification_code is null (i.e., user is verified)
        $credentials['verification_code'] = null;
        return $credentials;
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->two_factor_enabled) {
            // Store user id in session and logout
            session(['2fa:user:id' => $user->id]);
            Auth::logout();
            return redirect()->route('2fa.index');
        }
        // Redirect admin users to admin dashboard
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        // Default redirect for normal users
        return redirect($this->redirectTo);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = \App\Models\User::where($this->username(), $request->input($this->username()))->first();
        if ($user && $user->verification_code !== null) {
            // User is not verified
            return redirect()->route('register.verify')->withErrors([
                $this->username() => 'Please verify your email before logging in. Check your email for the verification code.',
            ]);
        }
        $username = $request->input('name');
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            return back()
                ->withInput($request->only('name', 'remember'))
                ->withErrors(['name' => 'Please use your username to login, not your email address.']);
        }
        return back()
            ->withInput($request->only('name', 'remember'))
            ->withErrors(['name' => trans('auth.failed')]);
    }
}
