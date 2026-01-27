@extends('layouts.app')

@push('styles')
<style>
    .nft-detail-container {
        max-width: 430px;
        margin: 0 auto;
        background: #f8fafc;
        min-height: 100vh;
        padding-bottom: 80px;
    }

    .nft-hero-section {
        position: relative;
        height: 400px;
        overflow: hidden;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .nft-hero-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .nft-back-btn {
        position: absolute;
        top: 16px;
        left: 16px;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-decoration: none;
        z-index: 10;
    }

    .nft-info-card {
        background: #fff;
        border-radius: 24px 24px 0 0;
        margin-top: -30px;
        position: relative;
        padding: 20px 16px;
    }

    .nft-title {
        font-size: 24px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .nft-id-badge {
        display: inline-block;
        background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
        color: #fff;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .nft-owner-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 16px;
    }

    .owner-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .owner-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 700;
    }

    .owner-name {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }

    .owner-label {
        font-size: 11px;
        color: #64748b;
    }

    .price-main-card {
        background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 16px;
        color: #fff;
    }

    .price-label {
        font-size: 13px;
        opacity: 0.9;
        margin-bottom: 4px;
    }

    .price-value {
        font-size: 32px;
        font-weight: 800;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin-bottom: 16px;
    }

    .stat-card {
        padding: 12px 8px;
        text-align: center;
    }

    .stat-label {
        font-size: 11px;
        color: #64748b;
        margin-bottom: 4px;
        font-weight: 500;
    }

    .stat-value {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }

    .stat-value.positive {
        color: #22c55e;
    }

    .stat-value.negative {
        color: #ef4444;
    }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 12px;
    }

    .bids-list {
        margin-bottom: 16px;
    }

    .bid-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .bid-item:last-child {
        border-bottom: none;
    }

    .bid-user {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: #1e293b;
        font-weight: 500;
    }

    .bid-amount {
        font-size: 14px;
        font-weight: 700;
        color: #2563eb;
    }

    .no-bids-alert {
        background: #f8fafc;
        border-radius: 8px;
        padding: 16px;
        text-align: center;
        color: #64748b;
        font-size: 13px;
        margin-bottom: 16px;
    }

    .no-bids-alert svg {
        color: #94a3b8;
    }

    .sell-btn {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        border: none;
        border-radius: 12px;
        color: #fff;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .sell-btn:hover {
        transform: translateY(-2px);
    }

    .description-text {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    /* Tabs Styles */
    .tabs-container {
        margin-bottom: 16px;
    }

    .tabs-header {
        display: flex;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 16px;
    }

    .tab-btn {
        flex: 1;
        padding: 12px 8px;
        background: transparent;
        border: none;
        border-bottom: 2px solid transparent;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
    }

    .tab-btn.active {
        color: #2563eb;
        border-bottom-color: #2563eb;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .info-grid {
        display: grid;
        gap: 0;
    }

    .info-item {
        padding: 12px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f1f5f9;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
    }

    .info-value {
        font-size: 13px;
        color: #1e293b;
        font-weight: 600;
    }

    .accept-bid-btn {
        padding: 6px 14px;
        background: #22c55e;
        border: none;
        border-radius: 6px;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }

    .accept-bid-btn:hover {
        background: #16a34a;
    }

    .bid-item-with-action {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .bid-item-with-action:last-child {
        border-bottom: none;
    }

    .bid-left {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

</style>
@endpush

@section('content')
<div class="nft-detail-container">
    <!-- Hero Section -->
    <div class="nft-hero-section">
        <img src="{{ $nft->image_url ?? $nft->image }}" alt="{{ $nft->name }}" class="nft-hero-image" />
        <a href="{{ url()->previous() }}" class="nft-back-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M15 19l-7-7 7-7" />
            </svg>
        </a>
    </div>

    <!-- Info Card -->
    <div class="nft-info-card">
        <h1 class="nft-title">{{ $nft->name }}</h1>
        <span class="nft-id-badge">#{{ $nft->id }} - {{ $nft->rarity ?? 'Unique' }}</span>
        
        <p class="description-text">{{ $nft->description ?? 'A unique digital collectible with exclusive ownership rights.' }}</p>

        <!-- Owner Section -->
        <div class="nft-owner-section">
            <div class="owner-info">
                <div class="owner-avatar">{{ substr($nft->user->name, 0, 1) }}</div>
                <div>
                    <div class="owner-label">Owned by</div>
                    <div class="owner-name">{{ $nft->user->name }}</div>
                </div>
            </div>
            <span class="badge bg-light text-secondary">Edition {{ $nft->edition ?? '1' }}</span>
        </div>

        <!-- Current Price -->
        <div class="price-main-card">
            <div class="price-label">Current Price</div>
            <div class="price-value">${{ number_format($nft->current_price ?? $nft->price ?? $nft->purchase_price, 2) }}</div>
        </div>

        <!-- Tabs -->
        <div class="tabs-container">
            <div class="tabs-header">
                <button class="tab-btn active" onclick="switchTab('info')">Info</button>
                <button class="tab-btn" onclick="switchTab('statistics')">Statistics</button>
                <button class="tab-btn" onclick="switchTab('bids')">Bids</button>
            </div>

            <!-- Info Tab -->
            <div id="info-tab" class="tab-content active">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Owner</span>
                        <span class="info-value">{{ $nft->user->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Edition</span>
                        <span class="info-value">{{ $nft->edition ?? '1' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Rarity</span>
                        <span class="info-value">{{ $nft->rarity ?? 'Unique' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Blockchain</span>
                        <span class="info-value">{{ $nft->blockchain ?? 'Ethereum' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Token Standard</span>
                        <span class="info-value">{{ $nft->token_standard ?? 'ERC-721' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Creator Royalty</span>
                        <span class="info-value">{{ $nft->creator_royalty ?? 5 }}%</span>
                    </div>
                </div>
            </div>

            <!-- Statistics Tab -->
            <div id="statistics-tab" class="tab-content">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-label">Highest</div>
                        <div class="stat-value positive">${{ number_format($statistics['highest'], 2) }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Lowest</div>
                        <div class="stat-value negative">${{ number_format($statistics['lowest'], 2) }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Change</div>
                        <div class="stat-value {{ $statistics['change_percent'] >= 0 ? 'positive' : 'negative' }}">{{ $statistics['change_percent'] }}%</div>
                    </div>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Views</span>
                        <span class="info-value">{{ number_format($nft->views ?? 0) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Likes</span>
                        <span class="info-value">{{ number_format($nft->likes_count ?? 0) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Total Trades</span>
                        <span class="info-value">{{ number_format($nft->trades_count ?? 0) }}</span>
                    </div>
                </div>
            </div>

            <!-- Bids Tab -->
            <div id="bids-tab" class="tab-content">
                @if(count($bids) > 0)
                    <div class="bids-list">
                        @foreach($bids as $bid)
                            <div class="bid-item-with-action">
                                <div class="bid-left">
                                    <div class="bid-user">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" style="color: #60a5fa;">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                        {{ $bid->user->name }}
                                    </div>
                                    <div class="bid-amount">${{ number_format($bid->amount, 2) }}</div>
                                </div>
                                @if(auth()->id() === $nft->user_id)
                                    <form action="{{ route('bid.accept', $bid->id) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="accept-bid-btn">Accept</button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-bids-alert">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        No bids placed yet. Be the first to bid!
                    </div>
                @endif
            </div>
        </div>

        <!-- Sell Button (only for owner) -->
        @if(auth()->id() === $nft->user_id)
            <form action="{{ route('nft.sell', $nft->id) }}" method="POST" style="margin-top: 24px;">
                @csrf
                <button type="submit" class="sell-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    List NFT for Sale
                </button>
            </form>
        @endif
    </div>
</div>

<script>
    function switchTab(tabName) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Remove active state from all buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Show selected tab
        document.getElementById(tabName + '-tab').classList.add('active');
        
        // Set active button
        event.target.classList.add('active');
    }
</script>
@endsection
