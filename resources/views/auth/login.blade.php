@extends('layouts.auth')

@section('content')
<div class="nft-login-wrapper">
    <!-- Animated Background -->
    <div class="nft-bg-effects">
        <div class="nft-grid-overlay"></div>
        <div class="nft-glow-line"></div>
    </div>

    <!-- Header -->
    <div class="nft-header">
        <a href="{{ url('/') }}" class="nft-back-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
        </a>
        <div class="nft-header-badge">
            <span class="badge-dot"></span>
            <span>Secure Login</span>
        </div>
    </div>

    <!-- Logo Section -->
    <div class="nft-logo-section">
        <img src="/images/vortex.png" alt="Vortex" class="vortex-logo">
        <p class="nft-tagline">
            <span class="tagline-icon">✨</span>
            The Future of Digital Assets
            <span class="tagline-icon">✨</span>
        </p>
    </div>

    <!-- Login Form -->
    <div class="nft-login-form-wrapper">
        <div class="nft-form-header">
            <h2 class="nft-form-title">Welcome Back</h2>
            <p class="nft-form-subtitle">Enter your credentials to access your portfolio</p>
        </div>

        @if(session('status'))
        <div class="nft-alert nft-alert-success">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <span>{{ session('status') }}</span>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="nft-login-form">
            @csrf

            <!-- Username Field -->
            <div class="nft-input-group">
                <label for="name" class="nft-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    Username
                </label>
                <div class="nft-input-wrapper @error('name') has-error @enderror">
                    <svg class="input-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    <input
                        id="name"
                        type="text"
                        class="nft-input"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autocomplete="username"
                        autofocus
                        placeholder="Enter your username">
                </div>
                @error('name')
                <span class="nft-error">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ $message }}
                </span>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="nft-input-group">
                <label for="password" class="nft-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    Password
                </label>
                <div class="nft-input-wrapper @error('password') has-error @enderror">
                    <svg class="input-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    <input
                        id="password"
                        type="password"
                        class="nft-input"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Enter your password">
                </div>
                @error('password')
                <span class="nft-error">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ $message }}
                </span>
                @enderror
            </div>

            <!-- Remember & Forgot -->
            <div class="nft-form-options">
                <label class="nft-checkbox">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span class="checkbox-custom"></span>
                    <span class="checkbox-label">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="nft-forgot-link">Forgot password?</a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="nft-submit-btn">
                <span class="btn-bg"></span>
                <span class="btn-content">
                    <span>Sign In</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </span>
            </button>
        </form>

        <!-- Divider -->
        <div class="nft-divider">
            <span>or continue with</span>
        </div>

        <!-- Social Login -->
        <div class="nft-social-login">
            <button type="button" class="nft-social-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
            </button>
            <button type="button" class="nft-social-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                </svg>
            </button>
            <button type="button" class="nft-social-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                </svg>
            </button>
        </div>

        <!-- Register Link -->
        <div class="nft-register-link">
            <span>New to Vortex?</span>
            <a href="{{ route('register') }}">Create Account <span class="arrow">→</span></a>
        </div>
    </div>

    <!-- Bottom Stats -->
    <div class="nft-stats-bar">
        <div class="stat-item">
            <span class="stat-value">50K+</span>
            <span class="stat-label">Users</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <span class="stat-value">$2.5M</span>
            <span class="stat-label">Volume</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <span class="stat-value">10K+</span>
            <span class="stat-label">NFTs</span>
        </div>
    </div>
</div>

<style>
/* NFT Login Page Styles - Light Theme */
.nft-login-wrapper {
    min-height: 100vh;
    min-height: 100dvh;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%);
    padding: 0 0 20px;
}

/* Animated Background Effects */
.nft-bg-effects {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    overflow: hidden;
    pointer-events: none;
}

.nft-grid-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        linear-gradient(rgba(42, 108, 246, 0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(42, 108, 246, 0.04) 1px, transparent 1px);
    background-size: 50px 50px;
}

.nft-glow-line {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, transparent, #2A6CF6, #3B8CFF, #2A6CF6, transparent);
    animation: glowPulse 3s ease-in-out infinite;
}

@keyframes glowPulse {
    0%, 100% { opacity: 0.6; }
    50% { opacity: 1; }
}

/* Header */
.nft-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    position: relative;
    z-index: 10;
}

.nft-back-btn {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-radius: 14px;
    color: #475569;
    text-decoration: none;
    border: 1px solid rgba(99, 102, 241, 0.15);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.nft-back-btn:active {
    transform: scale(0.95);
    background: #fff;
}

.nft-header-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: rgba(34, 197, 94, 0.1);
    border-radius: 20px;
    border: 1px solid rgba(34, 197, 94, 0.2);
}

.badge-dot {
    width: 8px;
    height: 8px;
    background: #22c55e;
    border-radius: 50%;
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.2); }
}

.nft-header-badge span:last-child {
    font-size: 12px;
    font-weight: 600;
    color: #16a34a;
    letter-spacing: 0.5px;
}

/* Logo Section */
.nft-logo-section {
    text-align: center;
    padding: 20px 20px 30px;
    position: relative;
    z-index: 10;
}

.vortex-logo {
    max-width: 280px;
    width: 100%;
    height: auto;
    margin-bottom: 12px;
    filter: drop-shadow(0 4px 12px rgba(99, 102, 241, 0.2));
}

.nft-tagline {
    font-size: 14px;
    color: #64748b;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.tagline-icon {
    font-size: 12px;
}

/* Login Form Wrapper */
.nft-login-form-wrapper {
    margin: 0 20px;
    padding: 0 4px;
    position: relative;
    z-index: 10;
}

.nft-form-header {
    text-align: center;
    margin-bottom: 28px;
}

.nft-form-title {
    font-size: 24px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 6px;
}

.nft-form-subtitle {
    font-size: 14px;
    color: #64748b;
    margin: 0;
}

/* Alert */
.nft-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: 12px;
    margin-bottom: 20px;
    font-size: 14px;
}

.nft-alert-success {
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.2);
    color: #16a34a;
}

/* Form Styles */
.nft-login-form {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.nft-input-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.nft-label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    font-weight: 600;
    color: #334155;
    letter-spacing: 0.3px;
}

.nft-label svg {
    color: #2A6CF6;
    opacity: 0.9;
}

.nft-input-wrapper {
    position: relative;
}

.nft-input-wrapper::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 8px;
    padding: 2px;
    background: linear-gradient(135deg, #e2e8f0, #f1f5f9);
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
    transition: all 0.3s ease;
    opacity: 0.6;
}

.nft-input-wrapper:focus-within::before {
    background: linear-gradient(135deg, #2A6CF6, #3B8CFF, #60a5fa);
}

.nft-input {
    width: 100%;
    padding: 18px 20px 18px 52px;
    background: rgba(255, 255, 255, 0.6);
    border: none;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
    color: #1e293b;
    transition: all 0.3s ease;
    box-sizing: border-box;
    box-shadow: 
        inset 0 2px 4px rgba(0, 0, 0, 0.02),
        0 4px 12px rgba(42, 108, 246, 0.06);
}

.nft-input-wrapper .input-icon {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    width: 22px;
    height: 22px;
    color: #94a3b8;
    transition: all 0.3s ease;
    z-index: 2;
    pointer-events: none;
}

.nft-input-wrapper:focus-within .input-icon {
    color: #2A6CF6;
}

.nft-input::placeholder {
    color: #94a3b8;
    font-weight: 400;
}

.nft-input:focus {
    outline: none;
    background: rgba(255, 255, 255, 0.8);
    box-shadow: 
        inset 0 2px 4px rgba(42, 108, 246, 0.04),
        0 8px 24px rgba(42, 108, 246, 0.12);
}

.nft-input-wrapper.has-error::before {
    background: linear-gradient(135deg, #f43f5e, #fb7185);
}

.nft-input-wrapper.has-error .nft-input {
    background: rgba(254, 242, 242, 0.7);
}

.nft-input-wrapper.has-error .input-icon {
    color: #f43f5e;
}

.input-focus-effect {
    display: none;
}

.nft-error {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 500;
    color: #e11d48;
    margin-top: 6px;
    padding: 8px 12px;
    background: linear-gradient(135deg, #fef2f2, #fff1f2);
    border-radius: 6px;
    border-left: 3px solid #e11d48;
}

/* Form Options */
.nft-form-options {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: -8px;
}

.nft-checkbox {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
}

.nft-checkbox input {
    display: none;
}

.checkbox-custom {
    width: 20px;
    height: 20px;
    border: 2px solid #cbd5e1;
    border-radius: 6px;
    position: relative;
    transition: all 0.3s ease;
    background: #ffffff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.nft-checkbox input:checked + .checkbox-custom {
    background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
    border-color: transparent;
}

.nft-checkbox input:checked + .checkbox-custom::after {
    content: '';
    position: absolute;
    top: 3px;
    left: 6px;
    width: 5px;
    height: 10px;
    border: solid #fff;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.checkbox-label {
    font-size: 14px;
    color: #64748b;
}

.nft-forgot-link {
    font-size: 14px;
    color: #2A6CF6;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.nft-forgot-link:hover {
    color: #3B8CFF;
}

/* Submit Button */
.nft-submit-btn {
    position: relative;
    width: 100%;
    padding: 16px 24px;
    border: none;
    border-radius: 14px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    overflow: hidden;
    margin-top: 8px;
}

.btn-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 50%, #60a5fa 100%);
    transition: opacity 0.3s ease;
}

.btn-bg::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    animation: btnShimmer 2s infinite;
}

@keyframes btnShimmer {
    0% { left: -100%; }
    100% { left: 100%; }
}

.btn-content {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    color: #fff;
}

.nft-submit-btn:active {
    transform: scale(0.98);
}

/* Divider */
.nft-divider {
    display: flex;
    align-items: center;
    gap: 16px;
    margin: 24px 0;
}

.nft-divider::before,
.nft-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
}

.nft-divider span {
    font-size: 12px;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Social Login */
.nft-social-login {
    display: flex;
    justify-content: center;
    gap: 16px;
}

.nft-social-btn {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    color: #475569;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.nft-social-btn:hover {
    background: #fff;
    border-color: #2A6CF6;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(42, 108, 246, 0.15);
}

.nft-social-btn:active {
    transform: scale(0.95);
}

/* Register Link */
.nft-register-link {
    text-align: center;
    margin-top: 24px;
    font-size: 14px;
    color: #64748b;
}

.nft-register-link a {
    color: #2A6CF6;
    text-decoration: none;
    font-weight: 600;
    margin-left: 4px;
    transition: color 0.3s ease;
}

.nft-register-link a:hover {
    color: #3B8CFF;
}

.nft-register-link .arrow {
    display: inline-block;
    transition: transform 0.3s ease;
}

.nft-register-link a:hover .arrow {
    transform: translateX(4px);
}

/* Stats Bar */
.nft-stats-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 24px;
    margin-top: 28px;
    padding: 16px 20px;
    position: relative;
    z-index: 10;
}

.stat-item {
    text-align: center;
}

.stat-value {
    display: block;
    font-size: 18px;
    font-weight: 700;
    background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stat-label {
    font-size: 11px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.stat-divider {
    width: 1px;
    height: 30px;
    background: linear-gradient(180deg, transparent, #cbd5e1, transparent);
}
</style>
@endsection