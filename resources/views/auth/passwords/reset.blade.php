@extends('layouts.auth')

@section('content')
<div class="nft-password-wrapper">
    <!-- Animated Background -->
    <div class="nft-bg-effects">
        <div class="nft-grid-overlay"></div>
        <div class="nft-glow-line"></div>
    </div>

    <!-- Header -->
    <div class="nft-header">
        <a href="{{ route('login') }}" class="nft-back-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
        </a>
        <div class="nft-header-badge">
            <span class="badge-dot"></span>
            <span>New Password</span>
        </div>
    </div>

    <!-- Logo Section -->
    <div class="nft-logo-section">
        <img src="/images/vortex.png" alt="Vortex" class="vortex-logo">
        <p class="nft-tagline">
            <span class="tagline-icon">🔐</span>
            Create Your New Password
            <span class="tagline-icon">🔐</span>
        </p>
    </div>

    <!-- Reset Form -->
    <div class="nft-form-wrapper">
        <div class="nft-form-header">
            <h2 class="nft-form-title">Set New Password</h2>
            <p class="nft-form-subtitle">Enter your new secure password below</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="nft-reset-form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email Field -->
            <div class="nft-input-group">
                <label for="email" class="nft-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                    Email Address
                </label>
                <div class="nft-input-wrapper @error('email') has-error @enderror">
                    <svg class="input-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                    <input
                        id="email"
                        type="email"
                        class="nft-input"
                        name="email"
                        value="{{ $email ?? old('email') }}"
                        required
                        autocomplete="email"
                        placeholder="Enter your email">
                </div>
                @error('email')
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
                    New Password
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
                        autocomplete="new-password"
                        placeholder="Enter new password">
                    <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                        <svg class="eye-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
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

            <!-- Confirm Password Field -->
            <div class="nft-input-group">
                <label for="password-confirm" class="nft-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 11l3 3L22 4" />
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                    </svg>
                    Confirm Password
                </label>
                <div class="nft-input-wrapper">
                    <svg class="input-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 11l3 3L22 4" />
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                    </svg>
                    <input
                        id="password-confirm"
                        type="password"
                        class="nft-input"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Confirm new password">
                    <button type="button" class="password-toggle" onclick="togglePassword('password-confirm', this)">
                        <svg class="eye-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="nft-submit-btn">
                <span class="btn-bg"></span>
                <span class="btn-content">
                    <span>Reset Password</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </span>
            </button>
        </form>

        <!-- Login Link -->
        <div class="nft-login-link">
            <span>Remember your password?</span>
            <a href="{{ route('login') }}">Sign In <span class="arrow">→</span></a>
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
/* NFT Password Reset Page Styles */
.nft-password-wrapper {
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
    border: 1px solid rgba(42, 108, 246, 0.15);
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
    padding: 10px 20px 20px;
    position: relative;
    z-index: 10;
}

.vortex-logo {
    max-width: 250px;
    width: 100%;
    height: auto;
    margin-bottom: 10px;
    filter: drop-shadow(0 4px 12px rgba(42, 108, 246, 0.2));
}

.nft-tagline {
    font-size: 13px;
    color: #64748b;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.tagline-icon {
    font-size: 11px;
}

/* Form Wrapper */
.nft-form-wrapper {
    margin: 0 20px;
    padding: 0 4px;
    position: relative;
    z-index: 10;
}

.nft-form-header {
    text-align: center;
    margin-bottom: 24px;
}

.nft-form-title {
    font-size: 22px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 4px;
}

.nft-form-subtitle {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}

/* Form Styles */
.nft-reset-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.nft-input-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.nft-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
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
    opacity: 1;
}

.nft-input {
    width: 100%;
    padding: 16px 52px 16px 48px;
    background: rgba(255, 255, 255, 0.6);
    border: none;
    border-radius: 8px;
    font-size: 14px;
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
    left: 14px;
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

.password-toggle {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px;
    color: #94a3b8;
    transition: color 0.3s ease;
    z-index: 2;
}

.password-toggle:hover {
    color: #2A6CF6;
}

.nft-input-wrapper.has-error::before {
    background: linear-gradient(135deg, #f43f5e, #fb7185);
    opacity: 1;
}

.nft-input-wrapper.has-error .nft-input {
    background: rgba(254, 242, 242, 0.7);
}

.nft-input-wrapper.has-error .input-icon {
    color: #f43f5e;
}

.nft-error {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    font-weight: 500;
    color: #e11d48;
    margin-top: 4px;
    padding: 6px 10px;
    background: linear-gradient(135deg, #fef2f2, #fff1f2);
    border-radius: 6px;
    border-left: 3px solid #e11d48;
}

/* Submit Button */
.nft-submit-btn {
    position: relative;
    width: 100%;
    padding: 15px 24px;
    border: none;
    border-radius: 14px;
    font-size: 15px;
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

/* Login Link */
.nft-login-link {
    text-align: center;
    margin-top: 20px;
    font-size: 13px;
    color: #64748b;
}

.nft-login-link a {
    color: #2A6CF6;
    text-decoration: none;
    font-weight: 600;
    margin-left: 4px;
    transition: color 0.3s ease;
}

.nft-login-link a:hover {
    color: #3B8CFF;
}

.nft-login-link .arrow {
    display: inline-block;
    transition: transform 0.3s ease;
}

.nft-login-link a:hover .arrow {
    transform: translateX(4px);
}

/* Stats Bar */
.nft-stats-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 24px;
    margin-top: 24px;
    padding: 14px 20px;
    position: relative;
    z-index: 10;
}

.stat-item {
    text-align: center;
}

.stat-value {
    display: block;
    font-size: 16px;
    font-weight: 700;
    background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stat-label {
    font-size: 10px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.stat-divider {
    width: 1px;
    height: 28px;
    background: linear-gradient(180deg, transparent, #cbd5e1, transparent);
}
</style>

<script>
function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('.eye-icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" /><line x1="1" y1="1" x2="23" y2="23" />';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" /><circle cx="12" cy="12" r="3" />';
    }
}
</script>
@endsection