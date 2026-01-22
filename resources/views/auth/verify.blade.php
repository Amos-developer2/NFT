@extends('layouts.auth')

@section('content')
<div class="nft-verify-wrapper">
    <!-- Animated Background -->
    <div class="nft-bg-effects">
        <div class="nft-grid-overlay"></div>
        <div class="nft-glow-line"></div>
    </div>

    <!-- Header -->
    <div class="nft-header">
        <a href="{{ route('register') }}" class="nft-back-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
        </a>
        <div class="nft-header-badge">
            <span class="badge-dot"></span>
            <span>Email Verification</span>
        </div>
    </div>

    <!-- Logo Section -->
    <div class="nft-logo-section">
        <img src="/images/vortex.png" alt="Vortex" class="vortex-logo">
        <p class="nft-tagline">
            <span class="tagline-icon">📧</span>
            Check Your Inbox
            <span class="tagline-icon">📧</span>
        </p>
    </div>

    <!-- Verify Form -->
    <div class="nft-form-wrapper">
        <div class="nft-form-header">
            <h2 class="nft-form-title">Verify Your Email</h2>
            <p class="nft-form-subtitle">We've sent a 6-digit code to</p>
            <p class="nft-email-display">{{ $email }}</p>
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

        @if($errors->any())
        <div class="nft-alert nft-alert-error">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <!-- Preview Code (Development Only) -->
        @if(isset($preview_code))
        <div class="nft-preview-code">
            <span class="preview-label">Dev Preview:</span>
            <span class="preview-value">{{ $preview_code }}</span>
        </div>
        @endif

        <form method="POST" action="{{ route('register.verify.submit') }}" class="nft-verify-form" id="verifyForm">
            @csrf

            <!-- OTP Input Group -->
            <div class="nft-otp-section">
                <label class="nft-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    Enter 6-Digit Code
                </label>
                <div class="nft-otp-group">
                    @for($i = 0; $i < 6; $i++)
                    <div class="nft-otp-wrapper">
                        <input type="text" maxlength="1" class="nft-otp-box" data-index="{{ $i }}" inputmode="numeric" pattern="[0-9]*" {{ $i === 0 ? 'autofocus' : '' }}>
                    </div>
                    @endfor
                </div>
                <input type="hidden" name="verification_code" id="verificationCode">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="nft-submit-btn" id="verifyBtn" disabled>
                <span class="btn-bg"></span>
                <span class="btn-content">
                    <span>Verify & Create Account</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </span>
            </button>
        </form>

        <!-- Resend Link -->
        <div class="nft-resend-section">
            <span>Didn't receive the code?</span>
            <form method="POST" action="{{ route('register.resend') }}" style="display: inline;">
                @csrf
                <button type="submit" class="nft-resend-btn" id="resendBtn">Resend Code</button>
            </form>
            <p class="nft-resend-timer" id="resendTimer" style="display: none;">
                Resend available in <strong id="countdown">60</strong>s
            </p>
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
/* NFT Verify Page Styles */
.nft-verify-wrapper {
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
    padding: 15px 20px 25px;
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
    margin: 0 0 6px;
}

.nft-form-subtitle {
    font-size: 13px;
    color: #64748b;
    margin: 0 0 4px;
}

.nft-email-display {
    font-size: 14px;
    font-weight: 600;
    color: #2A6CF6;
    margin: 0;
    word-break: break-all;
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

.nft-alert-error {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    color: #dc2626;
}

/* Preview Code */
.nft-preview-code {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px 16px;
    background: rgba(42, 108, 246, 0.08);
    border: 1px dashed rgba(42, 108, 246, 0.3);
    border-radius: 12px;
    margin-bottom: 20px;
}

.nft-preview-code .preview-label {
    font-size: 12px;
    color: #64748b;
}

.nft-preview-code .preview-value {
    font-size: 18px;
    font-weight: 700;
    color: #2A6CF6;
    letter-spacing: 4px;
}

/* Form Styles */
.nft-verify-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.nft-otp-section {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.nft-label {
    display: flex;
    align-items: center;
    justify-content: center;
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

/* OTP Input Group */
.nft-otp-group {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.nft-otp-wrapper {
    position: relative;
}

.nft-otp-wrapper::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 12px;
    padding: 2px;
    background: linear-gradient(135deg, #e2e8f0, #f1f5f9);
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
    transition: all 0.3s ease;
    opacity: 0.6;
}

.nft-otp-wrapper:focus-within::before {
    background: linear-gradient(135deg, #2A6CF6, #3B8CFF, #60a5fa);
    opacity: 1;
}

.nft-otp-box {
    width: 48px;
    height: 58px;
    background: rgba(255, 255, 255, 0.6);
    border: none;
    border-radius: 12px;
    font-size: 22px;
    font-weight: 700;
    text-align: center;
    color: #1e293b;
    outline: none;
    transition: all 0.3s ease;
    box-shadow: 
        inset 0 2px 4px rgba(0, 0, 0, 0.02),
        0 4px 12px rgba(42, 108, 246, 0.06);
}

.nft-otp-box:focus {
    background: rgba(255, 255, 255, 0.9);
    box-shadow: 
        inset 0 2px 4px rgba(42, 108, 246, 0.04),
        0 8px 24px rgba(42, 108, 246, 0.15);
}

.nft-otp-box.filled {
    background: rgba(42, 108, 246, 0.08);
    color: #2A6CF6;
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
    margin-top: 4px;
    transition: opacity 0.3s ease;
}

.nft-submit-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
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

.nft-submit-btn:active:not(:disabled) {
    transform: scale(0.98);
}

/* Resend Section */
.nft-resend-section {
    text-align: center;
    margin-top: 20px;
    font-size: 13px;
    color: #64748b;
}

.nft-resend-btn {
    background: none;
    border: none;
    color: #2A6CF6;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    margin-left: 4px;
    padding: 0;
    transition: color 0.3s ease;
}

.nft-resend-btn:hover {
    color: #3B8CFF;
}

.nft-resend-timer {
    margin: 8px 0 0;
    font-size: 13px;
    color: #64748b;
}

.nft-resend-timer strong {
    color: #2A6CF6;
}

/* Stats Bar */
.nft-stats-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 24px;
    margin-top: 28px;
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

@media (max-width: 380px) {
    .nft-otp-box {
        width: 42px;
        height: 52px;
        font-size: 20px;
    }
    
    .nft-otp-group {
        gap: 8px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const codeInputs = document.querySelectorAll('.nft-otp-box');
    const hiddenInput = document.getElementById('verificationCode');
    const verifyBtn = document.getElementById('verifyBtn');
    const resendBtn = document.getElementById('resendBtn');
    const resendTimer = document.getElementById('resendTimer');
    const countdown = document.getElementById('countdown');

    // Handle input
    codeInputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');

            if (this.value) {
                this.classList.add('filled');
                if (index < codeInputs.length - 1) {
                    codeInputs[index + 1].focus();
                }
            } else {
                this.classList.remove('filled');
            }

            updateHiddenInput();
        });

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && index > 0) {
                codeInputs[index - 1].focus();
            }
        });

        input.addEventListener('focus', function() {
            this.select();
        });

        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 6);

            pastedData.split('').forEach((char, i) => {
                if (codeInputs[i]) {
                    codeInputs[i].value = char;
                    codeInputs[i].classList.add('filled');
                }
            });

            updateHiddenInput();

            if (pastedData.length > 0) {
                const focusIndex = Math.min(pastedData.length, codeInputs.length - 1);
                codeInputs[focusIndex].focus();
            }
        });
    });

    function updateHiddenInput() {
        let code = '';
        codeInputs.forEach(input => {
            code += input.value;
        });
        hiddenInput.value = code;
        verifyBtn.disabled = code.length !== 6;
    }

    // Resend timer
    let timerInterval;

    resendBtn.addEventListener('click', function(e) {
        setTimeout(startCountdown, 100);
    });

    function startCountdown() {
        let seconds = 60;
        resendBtn.style.display = 'none';
        resendTimer.style.display = 'block';

        timerInterval = setInterval(() => {
            seconds--;
            countdown.textContent = seconds;

            if (seconds <= 0) {
                clearInterval(timerInterval);
                resendBtn.style.display = 'inline';
                resendTimer.style.display = 'none';
            }
        }, 1000);
    }
});
</script>
@endsection