@extends('layouts.app')

@section('title', $nft['name'] . ' - Purchase')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: #f8fafc;
        min-height: 100vh;
        overflow-x: hidden;
    }

    .purchase-container {
        max-width: 430px;
        margin: 0 auto;
        min-height: 100vh;
        background: #f8fafc;
        position: relative;
        padding-bottom: 80px;
    }

    /* Hero Section with Image */
    .nft-hero {
        position: relative;
        width: 100%;
        height: 345px;
        overflow: hidden;

    }

    .nft-hero-bg {
        position: absolute;
        inset: 0;
        background: url('{{ $nft->image }}') center/cover no-repeat;
        filter: blur(30px) saturate(1.3) brightness(0.9);
        transform: scale(1.3);
    }

    .nft-hero-bg::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.3) 100%);
    }

    .nft-image-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70%;
        max-width: 240px;
        aspect-ratio: 1;
        z-index: 2;
        margin-top: 25px;
    }

    .nft-hero-image {
        width: 100%;
        height: 100%;
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        filter: drop-shadow(0 16px 32px rgba(0, 0, 0, 0.3));
        /* Prevent download/save */
        pointer-events: none;
        user-select: none;
        -webkit-user-select: none;
        -webkit-user-drag: none;
        -webkit-touch-callout: none;
        transition: filter 0.3s ease;
    }

    /* When DevTools is detected */
    .devtools-open .nft-hero-image {
        filter: blur(30px) !important;
    }

    .devtools-open .nft-hero-bg {
        filter: blur(50px) saturate(0.5) brightness(0.5) !important;
    }

    .devtools-warning {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 10;
        background: rgba(0, 0, 0, 0.8);
        color: #fff;
        padding: 16px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        text-align: center;
    }

    .devtools-open .devtools-warning {
        display: block;
    }

    /* Watermark Overlay */
    .watermark-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
        z-index: 3;
    }

    .watermark-text {
        font-size: 18px;
        font-weight: 800;
        color: rgba(255, 255, 255, 0.25);
        text-transform: uppercase;
        letter-spacing: 4px;
        transform: rotate(-25deg);
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        white-space: nowrap;
    }

    /* Transparent protection layer */
    .image-protection {
        position: absolute;
        inset: 0;
        z-index: 4;
        background: transparent;
        cursor: default;
    }

    /* Floating Header */
    .floating-header {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: 10;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
    }

    .btn-back {
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .header-actions {
        display: flex;
        gap: 8px;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-icon.active {
        background: #ef4444;
    }

    .btn-icon svg {
        width: 18px;
        height: 18px;
        color: #fff;
        fill: #fff;
    }

    /* Content Section */
    .nft-content {
        padding: 28px 16px 16px;
    }

    /* Title Row */
    .nft-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 12px;
    }

    .nft-title {
        font-size: 20px;
        font-weight: 800;
        color: #1f2937;
        letter-spacing: -0.02em;
        margin: 0;
        flex: 1;
    }

    .nft-price-inline {
        background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
        color: #fff;
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 700;
        white-space: nowrap;
    }

    /* Description */
    .nft-description {
        font-size: 13px;
        line-height: 1.5;
        color: #6b7280;
        margin-bottom: 6px;
    }

    .read-more {
        color: #2563eb;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
    }

    .read-more:hover {
        text-decoration: underline;
    }

    /* Creator & Collection */
    .nft-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #e5e7eb;
    }

    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .meta-label {
        font-size: 12px;
        color: #9ca3af;
        font-weight: 500;
    }

    .meta-value {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .meta-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .meta-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .meta-name {
        font-size: 13px;
        font-weight: 600;
        color: #1f2937;
    }

    /* Stats Row */
    .nft-stats {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        padding: 16px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    .stat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    .stat-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon svg {
        width: 16px;
        height: 16px;
        color: #2563eb;
    }

    .stat-value {
        font-size: 14px;
        font-weight: 700;
        color: #1f2937;
    }

    .stat-label {
        font-size: 11px;
        color: #9ca3af;
        font-weight: 500;
    }

    /* Properties Section */
    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
        margin: 24px 0 12px;
    }

    .properties-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .property-card {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        padding: 12px 8px;
        text-align: center;
    }

    .property-type {
        font-size: 10px;
        color: #2563eb;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .property-value {
        font-size: 12px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 2px;
    }

    .property-rarity {
        font-size: 10px;
        color: #6b7280;
    }

    /* Info List */
    .info-list {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        margin-top: 12px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 16px;
        border-bottom: 1px solid #f3f4f6;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: #6b7280;
    }

    .info-label svg {
        width: 18px;
        height: 18px;
        color: #9ca3af;
    }

    .info-value {
        font-size: 13px;
        font-weight: 600;
        color: #1f2937;
    }

    .info-value.link {
        color: #2563eb;
        cursor: pointer;
    }

    /* Bottom Action Bar */
    .bottom-bar {
        position: fixed;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        max-width: 430px;
        background: #fff;
        padding: 12px 16px 16px;
        box-shadow: 0 -2px 12px rgba(0, 0, 0, 0.06);
        display: flex;
        gap: 10px;
        z-index: 100;
    }

    .btn-buy {
        flex: 1;
        padding: 14px 20px;
        background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-buy:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
    }

    .btn-bid {
        flex: 1;
        padding: 14px 20px;
        background: #fff;
        color: #2563eb;
        font-size: 15px;
        font-weight: 600;
        border: 2px solid #2563eb;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-bid:hover {
        background: #eff6ff;
    }

    /* Toast Styles */
    .colored-toast.swal2-icon-success {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%) !important;
        color: #fff !important;
    }

    .colored-toast.swal2-icon-error {
        background: linear-gradient(135deg, #ff4e50 0%, #f9d423 100%) !important;
        color: #fff !important;
    }

    /* Hide default layout elements for this page */
    .header,
    .header-spacer,
    .bottom-nav,
    .nav-spacer {
        display: none !important;
    }

    .mobile-container {
        padding: 0;
    }

    .content {
        padding: 0;
    }
</style>
@endpush

@section('content')
<div class="purchase-container">
    <!-- Hero Section -->
    <div class="nft-hero">
        <div class="nft-hero-bg"></div>

        <!-- Floating Header -->
        <div class="floating-header">
            <a href="{{ url()->previous() }}" class="btn-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div class="header-actions">
                <button class="btn-icon {{ $isLiked ? 'active' : '' }}" id="like-btn" data-nft-id="{{ $nft->id }}">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                </button>
                <button class="btn-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <circle cx="12" cy="5" r="2" />
                        <circle cx="12" cy="12" r="2" />
                        <circle cx="12" cy="19" r="2" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- NFT Image with Protection -->
        <div class="nft-image-container">
            <div class="nft-hero-image" style="background-image: url('{{ $nft->image }}');" role="img" aria-label="{{ $nft->name }}"></div>
            <div class="watermark-overlay">
                <span class="watermark-text">VortexNFT</span>
            </div>
            <div class="image-protection" oncontextmenu="return false;"></div>
        </div>
        <div class="devtools-warning">⚠️ Image protected</div>
    </div>

    <!-- Content -->
    <div class="nft-content">
        <!-- Title & Price -->
        <div class="nft-title-row">
            <h1 class="nft-title">{{ strtoupper($nft->name) }}</h1>
            <span class="nft-price-inline">{{ number_format($nft->price ?? $nft->purchase_price ?? 0, 2) }} USDT</span>
        </div>

        <!-- Description -->
        <p class="nft-description">
            {{ Str::limit($nft->description ?? 'A unique digital collectible with rare attributes and exclusive ownership rights on the blockchain.', 100) }}
        </p>
        <a class="read-more">read more</a>

        <!-- Creator & Collection -->
        <div class="nft-meta">
            <div class="meta-item">
                <span class="meta-label">Creator</span>
                <div class="meta-value">
                    <div class="meta-avatar">
                        <img src="/icons/user.svg" alt="Creator">
                    </div>
                    <span class="meta-name">{{ '@' . ($nft->creator ?? 'VortexNFT') }}</span>
                </div>
            </div>
            <div class="meta-item">
                <span class="meta-label">Collection</span>
                <div class="meta-value">
                    <div class="meta-avatar">
                        <img src="/icons/user.svg" alt="Collection">
                    </div>
                    <span class="meta-name">{{ '@' . ($nft->collection ?? 'VortexNFT') }}</span>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="nft-stats">
            <div class="stat-item">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <span class="stat-value">{{ number_format($nft->views ?? 0) }}</span>
                <span class="stat-label">Views</span>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="#ef4444"/>
                    </svg>
                </div>
                <span class="stat-value" id="likes-count">{{ number_format($nft->likes_count ?? 0) }}</span>
                <span class="stat-label">Likes</span>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <span class="stat-value">{{ number_format($nft->offers_count ?? 0) }}</span>
                <span class="stat-label">Offers</span>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
                <span class="stat-value">{{ number_format($nft->trades_count ?? 0) }}</span>
                <span class="stat-label">Trades</span>
            </div>
        </div>

        <!-- Properties -->
        <h3 class="section-title">Properties</h3>
        <div class="properties-grid">
            <div class="property-card">
                <div class="property-type">Background</div>
                <div class="property-value">{{ $nft->background ?? 'Cosmic' }}</div>
                <div class="property-rarity">{{ $nft->getPropertyRarity('background') }}% have this</div>
            </div>
            <div class="property-card">
                <div class="property-type">Rarity</div>
                <div class="property-value">{{ $nft->rarity ?? 'Legendary' }}</div>
                <div class="property-rarity">{{ $nft->getPropertyRarity('rarity') }}% have this</div>
            </div>
            <div class="property-card">
                <div class="property-type">Edition</div>
                <div class="property-value">#{{ $nft->edition ?? $nft->id }}</div>
                <div class="property-rarity">Unique</div>
            </div>
            <div class="property-card">
                <div class="property-type">Type</div>
                <div class="property-value">{{ $nft->type ?? 'Art' }}</div>
                <div class="property-rarity">{{ $nft->getPropertyRarity('type') }}% have this</div>
            </div>
            <div class="property-card">
                <div class="property-type">Style</div>
                <div class="property-value">{{ $nft->style ?? '2D' }}</div>
                <div class="property-rarity">{{ $nft->getPropertyRarity('style') }}% have this</div>
            </div>
            <div class="property-card">
                <div class="property-type">Tier</div>
                <div class="property-value">{{ $nft->tier ?? 'Standard' }}</div>
                <div class="property-rarity">{{ $nft->getPropertyRarity('tier') }}% have this</div>
            </div>
        </div>

        <!-- Details Info -->
        <h3 class="section-title">Details</h3>
        <div class="info-list">
            <div class="info-item">
                <span class="info-label">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    Contract Address
                </span>
                <span class="info-value link">{{ $nft->short_contract_address }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                    </svg>
                    Token ID
                </span>
                <span class="info-value">{{ $nft->id }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Blockchain
                </span>
                <span class="info-value">{{ $nft->blockchain ?? 'Ethereum' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Token Standard
                </span>
                <span class="info-value">{{ $nft->token_standard ?? 'ERC-721' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Creator Royalty
                </span>
                <span class="info-value">{{ $nft->creator_royalty ?? 5 }}%</span>
            </div>
        </div>
    </div>

    <!-- Bottom Action Bar -->
    <div class="bottom-bar">
        <button type="button" class="btn-buy" id="purchase-btn" onclick="confirmPurchase()">Buy now</button>
        <button class="btn-bid" onclick="window.location.href='{{ route('auction.index') }}'">Place a bid</button>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="purchaseModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: flex-end;">
    <div style="width: 100%; background: #fff; border-radius: 20px 20px 0 0; padding: 20px; animation: slideUp 0.3s ease;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0; font-size: 18px; font-weight: 700; color: #1e293b;">Confirm Purchase</h3>
            <button onclick="closePurchaseModal()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #94a3b8;">✕</button>
        </div>

        <div style="background: #f8fafc; border-radius: 12px; padding: 16px; margin-bottom: 20px;">
            <div style="display: flex; gap: 12px;">
                <img src="{{ $nft->image }}" style="width: 80px; height: 80px; border-radius: 8px; object-fit: cover;">
                <div style="flex: 1;">
                    <h4 style="margin: 0 0 4px; color: #1e293b; font-weight: 700;">{{ $nft->name }}</h4>
                    <p style="margin: 4px 0; color: #64748b; font-size: 12px;">#{{ $nft->id }} · {{ $nft->rarity }}</p>
                    <p style="margin: 8px 0 0; color: #2A6CF6; font-weight: 700; font-size: 16px;">{{ number_format($nft->price ?? 0, 2) }} USDT</p>
                </div>
            </div>
        </div>

        <div style="background: #f8fafc; border-radius: 12px; padding: 16px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                <span style="color: #64748b; font-size: 13px;">Your Balance</span>
                <span style="color: #1e293b; font-weight: 700;">{{ number_format(Auth::user()->balance ?? 0, 2) }} USDT</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                <span style="color: #64748b; font-size: 13px;">Purchase Amount</span>
                <span style="color: #ef4444; font-weight: 700;">-{{ number_format($nft->price ?? 0, 2) }} USDT</span>
            </div>
            <div style="border-top: 1px solid #e2e8f0; padding-top: 12px; display: flex; justify-content: space-between; align-items: center;">
                <span style="color: #1e293b; font-weight: 700;">After Purchase</span>
                <span style="color: #22c55e; font-weight: 700; font-size: 16px;">{{ number_format((Auth::user()->balance ?? 0) - ($nft->price ?? 0), 2) }} USDT</span>
            </div>
        </div>

        <p style="font-size: 12px; color: #64748b; margin-bottom: 20px; text-align: center;">
            ✅ A receipt will be sent to <strong>{{ Auth::user()->email }}</strong>
        </p>

        <div style="display: flex; gap: 12px;">
            <button type="button" onclick="closePurchaseModal()" style="flex: 1; padding: 14px; border: 1px solid #e2e8f0; background: #fff; border-radius: 10px; font-weight: 600; color: #64748b; cursor: pointer;">Cancel</button>
            <form id="purchaseForm" action="{{ route('nft.buy', $nft->id) }}" method="POST" style="flex: 1;">
                @csrf
                <button type="submit" style="width: 100%; padding: 14px; background: linear-gradient(135deg, #2A6CF6, #3B8CFF); border: none; border-radius: 10px; color: #fff; font-weight: 600; cursor: pointer; font-size: 14px;">Confirm & Purchase</button>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes slideUp {
        from {
            transform: translateY(100%);
        }
        to {
            transform: translateY(0);
        }
    }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'center',
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast'
        },
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    });
    @if(session('error'))
    Toast.fire({
        icon: 'error',
        title: @json(session('error'))
    });
    @endif
    @if(session('success'))
    Toast.fire({
        icon: 'success',
        title: @json(session('success'))
    });
    setTimeout(function() {
        window.location.href = "{{ route('collection') }}";
    }, 1600);
    @endif

    // Tab switching
    document.querySelectorAll('.nft-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.nft-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // ===== IMAGE PROTECTION =====
    
    // Disable right-click on entire page
    document.addEventListener('contextmenu', e => e.preventDefault());
    
    // Block keyboard shortcuts for DevTools and save
    document.addEventListener('keydown', function(e) {
        // F12
        if (e.key === 'F12') {
            e.preventDefault();
            return false;
        }
        // Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+Shift+C (DevTools)
        if (e.ctrlKey && e.shiftKey && ['I', 'J', 'C'].includes(e.key.toUpperCase())) {
            e.preventDefault();
            return false;
        }
        // Ctrl+U (View Source)
        if (e.ctrlKey && e.key.toUpperCase() === 'U') {
            e.preventDefault();
            return false;
        }
        // Ctrl+S (Save)
        if (e.ctrlKey && e.key.toUpperCase() === 'S') {
            e.preventDefault();
            return false;
        }
    });

    // DevTools detection
    const detectDevTools = () => {
        const widthThreshold = window.outerWidth - window.innerWidth > 160;
        const heightThreshold = window.outerHeight - window.innerHeight > 160;
        const isOpen = widthThreshold || heightThreshold;
        
        if (isOpen) {
            document.body.classList.add('devtools-open');
        } else {
            document.body.classList.remove('devtools-open');
        }
    };
    
    // Check on resize (when DevTools opens/closes)
    window.addEventListener('resize', detectDevTools);
    setInterval(detectDevTools, 1000);
    detectDevTools();

    // Disable drag on all images
    document.querySelectorAll('img').forEach(img => {
        img.setAttribute('draggable', 'false');
        img.addEventListener('dragstart', e => e.preventDefault());
    });

    // Purchase Modal Functions
    function confirmPurchase() {
        const modal = document.getElementById('purchaseModal');
        modal.style.display = 'flex';
    }

    function closePurchaseModal() {
        const modal = document.getElementById('purchaseModal');
        modal.style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Close modal when clicking outside
        document.getElementById('purchaseModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePurchaseModal();
            }
        });
    });

    // Prevent default form submission and use fetch instead
    document.getElementById('purchaseForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';
        
        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                _token: document.querySelector('input[name="_token"]').value
            })
        })
        .then(() => {
            submitBtn.textContent = 'Purchase Complete! ✓';
            setTimeout(() => {
                window.location.href = "{{ route('collection') }}";
            }, 1500);
        })
        .catch(error => {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Confirm & Purchase';
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });
    });

    // Like button functionality
    const likeBtn = document.getElementById('like-btn');
    if (likeBtn) {
        likeBtn.addEventListener('click', async function() {
            const nftId = this.dataset.nftId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
            
            try {
                const response = await fetch(`/nft/${nftId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(errorData.error || `HTTP error ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    // Toggle active class
                    if (data.liked) {
                        this.classList.add('active');
                    } else {
                        this.classList.remove('active');
                    }
                    
                    // Update likes count in stats
                    const likesCountEl = document.getElementById('likes-count');
                    if (likesCountEl) {
                        likesCountEl.textContent = data.likes_count.toLocaleString();
                    }
                } else if (data.error) {
                    Toast.fire({
                        icon: 'error',
                        title: data.error
                    });
                }
            } catch (error) {
                console.error('Error toggling like:', error);
                Toast.fire({
                    icon: 'error',
                    title: error.message || 'Failed to update like'
                });
            }
        });
    }
</script>
@endpush