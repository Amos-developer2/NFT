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

    /* NFT Grid - Match Home Page Style */
    .nft-grid {
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        margin-bottom: 24px;
        margin: 0!important;
        gap: 10px!important;
    }

    .nft-grid::-webkit-scrollbar {
        display: none;
    }

    .nft-scroll-card {
        flex: 0 0 calc(100% - 6px);
        min-width: calc(100% - 6px);
        max-width: calc(100% - 6px);
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(42, 108, 246, 0.08);
        scroll-snap-align: start;
        transition: transform 0.2s ease;
        position: relative;
    }

    .nft-scroll-card:active {
        transform: scale(0.98);
    }

    .nft-scroll-card.owned-card {
        border: 2px solid rgba(34, 197, 94, 0.3);
    }

    .nft-scroll-card.other-user-card {
        border: 2px solid rgba(168, 85, 247, 0.25);
    }

    .scroll-card-image {
        position: relative;
        aspect-ratio: 1;
        overflow: hidden;
        padding: 6px;
    }

    .scroll-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }

    .scroll-card-image .rarity-tag {
        position: absolute;
        top: 10px;
        left: 10px;
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

    .scroll-card-image .profit-tag {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 8px;
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

    .owned-badge {
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

    .owner-badge {
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

    .scroll-card-info {
        padding: 12px;
    }

    .card-info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .card-info-row:first-child {
        margin-bottom: 8px;
    }

    .card-name {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: 1;
        min-width: 0;
    }

    .card-id {
        font-size: 10px;
        color: #94a3b8;
        font-weight: 500;
        flex-shrink: 0;
    }

    .card-price {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .price-label {
        font-size: 10px;
        color: #94a3b8;
        font-weight: 500;
    }

    .price-value {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
    }

    .price-value small {
        font-size: 10px;
        color: #94a3b8;
        font-weight: 500;
    }

    .card-owner {
        font-size: 10px;
        color: #64748b;
        margin-bottom: 6px;
    }

    .card-owner strong {
        color: #a855f7;
        font-weight: 600;
    }

    .card-buy-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 16px;
        background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
        border: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        color: #fff;
        text-decoration: none;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .card-buy-btn:active {
        transform: scale(0.95);
        background: linear-gradient(135deg, #1d5ed9, #2a7cf6);
    }

    .card-buy-btn.sell-btn {
        background: linear-gradient(135deg, #22c55e, #16a34a);
    }

    .card-buy-btn.sell-btn:active {
        background: linear-gradient(135deg, #16a34a, #15803d);
    }

    .marketplace-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        color: #fff;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        animation: marketplacePulse 2s ease-in-out infinite;
    }

    @keyframes marketplacePulse {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(139, 92, 246, 0.4);
        }
        50% {
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0);
        }
    }

    .card-status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 16px;
        background: rgba(139, 92, 246, 0.1);
        border: 1px solid rgba(139, 92, 246, 0.3);
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        color: #8b5cf6;
        text-decoration: none;
        flex-shrink: 0;
    }

    .card-buy-btn.view-btn {
        background: linear-gradient(135deg, #a855f7, #8b5cf6);
    }

    .card-buy-btn.view-btn:active {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
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

    <!-- Error Display -->
    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof nativeAlert === 'function') {
                nativeAlert(@json(session('error')), { 
                    type: 'warning', 
                    title: 'Notice' 
                });
            }
        });
    </script>
    @endif

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
            $hasActiveAuction = $nft->auctions()->where('status', 'Live')->exists();
        @endphp
        <div class="nft-scroll-card owned-card" 
             data-ownership="owned" 
             data-rarity="{{ $nft->rarity }}" 
             data-name="{{ strtolower($nft->name) }}">
            <div class="scroll-card-image">
                <img src="{{ $nft->image }}" alt="{{ $nft->name }}">
                <span class="rarity-tag {{ strtolower($nft->rarity) }}">{{ $nft->rarity }}</span>
                @if($hasActiveAuction)
                    <span class="marketplace-badge">In Marketplace</span>
                @else
                    <span class="owned-badge">Owned</span>
                @endif
            </div>
            <div class="scroll-card-info">
                <div class="card-info-row">
                    <h3 class="card-name">{{ $nft->name }}</h3>
                    <span class="card-id">#{{ $nft->id }}</span>
                </div>
                <div class="card-info-row">
                    <div class="card-price">
                        <span class="price-label">Value</span>
                        <span class="price-value">{{ number_format($nft->value ?? 0, 2) }} <small>USDT</small></span>
                    </div>
                    @if($hasActiveAuction)
                        <span class="card-status-badge">Listed</span>
                    @else
                        <a href="{{ url('/auction/create/' . $nft->id) }}" class="card-buy-btn sell-btn">Sell</a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

        {{-- Show Available NFTs --}}
        @foreach($availableNfts ?? [] as $nft)
        @php
            $profit = ($nft->value ?? 0) - ($nft->price ?? 0);
            $profitPercent = ($nft->price ?? 0) > 0 ? (($profit / $nft->price) * 100) : 0;
        @endphp
        <div class="nft-scroll-card" 
             data-ownership="available" 
             data-rarity="{{ $nft->rarity }}" 
             data-name="{{ strtolower($nft->name) }}">
            <div class="scroll-card-image">
                <img src="{{ $nft->image }}" alt="{{ $nft->name }}">
                <span class="rarity-tag {{ strtolower($nft->rarity) }}">{{ $nft->rarity }}</span>
                <span class="profit-tag {{ $profitPercent >= 0 ? 'up' : 'down' }}">
                    {{ $profitPercent >= 0 ? '+' : '' }}{{ number_format($profitPercent, 0) }}%
                </span>
            </div>
            <div class="scroll-card-info">
                <div class="card-info-row">
                    <h3 class="card-name">{{ $nft->name }}</h3>
                    <span class="card-id">#{{ $nft->id }}</span>
                </div>
                <div class="card-info-row">
                    <div class="card-price">
                        <span class="price-label">Price</span>
                        <span class="price-value">{{ number_format($nft->price ?? 0, 2) }} <small>USDT</small></span>
                    </div>
                    <a href="{{ route('nft.purchase', $nft->id) }}" class="card-buy-btn">Buy</a>
                </div>
            </div>
        </div>
        @endforeach

        {{-- Show Other Users' NFTs --}}
        @foreach($otherUsersNfts ?? [] as $nft)
        <div class="nft-scroll-card other-user-card" 
             data-ownership="others" 
             data-rarity="{{ $nft->rarity }}" 
             data-name="{{ strtolower($nft->name) }}">
            <div class="scroll-card-image">
                <img src="{{ $nft->image }}" alt="{{ $nft->name }}">
                <span class="rarity-tag {{ strtolower($nft->rarity) }}">{{ $nft->rarity }}</span>
                <span class="owner-badge">{{ $nft->owner_name ?? 'User' }}</span>
            </div>
            <div class="scroll-card-info">
                <div class="card-info-row">
                    <h3 class="card-name">{{ $nft->name }}</h3>
                    <span class="card-id">#{{ $nft->id }}</span>
                </div>
                <div class="card-owner">
                    👤 Owned by <strong>{{ $nft->owner_name ?? 'User' }}</strong>
                </div>
                <div class="card-info-row">
                    <div class="card-price">
                        <span class="price-label">Value</span>
                        <span class="price-value">{{ number_format($nft->value ?? $nft->price ?? 0, 2) }} <small>USDT</small></span>
                    </div>
                    <a href="{{ url('/nft/' . $nft->id) }}" class="card-buy-btn view-btn">View</a>
                </div>
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
    const cards = document.querySelectorAll('.nft-scroll-card');
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
