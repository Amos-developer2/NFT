@extends('layouts.app')

@section('content')
<div class="deposit-history-wrapper">
    <!-- Header Card -->
    <div class="history-balance-card">
        <div class="balance-card-bg"></div>
        <div class="balance-card-content">
            <div class="balance-header">
                <div class="balance-label">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                    <span>Deposit History</span>
                </div>
                <a href="{{ route('user.deposit') }}" class="explore-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    New
                </a>
            </div>
            <div class="balance-amount">
                <span class="amount">${{ number_format($deposits->where('status', 'finished')->sum('amount') ?? 0, 2) }}</span>
            </div>
            <div class="balance-subtitle">Total Deposited</div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="history-quick-stats">
        <div class="stat-item">
            <span class="stat-value">{{ $deposits->count() }}</span>
            <span class="stat-label">Total</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <span class="stat-value pending-text">{{ $deposits->whereIn('status', ['waiting', 'confirming', 'confirmed', 'sending', 'partially_paid'])->count() }}</span>
            <span class="stat-label">Pending</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <span class="stat-value completed-text">{{ $deposits->where('status', 'finished')->count() }}</span>
            <span class="stat-label">Completed</span>
        </div>
    </div>

    <!-- Filter Chips -->
    <div class="filter-chips-section">
        <button class="filter-chip active" data-filter="all">
            <span class="chip-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
            </span>
            <span>All</span>
        </button>
        <button class="filter-chip" data-filter="pending">
            <span class="chip-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12,6 12,12 16,14"/>
                </svg>
            </span>
            <span>Pending</span>
        </button>
        <button class="filter-chip" data-filter="completed">
            <span class="chip-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="20,6 9,17 4,12"/>
                </svg>
            </span>
            <span>Completed</span>
        </button>
        <button class="filter-chip" data-filter="failed">
            <span class="chip-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </span>
            <span>Failed</span>
        </button>
    </div>

    <!-- Section Header -->
    <div class="section-header-row">
        <h2 class="section-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <path d="M3 9h18"/>
                <path d="M9 21V9"/>
            </svg>
            Transactions
        </h2>
        <span class="transaction-count">{{ $deposits->count() }} records</span>
    </div>

    <!-- Transactions List -->
    <div class="transactions-list">
        @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof nativeAlert === 'function') {
                    nativeAlert(@json(session('success')), { type: 'success', title: 'Success' });
                }
            });
        </script>
        @endif
        @if($errors && $errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof nativeAlert === 'function') {
                    nativeAlert(@json(implode("\n", $errors->all())), { type: 'error', title: 'Error' });
                }
            });
        </script>
        @endif

        @forelse($deposits as $deposit)
        @php
            // Map NowPayments statuses to display categories
            $statusMap = [
                'waiting' => 'pending',
                'confirming' => 'pending',
                'confirmed' => 'pending',
                'sending' => 'pending',
                'partially_paid' => 'pending',
                'finished' => 'completed',
                'failed' => 'failed',
                'refunded' => 'failed',
                'expired' => 'failed',
            ];
            $displayStatus = $statusMap[$deposit->status] ?? 'pending';
            
            // Status display labels
            $statusLabels = [
                'waiting' => 'Waiting',
                'confirming' => 'Confirming',
                'confirmed' => 'Confirmed',
                'sending' => 'Sending',
                'partially_paid' => 'Partial',
                'finished' => 'Completed',
                'failed' => 'Failed',
                'refunded' => 'Refunded',
                'expired' => 'Expired',
            ];
            $statusLabel = $statusLabels[$deposit->status] ?? ucfirst($deposit->status);
        @endphp
        <div class="transaction-card" 
             data-status="{{ $displayStatus }}"
             data-deposit-id="{{ $deposit->id }}"
             data-deposit-amount="{{ $deposit->amount }}"
             data-deposit-status="{{ $deposit->status }}"
             data-deposit-status-label="{{ $statusLabel }}"
             data-deposit-pay-id="{{ $deposit->pay_id }}"
             data-deposit-order-id="{{ $deposit->order_id }}"
             data-deposit-pay-address="{{ $deposit->pay_address }}"
             data-deposit-currency="{{ $deposit->currency ?? 'USDT' }}"
             data-deposit-network="{{ $deposit->network ?? 'TRC20' }}"
             data-deposit-created="{{ $deposit->created_at->format('M d, Y • h:i A') }}"
             data-deposit-updated="{{ $deposit->updated_at->format('M d, Y • h:i A') }}"
             onclick="openDepositDrawer(this)">
            <div class="transaction-icon {{ $displayStatus }}">
                @if($displayStatus === 'pending')
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12,6 12,12 16,14"></polyline>
                </svg>
                @elseif($displayStatus === 'completed')
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20,6 9,17 4,12"></polyline>
                </svg>
                @else
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
                @endif
            </div>
            <div class="transaction-details">
                <div class="transaction-top">
                    <span class="transaction-title">Deposit</span>
                    <span class="transaction-amount positive">+${{ number_format($deposit->amount, 2) }}</span>
                </div>
                <div class="transaction-bottom">
                    <div class="transaction-meta">
                        <span class="network-badge">{{ $deposit->network ?? 'TRC20' }}</span>
                        <span class="transaction-date">{{ $deposit->created_at->format('M d, Y • h:i A') }}</span>
                    </div>
                    <span class="status-badge {{ $displayStatus }}">{{ $statusLabel }}</span>
                </div>
            </div>
            <div class="transaction-arrow">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9,18 15,12 9,6"/>
                </svg>
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <path d="M3 9h18"/>
                    <path d="M9 21V9"/>
                </svg>
            </div>
            <h3>No Deposits Found</h3>
            <p>Your deposit history will appear here</p>
            <a href="{{ route('user.deposit') }}" class="empty-action-btn">Make a Deposit</a>
        </div>
        @endforelse

        <!-- Empty State (for filtering) -->
        <div class="empty-state filter-empty" style="display: none;">
            <div class="empty-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
            <h3>No Matching Deposits</h3>
            <p>No deposits found for this filter</p>
        </div>
    </div>
</div>

<!-- Bottom Drawer for Deposit Details -->
<div class="drawer-overlay" id="drawerOverlay" onclick="closeDepositDrawer()"></div>
<div class="deposit-drawer" id="depositDrawer">
    <div class="drawer-handle" onclick="closeDepositDrawer()">
        <div class="handle-bar"></div>
    </div>
    <div class="drawer-content">
        <div class="drawer-header">
            <div class="drawer-icon" id="drawerIcon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12,6 12,12 16,14"></polyline>
                </svg>
            </div>
            <h3 class="drawer-title">Deposit Details</h3>
            <span class="drawer-status-badge" id="drawerStatusBadge">Pending</span>
        </div>
        
        <div class="drawer-amount-section">
            <span class="drawer-amount-label">Amount</span>
            <span class="drawer-amount" id="drawerAmount">$0.00</span>
        </div>

        <div class="drawer-details-list">
            <div class="drawer-detail-item">
                <span class="detail-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    Status
                </span>
                <span class="detail-value" id="drawerDetailStatus">-</span>
            </div>
            <div class="drawer-detail-item">
                <span class="detail-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                    Currency
                </span>
                <span class="detail-value" id="drawerDetailCurrency">-</span>
            </div>
            <div class="drawer-detail-item">
                <span class="detail-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                    </svg>
                    Network
                </span>
                <span class="detail-value" id="drawerDetailNetwork">-</span>
            </div>
            <div class="drawer-detail-item">
                <span class="detail-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                    Order ID
                </span>
                <span class="detail-value" id="drawerDetailOrderId">-</span>
            </div>
            <div class="drawer-detail-item">
                <span class="detail-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/>
                        <path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/>
                        <path d="M18 12a2 2 0 0 0 0 4h4v-4h-4z"/>
                    </svg>
                    Payment ID
                </span>
                <span class="detail-value" id="drawerDetailPayId">-</span>
            </div>
            <div class="drawer-detail-item address-item">
                <span class="detail-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                    </svg>
                    Pay Address
                </span>
                <span class="detail-value address-value" id="drawerDetailPayAddress">-</span>
            </div>
            <div class="drawer-detail-item">
                <span class="detail-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    Created
                </span>
                <span class="detail-value" id="drawerDetailCreated">-</span>
            </div>
            <div class="drawer-detail-item">
                <span class="detail-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12,6 12,12 16,14"/>
                    </svg>
                    Last Updated
                </span>
                <span class="detail-value" id="drawerDetailUpdated">-</span>
            </div>
        </div>

        <button class="drawer-close-btn" onclick="closeDepositDrawer()">
            Close
        </button>
    </div>
</div>

<style>
    .deposit-history-wrapper {
        padding: 0 16px 100px;
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
    }

    /* Balance Card */
    .history-balance-card {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 16px;
    }

    .history-balance-card .balance-card-bg {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 50%, #60a5fa 100%);
    }

    .history-balance-card .balance-card-bg::before {
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

    .history-balance-card .balance-card-content {
        position: relative;
        padding: 15px;
        color: #fff;
    }

    .history-balance-card .balance-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .history-balance-card .balance-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        opacity: 0.9;
    }

    .history-balance-card .explore-link {
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

    .history-balance-card .explore-link:active {
        transform: scale(0.96);
        background: rgba(255, 255, 255, 0.3);
    }

    .history-balance-card .balance-amount {
        margin: 12px 0 4px;
    }

    .history-balance-card .balance-amount .amount {
        font-size: 32px;
        font-weight: 800;
        letter-spacing: -1px;
    }

    .history-balance-card .balance-subtitle {
        font-size: 13px;
        opacity: 0.85;
    }

    /* Quick Stats */
    .history-quick-stats {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fff;
        border-radius: 14px;
        padding: 14px 20px;
        margin-bottom: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    }

    .history-quick-stats .stat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
    }

    .history-quick-stats .stat-value {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
    }

    .history-quick-stats .stat-value.pending-text {
        color: #f59e0b;
    }

    .history-quick-stats .stat-value.completed-text {
        color: #22c55e;
    }

    .history-quick-stats .stat-label {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 2px;
        font-weight: 500;
    }

    .history-quick-stats .stat-divider {
        width: 1px;
        height: 32px;
        background: #e2e8f0;
    }

    /* Filter Chips */
    .filter-chips-section {
        display: flex;
        gap: 8px;
        margin-bottom: 16px;
        overflow-x: auto;
        padding-bottom: 4px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .filter-chips-section::-webkit-scrollbar {
        display: none;
    }

    .filter-chip {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 10px 16px;
        background: #fff;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.25s;
    }

    .filter-chip:active {
        transform: scale(0.96);
    }

    .filter-chip.active {
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 4px 12px rgba(42, 108, 246, 0.25);
    }

    .filter-chip .chip-icon {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Section Header */
    .section-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
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

    .transaction-count {
        font-size: 12px;
        font-weight: 600;
        color: #94a3b8;
    }

    /* Transaction Cards */
    .transactions-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .transaction-card {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #fff;
        border-radius: 14px;
        padding: 14px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        transition: all 0.25s;
        cursor: pointer;
    }

    .transaction-card:active {
        transform: scale(0.98);
        background: #f8fafc;
    }

    .transaction-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .transaction-icon.pending {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #f59e0b;
    }

    .transaction-icon.completed {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #22c55e;
    }

    .transaction-icon.failed {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #ef4444;
    }

    .transaction-details {
        flex: 1;
        min-width: 0;
    }

    .transaction-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 6px;
    }

    .transaction-title {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
    }

    .transaction-amount {
        font-size: 15px;
        font-weight: 700;
    }

    .transaction-amount.positive {
        color: #22c55e;
    }

    .transaction-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .transaction-meta {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .network-badge {
        font-size: 10px;
        font-weight: 700;
        color: #2A6CF6;
        background: rgba(42, 108, 246, 0.1);
        padding: 3px 8px;
        border-radius: 6px;
    }

    .transaction-date {
        font-size: 11px;
        color: #94a3b8;
    }

    .status-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 8px;
    }

    .status-badge.pending {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #b45309;
    }

    .status-badge.completed {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #166534;
    }

    .status-badge.failed {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #b91c1c;
    }

    .transaction-arrow {
        color: #cbd5e1;
        flex-shrink: 0;
    }

    /* Empty State */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        text-align: center;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    }

    .empty-state .empty-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, rgba(42, 108, 246, 0.1) 0%, rgba(59, 140, 255, 0.1) 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        color: #2A6CF6;
    }

    .empty-state h3 {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 8px;
    }

    .empty-state p {
        font-size: 13px;
        color: #94a3b8;
        margin: 0 0 20px;
    }

    .empty-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(42, 108, 246, 0.25);
        transition: all 0.25s;
    }

    .empty-action-btn:active {
        transform: scale(0.96);
    }

    /* Bottom Drawer */
    .drawer-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 998;
    }

    .drawer-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .deposit-drawer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        max-width: 430px;
        margin: 0 auto;
        background: #fff;
        border-radius: 24px 24px 0 0;
        transform: translateY(100%);
        transition: transform 0.3s ease;
        z-index: 999;
        max-height: 85vh;
        overflow-y: auto;
    }

    .deposit-drawer.active {
        transform: translateY(0);
    }

    .drawer-handle {
        display: flex;
        justify-content: center;
        padding: 12px;
        cursor: pointer;
    }

    .handle-bar {
        width: 40px;
        height: 4px;
        background: #e2e8f0;
        border-radius: 2px;
    }

    .drawer-content {
        padding: 0 20px 30px;
    }

    .drawer-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .drawer-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #f59e0b;
    }

    .drawer-icon.completed {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #22c55e;
    }

    .drawer-icon.failed {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #ef4444;
    }

    .drawer-title {
        flex: 1;
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .drawer-status-badge {
        font-size: 12px;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 8px;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #b45309;
    }

    .drawer-status-badge.completed {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #166534;
    }

    .drawer-status-badge.failed {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #b91c1c;
    }

    .drawer-amount-section {
        text-align: center;
        padding: 20px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 16px;
        margin-bottom: 20px;
    }

    .drawer-amount-label {
        display: block;
        font-size: 13px;
        color: #64748b;
        margin-bottom: 4px;
    }

    .drawer-amount {
        font-size: 36px;
        font-weight: 800;
        color: #22c55e;
        letter-spacing: -1px;
    }

    .drawer-details-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 24px;
    }

    .drawer-detail-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        background: #f8fafc;
        border-radius: 12px;
    }

    .drawer-detail-item.address-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .detail-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #64748b;
    }

    .detail-label svg {
        color: #94a3b8;
    }

    .detail-value {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
    }

    .detail-value.address-value {
        font-size: 11px;
        word-break: break-all;
        color: #2A6CF6;
        background: rgba(42, 108, 246, 0.1);
        padding: 8px 12px;
        border-radius: 8px;
        width: 100%;
        font-family: monospace;
    }

    .drawer-close-btn {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        color: #fff;
        border: none;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s;
    }

    .drawer-close-btn:active {
        transform: scale(0.98);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chips = document.querySelectorAll('.filter-chip');
        const items = document.querySelectorAll('.transaction-card');
        const emptyState = document.querySelector('.empty-state:not(.filter-empty)');
        const filterEmpty = document.querySelector('.filter-empty');

        chips.forEach(chip => {
            chip.addEventListener('click', () => {
                chips.forEach(c => c.classList.remove('active'));
                chip.classList.add('active');

                const filter = chip.dataset.filter;
                let visibleCount = 0;

                items.forEach(item => {
                    if (filter === 'all' || item.dataset.status === filter) {
                        item.style.display = 'flex';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                if (visibleCount === 0 && items.length > 0) {
                    filterEmpty.style.display = 'flex';
                    if (emptyState) emptyState.style.display = 'none';
                } else {
                    filterEmpty.style.display = 'none';
                }
            });
        });
    });

    function openDepositDrawer(card) {
        const drawer = document.getElementById('depositDrawer');
        const overlay = document.getElementById('drawerOverlay');
        
        // Get data from card
        const amount = card.dataset.depositAmount;
        const status = card.dataset.depositStatus;
        const statusLabel = card.dataset.depositStatusLabel;
        const payId = card.dataset.depositPayId;
        const orderId = card.dataset.depositOrderId;
        const payAddress = card.dataset.depositPayAddress;
        const currency = card.dataset.depositCurrency;
        const network = card.dataset.depositNetwork;
        const created = card.dataset.depositCreated;
        const updated = card.dataset.depositUpdated;
        
        // Map status to display category
        const statusMap = {
            'waiting': 'pending',
            'confirming': 'pending',
            'confirmed': 'pending',
            'sending': 'pending',
            'partially_paid': 'pending',
            'finished': 'completed',
            'failed': 'failed',
            'refunded': 'failed',
            'expired': 'failed',
        };
        const displayStatus = statusMap[status] || 'pending';
        
        // Update drawer content
        document.getElementById('drawerAmount').textContent = '$' + parseFloat(amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('drawerDetailStatus').textContent = statusLabel;
        document.getElementById('drawerDetailCurrency').textContent = currency || 'USDT';
        document.getElementById('drawerDetailNetwork').textContent = network || 'TRC20';
        document.getElementById('drawerDetailOrderId').textContent = orderId || '-';
        document.getElementById('drawerDetailPayId').textContent = payId || '-';
        document.getElementById('drawerDetailPayAddress').textContent = payAddress || '-';
        document.getElementById('drawerDetailCreated').textContent = created || '-';
        document.getElementById('drawerDetailUpdated').textContent = updated || '-';
        
        // Update status badge
        const statusBadge = document.getElementById('drawerStatusBadge');
        statusBadge.textContent = statusLabel;
        statusBadge.className = 'drawer-status-badge ' + displayStatus;
        
        // Update icon
        const drawerIcon = document.getElementById('drawerIcon');
        drawerIcon.className = 'drawer-icon ' + displayStatus;
        
        let iconSvg = '';
        if (displayStatus === 'pending') {
            iconSvg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12,6 12,12 16,14"></polyline></svg>';
        } else if (displayStatus === 'completed') {
            iconSvg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20,6 9,17 4,12"></polyline></svg>';
        } else {
            iconSvg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>';
        }
        drawerIcon.innerHTML = iconSvg;
        
        // Show drawer
        drawer.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeDepositDrawer() {
        const drawer = document.getElementById('depositDrawer');
        const overlay = document.getElementById('drawerOverlay');
        
        drawer.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
</script>
@endsection
