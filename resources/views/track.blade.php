@extends('layouts.app', ['hideHeader' => true])

@section('title', 'My NFTs')

@push('styles')
<style>
    .track-wrapper {
        padding: 0 16px 100px;
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
    }

    /* Summary Card */
    .track-summary-card {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 50px;
    }

    .track-summary-bg {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 50%, #60a5fa 100%);
    }

    .track-summary-bg::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .track-summary-content {
        position: relative;
        padding: 20px;
        color: #fff;
    }

    .track-summary-title {
        font-size: 14px;
        font-weight: 600;
        opacity: 0.9;
        margin-bottom: 4px;
    }

    .track-summary-value {
        font-size: 32px;
        font-weight: 800;
        letter-spacing: -1px;
        margin-bottom: 16px;
    }

    .track-summary-value small {
        font-size: 16px;
        font-weight: 600;
        opacity: 0.9;
    }

    .track-stats-row {
        display: flex;
        gap: 12px;
    }

    .track-stat-item {
        flex: 1;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 12px;
        text-align: center;
    }

    .track-stat-value {
        font-size: 18px;
        font-weight: 700;
        display: block;
    }

    .track-stat-value.profit-up {
        color: #bbf7d0;
    }

    .track-stat-value.profit-down {
        color: #fecaca;
    }

    .track-stat-label {
        font-size: 11px;
        opacity: 0.85;
        margin-top: 2px;
        display: block;
    }

    /* Filter Tabs */
    .track-filter-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        overflow-x: auto;
        padding-bottom: 4px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .track-filter-tabs::-webkit-scrollbar {
        display: none;
    }

    .track-filter-tab {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 10px 18px;
        background: #fff;
        border: 1px solid rgba(42, 108, 246, 0.1);
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .track-filter-tab.active {
        background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
        border-color: transparent;
        color: #fff;
    }

    /* NFT Cards */
    .track-nft-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .track-nft-card {
        display: flex;
        align-items: center;
        gap: 14px;
        background: #fff;
        border-radius: 16px;
        padding: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(42, 108, 246, 0.06);
        transition: transform 0.2s ease;
    }

    .track-nft-card:active {
        transform: scale(0.98);
    }

    .track-nft-image {
        width: 72px;
        height: 72px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        position: relative;
    }

    .track-nft-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .track-nft-rarity {
        position: absolute;
        bottom: 4px;
        left: 4px;
        padding: 3px 6px;
        border-radius: 4px;
        font-size: 8px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .track-nft-rarity.legendary {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: #fff;
    }

    .track-nft-rarity.epic {
        background: linear-gradient(135deg, #a855f7, #8b5cf6);
        color: #fff;
    }

    .track-nft-rarity.rare {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #fff;
    }

    .track-nft-rarity.common {
        background: #e2e8f0;
        color: #64748b;
    }

    .track-nft-info {
        flex: 1;
        min-width: 0;
    }

    .track-nft-name {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .track-nft-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 12px;
        color: #64748b;
    }

    .track-nft-meta span {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .track-nft-values {
        text-align: right;
        flex-shrink: 0;
    }

    .track-nft-current {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2px;
    }

    .track-nft-profit {
        font-size: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 4px;
    }

    .track-nft-profit.up {
        color: #22c55e;
    }

    .track-nft-profit.down {
        color: #ef4444;
    }

    .track-nft-profit svg {
        width: 12px;
        height: 12px;
    }

    /* Action Button */
    .track-nft-action {
        padding: 8px 14px;
        background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
        border-radius: 8px;
        font-size: 11px;
        font-weight: 600;
        color: #fff;
        text-decoration: none;
        flex-shrink: 0;
    }

    /* Empty State */
    .track-empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 48px 24px;
        background: #fff;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    }

    .track-empty-icon {
        width: 80px;
        height: 80px;
        margin-bottom: 16px;
        background: linear-gradient(135deg, rgba(42, 108, 246, 0.1), rgba(59, 140, 255, 0.1));
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
    }

    .track-empty-state h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 8px;
    }

    .track-empty-state p {
        font-size: 14px;
        color: #64748b;
        margin: 0 0 20px;
    }

    .track-empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        text-decoration: none;
    }

    .auction-filter-btn.active {
        background: #fff !important;
        color: #2563eb !important;
    }
</style>
@endpush

@section('content')
<div class="track-wrapper">
    <!-- Page Header -->
    @include('partials.header', ['title' => 'My NFTs'])

    <!-- Summary Card -->
    <div class="track-summary-card">
        <div class="track-summary-bg"></div>
        <div class="track-summary-content">
            <div class="track-summary-title">Portfolio Value</div>
            <div class="track-summary-value">
                {{ number_format($totalValue ?? 0, 2) }} <small>USDT</small>
            </div>
            <div class="track-stats-row">
                <div class="track-stat-item">
                    <span class="track-stat-value">{{ $totalNfts ?? 0 }}</span>
                    <span class="track-stat-label">Total NFTs</span>
                </div>
                <div class="track-stat-item">
                    <span class="track-stat-value {{ ($totalProfit ?? 0) >= 0 ? 'profit-up' : 'profit-down' }}">
                        {{ ($totalProfit ?? 0) >= 0 ? '+' : '' }}{{ number_format($totalProfit ?? 0, 2) }}
                    </span>
                    <span class="track-stat-label">Total Profit</span>
                </div>
                <div class="track-stat-item">
                    @php
                        $profitPercent = ($totalValue ?? 0) > 0 && ($totalProfit ?? 0) != 0 
                            ? (($totalProfit / ($totalValue - $totalProfit)) * 100) 
                            : 0;
                    @endphp
                    <span class="track-stat-value {{ $profitPercent >= 0 ? 'profit-up' : 'profit-down' }}">
                        {{ $profitPercent >= 0 ? '+' : '' }}{{ number_format($profitPercent, 1) }}%
                    </span>
                    <span class="track-stat-label">ROI</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="track-filter-tabs">
        <button class="track-filter-tab active" data-filter="all">
            🎨 All
        </button>
        <button class="track-filter-tab" data-filter="Common">
            ⭐ Common
        </button>
        <button class="track-filter-tab" data-filter="Rare">
            💎 Rare
        </button>
        <button class="track-filter-tab" data-filter="Epic">
            🎯 Epic
        </button>
        <button class="track-filter-tab" data-filter="Legendary">
            👑 Legendary
        </button>
    </div>

    <!-- NFT List -->
    @if(($userNfts ?? collect())->isEmpty())
    <div class="track-empty-state">
        <div class="track-empty-icon">🎨</div>
        <h3>No NFTs Yet</h3>
        <p>Start building your collection by purchasing NFTs from the marketplace.</p>
        <a href="{{ route('home') }}" class="track-empty-btn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <path d="M3 9h18" />
                <path d="M9 21V9" />
            </svg>
            Browse NFTs
        </a>
    </div>
    @else
    <div class="track-nft-list">
        @foreach($userNfts as $nft)
        @php
            $profit = ($nft->value ?? 0) - ($nft->purchase_price ?? 0);
            $profitPercent = ($nft->purchase_price ?? 0) > 0 ? (($profit / $nft->purchase_price) * 100) : 0;
        @endphp
        <div class="track-nft-card" data-rarity="{{ $nft->rarity }}">
            <div class="track-nft-image">
                <img src="{{ $nft->image }}" alt="{{ $nft->name }}">
                <span class="track-nft-rarity {{ strtolower($nft->rarity) }}">{{ $nft->rarity }}</span>
            </div>
            <div class="track-nft-info">
                <h3 class="track-nft-name">{{ $nft->name }}</h3>
                <div class="track-nft-meta">
                    <span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 6v6l4 2"/>
                        </svg>
                        #{{ $nft->id }}
                    </span>
                    <span>Bought: {{ number_format($nft->purchase_price ?? 0, 2) }} USDT</span>
                </div>
            </div>
            <div class="track-nft-values">
                <div class="track-nft-current">{{ number_format($nft->value ?? 0, 2) }}</div>
                <div class="track-nft-profit {{ $profit >= 0 ? 'up' : 'down' }}">
                    @if($profit >= 0)
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 15l-6-6-6 6"/>
                    </svg>
                    @else
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                    @endif
                    {{ $profit >= 0 ? '+' : '' }}{{ number_format($profitPercent, 1) }}%
                </div>
            </div>
            <a href="{{ route('collection.show', $nft->id) }}" class="track-nft-action">View</a>
        </div>
        @endforeach
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.track-filter-tab');
    const cards = document.querySelectorAll('.track-nft-card');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            cards.forEach(card => {
                if (filter === 'all' || card.dataset.rarity === filter) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endsection
