@extends('layouts.auth')

@section('content')
<!-- Header -->
<div class="auth-header-bar">
    <a href="{{ route('login') }}" class="back-btn">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7" />
        </svg>
    </a>
    <h1 class="header-title">Sign Up</h1>
    <div class="header-spacer"></div>
</div>

<!-- Logo Section -->
<div class="auth-branding compact">
    <div class="auth-logo-large">
        <img src="/icons/diamond.svg" alt="TradeX" width="48" height="48">
    </div>
    <h2 class="brand-title">Join TradeX</h2>
    <p class="brand-tagline">Start your NFT trading journey</p>
</div>

<!-- Register Card -->
<div class="auth-card-new">
    <div class="card-header">
        <h3 class="card-title">Create Account</h3>
        <p class="card-subtitle">Fill in your details to get started</p>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="auth-form-new">
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
                    placeholder="Choose a username">
            </div>
            @error('name')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email Field -->
        <div class="input-group">
            <label for="email" class="input-label">Email Address</label>
            <div class="input-wrapper">
                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                    <polyline points="22,6 12,13 2,6" />
                </svg>
                <input
                    id="email"
                    type="email"
                    class="input-field @error('email') is-invalid @enderror"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    placeholder="Enter your email">
            </div>
            @error('email')
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
                    autocomplete="new-password"
                    placeholder="Create a password (min 8 chars)">
            </div>
            @error('password')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password Field -->
        <div class="input-group">
            <label for="password-confirm" class="input-label">Confirm Password</label>
            <div class="input-wrapper">
                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
                <input
                    id="password-confirm"
                    type="password"
                    class="input-field"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Confirm your password">
            </div>
        </div>

        <!-- Referral Code Field -->
        <div class="input-group">
            <label for="referral_code" class="input-label">
                Referral Code <span class="required-tag">*</span>
            </label>
            <div class="input-wrapper">
                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                <input
                    id="referral_code"
                    type="text"
                    class="input-field @error('referral_code') is-invalid @enderror"
                    name="referral_code"
                    value="{{ old('referral_code', request()->query('ref')) }}"
                    required
                    autocomplete="off"
                    placeholder="Enter your invitation code">
            </div>
            @error('referral_code')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Terms Checkbox -->
        <div class="terms-group">
            <label class="checkbox-label terms">
                <input type="checkbox" name="terms" class="checkbox-input" required {{ old('terms') ? 'checked' : '' }}>
                <span class="checkbox-text">
                    I agree to the <a href="#" class="link-blue">Terms of Service</a> and <a href="#" class="link-blue">Privacy Policy</a>
                </span>
            </label>
            @error('terms')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">
            <span>Continue</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
        </button>
    </form>

    <!-- Login Link -->
    <div class="auth-switch">
        <span>Already have an account?</span>
        <a href="{{ route('login') }}" class="switch-link">Sign In</a>
    </div>
</div>

<!-- Bottom Decoration -->
<div class="auth-decoration">
    <div class="decoration-circle"></div>
    <div class="decoration-circle small"></div>
</div>
@endsection