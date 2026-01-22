@extends('layouts.auth')

@section('content')
@php
// Mask email like exa*********@gmail.com
[$name, $domain] = explode('@', $email);
$maskedName = substr($name, 0, 3) . str_repeat('*', max(strlen($name) - 3, 5));
$maskedEmail = $maskedName . '@' . $domain;
@endphp

<div class="nft-code-wrapper">
    <!-- Animated Background -->
    <div class="nft-bg-effects">
        <div class="nft-grid-overlay"></div>
        <div class="nft-glow-line"></div>
    </div>

    <!-- Header -->
    <div class="nft-header">
        <a href="{{ route('password.request') }}" class="nft-back-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
        </a>
        <div class="nft-header-badge">
            <span class="badge-dot"></span>
            <span>Verification</span>
        </div>
    </div>

    <!-- Logo Section -->
    <div class="nft-logo-section">
        <img src="/images/vortex.png" alt="Vortex" class="vortex-logo">
        <p class="nft-tagline">
            <span class="tagline-icon">📧</span>
            Check Your Email
            <span class="tagline-icon">📧</span>
        </p>
    </div>

    <!-- Code Form -->
    <div class="nft-form-wrapper">
        <div class="nft-form-header">
            <h2 class="nft-form-title">Verify Code</h2>
            <p class="nft-form-subtitle">Code sent to <strong>{{ $maskedEmail }}</strong></p>
        </div>

        @if ($errors->any())
        <div class="nft-alert nft-alert-error">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
            </svg>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <form method="POST" action="{{ route('password.code.verify') }}" id="otpForm" class="nft-code-form" autocomplete="off">
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
                        <input type="text" maxlength="1" class="nft-otp-box" inputmode="numeric" pattern="[0-9]*">
                </div>
                @endfor
            </div>
    </div>

    <input type="hidden" name="email" value="{{ $email }}">
    <input type="hidden" name="code" id="finalCode">

    <!-- Timer -->
    <div class="nft-timer">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10" />
            <polyline points="12 6 12 12 16 14" />
        </svg>
        <span>Code expires in</span>
        <strong id="countdown">10:00</strong>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="nft-submit-btn">
        <span class="btn-bg"></span>
        <span class="btn-content">
            <span>Verify Code</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
        </span>
    </button>
    </form>

    <!-- Resend Link -->
    <div class="nft-resend-link">
        <span>Didn't receive the code?</span>
        <form method="POST" action="{{ route('password.email') }}" style="display: inline;">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <button type="submit" id="resendBtn" disabled>Resend (60s)</button>
        </form>
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
    /* NFT Code Verification Page Styles */
    .nft-code-wrapper {
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

        0%,
        100% {
            opacity: 0.6;
        }

        50% {
            opacity: 1;
        }
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
        background: rgba(139, 92, 246, 0.1);
        border-radius: 20px;
        border: 1px solid rgba(139, 92, 246, 0.2);
    }

    .badge-dot {
        width: 8px;
        height: 8px;
        background: #8b5cf6;
        border-radius: 50%;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.5;
            transform: scale(1.2);
        }
    }

    .nft-header-badge span:last-child {
        font-size: 12px;
        font-weight: 600;
        color: #7c3aed;
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
        margin: 0;
    }

    .nft-form-subtitle strong {
        color: #2A6CF6;
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

    .nft-alert-error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #dc2626;
    }

    /* Form Styles */
    .nft-code-form {
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

    /* Timer */
    .nft-timer {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 13px;
        color: #64748b;
        padding: 12px 16px;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 12px;
        border: 1px solid rgba(42, 108, 246, 0.1);
    }

    .nft-timer svg {
        color: #2A6CF6;
    }

    .nft-timer strong {
        color: #2A6CF6;
        font-size: 14px;
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
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: btnShimmer 2s infinite;
    }

    @keyframes btnShimmer {
        0% {
            left: -100%;
        }

        100% {
            left: 100%;
        }
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

    /* Resend Link */
    .nft-resend-link {
        text-align: center;
        margin-top: 20px;
        font-size: 13px;
        color: #64748b;
    }

    .nft-resend-link button {
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

    .nft-resend-link button:hover:not(:disabled) {
        color: #3B8CFF;
    }

    .nft-resend-link button:disabled {
        color: #94a3b8;
        cursor: not-allowed;
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
const boxes = [...document.querySelectorAll('.nft-otp-box')];
const hidden = document.getElementById('finalCode');
const resendBtn = document.getElementById('resendBtn');

/* OTP INPUT */
boxes.forEach((box, i) => {
box.addEventListener('input', (e) => {
// Only allow numbers
box.value = box.value.replace(/[^0-9]/g, '');

if (box.value) {
box.classList.add('filled');
if (boxes[i + 1]) boxes[i + 1].focus();
} else {
box.classList.remove('filled');
}
hidden.value = boxes.map(b => b.value).join('');
});

box.addEventListener('keydown', (e) => {
if (e.key === 'Backspace' && !box.value && boxes[i - 1]) {
boxes[i - 1].focus();
}
});

box.addEventListener('focus', () => {
box.select();
});
});

/* PASTE SUPPORT */
document.addEventListener('paste', e => {
const data = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
data.split('').forEach((v, i) => {
if (boxes[i]) {
boxes[i].value = v;
boxes[i].classList.add('filled');
}
});
hidden.value = data;
if (boxes[data.length - 1]) boxes[data.length - 1].focus();
});

/* 10-MIN COUNTDOWN */
let time = 600; // 10 minutes
const cd = document.getElementById('countdown');

const countdownInterval = setInterval(() => {
if (time <= 0) {
    cd.textContent='Expired' ;
    cd.style.color='#ef4444' ;
    clearInterval(countdownInterval);
    return;
    }
    time--;
    cd.textContent=String(Math.floor(time / 60)).padStart(2, '0' ) + ':' +
    String(time % 60).padStart(2, '0' );
    }, 1000);

    /* RESEND COOLDOWN */
    let resend=60;
    const rTimer=setInterval(()=> {
    resend--;
    resendBtn.textContent = resend > 0 ? `Resend (${resend}s)` : 'Resend Code';
    resendBtn.disabled = resend > 0;
    if (resend <= 0) clearInterval(rTimer);
        }, 1000);
        });
        // Client-side validation for 6-digit code
        document.addEventListener('DOMContentLoaded', function() {
        // ...existing code...

        // Add form validation
        const otpForm=document.getElementById('otpForm');
        otpForm.addEventListener('submit', function(e) {
        if (hidden.value.length !==6 || !/^\d{6}$/.test(hidden.value)) {
        e.preventDefault();
        alert('Please enter the full 6-digit code.');
        boxes[0].focus();
        }
        });
        });
        </script>
        @endsection