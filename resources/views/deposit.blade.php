@extends('layouts.app')

@section('content')
<div class="deposit-page-wrapper">
    <!-- Balance Card (Matching Homepage Style) -->
    <div class="deposit-balance-card">
        <div class="balance-card-bg"></div>
        <div class="balance-card-content">
            <div class="balance-header">
                <div class="balance-label">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                    <span>Deposit Funds</span>
                </div>
                <a href="{{ route('user.deposit.history') }}" class="explore-link">
                    History
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="balance-amount">
                <span class="amount">{{ number_format(Auth::user()->balance ?? 0, 2) }}</span>
                <span class="currency">USDT</span>
            </div>
            <div class="balance-subtitle">Fast & secure crypto deposits</div>
        </div>
    </div>

    <!-- Deposit Form -->
    <form id="depositForm" action="{{ route('user.deposit.address') }}" method="POST">
        @csrf
        
        <!-- Network Selection Section -->
        <div class="deposit-section-card">
            <div class="section-header-row">
                <h2 class="section-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                    </svg>
                    Select Network
                </h2>
            </div>

            <div class="network-grid">
                <label class="network-card">
                    <input type="radio" name="currency_network" value="usdt_bep20" required>
                    <div class="network-card-inner">
                        <span class="check-indicator">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </span>
                        <div class="network-icon">
                            <img src="/icons/usdt.svg" alt="USDT">
                        </div>
                        <div class="network-info">
                            <span class="network-name">USDT</span>
                            <span class="network-chain">BEP20 (BSC)</span>
                        </div>
                    </div>
                </label>

                <label class="network-card">
                    <input type="radio" name="currency_network" value="usdc_bep20">
                    <div class="network-card-inner">
                        <span class="check-indicator">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </span>
                        <div class="network-icon">
                            <img src="/icons/usdc.svg" alt="USDC">
                        </div>
                        <div class="network-info">
                            <span class="network-name">USDC</span>
                            <span class="network-chain">BEP20 (BSC)</span>
                        </div>
                    </div>
                </label>

                <label class="network-card">
                    <input type="radio" name="currency_network" value="usdt_trc20">
                    <div class="network-card-inner">
                        <span class="check-indicator">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </span>
                        <div class="network-icon">
                            <img src="/icons/usdt.svg" alt="USDT">
                        </div>
                        <div class="network-info">
                            <span class="network-name">USDT</span>
                            <span class="network-chain">TRC20</span>
                        </div>
                    </div>
                </label>

                <label class="network-card">
                    <input type="radio" name="currency_network" value="bnb_bsc">
                    <div class="network-card-inner">
                        <span class="check-indicator">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </span>
                        <div class="network-icon">
                            <img src="/icons/bnb.svg" alt="BNB">
                        </div>
                        <div class="network-info">
                            <span class="network-name">BNB</span>
                            <span class="network-chain">BSC</span>
                        </div>
                    </div>
                </label>
            </div>
        </div>

        <!-- Amount Section -->
        <div class="deposit-section-card">
            <div class="section-header-row">
                <h2 class="section-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="6" width="20" height="12" rx="2"/>
                        <circle cx="12" cy="12" r="2"/>
                        <path d="M6 12h.01M18 12h.01"/>
                    </svg>
                    Enter Amount
                </h2>
                <span class="section-badge">Min $25</span>
            </div>

            <div class="amount-input-group">
                <div class="amount-input-wrapper">
                    <span class="amount-prefix">$</span>
                    <input type="number" id="amount" name="amount" class="amount-input" placeholder="0.00" min="25" step="any" required>
                    <span class="amount-suffix">USD</span>
                </div>
            </div>

            <div class="quick-amounts">
                <button type="button" class="quick-btn" data-amount="25">$25</button>
                <button type="button" class="quick-btn" data-amount="50">$50</button>
                <button type="button" class="quick-btn" data-amount="100">$100</button>
                <button type="button" class="quick-btn" data-amount="200">$200</button>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="deposit-submit-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M12 5v14M5 12l7-7 7 7"/>
            </svg>
            <span>Continue to Deposit</span>
        </button>
    </form>

    <!-- Info Section -->
    <div class="deposit-info-card">
        <div class="info-header">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="16" x2="12" y2="12"/>
                <line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
            <span>Important Information</span>
        </div>
        <ul class="info-list">
            <li>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span>Minimum deposit amount is $25</span>
            </li>
            <li>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span>Ensure you select the correct network</span>
            </li>
            <li>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span>Deposits are processed automatically</span>
            </li>
        </ul>
    </div>

    <!-- Bottom Stats (Matching Homepage) -->
    <div class="deposit-bottom-stats">
        <div class="bottom-stat">
            <span class="stat-icon">⚡</span>
            <span class="stat-text">Instant</span>
        </div>
        <div class="stat-divider"></div>
        <div class="bottom-stat">
            <span class="stat-icon">🔒</span>
            <span class="stat-text">Secure</span>
        </div>
        <div class="stat-divider"></div>
        <div class="bottom-stat">
            <span class="stat-icon">🌐</span>
            <span class="stat-text">24/7</span>
        </div>
    </div>
</div>

<style>
    .deposit-page-wrapper {
        padding: 0 16px 100px;
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
    }

    /* Balance Card - Matching Homepage */
    .deposit-balance-card {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .deposit-balance-card .balance-card-bg {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 50%, #60a5fa 100%);
    }

    .deposit-balance-card .balance-card-bg::before {
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

    .deposit-balance-card .balance-card-content {
        position: relative;
        padding: 15px;
        color: #fff;
    }

    .deposit-balance-card .balance-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .deposit-balance-card .balance-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        opacity: 0.9;
    }

    .deposit-balance-card .explore-link {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 6px 14px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        text-decoration: none;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .deposit-balance-card .explore-link:active {
        transform: scale(0.96);
        background: rgba(255, 255, 255, 0.3);
    }

    .deposit-balance-card .balance-amount {
        margin: 12px 0 8px;
    }

    .deposit-balance-card .balance-amount .amount {
        font-size: 36px;
        font-weight: 800;
        letter-spacing: -1px;
    }

    .deposit-balance-card .balance-amount .currency {
        font-size: 18px;
        font-weight: 600;
        opacity: 0.9;
        margin-left: 8px;
    }

    .deposit-balance-card .balance-subtitle {
        font-size: 13px;
        opacity: 0.85;
    }

    /* Section Cards */
    .deposit-section-card {
        background: #fff;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(42, 108, 246, 0.08);
    }

    .section-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .section-title svg {
        color: #2A6CF6;
    }

    .section-badge {
        font-size: 11px;
        font-weight: 600;
        color: #2A6CF6;
        background: rgba(42, 108, 246, 0.1);
        padding: 4px 10px;
        border-radius: 12px;
    }

    /* Network Grid */
    .network-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .network-card {
        cursor: pointer;
    }

    .network-card input {
        display: none;
    }

    .network-card-inner {
        position: relative;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .network-card input:checked + .network-card-inner {
        border-color: #2A6CF6;
        background: linear-gradient(135deg, rgba(42, 108, 246, 0.08) 0%, rgba(59, 140, 255, 0.08) 100%);
    }

    .network-card:active .network-card-inner {
        transform: scale(0.97);
    }

    .check-indicator {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 22px;
        height: 22px;
        background: #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.25s;
    }

    .check-indicator svg {
        opacity: 0;
        color: #fff;
        transition: opacity 0.2s;
    }

    .network-card input:checked + .network-card-inner .check-indicator {
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
    }

    .network-card input:checked + .network-card-inner .check-indicator svg {
        opacity: 1;
    }

    .network-icon {
        width: 44px;
        height: 44px;
        background: #fff;
        border-radius: 12px;
        padding: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .network-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .network-info {
        text-align: center;
    }

    .network-name {
        display: block;
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
    }

    .network-chain {
        display: block;
        font-size: 11px;
        color: #64748b;
        margin-top: 2px;
    }

    /* Amount Input */
    .amount-input-group {
        margin-bottom: 12px;
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
        box-shadow: 0 0 0 4px rgba(42, 108, 246, 0.1);
    }

    .amount-prefix {
        padding: 12px 8px 12px 14px;
        font-size: 20px;
        font-weight: 700;
        color: #94a3b8;
    }

    .amount-input {
        flex: 1;
        border: none;
        background: transparent;
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        outline: none;
        min-width: 0;
        padding: 10px 0;
    }

    .amount-input::placeholder {
        color: #cbd5e1;
    }

    .amount-suffix {
        padding: 10px 14px;
        font-size: 13px;
        font-weight: 700;
        color: #2A6CF6;
        background: rgba(42, 108, 246, 0.1);
        border-radius: 10px;
        margin: 2px;
    }

    /* Quick Amounts */
    .quick-amounts {
        display: flex;
        gap: 8px;
    }

    .quick-btn {
        flex: 1;
        padding: 12px 8px;
        background: #f1f5f9;
        border: 2px solid transparent;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s;
    }

    .quick-btn:active {
        transform: scale(0.96);
    }

    .quick-btn.active {
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        color: #fff;
        box-shadow: 0 4px 12px rgba(42, 108, 246, 0.25);
    }

    /* Submit Button */
    .deposit-submit-btn {
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
        font-weight: 700;
        color: #fff;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(42, 108, 246, 0.35);
        margin-bottom: 16px;
    }

    .deposit-submit-btn:active {
        transform: scale(0.98);
        box-shadow: 0 2px 8px rgba(42, 108, 246, 0.3);
    }

    /* Info Card */
    .deposit-info-card {
        background: #fff;
        border-radius: 14px;
        padding: 14px 16px;
        margin-bottom: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(251, 191, 36, 0.2);
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    }

    .deposit-info-card .info-header {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 700;
        color: #92400e;
        margin-bottom: 12px;
    }

    .deposit-info-card .info-header svg {
        color: #f59e0b;
    }

    .deposit-info-card .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .deposit-info-card .info-list li {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: #78350f;
        padding: 6px 0;
    }

    .deposit-info-card .info-list li svg {
        color: #22c55e;
        flex-shrink: 0;
    }

    /* Bottom Stats */
    .deposit-bottom-stats {
        display: flex;
        align-items: center;
        justify-content: space-around;
        background: #fff;
        border-radius: 14px;
        padding: 14px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    }

    .bottom-stat {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    .stat-icon {
        font-size: 20px;
    }

    .stat-text {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    .stat-divider {
        width: 1px;
        height: 32px;
        background: #e2e8f0;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quick amount buttons
        document.querySelectorAll('.quick-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const amount = this.getAttribute('data-amount');
                document.getElementById('amount').value = amount;
                document.querySelectorAll('.quick-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Update quick buttons on manual input
        document.getElementById('amount').addEventListener('input', function() {
            document.querySelectorAll('.quick-btn').forEach(btn => {
                btn.classList.toggle('active', btn.getAttribute('data-amount') === this.value);
            });
        });

        // Form validation
        document.getElementById('depositForm').addEventListener('submit', function(e) {
            const amount = document.getElementById('amount').value;
            if (!amount || parseFloat(amount) < 25) {
                e.preventDefault();
                nativeAlert('Please enter a valid amount (minimum $25).', { type: 'warning', title: 'Invalid Amount' });
                return;
            }
            
            const selected = document.querySelector('input[name="currency_network"]:checked');
            if (!selected) {
                e.preventDefault();
                nativeAlert('Please select a currency and network.', { type: 'warning', title: 'Selection Required' });
                return;
            }
        });
    });
</script>
@endsection