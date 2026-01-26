@extends('layouts.app')

@section('content')
<div class="withdrawal-address-wrapper">
    <!-- Header Card -->
    <div class="address-header-card">
        <div class="header-bg"></div>
        <div class="header-content">
            <div class="header-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/>
                    <path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/>
                    <path d="M18 12a2 2 0 0 0 0 4h4v-4h-4z"/>
                </svg>
            </div>
            <h1 class="header-title">Withdrawal Address</h1>
            <p class="header-subtitle">Bind your wallet address for withdrawals</p>
        </div>
    </div>

    @if(Auth::user()->withdrawal_address)
    <!-- Already Bound Card -->
    <div class="bound-address-card">
        <div class="bound-header">
            <div class="bound-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <span class="bound-label">Address Bound</span>
        </div>
        
        <div class="bound-details">
            <div class="bound-detail-item">
                <span class="detail-label">Currency</span>
                <span class="detail-value">
                    <img src="/icons/{{ strtolower(Auth::user()->withdrawal_currency) }}.svg" alt="{{ Auth::user()->withdrawal_currency }}" class="currency-icon">
                    {{ Auth::user()->withdrawal_currency }}
                </span>
            </div>
            <div class="bound-detail-item">
                <span class="detail-label">Network</span>
                <span class="detail-value">{{ Auth::user()->withdrawal_network }}</span>
            </div>
            <div class="bound-detail-item full-width">
                <span class="detail-label">Wallet Address</span>
                <div class="address-display">
                    <span class="address-text" id="boundAddress">{{ Auth::user()->withdrawal_address }}</span>
                    <button type="button" class="copy-btn" onclick="copyAddress()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="bound-detail-item">
                <span class="detail-label">Bound On</span>
                <span class="detail-value">{{ Auth::user()->withdrawal_address_bound_at ? Auth::user()->withdrawal_address_bound_at->format('M d, Y • h:i A') : '-' }}</span>
            </div>
        </div>

        <div class="bound-notice">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="16" x2="12" y2="12"/>
                <line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
            <span>Withdrawal address cannot be changed once bound. Contact support if you need assistance.</span>
        </div>
    </div>
    @else
    <!-- Bind Address Form -->
    <form id="bindAddressForm" action="{{ route('account.withdrawal-address.bind') }}" method="POST">
        @csrf

        <!-- Network Selection -->
        <div class="form-section-card">
            <div class="section-header">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                </svg>
                <span>Select Currency & Network</span>
            </div>

            <div class="network-grid">
                <label class="network-option">
                    <input type="radio" name="currency_network" value="usdt_trc20" required>
                    <div class="network-card">
                        <div class="network-icon">
                            <img src="/icons/usdt.svg" alt="USDT">
                        </div>
                        <div class="network-info">
                            <span class="network-name">USDT</span>
                            <span class="network-chain">TRC20</span>
                        </div>
                        <div class="check-mark">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </div>
                    </div>
                </label>

                <label class="network-option">
                    <input type="radio" name="currency_network" value="usdt_bep20">
                    <div class="network-card">
                        <div class="network-icon">
                            <img src="/icons/usdt.svg" alt="USDT">
                        </div>
                        <div class="network-info">
                            <span class="network-name">USDT</span>
                            <span class="network-chain">BEP20</span>
                        </div>
                        <div class="check-mark">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </div>
                    </div>
                </label>

                <label class="network-option">
                    <input type="radio" name="currency_network" value="usdc_bep20">
                    <div class="network-card">
                        <div class="network-icon">
                            <img src="/icons/usdc.svg" alt="USDC">
                        </div>
                        <div class="network-info">
                            <span class="network-name">USDC</span>
                            <span class="network-chain">BEP20</span>
                        </div>
                        <div class="check-mark">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </div>
                    </div>
                </label>

                <label class="network-option">
                    <input type="radio" name="currency_network" value="bnb_bsc">
                    <div class="network-card">
                        <div class="network-icon">
                            <img src="/icons/bnb.svg" alt="BNB">
                        </div>
                        <div class="network-info">
                            <span class="network-name">BNB</span>
                            <span class="network-chain">BSC</span>
                        </div>
                        <div class="check-mark">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </div>
                    </div>
                </label>
            </div>
            @error('currency_network')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <!-- Wallet Address -->
        <div class="form-section-card">
            <div class="section-header">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/>
                    <path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/>
                    <path d="M18 12a2 2 0 0 0 0 4h4v-4h-4z"/>
                </svg>
                <span>Wallet Address</span>
            </div>

            <div class="input-group">
                <input type="text" 
                       name="address" 
                       id="address"
                       class="form-input" 
                       placeholder="Enter your wallet address"
                       value="{{ old('address') }}"
                       required>
            </div>
            @error('address')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email Verification -->
        <div class="form-section-card">
            <div class="section-header">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                <span>Email Verification</span>
            </div>

            <div class="verification-row">
                <input type="text" 
                       name="verification_code" 
                       id="verification_code"
                       class="form-input code-input" 
                       placeholder="6-digit code"
                       maxlength="6"
                       inputmode="numeric"
                       required>
                <button type="button" class="send-code-btn" id="sendCodeBtn" onclick="sendVerificationCode()">
                    <span id="sendCodeText">Send Code</span>
                </button>
            </div>
            <p class="input-hint">We'll send a verification code to {{ Auth::user()->email }}</p>
            @error('verification_code')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <!-- Withdrawal PIN -->
        <div class="form-section-card">
            <div class="section-header">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <span>Withdrawal PIN</span>
            </div>

            @if(Auth::user()->withdrawal_pin)
            <div class="input-group">
                <input type="password" 
                       name="pin" 
                       id="pin"
                       class="form-input" 
                       placeholder="Enter your 4-digit PIN"
                       maxlength="4"
                       inputmode="numeric"
                       required>
            </div>
            @error('pin')
                <span class="error-text">{{ $message }}</span>
            @enderror
            @else
            <div class="no-pin-notice">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>You need to set a withdrawal PIN first.</span>
                <a href="{{ route('account.pin.edit') }}" class="set-pin-link">Set PIN</a>
            </div>
            @endif
        </div>

        <!-- Warning Notice -->
        <div class="warning-card">
            <div class="warning-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </div>
            <div class="warning-content">
                <h4>Important Warning</h4>
                <ul>
                    <li>Double-check your wallet address before binding</li>
                    <li><strong>Address cannot be changed</strong> once bound</li>
                    <li>Wrong address may result in <strong>permanent loss</strong> of funds</li>
                    <li>Make sure network matches your wallet's network</li>
                </ul>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn" {{ Auth::user()->withdrawal_pin ? '' : 'disabled' }}>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
            </svg>
            <span>Bind Withdrawal Address</span>
        </button>
    </form>
    @endif

    <!-- Back Button -->
    <a href="{{ route('account') }}" class="back-btn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        <span>Back to Account</span>
    </a>
</div>

<style>
    .withdrawal-address-wrapper {
        padding: 0 16px 100px;
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
    }

    /* Header Card */
    .address-header-card {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 16px;
        padding: 24px 20px;
    }

    .header-bg {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 50%, #60a5fa 100%);
    }

    .header-bg::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    .header-content {
        position: relative;
        text-align: center;
        color: #fff;
    }

    .header-icon {
        width: 64px;
        height: 64px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        backdrop-filter: blur(10px);
    }

    .header-title {
        font-size: 22px;
        font-weight: 700;
        margin: 0 0 4px;
    }

    .header-subtitle {
        font-size: 14px;
        opacity: 0.9;
        margin: 0;
    }

    /* Bound Address Card */
    .bound-address-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    }

    .bound-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .bound-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #22c55e;
    }

    .bound-label {
        font-size: 16px;
        font-weight: 700;
        color: #22c55e;
    }

    .bound-details {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .bound-detail-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .bound-detail-item.full-width {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .detail-label {
        font-size: 13px;
        color: #64748b;
    }

    .detail-value {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .currency-icon {
        width: 20px;
        height: 20px;
    }

    .address-display {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        padding: 12px;
        background: #f8fafc;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .address-text {
        flex: 1;
        font-size: 12px;
        font-family: 'SF Mono', Monaco, monospace;
        color: #1e293b;
        word-break: break-all;
    }

    .copy-btn {
        padding: 8px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
    }

    .copy-btn:active {
        background: #f1f5f9;
    }

    .bound-notice {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-top: 16px;
        padding: 12px;
        background: rgba(42, 108, 246, 0.1);
        border-radius: 10px;
        font-size: 12px;
        color: #2A6CF6;
    }

    .bound-notice svg {
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* Form Section Cards */
    .form-section-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 16px;
    }

    .section-header svg {
        color: #2A6CF6;
    }

    /* Network Grid */
    .network-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .network-option {
        cursor: pointer;
    }

    .network-option input {
        display: none;
    }

    .network-card {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.25s;
    }

    .network-option input:checked + .network-card {
        background: linear-gradient(135deg, rgba(42, 108, 246, 0.1) 0%, rgba(59, 140, 255, 0.1) 100%);
        border-color: #2A6CF6;
    }

    .network-icon {
        width: 36px;
        height: 36px;
        background: #fff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
    }

    .network-icon img {
        width: 24px;
        height: 24px;
    }

    .network-info {
        flex: 1;
    }

    .network-name {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
    }

    .network-chain {
        display: block;
        font-size: 11px;
        color: #64748b;
    }

    .check-mark {
        width: 24px;
        height: 24px;
        background: #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        opacity: 0;
        transition: all 0.25s;
    }

    .network-option input:checked + .network-card .check-mark {
        background: #2A6CF6;
        opacity: 1;
    }

    /* Form Inputs */
    .input-group {
        position: relative;
    }

    .form-input {
        width: 100%;
        padding: 14px 16px;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        color: #1e293b;
        transition: all 0.25s;
        outline: none;
    }

    .form-input:focus {
        border-color: #2A6CF6;
        background: #fff;
    }

    .form-input::placeholder {
        color: #94a3b8;
    }

    /* Verification Row */
    .verification-row {
        display: flex;
        gap: 10px;
    }

    .code-input {
        flex: 1;
        letter-spacing: 4px;
        text-align: center;
        font-weight: 600;
    }

    .send-code-btn {
        padding: 14px 20px;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        border: none;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.25s;
    }

    .send-code-btn:disabled {
        background: #94a3b8;
        cursor: not-allowed;
    }

    .send-code-btn:active:not(:disabled) {
        transform: scale(0.98);
    }

    .input-hint {
        font-size: 12px;
        color: #94a3b8;
        margin: 8px 0 0;
    }

    /* No PIN Notice */
    .no-pin-notice {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        padding: 14px;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 12px;
        font-size: 13px;
        color: #92400e;
    }

    .no-pin-notice svg {
        flex-shrink: 0;
    }

    .set-pin-link {
        margin-left: auto;
        padding: 6px 12px;
        background: #fff;
        border-radius: 8px;
        font-weight: 600;
        color: #2A6CF6;
        text-decoration: none;
    }

    /* Warning Card */
    .warning-card {
        display: flex;
        gap: 14px;
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 16px;
    }

    .warning-icon {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        background: rgba(239, 68, 68, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #dc2626;
    }

    .warning-content h4 {
        font-size: 14px;
        font-weight: 700;
        color: #991b1b;
        margin: 0 0 8px;
    }

    .warning-content ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .warning-content li {
        font-size: 12px;
        color: #991b1b;
        padding: 3px 0;
        padding-left: 16px;
        position: relative;
    }

    .warning-content li::before {
        content: '•';
        position: absolute;
        left: 0;
        color: #dc2626;
    }

    /* Submit Button */
    .submit-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 16px;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        border: none;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(42, 108, 246, 0.25);
        transition: all 0.25s;
        margin-bottom: 12px;
    }

    .submit-btn:disabled {
        background: #94a3b8;
        box-shadow: none;
        cursor: not-allowed;
    }

    .submit-btn:active:not(:disabled) {
        transform: scale(0.98);
    }

    /* Back Button */
    .back-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px;
        background: #fff;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        transition: all 0.25s;
    }

    .back-btn:active {
        transform: scale(0.98);
        background: #f8fafc;
    }

    /* Error Text */
    .error-text {
        display: block;
        margin-top: 8px;
        font-size: 12px;
        color: #ef4444;
    }
</style>

<script>
    let countdownTimer = null;

    function sendVerificationCode() {
        const btn = document.getElementById('sendCodeBtn');
        const btnText = document.getElementById('sendCodeText');
        
        btn.disabled = true;
        btnText.textContent = 'Sending...';

        fetch('{{ route("account.withdrawal-address.sendCode") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.sent) {
                startCountdown(60);
                if (typeof nativeAlert === 'function') {
                    nativeAlert('Verification code sent to your email!', { type: 'success', title: 'Code Sent' });
                }
            } else if (data.error) {
                btn.disabled = false;
                btnText.textContent = 'Send Code';
                if (typeof nativeAlert === 'function') {
                    nativeAlert(data.error, { type: 'error', title: 'Error' });
                }
            }
        })
        .catch(error => {
            btn.disabled = false;
            btnText.textContent = 'Send Code';
            if (typeof nativeAlert === 'function') {
                nativeAlert('Failed to send code. Please try again.', { type: 'error', title: 'Error' });
            }
        });
    }

    function startCountdown(seconds) {
        const btn = document.getElementById('sendCodeBtn');
        const btnText = document.getElementById('sendCodeText');
        let remaining = seconds;

        btnText.textContent = `${remaining}s`;

        countdownTimer = setInterval(() => {
            remaining--;
            btnText.textContent = `${remaining}s`;

            if (remaining <= 0) {
                clearInterval(countdownTimer);
                btn.disabled = false;
                btnText.textContent = 'Send Code';
            }
        }, 1000);
    }

    function copyAddress() {
        const address = document.getElementById('boundAddress').textContent.trim();
        navigator.clipboard.writeText(address).then(() => {
            if (typeof nativeAlert === 'function') {
                nativeAlert('Address copied to clipboard!', { type: 'success', title: 'Copied' });
            }
        });
    }
</script>
@endsection
