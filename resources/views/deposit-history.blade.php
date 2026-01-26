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
                <span class="amount">${{ number_format($totalAmount ?? 1950, 2) }}</span>
            </div>
            <div class="balance-subtitle">Total Deposited</div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="history-quick-stats">
        <div class="stat-item">
            <span class="stat-value">{{ $totalDeposits ?? 6 }}</span>
            <span class="stat-label">Total</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <span class="stat-value pending-text">{{ $pendingCount ?? 1 }}</span>
            <span class="stat-label">Pending</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <span class="stat-value completed-text">{{ $completedCount ?? 5 }}</span>
            <span class="stat-label">Completed</span>
        </div>
    </div>

    <!-- Filter Chips -->
    <div class="filter-chips-section">
        <button class="filter-chip active" data-filter="all">
            <span class="chip-icon">📋</span>
            <span>All</span>
        </button>
        <button class="filter-chip" data-filter="pending">
            <span class="chip-icon">⏳</span>
            <span>Pending</span>
        </button>
        <button class="filter-chip" data-filter="completed">
            <span class="chip-icon">✅</span>
            <span>Completed</span>
        </button>
        <button class="filter-chip" data-filter="failed">
            <span class="chip-icon">❌</span>
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
        <span class="transaction-count">{{ $totalDeposits ?? 6 }} records</span>
    </div>

    <!-- Transactions List -->
    <div class="transactions-list">
        @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                nativeAlert(@json(session('success')), { type: 'success', title: 'Success' });
            });
        </script>
        @endif
        @if($errors && $errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                nativeAlert(@json(implode("\n", $errors->all())), { type: 'error', title: 'Error' });
            });
        </script>
        @endif

        <!-- Sample Pending Deposit -->
        <div class="transaction-card" data-status="pending">
            <div class="transaction-icon pending">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12,6 12,12 16,14"></polyline>
                </svg>
            </div>
            <div class="transaction-details">
                <div class="transaction-top">
                    <span class="transaction-title">Deposit</span>
                    <span class="transaction-amount positive">+$250.00</span>
                </div>
                <div class="transaction-bottom">
                    <div class="transaction-meta">
                        <span class="network-badge">TRC20</span>
                        <span class="transaction-date">Jan 19, 2026 • 3:45 PM</span>
                    </div>
                    <span class="status-badge pending">Pending</span>
                </div>
            </div>
        </div>

        <!-- Sample Completed Deposit -->
        <div class="transaction-card" data-status="completed">
            <div class="transaction-icon completed">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20,6 9,17 4,12"></polyline>
                </svg>
            </div>
            <div class="transaction-details">
                <div class="transaction-top">
                    <span class="transaction-title">Deposit</span>
                    <span class="transaction-amount positive">+$500.00</span>
                </div>
                <div class="transaction-bottom">
                    <div class="transaction-meta">
                        <span class="network-badge">BEP20</span>
                        <span class="transaction-date">Jan 18, 2026 • 11:30 AM</span>
                    </div>
                    <span class="status-badge completed">Completed</span>
                </div>
            </div>
        </div>

        <!-- Sample Completed Deposit 2 -->
        <div class="transaction-card" data-status="completed">
            <div class="transaction-icon completed">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20,6 9,17 4,12"></polyline>
                </svg>
            </div>
            <div class="transaction-details">
                <div class="transaction-top">
                    <span class="transaction-title">Deposit</span>
                    <span class="transaction-amount positive">+$100.00</span>
                </div>
                <div class="transaction-bottom">
                    <div class="transaction-meta">
                        <span class="network-badge">TRC20</span>
                        <span class="transaction-date">Jan 17, 2026 • 9:15 AM</span>
                    </div>
                    <span class="status-badge completed">Completed</span>
                </div>
            </div>
        </div>

        <!-- Sample Completed Deposit 3 -->
        <div class="transaction-card" data-status="completed">
            <div class="transaction-icon completed">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20,6 9,17 4,12"></polyline>
                </svg>
            </div>
            <div class="transaction-details">
                <div class="transaction-top">
                    <span class="transaction-title">Deposit</span>
                    <span class="transaction-amount positive">+$750.00</span>
                </div>
                <div class="transaction-bottom">
                    <div class="transaction-meta">
                        <span class="network-badge">BEP20</span>
                        <span class="transaction-date">Jan 15, 2026 • 2:00 PM</span>
                    </div>
                    <span class="status-badge completed">Completed</span>
                </div>
            </div>
        </div>

        <!-- Sample Completed Deposit 4 -->
        <div class="transaction-card" data-status="completed">
            <div class="transaction-icon completed">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20,6 9,17 4,12"></polyline>
                </svg>
            </div>
            <div class="transaction-details">
                <div class="transaction-top">
                    <span class="transaction-title">Deposit</span>
                    <span class="transaction-amount positive">+$300.00</span>
                </div>
                <div class="transaction-bottom">
                    <div class="transaction-meta">
                        <span class="network-badge">TRC20</span>
                        <span class="transaction-date">Jan 12, 2026 • 5:30 PM</span>
                    </div>
                    <span class="status-badge completed">Completed</span>
                </div>
            </div>
        </div>

        <!-- Sample Failed Deposit -->
        <div class="transaction-card" data-status="failed">
            <div class="transaction-icon failed">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </div>
            <div class="transaction-details">
                <div class="transaction-top">
                    <span class="transaction-title">Deposit</span>
                    <span class="transaction-amount positive">+$50.00</span>
                </div>
                <div class="transaction-bottom">
                    <div class="transaction-meta">
                        <span class="network-badge">TRC20</span>
                        <span class="transaction-date">Jan 10, 2026 • 10:00 AM</span>
                    </div>
                    <span class="status-badge failed">Failed</span>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div class="empty-state" style="display: none;">
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
        font-size: 14px;
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
        align-items: flex-start;
        gap: 12px;
        background: #fff;
        border-radius: 14px;
        padding: 14px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        transition: all 0.25s;
    }

    .transaction-card:active {
        transform: scale(0.98);
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
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chips = document.querySelectorAll('.filter-chip');
        const items = document.querySelectorAll('.transaction-card');
        const emptyState = document.querySelector('.empty-state');

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

                if (visibleCount === 0) {
                    emptyState.style.display = 'flex';
                } else {
                    emptyState.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection