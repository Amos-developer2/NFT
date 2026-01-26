@extends('layouts.app')

@section('content')
<div class="history-wrapper">
    <!-- Header Card -->
    <div class="history-header-card">
        <div class="header-bg"></div>
        <div class="header-content">
            <div class="header-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <h1 class="header-title">Withdrawal History</h1>
            <p class="header-subtitle">Track all your withdrawal transactions</p>
        </div>
        
        <!-- Stats Display -->
        <div class="stats-display">
            <div class="stat-item">
                <span class="stat-value">${{ number_format($totalAmount ?? 925.50, 2) }}</span>
                <span class="stat-label">Total Withdrawn</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-value">{{ $totalWithdrawals ?? 5 }}</span>
                <span class="stat-label">Transactions</span>
            </div>
        </div>
    </div>

    <!-- Status Cards -->
    <div class="status-cards">
        <div class="status-card pending">
            <div class="status-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div class="status-info">
                <span class="status-count">{{ $pendingCount ?? 2 }}</span>
                <span class="status-label">Pending</span>
            </div>
        </div>
        <div class="status-card completed">
            <div class="status-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div class="status-info">
                <span class="status-count">{{ $completedCount ?? 3 }}</span>
                <span class="status-label">Completed</span>
            </div>
        </div>
        <div class="status-card failed">
            <div class="status-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </div>
            <div class="status-info">
                <span class="status-count">{{ $failedCount ?? 0 }}</span>
                <span class="status-label">Failed</span>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-section">
        <div class="filter-tabs">
            <button class="filter-tab active" data-filter="all">
                <span>All</span>
            </button>
            <button class="filter-tab" data-filter="pending">
                <span>Pending</span>
            </button>
            <button class="filter-tab" data-filter="completed">
                <span>Completed</span>
            </button>
            <button class="filter-tab" data-filter="failed">
                <span>Failed</span>
            </button>
        </div>
    </div>

    <!-- Transactions List -->
    <div class="transactions-list">
        <!-- Date Group -->
        <div class="date-group">
            <div class="date-header">
                <span class="date-text">Today</span>
                <span class="date-line"></span>
            </div>
            
            <!-- Pending Item -->
            <div class="transaction-card" data-status="pending">
                <div class="transaction-main">
                    <div class="transaction-icon pending">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <div class="transaction-info">
                        <div class="transaction-title">Withdrawal</div>
                        <div class="transaction-meta">
                            <span class="network-badge">TRC20</span>
                            <span class="transaction-time">2:30 PM</span>
                        </div>
                    </div>
                    <div class="transaction-amount-section">
                        <span class="transaction-amount">-$150.00</span>
                        <span class="transaction-status pending">Pending</span>
                    </div>
                </div>
                <div class="transaction-details">
                    <div class="detail-row">
                        <span class="detail-label">Fee</span>
                        <span class="detail-value">$1.00</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Received</span>
                        <span class="detail-value">$149.00</span>
                    </div>
                </div>
                <button class="expand-btn" onclick="toggleDetails(this)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>
            </div>

            <!-- Pending Item 2 -->
            <div class="transaction-card" data-status="pending">
                <div class="transaction-main">
                    <div class="transaction-icon pending">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <div class="transaction-info">
                        <div class="transaction-title">Withdrawal</div>
                        <div class="transaction-meta">
                            <span class="network-badge bep20">BEP20</span>
                            <span class="transaction-time">1:15 PM</span>
                        </div>
                    </div>
                    <div class="transaction-amount-section">
                        <span class="transaction-amount">-$75.50</span>
                        <span class="transaction-status pending">Pending</span>
                    </div>
                </div>
                <div class="transaction-details">
                    <div class="detail-row">
                        <span class="detail-label">Fee</span>
                        <span class="detail-value">$0.50</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Received</span>
                        <span class="detail-value">$75.00</span>
                    </div>
                </div>
                <button class="expand-btn" onclick="toggleDetails(this)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Yesterday Group -->
        <div class="date-group">
            <div class="date-header">
                <span class="date-text">Yesterday</span>
                <span class="date-line"></span>
            </div>
            
            <!-- Completed Item -->
            <div class="transaction-card" data-status="completed">
                <div class="transaction-main">
                    <div class="transaction-icon completed">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <div class="transaction-info">
                        <div class="transaction-title">Withdrawal</div>
                        <div class="transaction-meta">
                            <span class="network-badge">TRC20</span>
                            <span class="transaction-time">4:45 PM</span>
                        </div>
                    </div>
                    <div class="transaction-amount-section">
                        <span class="transaction-amount">-$200.00</span>
                        <span class="transaction-status completed">Completed</span>
                    </div>
                </div>
                <div class="transaction-details">
                    <div class="detail-row">
                        <span class="detail-label">Fee</span>
                        <span class="detail-value">$1.00</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Received</span>
                        <span class="detail-value">$199.00</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">TX Hash</span>
                        <span class="detail-value hash">a1b2c3...x7y8z9</span>
                    </div>
                </div>
                <button class="expand-btn" onclick="toggleDetails(this)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Earlier Group -->
        <div class="date-group">
            <div class="date-header">
                <span class="date-text">Jan 17, 2026</span>
                <span class="date-line"></span>
            </div>
            
            <!-- Completed Item 2 -->
            <div class="transaction-card" data-status="completed">
                <div class="transaction-main">
                    <div class="transaction-icon completed">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <div class="transaction-info">
                        <div class="transaction-title">Withdrawal</div>
                        <div class="transaction-meta">
                            <span class="network-badge bep20">BEP20</span>
                            <span class="transaction-time">10:20 AM</span>
                        </div>
                    </div>
                    <div class="transaction-amount-section">
                        <span class="transaction-amount">-$500.00</span>
                        <span class="transaction-status completed">Completed</span>
                    </div>
                </div>
                <div class="transaction-details">
                    <div class="detail-row">
                        <span class="detail-label">Fee</span>
                        <span class="detail-value">$0.50</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Received</span>
                        <span class="detail-value">$499.50</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">TX Hash</span>
                        <span class="detail-value hash">d4e5f6...m3n4o5</span>
                    </div>
                </div>
                <button class="expand-btn" onclick="toggleDetails(this)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Jan 15 Group -->
        <div class="date-group">
            <div class="date-header">
                <span class="date-text">Jan 15, 2026</span>
                <span class="date-line"></span>
            </div>
            
            <!-- Failed Item -->
            <div class="transaction-card" data-status="failed">
                <div class="transaction-main">
                    <div class="transaction-icon failed">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="15" y1="9" x2="9" y2="15"/>
                            <line x1="9" y1="9" x2="15" y2="15"/>
                        </svg>
                    </div>
                    <div class="transaction-info">
                        <div class="transaction-title">Withdrawal</div>
                        <div class="transaction-meta">
                            <span class="network-badge">TRC20</span>
                            <span class="transaction-time">8:00 AM</span>
                        </div>
                    </div>
                    <div class="transaction-amount-section">
                        <span class="transaction-amount">-$50.00</span>
                        <span class="transaction-status failed">Failed</span>
                    </div>
                </div>
                <div class="transaction-details">
                    <div class="detail-row">
                        <span class="detail-label">Reason</span>
                        <span class="detail-value error">Invalid address</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Refunded</span>
                        <span class="detail-value success">Yes</span>
                    </div>
                </div>
                <button class="expand-btn" onclick="toggleDetails(this)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Empty State -->
        <div class="empty-state" style="display: none;">
            <div class="empty-illustration">
                <div class="empty-circle">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                </div>
            </div>
            <h3 class="empty-title">No withdrawals found</h3>
            <p class="empty-text">Your withdrawal history will appear here once you make your first withdrawal.</p>
        </div>
    </div>

    <!-- New Withdrawal Button -->
    <a href="{{ route('user.withdrawal') }}" class="new-withdrawal-btn">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        <span>New Withdrawal</span>
    </a>
</div>

<style>
    .history-wrapper {
        padding: 0 16px 100px;
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        max-width: 430px;
        margin: 0 auto;
    }

    .history-wrapper * {
        box-sizing: border-box;
    }

    /* Header Card */
    .history-header-card {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        margin-bottom: 16px;
        padding: 24px 20px 20px;
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
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 16px;
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
        font-size: 13px;
        opacity: 0.9;
        margin: 0;
    }

    .stats-display {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 24px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 16px 20px;
    }

    .stat-item {
        text-align: center;
    }

    .stat-value {
        display: block;
        font-size: 20px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 2px;
    }

    .stat-label {
        display: block;
        font-size: 11px;
        color: rgba(255, 255, 255, 0.8);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-divider {
        width: 1px;
        height: 36px;
        background: rgba(255, 255, 255, 0.3);
    }

    /* Status Cards */
    .status-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 20px;
    }

    .status-card {
        background: #fff;
        border-radius: 16px;
        padding: 14px 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    }

    .status-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .status-card.pending .status-icon {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #d97706;
    }

    .status-card.completed .status-icon {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #16a34a;
    }

    .status-card.failed .status-icon {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #dc2626;
    }

    .status-info {
        text-align: center;
    }

    .status-count {
        display: block;
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
    }

    .status-label {
        display: block;
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    /* Filter Section */
    .filter-section {
        margin-bottom: 20px;
    }

    .filter-tabs {
        display: flex;
        background: #fff;
        border-radius: 14px;
        padding: 4px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    }

    .filter-tab {
        flex: 1;
        padding: 10px 12px;
        background: transparent;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        transition: all 0.25s;
    }

    .filter-tab.active {
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        color: #fff;
        box-shadow: 0 4px 12px rgba(42, 108, 246, 0.3);
    }

    /* Transactions List */
    .transactions-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .date-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .date-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0 4px;
    }

    .date-text {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        white-space: nowrap;
    }

    .date-line {
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }

    /* Transaction Card */
    .transaction-card {
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        position: relative;
    }

    .transaction-main {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
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
        color: #d97706;
    }

    .transaction-icon.completed {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #16a34a;
    }

    .transaction-icon.failed {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #dc2626;
    }

    .transaction-info {
        flex: 1;
        min-width: 0;
    }

    .transaction-title {
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .transaction-meta {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .network-badge {
        padding: 3px 8px;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-radius: 6px;
        font-size: 10px;
        font-weight: 700;
        color: #2563eb;
        text-transform: uppercase;
    }

    .network-badge.bep20 {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #d97706;
    }

    .transaction-time {
        font-size: 12px;
        color: #94a3b8;
    }

    .transaction-amount-section {
        text-align: right;
        flex-shrink: 0;
    }

    .transaction-amount {
        display: block;
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .transaction-status {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .transaction-status.pending {
        background: #fef3c7;
        color: #d97706;
    }

    .transaction-status.completed {
        background: #dcfce7;
        color: #16a34a;
    }

    .transaction-status.failed {
        background: #fee2e2;
        color: #dc2626;
    }

    /* Transaction Details (Expandable) */
    .transaction-details {
        display: none;
        padding: 0 16px 16px;
        border-top: 1px solid #f1f5f9;
        margin-top: -4px;
        padding-top: 12px;
    }

    .transaction-card.expanded .transaction-details {
        display: block;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
    }

    .detail-label {
        font-size: 12px;
        color: #64748b;
    }

    .detail-value {
        font-size: 12px;
        font-weight: 600;
        color: #1e293b;
    }

    .detail-value.hash {
        font-family: 'SF Mono', Monaco, monospace;
        color: #2A6CF6;
    }

    .detail-value.error {
        color: #dc2626;
    }

    .detail-value.success {
        color: #16a34a;
    }

    .expand-btn {
        position: absolute;
        bottom: 8px;
        left: 50%;
        transform: translateX(-50%);
        width: 28px;
        height: 16px;
        background: #f1f5f9;
        border: none;
        border-radius: 8px;
        color: #94a3b8;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.25s;
    }

    .transaction-card.expanded .expand-btn {
        transform: translateX(-50%) rotate(180deg);
    }

    .expand-btn:hover {
        background: #e2e8f0;
        color: #64748b;
    }

    /* Empty State */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 48px 24px;
        text-align: center;
    }

    .empty-illustration {
        margin-bottom: 20px;
    }

    .empty-circle {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
    }

    .empty-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 8px;
    }

    .empty-text {
        font-size: 14px;
        color: #64748b;
        line-height: 1.5;
        margin: 0;
    }

    /* New Withdrawal Button */
    .new-withdrawal-btn {
        position: fixed;
        bottom: 90px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 16px 32px;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        border: none;
        border-radius: 16px;
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        text-decoration: none;
        box-shadow: 0 8px 24px rgba(42, 108, 246, 0.4);
        transition: all 0.25s;
        max-width: calc(430px - 32px);
        width: calc(100% - 32px);
    }

    .new-withdrawal-btn:active {
        transform: translateX(-50%) scale(0.98);
    }
</style>

<script>
    // Filter tabs functionality
    const tabs = document.querySelectorAll('.filter-tab');
    const cards = document.querySelectorAll('.transaction-card');
    const dateGroups = document.querySelectorAll('.date-group');
    const emptyState = document.querySelector('.empty-state');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Update active tab
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            const filter = tab.dataset.filter;
            let visibleCount = 0;

            // Filter cards
            cards.forEach(card => {
                if (filter === 'all' || card.dataset.status === filter) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Update date group visibility
            dateGroups.forEach(group => {
                const visibleCards = group.querySelectorAll('.transaction-card[style="display: block"], .transaction-card:not([style*="display"])');
                const hiddenCards = group.querySelectorAll('.transaction-card[style*="display: none"]');
                
                if (filter === 'all') {
                    group.style.display = 'flex';
                } else {
                    const hasVisibleCards = Array.from(group.querySelectorAll('.transaction-card')).some(card => {
                        return card.dataset.status === filter;
                    });
                    group.style.display = hasVisibleCards ? 'flex' : 'none';
                }
            });

            // Show empty state if no items
            if (visibleCount === 0) {
                emptyState.style.display = 'flex';
            } else {
                emptyState.style.display = 'none';
            }
        });
    });

    // Expand/collapse transaction details
    function toggleDetails(btn) {
        const card = btn.closest('.transaction-card');
        card.classList.toggle('expanded');
    }
</script>
@endsection
