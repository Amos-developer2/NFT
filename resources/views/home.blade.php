@extends('layouts.app')

@section('content')
<div class="nft-home-wrapper">
    <!-- Balance Card -->
    <div class="nft-balance-card">
        <div class="balance-card-bg"></div>
        <div class="balance-card-content">
            <div class="balance-header">
                <div class="balance-label">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4" />
                        <path d="M3 5v14a2 2 0 0 0 2 2h16v-5" />
                        <path d="M18 12a2 2 0 0 0 0 4h4v-4h-4z" />
                    </svg>
                    <span>Total Balance</span>
                </div>
                <a href="{{ route('collection') }}" class="explore-link">
                    Explore
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="balance-amount">
                <span class="amount">{{ number_format(Auth::user()->balance ?? 0, 2) }}</span>
                <span class="currency">USDT</span>
            </div>
            <div class="balance-crypto">
                <div class="crypto-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
                    </svg>
                    <span>{{ Auth::user()->germs ?? 0 }} Germs</span>
                </div>
                <!-- <div class="crypto-item stars">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        <span>{{ $userStats['stars'] ?? 100 }} Stars</span>
                    </div> -->
                <div class="daily-checkin-btn-wrapper-small">
                    <a href="" class="daily-checkin-btn-small">
                        <span class="btn-icon">🎁</span>
                        <span>Daily Check-In</span>
                    </a>
                </div>
            </div>
            <div class="balance-actions">
                <a href="{{ route('user.deposit') }}" class="balance-btn deposit">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M12 5v14M5 12l7-7 7 7" />
                    </svg>
                    <span>Deposit</span>
                </a>
                <a href="{{ route('user.withdrawal') }}" class="balance-btn withdraw">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M12 19V5M5 12l7 7 7-7" />
                    </svg>
                    <span>Withdraw</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="nft-quick-stats-card">
        <div class="stat-item">
            <span class="stat-value">{{ $userStats['nftsOwned'] ?? 0 }}</span>
            <span class="stat-label">NFTs</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <span class="stat-value">${{ number_format($userStats['netWorth'] ?? 0, 0) }}</span>
            <span class="stat-label">Net Worth</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <span class="stat-value {{ ($userStats['profit'] ?? 0) >= 0 ? 'profit-up' : 'profit-down' }}">
                {{ ($userStats['profit'] ?? 0) >= 0 ? '+' : '' }}${{ number_format($userStats['profit'] ?? 0, 2) }}
            </span>
            <span class="stat-label">Profit</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <span class="stat-value" id="change2m-value">
                <span id="change2m-arrow"></span><span id="change2m-sign"></span><span id="change2m-num">{{ number_format($userStats['change24h'] ?? 0, 2) }}</span>%
            </span>
            <span class="stat-label">2m Change</span>
        </div>
    </div>

    <!-- Gamification Section -->
    <!-- <div class="nft-gamification-card">
            <h3 class="gamification-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M8 12l2 2 4-4" />
                </svg>
                Daily & Weekly Challenges
            </h3>
            <ul class="gamification-list">
                <li>
                    <span class="challenge-name">Buy 3 NFTs today</span>
                    <div class="challenge-progress">
                        <div class="progress-bar" style="width: 66%"></div>
                    </div>
                    <span class="challenge-reward">+10 Stars</span>
                </li>
                <li>
                    <span class="challenge-name">Refer a friend</span>
                    <div class="challenge-progress">
                        <div class="progress-bar" style="width: 0%"></div>
                    </div>
                    <span class="challenge-reward">+20 Germs</span>
                </li>
                <li>
                    <span class="challenge-name">Sell 1 NFT this week</span>
                    <div class="challenge-progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="challenge-reward completed">Completed!</span>
                </li>
            </ul>
        </div> -->


    <!-- Search Section -->
    <div class="nft-search-section">
        <div class="search-wrapper">
            <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.35-4.35" />
            </svg>
            <input type="text" placeholder="Search NFTs..." class="nft-search-input" id="nftSearch">
            <button class="filter-toggle">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
                </svg>
            </button>
        </div>
        <div class="filter-chips">
            <button class="nft-chip active" data-filter="all">
                <span class="chip-icon">🔥</span>
                <span>Trending</span>
            </button>
            <button class="nft-chip" data-filter="Common">
                <span class="chip-icon">⭐</span>
                <span>Common</span>
            </button>
            <button class="nft-chip" data-filter="Rare">
                <span class="chip-icon">💎</span>
                <span>Rare</span>
            </button>
            <button class="nft-chip" data-filter="Epic">
                <span class="chip-icon">🎯</span>
                <span>Epic</span>
            </button>
            <button class="nft-chip" data-filter="Legendary">
                <span class="chip-icon">👑</span>
                <span>Legendary</span>
            </button>
        </div>
    </div>

    <!-- Section Header -->
    <div class="nft-section-header">
        <h2 class="section-title">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <path d="M3 9h18" />
                <path d="M9 21V9" />
            </svg>
            NFT Market
        </h2>
        <a href="{{ route('collection') }}" class="see-all-btn">
            <span>My Collection</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <!-- NFT Grid -->
    <div class="nft-market-grid">
        @forelse($nfts ?? [] as $nft)
        @php
        $profit = $nft['value'] - $nft['price'];
        $profitPercent = $nft['price'] > 0 ? (($profit / $nft['price']) * 100) : 0;
        @endphp
        <div class="nft-market-card" data-rarity="{{ $nft['rarity'] }}" data-name="{{ strtolower($nft['name']) }}">
            <div class="card-image-section">
                <img src="{{ $nft['image'] }}" alt="{{ $nft['name'] }}" class="card-image">
                <span class="rarity-tag {{ strtolower($nft['rarity']) }}">{{ $nft['rarity'] }}</span>
                <span class="profit-tag {{ $profitPercent >= 0 ? 'up' : 'down' }}">
                    {{ $profitPercent >= 0 ? '+' : '' }}{{ number_format($profitPercent, 0) }}%
                </span>
            </div>
            <div class="card-details">
                <div class="details-row">
                    <h3 class="nft-name">{{ $nft['name'] }}</h3>
                    <span class="nft-id">#{{ $nft['id'] }}</span>
                </div>
                <div class="details-row">
                    <div class="nft-price">
                        <span style="display:block; font-size:12px; color:#1e293b; font-weight:700;">Current: {{ isset($nft['price']) ? number_format($nft['price'], 2) : '--' }} <span style="font-size:10px; color:#64748b; font-weight:500;">USDT</span></span>
                        <span style="display:block; font-size:11px; color:#64748b;">Purchase: {{ isset($nft['purchase_price']) ? number_format($nft['purchase_price'], 2) : '--' }} <span style="font-size:10px; color:#94a3b8; font-weight:500;">USDT</span></span>
                    </div>
                    <a href="{{ route('nft.purchase', $nft['id']) }}" class="buy-btn">Buy</a>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <path d="M3 9h18" />
                    <path d="M9 21V9" />
                </svg>
            </div>
            <h3>No NFTs Available</h3>
            <p>Check back later for new listings</p>
        </div>
        @endforelse
    </div>

    <!-- Bottom Stats -->
    <div class="nft-bottom-stats">
        <div class="bottom-stat">
            <span class="stat-num">50K+</span>
            <span class="stat-text">Users</span>
        </div>
        <div class="stat-divider"></div>
        <div class="bottom-stat">
            <span class="stat-num">$2.5M</span>
            <span class="stat-text">Volume</span>
        </div>
        <div class="stat-divider"></div>
        <div class="bottom-stat">
            <span class="stat-num">{{ count($nfts ?? []) }}</span>
            <span class="stat-text">NFTs</span>
        </div>
    </div>
</div>

<style>
    .daily-checkin-btn-wrapper,
    .daily-checkin-btn-wrapper-small {
        display: flex;
        justify-content: center;
        margin-top: 0;
    }

    .daily-checkin-btn-small {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        background: linear-gradient(90deg, #fbbf24, #2A6CF6, #3B8CFF);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        border-radius: 16px;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(42, 108, 246, 0.10);
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        margin-top: 4px;
        margin-bottom: 0;
        animation: bounce 1.2s infinite alternate;
    }

    .daily-checkin-btn-small .btn-icon {
        font-size: 15px;
        animation: spin 2s linear infinite;
    }

    .daily-checkin-btn-small:hover {
        transform: scale(1.08);
        box-shadow: 0 4px 12px rgba(42, 108, 246, 0.18);
    }

    .daily-checkin-btn-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 18px;
    }

    .daily-checkin-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 32px;
        background: linear-gradient(90deg, #fbbf24, #2A6CF6, #3B8CFF);
        color: #fff;
        font-size: 16px;
        font-weight: 800;
        border-radius: 30px;
        text-decoration: none;
        box-shadow: 0 4px 16px rgba(42, 108, 246, 0.10);
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        animation: bounce 1.2s infinite alternate;
    }

    .daily-checkin-btn .btn-icon {
        font-size: 22px;
        animation: spin 2s linear infinite;
    }

    .daily-checkin-btn:hover {
        transform: scale(1.06);
        box-shadow: 0 8px 24px rgba(42, 108, 246, 0.18);
    }

    @keyframes bounce {
        0% {
            transform: translateY(0);
        }

        100% {
            transform: translateY(-8px);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .nft-home-wrapper {
        padding: 0 16px 100px;
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
    }

    .nft-gamification-card {
        background: #fff;
        border-radius: 16px;
        margin: 18px 0 24px 0;
        padding: 18px 16px 14px 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(42, 108, 246, 0.08);
    }

    .gamification-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 16px;
        font-weight: 700;
        color: #2A6CF6;
        margin-bottom: 12px;
    }

    .gamification-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .gamification-list li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
        border-radius: 10px;
        padding: 10px 12px;
        gap: 10px;
    }

    .challenge-name {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        flex: 2;
    }

    .challenge-progress {
        flex: 2;
        background: #e2e8f0;
        border-radius: 6px;
        height: 8px;
        width: 100%;
        margin: 0 10px;
        position: relative;
        overflow: hidden;
    }

    .progress-bar {
        background: linear-gradient(90deg, #2A6CF6, #3B8CFF);
        height: 100%;
        border-radius: 6px;
        transition: width 0.4s;
    }

    .challenge-reward {
        font-size: 12px;
        font-weight: 700;
        color: #22c55e;
        flex: 1;
        text-align: right;
    }

    .challenge-reward.completed {
        color: #64748b;
    }

    .nft-balance-card {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .balance-card-bg {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 50%, #60a5fa 100%);
    }

    .balance-card-bg::before {
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
        0% {
            left: -100%;
        }

        100% {
            left: 100%;
        }
    }

    .balance-card-content {
        position: relative;
        padding: 15px;
        color: #fff;
    }

    .balance-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        /* margin-bottom: 16px; */
    }

    .balance-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        opacity: 0.9;
    }

    .explore-link {
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

    .explore-link:active {
        transform: scale(0.96);
        background: rgba(255, 255, 255, 0.3);
    }

    .balance-amount {
        margin-bottom: 12px;
    }

    .balance-amount .amount {
        font-size: 36px;
        font-weight: 800;
        letter-spacing: -1px;
    }

    .balance-amount .currency {
        font-size: 18px;
        font-weight: 600;
        opacity: 0.9;
        margin-left: 8px;
    }

    .balance-crypto {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .crypto-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        opacity: 0.9;
    }

    .crypto-item.stars svg {
        fill: #fbbf24;
        stroke: #fbbf24;
    }

    .balance-actions {
        display: flex;
        gap: 12px;
    }

    .balance-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .balance-btn.deposit {
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        backdrop-filter: blur(10px);
    }

    .balance-btn.withdraw {
        background: #fff;
        color: #2A6CF6;
    }

    .balance-btn:active {
        transform: scale(0.98);
    }

    .nft-quick-stats-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fff;
        border-radius: 16px;
        padding: 16px 12px;
        margin-bottom: 24px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(42, 108, 246, 0.08);
    }

    .nft-quick-stats-card .stat-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 0 4px;
    }

    .nft-quick-stats-card .stat-value {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        white-space: nowrap;
    }

    .nft-quick-stats-card .stat-value.profit-up {
        color: #22c55e;
    }

    .nft-quick-stats-card .stat-value.profit-down {
        color: #ef4444;
    }

    .nft-quick-stats-card .stat-label {
        font-size: 11px;
        color: #64748b;
        margin-top: 2px;
    }

    .nft-quick-stats-card .stat-divider {
        width: 1px;
        height: 36px;
        background: linear-gradient(180deg, transparent, #e2e8f0, transparent);
        flex-shrink: 0;
    }

    .nft-search-section {
        margin-bottom: 24px;
        width: 100%;
        max-width: 100%;
        overflow: hidden;
    }

    .search-wrapper {
        position: relative;
        margin-bottom: 14px;
        width: 100%;
        box-sizing: border-box;
    }

    .search-wrapper::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 14px;
        padding: 2px;
        background: linear-gradient(135deg, #e2e8f0, #f1f5f9);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
        opacity: 0.6;
        transition: all 0.3s ease;
    }

    .search-wrapper:focus-within::before {
        background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
        opacity: 1;
    }

    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        z-index: 1;
        flex-shrink: 0;
    }

    .search-wrapper:focus-within .search-icon {
        color: #2A6CF6;
    }

    .nft-search-input {
        width: 100%;
        padding: 14px 56px 14px 44px;
        background: #fff;
        border: none;
        border-radius: 14px;
        font-size: 14px;
        color: #1e293b;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        box-sizing: border-box;
    }

    .nft-search-input::placeholder {
        color: #94a3b8;
    }

    .nft-search-input:focus {
        outline: none;
    }

    .filter-toggle {
        position: absolute;
        right: 6px;
        top: 50%;
        transform: translateY(-50%);
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
        border: none;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
    }

    .filter-chips {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 4px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .filter-chips::-webkit-scrollbar {
        display: none;
    }

    .nft-chip {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 10px 16px;
        background: #fff;
        border: 1px solid rgba(42, 108, 246, 0.1);
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        color: #64748b;
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .nft-chip .chip-icon {
        font-size: 14px;
    }

    .nft-chip.active {
        background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
        border-color: transparent;
        color: #fff;
    }

    .nft-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .section-title svg {
        color: #2A6CF6;
    }

    .see-all-btn {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 14px;
        font-weight: 600;
        color: #2A6CF6;
        text-decoration: none;
    }

    .nft-market-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 24px;
    }

    .nft-market-card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(42, 108, 246, 0.08);
        transition: transform 0.2s ease;
    }

    .nft-market-card:active {
        transform: scale(0.98);
    }

    .nft-market-card .card-image-section {
        position: relative;
        aspect-ratio: 1;
        overflow: hidden;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    }

    .nft-market-card .card-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .nft-market-card .rarity-tag {
        position: absolute;
        top: 8px;
        left: 8px;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .rarity-tag.legendary {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: #fff;
    }

    .rarity-tag.epic {
        background: linear-gradient(135deg, #a855f7, #8b5cf6);
        color: #fff;
    }

    .rarity-tag.rare {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #fff;
    }

    .rarity-tag.common {
        background: #e2e8f0;
        color: #64748b;
    }

    .nft-market-card .profit-tag {
        position: absolute;
        top: 8px;
        right: 8px;
        padding: 4px 6px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 700;
    }

    .profit-tag.up {
        background: rgba(34, 197, 94, 0.9);
        color: #fff;
    }

    .profit-tag.down {
        background: rgba(239, 68, 68, 0.9);
        color: #fff;
    }

    .nft-market-card .card-details {
        display: flex;
        flex-direction: column;
        padding: 10px;
        gap: 6px;
    }

    .nft-market-card .details-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .nft-market-card .nft-name {
        font-size: 12px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: 1;
        min-width: 0;
    }

    .nft-market-card .nft-id {
        font-size: 10px;
        color: #94a3b8;
        font-weight: 500;
        flex-shrink: 0;
    }

    .nft-market-card .nft-price {
        font-size: 12px;
        font-weight: 700;
        color: #1e293b;
        white-space: nowrap;
    }

    .nft-market-card .nft-price span {
        font-size: 9px;
        color: #64748b;
        font-weight: 500;
    }

    .nft-market-card .buy-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 14px;
        background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
        border: none;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        color: #fff;
        text-decoration: none;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .nft-market-card .buy-btn:active {
        transform: scale(0.95);
        background: linear-gradient(135deg, #1d5ed9, #2a7cf6);
    }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 48px 20px;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 16px;
        border-radius: 20px;
        background: linear-gradient(135deg, rgba(42, 108, 246, 0.1), rgba(59, 140, 255, 0.1));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2A6CF6;
    }

    .empty-state h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 8px;
    }

    .empty-state p {
        font-size: 14px;
        color: #64748b;
        margin: 0;
    }

    .nft-bottom-stats {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 32px;
        padding: 20px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(42, 108, 246, 0.08);
    }

    .bottom-stat {
        text-align: center;
    }

    .bottom-stat .stat-num {
        display: block;
        font-size: 20px;
        font-weight: 700;
        background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .bottom-stat .stat-text {
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .nft-bottom-stats .stat-divider {
        width: 1px;
        height: 32px;
        background: linear-gradient(180deg, transparent, #e2e8f0, transparent);
    }

    @media (max-width: 360px) {
        .nft-market-grid {
            grid-template-columns: 1fr;
        }

        .nft-quick-stats {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateChange2m() {
            fetch('/api/portfolio-change')
                .then(res => res.json())
                .then(data => {
                    let change = parseFloat(data.change24h || 0);
                    let isUp = change > 0;
                    let isDown = change < 0;
                    let arrow = isUp ? '▲' : (isDown ? '▼' : '');
                    let color = isUp ? '#22c55e' : (isDown ? '#ef4444' : '#64748b');
                    let sign = isUp ? '+' : '';
                    document.getElementById('change2m-value').style.color = color;
                    document.getElementById('change2m-arrow').textContent = arrow;
                    document.getElementById('change2m-sign').textContent = sign;
                    document.getElementById('change2m-num').textContent = change.toFixed(2);
                });
        }
        setInterval(updateChange2m, 15000);

        document.querySelectorAll('.nft-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                document.querySelectorAll('.nft-chip').forEach(c => c.classList.remove('active'));
                this.classList.add('active');

                const filter = this.dataset.filter;
                document.querySelectorAll('.nft-market-card').forEach(card => {
                    if (filter === 'all' || card.dataset.rarity === filter) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        document.getElementById('nftSearch').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.nft-market-card').forEach(card => {
                const name = card.dataset.name;
                card.style.display = name.includes(query) ? 'block' : 'none';
            });
        });

        document.querySelectorAll('.card-favorite-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.toggle('active');
            });
        });
    });
</script>
@endsection