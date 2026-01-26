@extends('layouts.app')

@section('content')
<div class="deposit-address-wrapper">
    <!-- Status Header -->
    <div class="status-header-card">
        <div class="status-bg"></div>
        <div class="status-content">
            <div class="status-icon-wrapper">
                <div class="status-icon pending">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12,6 12,12 16,14"/>
                    </svg>
                </div>
                <div class="status-pulse"></div>
            </div>
            <h1 class="status-title">Awaiting Payment</h1>
            <p class="status-subtitle">Send the exact amount to complete your deposit</p>
        </div>
    </div>

    <!-- Amount Card -->
    <div class="amount-display-card">
        <div class="amount-row">
            <div class="amount-info">
                <span class="amount-label">You Pay</span>
                <div class="amount-value-row">
                    <span class="amount-crypto">{{ $payAmount ?? $amount }} {{ strtoupper($payCurrency ?? $currency) }}</span>
                </div>
                <span class="amount-usd">${{ number_format($amount, 2) }} USD</span>
            </div>
            <div class="currency-icon-large">
                <img src="/icons/{{ strtolower($currency ?? 'usdt') }}.svg" alt="{{ $currency }}">
            </div>
        </div>
        <div class="network-tag">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
            <span>{{ strtoupper($network ?? 'TRC20') }} Network</span>
        </div>
    </div>

    <!-- QR Code Section -->
    <div class="qr-section-card">
        <div class="qr-header">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7"/>
                <rect x="14" y="3" width="7" height="7"/>
                <rect x="3" y="14" width="7" height="7"/>
                <rect x="14" y="14" width="7" height="7"/>
            </svg>
            <span>Scan QR Code</span>
        </div>
        <div class="qr-code-container">
            <div class="qr-code-wrapper">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode($address ?? '') }}&bgcolor=ffffff&color=1e293b" 
                     alt="Deposit QR Code"
                     class="qr-image">
                <div class="qr-logo">
                    <img src="/icons/{{ strtolower($currency ?? 'usdt') }}.svg" alt="{{ $currency }}">
                </div>
            </div>
        </div>
        <p class="qr-hint">Scan with your wallet app to pay</p>
    </div>

    <!-- Wallet Address Section -->
    <div class="address-section-card">
        <div class="address-header">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/>
                <path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/>
                <path d="M18 12a2 2 0 0 0 0 4h4v-4h-4z"/>
            </svg>
            <span>Wallet Address</span>
        </div>
        <div class="address-box">
            <span class="address-text" id="depositAddress">{{ $address ?? '' }}</span>
        </div>
        <button type="button" class="copy-address-btn" onclick="copyToClipboard('depositAddress', this)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
            </svg>
            <span>Copy Address</span>
        </button>
    </div>

    <!-- Payment Details -->
    <div class="details-section-card">
        <div class="details-header">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
            <span>Payment Details</span>
        </div>
        
        <div class="details-list">
            <div class="detail-item">
                <span class="detail-label">Status</span>
                <span class="detail-value status-badge {{ $status ?? 'waiting' }}">
                    @php
                        $statusLabels = [
                            'waiting' => 'Waiting',
                            'confirming' => 'Confirming',
                            'confirmed' => 'Confirmed',
                            'sending' => 'Processing',
                            'finished' => 'Completed',
                            'failed' => 'Failed',
                            'expired' => 'Expired',
                        ];
                    @endphp
                    {{ $statusLabels[$status ?? 'waiting'] ?? ucfirst($status ?? 'Waiting') }}
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Amount (USD)</span>
                <span class="detail-value">${{ number_format($amount ?? 0, 2) }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Pay Amount</span>
                <span class="detail-value">{{ $payAmount ?? $amount }} {{ strtoupper($payCurrency ?? $currency) }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Currency</span>
                <span class="detail-value">
                    <img src="/icons/{{ strtolower($currency ?? 'usdt') }}.svg" alt="{{ $currency }}" class="detail-icon">
                    {{ strtoupper($currency ?? 'USDT') }}
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Network</span>
                <span class="detail-value">{{ strtoupper($network ?? 'TRC20') }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Order ID</span>
                <div class="detail-value-copy">
                    <span class="detail-value truncate" id="orderId">{{ $orderId ?? '-' }}</span>
                    <button type="button" class="mini-copy-btn" onclick="copyToClipboard('orderId', this)" title="Copy">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                        </svg>
                    </button>
                </div>
            </div>
            @if($payId ?? null)
            <div class="detail-item">
                <span class="detail-label">Payment ID</span>
                <div class="detail-value-copy">
                    <span class="detail-value truncate" id="payId">{{ $payId }}</span>
                    <button type="button" class="mini-copy-btn" onclick="copyToClipboard('payId', this)" title="Copy">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                        </svg>
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Warning Card -->
    <div class="warning-card">
        <div class="warning-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        <div class="warning-content">
            <h4>Important</h4>
            <ul>
                <li>Send only <strong>{{ strtoupper($currency ?? 'USDT') }}</strong> on <strong>{{ strtoupper($network ?? 'TRC20') }}</strong> network</li>
                <li>Send the <strong>exact amount</strong> shown above</li>
                <li>Minimum deposit is <strong>$25</strong></li>
                <li>Wrong network = <strong>permanent loss</strong></li>
            </ul>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('user.deposit.history') }}" class="action-btn secondary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <path d="M3 9h18"/>
                <path d="M9 21V9"/>
            </svg>
            View History
        </a>
        <a href="{{ route('user.deposit') }}" class="action-btn primary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            New Deposit
        </a>
    </div>

    <!-- Timer/Expiry Notice -->
    <div class="expiry-notice">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12,6 12,12 16,14"/>
        </svg>
        <span>This address is valid for <strong>60 minutes</strong>. After that, create a new deposit.</span>
    </div>
</div>

<style>
    .deposit-address-wrapper {
        padding: 0 16px 100px;
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
    }

    /* Status Header */
    .status-header-card {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 16px;
        padding: 24px 20px;
    }

    .status-bg {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 50%, #60a5fa 100%);
    }

    .status-bg::before {
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

    .status-content {
        position: relative;
        text-align: center;
        color: #fff;
    }

    .status-icon-wrapper {
        position: relative;
        display: inline-flex;
        margin-bottom: 12px;
    }

    .status-icon {
        width: 64px;
        height: 64px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }

    .status-pulse {
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.4);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.5; }
    }

    .status-title {
        font-size: 22px;
        font-weight: 700;
        margin: 0 0 4px;
    }

    .status-subtitle {
        font-size: 14px;
        opacity: 0.9;
        margin: 0;
    }

    /* Amount Display */
    .amount-display-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    }

    .amount-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .amount-info {
        display: flex;
        flex-direction: column;
    }

    .amount-label {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 4px;
    }

    .amount-crypto {
        font-size: 26px;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -0.5px;
    }

    .amount-usd {
        font-size: 14px;
        color: #64748b;
        margin-top: 2px;
    }

    .currency-icon-large {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .currency-icon-large img {
        width: 36px;
        height: 36px;
    }

    .network-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: linear-gradient(135deg, rgba(42, 108, 246, 0.1) 0%, rgba(59, 140, 255, 0.1) 100%);
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        color: #2A6CF6;
    }

    /* QR Code Section */
    .qr-section-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        text-align: center;
    }

    .qr-header {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 16px;
    }

    .qr-header svg {
        color: #2A6CF6;
    }

    .qr-code-container {
        display: flex;
        justify-content: center;
        margin-bottom: 12px;
    }

    .qr-code-wrapper {
        position: relative;
        padding: 12px;
        background: #fff;
        border-radius: 16px;
        border: 2px solid #e2e8f0;
    }

    .qr-image {
        display: block;
        width: 180px;
        height: 180px;
        border-radius: 8px;
    }

    .qr-logo {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40px;
        height: 40px;
        background: #fff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .qr-logo img {
        width: 28px;
        height: 28px;
    }

    .qr-hint {
        font-size: 13px;
        color: #94a3b8;
        margin: 0;
    }

    /* Address Section */
    .address-section-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    }

    .address-header {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 12px;
    }

    .address-header svg {
        color: #2A6CF6;
    }

    .address-box {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px;
        margin-bottom: 12px;
    }

    .address-text {
        font-size: 12px;
        font-family: 'SF Mono', Monaco, monospace;
        color: #1e293b;
        word-break: break-all;
        line-height: 1.5;
    }

    .copy-address-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
        transition: all 0.25s;
    }

    .copy-address-btn:active {
        transform: scale(0.98);
    }

    .copy-address-btn.copied {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    }

    /* Details Section */
    .details-section-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    }

    .details-header {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .details-header svg {
        color: #2A6CF6;
    }

    .details-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .detail-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
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

    .detail-icon {
        width: 18px;
        height: 18px;
    }

    .detail-value.truncate {
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .detail-value-copy {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .mini-copy-btn {
        padding: 6px;
        background: #f1f5f9;
        border: none;
        border-radius: 6px;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
    }

    .mini-copy-btn:active {
        background: #e2e8f0;
    }

    .mini-copy-btn.copied {
        background: #dcfce7;
        color: #22c55e;
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-badge.waiting,
    .status-badge.confirming,
    .status-badge.confirmed,
    .status-badge.sending {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #b45309;
    }

    .status-badge.finished {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #166534;
    }

    .status-badge.failed,
    .status-badge.expired {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #b91c1c;
    }

    /* Warning Card */
    .warning-card {
        display: flex;
        gap: 14px;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 16px;
    }

    .warning-icon {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        background: rgba(245, 158, 11, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #b45309;
    }

    .warning-content h4 {
        font-size: 14px;
        font-weight: 700;
        color: #92400e;
        margin: 0 0 8px;
    }

    .warning-content ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .warning-content li {
        font-size: 12px;
        color: #92400e;
        padding: 3px 0;
        padding-left: 16px;
        position: relative;
    }

    .warning-content li::before {
        content: '•';
        position: absolute;
        left: 0;
        color: #b45309;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 12px;
        margin-bottom: 16px;
    }

    .action-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s;
    }

    .action-btn.primary {
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        color: #fff;
        box-shadow: 0 4px 12px rgba(42, 108, 246, 0.25);
    }

    .action-btn.secondary {
        background: #fff;
        color: #1e293b;
        border: 2px solid #e2e8f0;
    }

    .action-btn:active {
        transform: scale(0.98);
    }

    /* Expiry Notice */
    .expiry-notice {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px;
        background: rgba(42, 108, 246, 0.1);
        border-radius: 12px;
        font-size: 12px;
        color: #2A6CF6;
        text-align: center;
    }
</style>

<script>
    function copyToClipboard(elementId, button) {
        const text = document.getElementById(elementId).textContent.trim();
        
        navigator.clipboard.writeText(text).then(() => {
            // Update button state
            const originalHTML = button.innerHTML;
            
            if (button.classList.contains('copy-address-btn')) {
                button.innerHTML = `
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>Copied!</span>
                `;
                button.classList.add('copied');
            } else {
                button.innerHTML = `
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                `;
                button.classList.add('copied');
            }
            
            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.classList.remove('copied');
            }, 2000);
        }).catch(() => {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
        });
    }
</script>
@endsection
