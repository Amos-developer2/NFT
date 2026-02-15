@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="/collection.css">
@endpush

@section('title', 'NFT Collection')

@section('content')
<div class="collection-wrapper">
    <!-- Page Header -->
    @include('partials.header', ['title' => 'NFT Collection'])
    <!-- Portfolio Summary Card -->
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
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.35-4.35" />
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

    <!-- NFT Grid -->
    <div class="section-header">
        <h2 class="section-title">📦 All NFTs</h2>
    </div>
    <div class="nft-grid" id="nftGrid">
        @foreach($ownedNfts ?? [] as $nft)
        <div class="nft-scroll-card owned-card" data-ownership="owned" data-rarity="{{ $nft->rarity }}" data-name="{{ strtolower($nft->name) }}">
            <div class="scroll-card-image">
                <img src="{{ $nft->image }}" alt="{{ $nft->name }}">
                <span class="rarity-tag {{ strtolower($nft->rarity) }}">{{ $nft->rarity }}</span>
                @php
                $profitPercent = ($nft->purchase_price ?? $nft->price ?? 0) > 0
                ? (($nft->value - ($nft->purchase_price ?? $nft->price)) / ($nft->purchase_price ?? $nft->price)) * 100
                : 0;
                @endphp
                <span class="profit-tag {{ $profitPercent >= 0 ? 'up' : 'down' }}">
                    {{ $profitPercent >= 0 ? '+' : '' }}{{ number_format($profitPercent, 0) }}%
                </span>
                <span class="owned-badge">Owned</span>
            </div>
            <div class="scroll-card-info">
                <div class="card-info-row">
                    <h3 class="card-name">{{ $nft->name }}</h3>
                    <span class="card-id">#{{ $nft->id }}</span>
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
        {{-- Show Available NFTs --}}
        @foreach($availableNfts ?? [] as $nft)
        <div class="nft-scroll-card" data-ownership="available" data-rarity="{{ $nft->rarity }}" data-name="{{ strtolower($nft->name) }}">
            <div class="scroll-card-image">
                <img src="{{ $nft->image }}" alt="{{ $nft->name }}">
                <span class="rarity-tag {{ strtolower($nft->rarity) }}">{{ $nft->rarity }}</span>
                @php
                $profitPercent = ($nft->price ?? 0) > 0 ? (($nft->value - $nft->price) / $nft->price) * 100 : 0;
                @endphp
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
        <div class="nft-scroll-card other-user-card" data-ownership="others" data-rarity="{{ $nft->rarity }}" data-name="{{ strtolower($nft->name) }}">
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
                <div class="card-owner">👤 Owned by <strong>{{ $nft->owner_name ?? 'User' }}</strong></div>
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
@endsection

@push('scripts')
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
@endpush