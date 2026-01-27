@extends('layouts.app', ['hideHeader' => true])

@section('title', 'NFT Collection')

@push('styles')
<style>
    .collection-wrapper {
        padding: 0 16px 100px;
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
    }

    /* Portfolio Summary Card */
    .portfolio-card {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .portfolio-card-bg {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 50%, #60a5fa 100%);
    }

    .portfolio-card-bg::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .portfolio-card-content {
        position: relative;
        padding: 20px;
        color: #fff;
    }

    .portfolio-title {
        font-size: 14px;
        font-weight: 600;
        opacity: 0.9;
        margin-bottom: 4px;
    }

    .portfolio-value {
        font-size: 32px;
        font-weight: 800;
        letter-spacing: -1px;
        margin-bottom: 16px;
    }

    .portfolio-value small {
        font-size: 16px;
        font-weight: 600;
        opacity: 0.9;
    }

    .portfolio-stats {
        display: flex;
        gap: 12px;
    }

    .portfolio-stat {
        flex: 1;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 12px;
        text-align: center;
    }

    .portfolio-stat-value {
        font-size: 16px;
        font-weight: 700;
        display: block;
    }

    .portfolio-stat-value.profit {
        color: #bbf7d0;
    }

    .portfolio-stat-value.loss {
        color: #fecaca;
    }

    .portfolio-stat-label {
        font-size: 11px;
        opacity: 0.85;
        margin-top: 2px;
        display: block;
    }

    /* Popular Collections */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .section-title {
        font-size: 17px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .view-all-btn {
        font-size: 13px;
        font-weight: 600;
        color: #2A6CF6;
        text-decoration: none;
    }

    .collections-scroll {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding-bottom: 8px;
        margin-bottom: 24px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .collections-scroll::-webkit-scrollbar {
        display: none;
    }

    .collection-card {
        flex: 0 0 140px;
        background: #fff;
        border-radius: 16px;
        padding: 16px;
        text-align: center;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(42, 108, 246, 0.06);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .collection-card:active {
        transform: scale(0.98);
    }

    .collection-icon {
        font-size: 32px;
        margin-bottom: 8px;
    }

    .collection-name {
        font-size: 12px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .collection-count {
        font-size: 11px;
        color: #64748b;
    }

    /* Filter Tabs */
    .filter-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        overflow-x: auto;
        padding-bottom: 4px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .filter-tabs::-webkit-scrollbar {
        display: none;
    }

    .filter-tab {
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

    .filter-tab.active {
        background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
        border-color: transparent;
        color: #fff;
    }

    /* Search Bar */
    .search-bar {
        position: relative;
        margin-bottom: 20px;
    }

    .search-bar input {
        width: 100%;
        padding: 14px 14px 14px 44px;
        background: #fff;
        border: 1px solid rgba(42, 108, 246, 0.1);
        border-radius: 14px;
        font-size: 14px;
        color: #1e293b;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .search-bar input::placeholder {
        color: #94a3b8;
    }

    .search-bar input:focus {
        outline: none;
        border-color: #2A6CF6;
    }

    .search-bar svg {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    /* NFT Grid */
    .nft-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 24px;
    }

    .nft-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(42, 108, 246, 0.06);
        transition: transform 0.2s ease;
    }

    .nft-card:active {
        transform: scale(0.98);
    }

    .nft-card.owned {
        border: 2px solid rgba(34, 197, 94, 0.3);
    }

    .nft-card.other-user {
        border: 2px solid rgba(168, 85, 247, 0.3);
    }

    .nft-card-image {
        position: relative;
        aspect-ratio: 1;
        overflow: hidden;
        padding: 6px;
    }

    .nft-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px;
    }

    .nft-rarity {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .nft-rarity.legendary {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: #fff;
    }

    .nft-rarity.epic {
        background: linear-gradient(135deg, #a855f7, #8b5cf6);
        color: #fff;
    }

    .nft-rarity.rare {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #fff;
    }

    .nft-rarity.common {
        background: #e2e8f0;
        color: #64748b;
    }

    .nft-owned-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 8px;
        background: rgba(34, 197, 94, 0.9);
        border-radius: 6px;
        font-size: 9px;
        font-weight: 700;
        color: #fff;
    }

    .nft-owner-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 8px;
        background: rgba(168, 85, 247, 0.9);
        border-radius: 6px;
        font-size: 9px;
        font-weight: 700;
        color: #fff;
        max-width: 70px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .nft-card-owner {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        color: #64748b;
        margin-bottom: 6px;
    }

    .nft-card-owner svg {
        color: #a855f7;
    }

    .nft-card-owner strong {
        color: #1e293b;
        font-weight: 600;
    }

    .nft-card-btn.view {
        background: linear-gradient(135deg, #a855f7, #8b5cf6);
        color: #fff;
    }

    .nft-card-info {
        padding: 12px;
    }

    .nft-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .nft-card-name {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: 1;
    }

    .nft-card-id {
        font-size: 10px;
        color: #94a3b8;
        font-weight: 500;
    }

    .nft-card-price {
        display: flex;
        flex-direction: column;
        gap: 2px;
        margin-bottom: 10px;
    }

    .price-label {
        font-size: 10px;
        color: #94a3b8;
    }

    .price-value {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
    }

    .price-value small {
        font-size: 10px;
        color: #94a3b8;
        font-weight: 500;
    }

    .nft-card-profit {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .nft-card-profit.up {
        color: #22c55e;
    }

    .nft-card-profit.down {
        color: #ef4444;
    }

    .nft-card-btn {
        display: block;
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .nft-card-btn.buy {
        background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
        color: #fff;
    }

    .nft-card-btn.sell {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: #fff;
    }

    .nft-card-btn:active {
        transform: scale(0.98);
    }

    /* Empty State */
    .empty-state {
        grid-column: 1 / -1;
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

    .empty-icon {
        font-size: 48px;
        margin-bottom: 16px;
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
</style>
@endpush

@section('content')
<div class="collection-wrapper">
    <!-- Page Header -->
    @include('partials.header', ['title' => 'Collection'])

    <!-- Portfolio Summary -->
    <div class="portfolio-card">
        <div class="portfolio-card-bg"></div>
        <div class="portfolio-card-content">
            <div class="portfolio-title">My Portfolio Value</div>
            <div class="portfolio-value">
                {{ number_format($totalValue ?? 0, 2) }} <small>USDT</small>
            </div>
            <div class="portfolio-stats">
                <div class="portfolio-stat">
                    <span class="portfolio-stat-value">{{ $totalNfts ?? 0 }}</span>
                    <span class="portfolio-stat-label">NFTs Owned</span>
                </div>
                <div class="portfolio-stat">
                    <span class="portfolio-stat-value {{ ($totalProfit ?? 0) >= 0 ? 'profit' : 'loss' }}">
                        {{ ($totalProfit ?? 0) >= 0 ? '+' : '' }}{{ number_format($totalProfit ?? 0, 2) }}
                    </span>
                    <span class="portfolio-stat-label">Total P/L</span>
                </div>
                <div class="portfolio-stat">
                    <span class="portfolio-stat-value">{{ count($availableNfts ?? []) + count($otherUsersNfts ?? []) }}</span>
                    <span class="portfolio-stat-label">Market</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Collections -->
    <div class="section-header">
        <h2 class="section-title">🔥 Popular Collections</h2>
    </div>
    <div class="collections-scroll">
        @foreach($popularCollections ?? [] as $collection)
        <div class="collection-card" data-rarity="{{ $collection['rarity'] }}">
            <div class="collection-icon">{{ $collection['icon'] }}</div>
            <div class="collection-name">{{ $collection['name'] }}</div>
            <div class="collection-count">{{ $collection['count'] }} NFTs</div>
        </div>
        @endforeach
    </div>

    <!-- Search Bar -->
    <div class="search-bar">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.35-4.35"/>
        </svg>
        <input type="text" id="nftSearch" placeholder="Search NFTs...">
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <button class="filter-tab active" data-filter="all">🎨 All NFTs</button>
        <button class="filter-tab" data-filter="owned">✅ My NFTs</button>
        <button class="filter-tab" data-filter="available">🛒 Available</button>
        <button class="filter-tab" data-filter="others">👥 Others</button>
        <button class="filter-tab" data-filter="Legendary">👑 Legendary</button>
        <button class="filter-tab" data-filter="Epic">🎯 Epic</button>
        <button class="filter-tab" data-filter="Rare">💎 Rare</button>
        <button class="filter-tab" data-filter="Common">⭐ Common</button>
    </div>

    <!-- NFT Grid - My Owned NFTs -->
    <div class="section-header">
        <h2 class="section-title">📦 All NFTs</h2>
    </div>
    <div class="nft-grid" id="nftGrid">
        @php
            $userId = Auth::id();
            $adminIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        @endphp

        {{-- Show Owned NFTs First --}}
        @foreach($ownedNfts ?? [] as $nft)
        @php
            $profit = ($nft->value ?? 0) - ($nft->purchase_price ?? $nft->price ?? 0);
            $profitPercent = ($nft->purchase_price ?? $nft->price ?? 0) > 0 
                ? (($profit / ($nft->purchase_price ?? $nft->price)) * 100) 
                : 0;
        @endphp
        <div class="nft-card owned" 
             data-ownership="owned" 
             data-rarity="{{ $nft->rarity }}" 
             data-name="{{ strtolower($nft->name) }}">
            <div class="nft-card-image">
                <img src="{{ $nft->image }}" alt="{{ $nft->name }}">
                <span class="nft-rarity {{ strtolower($nft->rarity) }}">{{ $nft->rarity }}</span>
                <span class="nft-owned-badge">Owned</span>
            </div>
            <div class="nft-card-info">
                <div class="nft-card-header">
                    <h3 class="nft-card-name">{{ $nft->name }}</h3>
                    <span class="nft-card-id">#{{ $nft->id }}</span>
                </div>
                <div class="nft-card-price">
                    <span class="price-label">Current Value</span>
                    <span class="price-value">{{ number_format($nft->value ?? 0, 2) }} <small>USDT</small></span>
                </div>
                <div class="nft-card-profit {{ $profit >= 0 ? 'up' : 'down' }}">
                    @if($profit >= 0)
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 15l-6-6-6 6"/>
                    </svg>
                    @else
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                    @endif
                    {{ $profit >= 0 ? '+' : '' }}{{ number_format($profitPercent, 1) }}% ({{ $profit >= 0 ? '+' : '' }}{{ number_format($profit, 2) }} USDT)
                </div>
                <a href="{{ url('/auction/create/' . $nft->id) }}" class="nft-card-btn sell">Sell / Auction</a>
            </div>
        </div>
        @endforeach

        {{-- Show Available NFTs --}}
        @foreach($availableNfts ?? [] as $nft)
        @php
            $profit = ($nft->value ?? 0) - ($nft->price ?? 0);
            $profitPercent = ($nft->price ?? 0) > 0 ? (($profit / $nft->price) * 100) : 0;
        @endphp
        <div class="nft-card" 
             data-ownership="available" 
             data-rarity="{{ $nft->rarity }}" 
             data-name="{{ strtolower($nft->name) }}">
            <div class="nft-card-image">
                <img src="{{ $nft->image }}" alt="{{ $nft->name }}">
                <span class="nft-rarity {{ strtolower($nft->rarity) }}">{{ $nft->rarity }}</span>
            </div>
            <div class="nft-card-info">
                <div class="nft-card-header">
                    <h3 class="nft-card-name">{{ $nft->name }}</h3>
                    <span class="nft-card-id">#{{ $nft->id }}</span>
                </div>
                <div class="nft-card-price">
                    <span class="price-label">Price</span>
                    <span class="price-value">{{ number_format($nft->price ?? 0, 2) }} <small>USDT</small></span>
                </div>
                <div class="nft-card-profit {{ $profitPercent >= 0 ? 'up' : 'down' }}">
                    @if($profitPercent >= 0)
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 15l-6-6-6 6"/>
                    </svg>
                    @else
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                    @endif
                    {{ $profitPercent >= 0 ? '+' : '' }}{{ number_format($profitPercent, 1) }}%
                </div>
                <a href="{{ route('nft.purchase', $nft->id) }}" class="nft-card-btn buy">Buy Now</a>
            </div>
        </div>
        @endforeach

        {{-- Show Other Users' NFTs --}}
        @foreach($otherUsersNfts ?? [] as $nft)
        @php
            $profit = ($nft->value ?? 0) - ($nft->price ?? 0);
            $profitPercent = ($nft->price ?? 0) > 0 ? (($profit / $nft->price) * 100) : 0;
        @endphp
        <div class="nft-card other-user" 
             data-ownership="others" 
             data-rarity="{{ $nft->rarity }}" 
             data-name="{{ strtolower($nft->name) }}">
            <div class="nft-card-image">
                <img src="{{ $nft->image }}" alt="{{ $nft->name }}">
                <span class="nft-rarity {{ strtolower($nft->rarity) }}">{{ $nft->rarity }}</span>
                <span class="nft-owner-badge">{{ $nft->owner_name ?? 'User' }}</span>
            </div>
            <div class="nft-card-info">
                <div class="nft-card-header">
                    <h3 class="nft-card-name">{{ $nft->name }}</h3>
                    <span class="nft-card-id">#{{ $nft->id }}</span>
                </div>
                <div class="nft-card-owner">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    Owned by <strong>{{ $nft->owner_name ?? 'User' }}</strong>
                </div>
                <div class="nft-card-price">
                    <span class="price-label">Value</span>
                    <span class="price-value">{{ number_format($nft->value ?? $nft->price ?? 0, 2) }} <small>USDT</small></span>
                </div>
                <a href="{{ url('/nft/' . $nft->id) }}" class="nft-card-btn view">View Details</a>
            </div>
        </div>
        @endforeach

        @if(count($ownedNfts ?? []) == 0 && count($availableNfts ?? []) == 0 && count($otherUsersNfts ?? []) == 0)
        <div class="empty-state">
            <div class="empty-icon">🎨</div>
            <h3>No NFTs Available</h3>
            <p>Check back later for new listings</p>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.filter-tab');
    const cards = document.querySelectorAll('.nft-card');
    const collectionCards = document.querySelectorAll('.collection-card');
    const searchInput = document.getElementById('nftSearch');

    // Filter tabs
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            filterCards(filter, searchInput.value.toLowerCase());
        });
    });

    // Collection cards click
    collectionCards.forEach(card => {
        card.addEventListener('click', function() {
            const rarity = this.dataset.rarity;
            // Find and click the matching tab
            tabs.forEach(tab => {
                if (tab.dataset.filter === rarity) {
                    tab.click();
                }
            });
        });
    });

    // Search functionality
    searchInput.addEventListener('input', function() {
        const activeTab = document.querySelector('.filter-tab.active');
        const filter = activeTab ? activeTab.dataset.filter : 'all';
        filterCards(filter, this.value.toLowerCase());
    });

    function filterCards(filter, searchQuery) {
        cards.forEach(card => {
            const ownership = card.dataset.ownership;
            const rarity = card.dataset.rarity;
            const name = card.dataset.name || '';

            let showByFilter = false;
            
            if (filter === 'all') {
                showByFilter = true;
            } else if (filter === 'owned') {
                showByFilter = ownership === 'owned';
            } else if (filter === 'available') {
                showByFilter = ownership === 'available';
            } else if (filter === 'others') {
                showByFilter = ownership === 'others';
            } else {
                // Rarity filter
                showByFilter = rarity === filter;
            }

            const showBySearch = !searchQuery || name.includes(searchQuery);

            card.style.display = (showByFilter && showBySearch) ? 'block' : 'none';
        });
    }
});
</script>
@endsection
