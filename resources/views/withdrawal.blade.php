@extends('layouts.app')

@section('content')
<div class="withdrawal-wrapper">
    <!-- Header Card -->
    <div class="withdrawal-header-card">
        <div class="header-bg"></div>
        <div class="header-content">
            <div class="header-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
            </div>
            <h1 class="header-title">Withdraw Funds</h1>
            <p class="header-subtitle">Transfer to your bound wallet address</p>
        </div>
        
        <!-- Balance Display -->
        <div class="balance-display">
            <div class="balance-item">
                <span class="balance-label">Available Balance</span>
                <span class="balance-value">${{ number_format(Auth::user()->balance ?? 1092.87, 2) }}</span>
            </div>
            <div class="balance-divider"></div>
            <div class="balance-item">
                <span class="balance-label">Processing Time</span>
                <span class="balance-value time">10-30 min</span>
            </div>
        </div>
    </div>

    @if(Auth::user()->withdrawal_address)
    <!-- Bound Wallet Card -->
    <div class="wallet-card">
        <div class="wallet-card-header">
            <div class="wallet-info">
                <div class="wallet-icon">
                    <img src="/icons/{{ strtolower(Auth::user()->withdrawal_currency) }}.svg" alt="{{ Auth::user()->withdrawal_currency }}">
                </div>
                <div class="wallet-details">
                    <span class="wallet-currency">{{ Auth::user()->withdrawal_currency }}</span>
                    <span class="wallet-network">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M2 12h20"/>
                        </svg>
                        {{ Auth::user()->withdrawal_network }}
                    </span>
                </div>
            </div>
            <div class="wallet-status">
                <span class="status-dot"></span>
                Bound
            </div>
        </div>
        
        <div class="wallet-address-section">
            <span class="address-label">Receiving Address</span>
            <div class="address-box">
                <span class="address-text" id="boundAddress">{{ Auth::user()->withdrawal_address }}</span>
                <button type="button" class="copy-btn" id="copyBtn" onclick="copyAddress()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" id="copyIcon">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                    </svg>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" id="checkIcon" style="display: none;">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Withdrawal Form -->
    <form action="{{ route('user.withdrawal.process') }}" method="POST" id="withdrawalForm">
        @csrf
        <input type="hidden" name="network" value="{{ strtolower(Auth::user()->withdrawal_network) }}">
        <input type="hidden" name="wallet_address" value="{{ Auth::user()->withdrawal_address }}">

        <!-- Amount Section -->
        <div class="form-card">
            <div class="form-card-header">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
                <span>Withdrawal Amount</span>
            </div>
            
            <div class="amount-input-container">
                <div class="amount-input-wrapper">
                    <span class="currency-symbol">$</span>
                    <input type="number" 
                           id="amount" 
                           name="amount" 
                           class="amount-input" 
                           placeholder="0.00"
                           min="12" 
                           step="0.01" 
                           required>
                    <button type="button" class="max-btn" onclick="setMaxAmount()">MAX</button>
                </div>
                <div class="amount-hints">
                    <span class="min-hint">Min: 12 {{ Auth::user()->withdrawal_currency }}</span>
                    <span class="receive-hint" id="receiveAmount">You receive: $0.00</span>
                </div>
            </div>

            <!-- Quick Amount Buttons -->
            <div class="quick-amounts">
                <button type="button" class="quick-btn" onclick="setAmount(50)">$50</button>
                <button type="button" class="quick-btn" onclick="setAmount(100)">$100</button>
                <button type="button" class="quick-btn" onclick="setAmount(200)">$200</button>
                <button type="button" class="quick-btn" onclick="setAmount(500)">$500</button>
            </div>
        </div>

        <!-- PIN Section -->
        <div class="form-card">
            <div class="form-card-header">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <span>Withdrawal PIN</span>
            </div>
            
            <div class="pin-input-container">
                <input type="password" class="pin-box" maxlength="1" data-index="0" inputmode="numeric" pattern="[0-9]*" required>
                <input type="password" class="pin-box" maxlength="1" data-index="1" inputmode="numeric" pattern="[0-9]*" required>
                <input type="password" class="pin-box" maxlength="1" data-index="2" inputmode="numeric" pattern="[0-9]*" required>
                <input type="password" class="pin-box" maxlength="1" data-index="3" inputmode="numeric" pattern="[0-9]*" required>
                <input type="hidden" name="withdrawal_pin" id="withdrawal_pin">
            </div>
            <p class="pin-hint">Enter your 4-digit withdrawal PIN</p>
        </div>

        <!-- Summary Card -->
        <div class="summary-card">
            <div class="summary-header">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                <span>Transaction Summary</span>
            </div>
            
            <div class="summary-rows">
                <div class="summary-row">
                    <span class="summary-label">Withdrawal Amount</span>
                    <span class="summary-value" id="summaryAmount">$0.00</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Network Fee ({{ Auth::user()->withdrawal_network }})</span>
                    <span class="summary-value fee">-${{ Auth::user()->withdrawal_network === 'TRC20' ? '1.00' : '0.50' }}</span>
                </div>
                <div class="summary-divider"></div>
                <div class="summary-row total">
                    <span class="summary-label">You Will Receive</span>
                    <span class="summary-value" id="summaryTotal">$0.00</span>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn" id="submitBtn" disabled>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 2L11 13"/>
                <path d="M22 2l-7 20-4-9-9-4 20-7z"/>
            </svg>
            <span>Confirm Withdrawal</span>
        </button>
    </form>

    @else
    <!-- No Address Card -->
    <div class="no-address-card">
        <div class="no-address-illustration">
            <div class="illustration-circle">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/>
                    <path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/>
                    <path d="M18 12a2 2 0 0 0 0 4h4v-4h-4z"/>
                </svg>
            </div>
            <div class="illustration-dots">
                <span></span><span></span><span></span>
            </div>
        </div>
        <h3 class="no-address-title">No Withdrawal Address</h3>
        <p class="no-address-text">You need to bind a withdrawal address before you can withdraw funds. This is a one-time setup for security.</p>
        <a href="{{ route('account.withdrawal-address.edit') }}" class="bind-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
            </svg>
            <span>Bind Withdrawal Address</span>
        </a>
    </div>
    @endif

    <!-- Info Card -->
    <div class="info-card">
        <div class="info-header">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 16v-4"/>
                <path d="M12 8h.01"/>
            </svg>
            <span>Important Information</span>
        </div>
        <ul class="info-list">
            @if(Auth::user()->withdrawal_address)
            <li>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <span>Funds will be sent to your bound {{ Auth::user()->withdrawal_network }} address</span>
            </li>
            <li>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <span>Minimum withdrawal amount is 12 {{ Auth::user()->withdrawal_currency }}</span>
            </li>
            <li>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <span>Processing typically takes 10-30 minutes</span>
            </li>
            @else
            <li>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>Bind your withdrawal address first (one-time setup)</span>
            </li>
            <li>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>Address cannot be changed once bound</span>
            </li>
            <li>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>Email & PIN verification required for security</span>
            </li>
            @endif
        </ul>
    </div>

    <!-- History Link -->
    <a href="{{ route('user.withdrawal.history') }}" class="history-link">
        <div class="history-link-content">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
            <span>View Withdrawal History</span>
        </div>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="9 18 15 12 9 6"/>
        </svg>
    </a>
</div>

<style>
    .withdrawal-wrapper {
        padding: 0 16px 100px;
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        max-width: 430px;
        margin: 0 auto;
    }

    .withdrawal-wrapper * {
        box-sizing: border-box;
    }

    /* Header Card */
    .withdrawal-header-card {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        margin-bottom: 20px;
        padding: 28px 20px 20px;
    }

    .header-bg {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 50%, #60a5fa 100%);
    }

    .header-bg::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    }

    .header-content {
        position: relative;
        text-align: center;
        color: #fff;
        margin-bottom: 20px;
    }

    .header-icon {
        width: 64px;
        height: 64px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        backdrop-filter: blur(10px);
    }

    .header-title {
        font-size: 24px;
        font-weight: 700;
        margin: 0 0 4px;
    }

    .header-subtitle {
        font-size: 14px;
        opacity: 0.9;
        margin: 0;
    }

    .balance-display {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 16px 20px;
    }

    .balance-item {
        text-align: center;
    }

    .balance-label {
        display: block;
        font-size: 11px;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .balance-value {
        display: block;
        font-size: 20px;
        font-weight: 700;
        color: #fff;
    }

    .balance-value.time {
        font-size: 16px;
    }

    .balance-divider {
        width: 1px;
        height: 36px;
        background: rgba(255, 255, 255, 0.3);
    }

    /* Wallet Card */
    .wallet-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .wallet-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
    }

    .wallet-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .wallet-icon {
        width: 44px;
        height: 44px;
        background: #fff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .wallet-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .wallet-details {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .wallet-currency {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }

    .wallet-network {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        color: #64748b;
    }

    .wallet-status {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        color: #166534;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        background: #22c55e;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.6; transform: scale(1.2); }
    }

    .wallet-address-section {
        padding: 16px 20px;
    }

    .address-label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }

    .address-box {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
    }

    .address-text {
        flex: 1;
        font-size: 11px;
        font-family: 'SF Mono', 'Roboto Mono', Monaco, monospace;
        color: #1e293b;
        word-break: break-all;
        line-height: 1.5;
    }

    .copy-btn {
        flex-shrink: 0;
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        border: none;
        border-radius: 10px;
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .copy-btn:active {
        transform: scale(0.95);
    }

    .copy-btn.copied {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    }

    /* Form Cards */
    .form-card {
        background: #fff;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .form-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 16px;
    }

    .form-card-header svg {
        color: #2A6CF6;
    }

    /* Amount Input */
    .amount-input-container {
        margin-bottom: 16px;
    }

    .amount-input-wrapper {
        display: flex;
        align-items: center;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 4px;
        transition: all 0.25s;
    }

    .amount-input-wrapper:focus-within {
        border-color: #2A6CF6;
        background: #fff;
    }

    .currency-symbol {
        padding: 12px 4px 12px 14px;
        font-size: 20px;
        font-weight: 700;
        color: #64748b;
    }

    .amount-input {
        flex: 1;
        min-width: 0;
        padding: 12px 8px;
        border: none;
        background: transparent;
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        outline: none;
    }

    .amount-input::placeholder {
        color: #cbd5e1;
    }

    .max-btn {
        padding: 10px 16px;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        border: none;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        color: #fff;
        cursor: pointer;
        margin-right: 4px;
    }

    .max-btn:active {
        transform: scale(0.95);
    }

    .amount-hints {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        padding: 0 4px;
    }

    .min-hint {
        font-size: 12px;
        color: #94a3b8;
    }

    .receive-hint {
        font-size: 12px;
        font-weight: 600;
        color: #22c55e;
    }

    /* Quick Amounts */
    .quick-amounts {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
    }

    .quick-btn {
        padding: 10px;
        background: #f1f5f9;
        border: 2px solid transparent;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
    }

    .quick-btn:active {
        background: linear-gradient(135deg, rgba(42, 108, 246, 0.1) 0%, rgba(59, 140, 255, 0.1) 100%);
        border-color: #2A6CF6;
        color: #2A6CF6;
    }

    /* PIN Input */
    .pin-input-container {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .pin-box {
        width: 56px;
        height: 60px;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        font-size: 24px;
        font-weight: 700;
        text-align: center;
        color: #1e293b;
        outline: none;
        transition: all 0.25s;
    }

    .pin-box:focus {
        border-color: #2A6CF6;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(42, 108, 246, 0.1);
    }

    .pin-hint {
        text-align: center;
        font-size: 12px;
        color: #94a3b8;
        margin: 0;
    }

    /* Summary Card */
    .summary-card {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .summary-header {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 16px;
    }

    .summary-rows {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .summary-label {
        font-size: 13px;
        color: #64748b;
    }

    .summary-value {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }

    .summary-value.fee {
        color: #ef4444;
    }

    .summary-divider {
        height: 1px;
        background: #e2e8f0;
        margin: 4px 0;
    }

    .summary-row.total .summary-label {
        font-weight: 600;
        color: #1e293b;
    }

    .summary-row.total .summary-value {
        font-size: 18px;
        color: #22c55e;
    }

    /* Submit Button */
    .submit-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 18px;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        border: none;
        border-radius: 16px;
        font-size: 16px;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
        box-shadow: 0 8px 24px rgba(42, 108, 246, 0.3);
        transition: all 0.25s;
        margin-bottom: 16px;
    }

    .submit-btn:disabled {
        background: #94a3b8;
        box-shadow: none;
        cursor: not-allowed;
    }

    .submit-btn:active:not(:disabled) {
        transform: scale(0.98);
    }

    /* No Address Card */
    .no-address-card {
        background: #fff;
        border-radius: 24px;
        padding: 32px 24px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        margin-bottom: 20px;
    }

    .no-address-illustration {
        margin-bottom: 20px;
    }

    .illustration-circle {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        color: #d97706;
    }

    .illustration-dots {
        display: flex;
        justify-content: center;
        gap: 6px;
    }

    .illustration-dots span {
        width: 8px;
        height: 8px;
        background: #e2e8f0;
        border-radius: 50%;
    }

    .illustration-dots span:nth-child(2) {
        background: #cbd5e1;
    }

    .no-address-title {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 8px;
    }

    .no-address-text {
        font-size: 14px;
        color: #64748b;
        line-height: 1.6;
        margin: 0 0 24px;
    }

    .bind-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 16px 32px;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        border: none;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        text-decoration: none;
        box-shadow: 0 8px 24px rgba(42, 108, 246, 0.3);
    }

    .bind-btn:active {
        transform: scale(0.98);
    }

    /* Info Card */
    .info-card {
        background: #fff;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .info-header {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 16px;
    }

    .info-header svg {
        color: #2A6CF6;
    }

    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .info-list li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 13px;
        color: #64748b;
        line-height: 1.4;
    }

    .info-list li svg {
        flex-shrink: 0;
        margin-top: 2px;
        color: #22c55e;
    }

    /* History Link */
    .history-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        background: #fff;
        border-radius: 16px;
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.2s;
    }

    .history-link:active {
        transform: scale(0.98);
    }

    .history-link-content {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .history-link-content svg {
        color: #2A6CF6;
    }

    .history-link-content span {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }

    .history-link > svg {
        color: #94a3b8;
    }
</style>

<script>
    @if(Auth::user()->withdrawal_address)
    const networkFee = {{ Auth::user()->withdrawal_network === 'TRC20' ? 1 : 0.5 }};
    const availableBalance = {{ Auth::user()->balance ?? 1092.87 }};
    const minWithdrawal = 12;

    function updateCalculations() {
        const amount = parseFloat(document.getElementById('amount').value) || 0;
        const receive = Math.max(0, amount - networkFee);

        document.getElementById('receiveAmount').textContent = `You receive: $${receive.toFixed(2)}`;
        document.getElementById('summaryAmount').textContent = `$${amount.toFixed(2)}`;
        document.getElementById('summaryTotal').textContent = `$${receive.toFixed(2)}`;
        validateForm();
    }

    function setMaxAmount() {
        document.getElementById('amount').value = availableBalance.toFixed(2);
        updateCalculations();
    }

    function setAmount(value) {
        if (value <= availableBalance) {
            document.getElementById('amount').value = value.toFixed(2);
            updateCalculations();
        }
    }

    // PIN handling
    const pinInputs = document.querySelectorAll('.pin-box');
    pinInputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            const value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
            if (value && index < pinInputs.length - 1) {
                pinInputs[index + 1].focus();
            }
            updatePinValue();
            validateForm();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                pinInputs[index - 1].focus();
            }
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 4);
            pastedData.split('').forEach((char, i) => {
                if (pinInputs[i]) {
                    pinInputs[i].value = char;
                }
            });
            updatePinValue();
            validateForm();
            if (pastedData.length > 0) {
                pinInputs[Math.min(pastedData.length, 3)].focus();
            }
        });
    });

    function updatePinValue() {
        document.getElementById('withdrawal_pin').value = Array.from(pinInputs).map(i => i.value).join('');
    }

    function validateForm() {
        const amount = parseFloat(document.getElementById('amount').value) || 0;
        const pin = document.getElementById('withdrawal_pin').value;
        const isValid = amount >= minWithdrawal && amount <= availableBalance && pin.length === 4;
        document.getElementById('submitBtn').disabled = !isValid;
    }

    // Event listeners
    document.getElementById('amount').addEventListener('input', updateCalculations);

    document.getElementById('withdrawalForm').addEventListener('submit', function(e) {
        const amount = parseFloat(document.getElementById('amount').value);
        if (amount < minWithdrawal) {
            e.preventDefault();
            if (typeof nativeAlert === 'function') {
                nativeAlert('Minimum withdrawal is 12 USDT', { type: 'warning', title: 'Invalid Amount' });
            }
        } else if (amount > availableBalance) {
            e.preventDefault();
            if (typeof nativeAlert === 'function') {
                nativeAlert('Insufficient balance', { type: 'error', title: 'Error' });
            }
        }
    });

    updateCalculations();
    @endif

    function copyAddress() {
        const address = document.getElementById('boundAddress')?.textContent.trim();
        if (!address) return;
        
        const copyBtn = document.getElementById('copyBtn');
        const copyIcon = document.getElementById('copyIcon');
        const checkIcon = document.getElementById('checkIcon');
        
        navigator.clipboard.writeText(address).then(() => {
            copyBtn.classList.add('copied');
            copyIcon.style.display = 'none';
            checkIcon.style.display = 'block';
            
            if (typeof nativeAlert === 'function') {
                nativeAlert('Address copied!', { type: 'success', title: 'Copied' });
            }
            
            setTimeout(() => {
                copyBtn.classList.remove('copied');
                copyIcon.style.display = 'block';
                checkIcon.style.display = 'none';
            }, 2000);
        });
    }
</script>
@endsection
