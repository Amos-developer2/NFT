@extends('layouts.auth')

@section('content')
<!-- Header -->
<div class="auth-header-bar">
    <a href="{{ url('/') }}" class="back-btn">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7" />
        </svg>
    </a>
    <h1 class="header-title">Sign In</h1>
    <div class="header-spacer"></div>
</div>

<!-- Logo Section -->
<div class="auth-branding">
    <div class="auth-logo-large">
        <img src="/icons/diamond.svg" alt="TradeX" width="48" height="48">
    </div>
    <h2 class="brand-title">TradeX</h2>
    <p class="brand-tagline">Your NFT Trading Platform</p>
</div>

<!-- Login Card -->
<div class="auth-card-new">
    <div class="card-header">
        <h3 class="card-title">Welcome Back</h3>
        <p class="card-subtitle">Sign in to continue trading</p>
    </div>

    @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form-new">
        @csrf

        <!-- Username Field -->
        <div class="input-group">
            <label for="name" class="input-label">Username</label>
            <div class="input-wrapper">
                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                <input
                    id="name"
                    type="text"
                    class="input-field @error('name') is-invalid @enderror"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autocomplete="username"
                    autofocus
                    placeholder="Enter your username">
            </div>
            @error('name')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password Field -->
        <div class="input-group">
            <label for="password" class="input-label">Password</label>
            <div class="input-wrapper">
                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
                <input
                    id="password"
                    type="password"
                    class="input-field @error('password') is-invalid @enderror"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password">
            </div>
            @error('password')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember & Forgot -->
        <div class="form-options">
            <label class="checkbox-label">
                <input type="checkbox" name="remember" class="checkbox-input" {{ old('remember') ? 'checked' : '' }}>
                <span class="checkbox-text">Remember me</span>
            </label>
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">
            <span>Sign In</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
        </button>
    </form>

    <!-- Register Link -->
    <div class="auth-switch">
        <span>Don't have an account?</span>
        <a href="{{ route('register') }}" class="switch-link">Sign Up</a>
    </div>
</div>

<!-- Bottom Decoration -->
<div class="auth-decoration">
    <div class="decoration-circle"></div>
    <div class="decoration-circle small"></div>
</div>
@endsection