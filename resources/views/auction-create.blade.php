@extends('layouts.app')

@section('content')
<div class="auction-create-wrapper">
    <!-- Page Header -->
    <div class="auction-header">
        <a href="{{ route('collection') }}" class="back-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="page-title">Create Auction</h1>
        <div class="spacer"></div>
    </div>

    <!-- NFT Preview Card -->
    <div class="nft-preview-card">
        <div class="preview-image-container">
            <img src="{{ $nft->image }}" alt="{{ $nft->name }}" class="preview-image">
            <div class="preview-overlay">
                <span class="nft-badge">Ready to Sell</span>
            </div>
        </div>
        <div class="preview-info">
            <div class="info-row">
                <h2 class="nft-name">{{ $nft->name }}</h2>
                <span class="nft-id">#{{ $nft->id }}</span>
            </div>
            @if($nft->description)
            <p class="nft-description">{{ $nft->description }}</p>
            @endif
        </div>
    </div>

    <!-- Price Info Card -->
    <div class="price-info-card">
        <div class="price-info-header">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 16v-4M12 8h.01"/>
            </svg>
            <span>Pricing Information</span>
        </div>
        <div class="price-details">
            <div class="price-item">
                <span class="price-label">Purchase Price</span>
                <span class="price-value">{{ number_format($nft->purchase_price, 2) }} <small>USDT</small></span>
            </div>
            @php
                $minSell = $nft->purchase_price * 1.001;
                $maxSell = $nft->purchase_price * 1.005;
                $profit = $minSell - $nft->purchase_price;
                $profitPercent = ($profit / $nft->purchase_price) * 100;
            @endphp
            <div class="price-divider"></div>
            <div class="price-item">
                <span class="price-label">Auction Price</span>
                <span class="price-value highlight">{{ number_format($minSell, 2) }} <small>USDT</small></span>
            </div>
            <div class="price-divider"></div>
            <div class="price-item">
                <span class="price-label">Expected Profit</span>
                <span class="price-value profit">+{{ number_format($profit, 2) }} <small>USDT</small></span>
            </div>
        </div>
        <div class="profit-badge">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M12 19V5M5 12l7-7 7 7"/>
            </svg>
            <span>+{{ number_format($profitPercent, 2) }}% Profit Margin</span>
        </div>
    </div>

    <!-- Auction Details Card -->
    <div class="auction-details-card">
        <h3 class="section-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
            Auction Duration
        </h3>
        <div class="duration-info">
            <div class="duration-item">
                <div class="duration-icon">⏱️</div>
                <div class="duration-text">
                    <span class="duration-value">2 Hours</span>
                    <span class="duration-label">Auto-sell duration</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Important Notice -->
    <div class="notice-card">
        <div class="notice-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        <div class="notice-content">
            <h4 class="notice-title">Important Information</h4>
            <p class="notice-text">Your NFT will be sold by the company. Both profit and capital will be credited to your account after 2 hours of auction completion.</p>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('auction.store') }}" method="POST" id="auctionForm">
        @csrf
        <input type="hidden" name="nft_id" value="{{ $nft->id }}">
        <input type="hidden" name="starting_price" value="{{ $minSell }}">
        <input type="hidden" name="duration" value="2">
        
        <button type="submit" class="auction-submit-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <span>Start Auction Now</span>
        </button>
    </form>
</div>

@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.onload = function() {
        Swal.fire({
            icon: 'success',
            title: 'Auction Started!',
            html: '<div style="text-align: center;"><p style="margin-bottom: 8px;">{{ session("success") }}</p><p style="font-size: 13px; color: #64748b;">Both profit and capital will be credited after 2 hours.</p></div>',
            confirmButtonColor: '#22c55e',
            confirmButtonText: 'Go to My NFTs',
            customClass: {
                popup: 'swal2-mobile',
                confirmButton: 'swal-confirm-btn'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route("my-nft") }}';
            }
        });
    };
</script>
@endif

<style>
.auction-create-wrapper {
    padding: 0 16px 100px;
    background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
    min-height: 100vh;
}

.auction-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 0;
    margin-bottom: 20px;
}

.back-btn {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    border-radius: 12px;
    color: #2A6CF6;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    transition: all 0.2s ease;
}

.back-btn:active {
    transform: scale(0.95);
    background: rgba(42, 108, 246, 0.05);
}

.page-title {
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.spacer {
    width: 40px;
}

.nft-preview-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 20px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(42, 108, 246, 0.08);
}

.preview-image-container {
    position: relative;
    aspect-ratio: 1;
    overflow: hidden;
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.preview-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.5) 100%);
    display: flex;
    align-items: flex-end;
    padding: 16px;
}

.nft-badge {
    background: linear-gradient(135deg, #22c55e, #10b981);
    color: #fff;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.preview-info {
    padding: 16px;
}

.info-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 8px;
}

.nft-name {
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    flex: 1;
    min-width: 0;
}

.nft-id {
    font-size: 12px;
    color: #94a3b8;
    font-weight: 500;
    flex-shrink: 0;
}

.nft-description {
    font-size: 13px;
    color: #64748b;
    line-height: 1.5;
    margin: 0;
}

.price-info-card {
    background: #fff;
    border-radius: 16px;
    padding: 18px;
    margin-bottom: 20px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(42, 108, 246, 0.08);
}

.price-info-header {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #2A6CF6;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 16px;
}

.price-details {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 16px;
}

.price-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.price-label {
    font-size: 13px;
    color: #64748b;
    font-weight: 500;
}

.price-value {
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
}

.price-value.highlight {
    color: #2A6CF6;
}

.price-value.profit {
    color: #22c55e;
}

.price-value small {
    font-size: 11px;
    color: #94a3b8;
    font-weight: 500;
}

.price-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
}

.profit-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px;
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(16, 185, 129, 0.1));
    border-radius: 10px;
    color: #22c55e;
    font-size: 13px;
    font-weight: 600;
}

.auction-details-card {
    background: #fff;
    border-radius: 16px;
    padding: 18px;
    margin-bottom: 20px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(42, 108, 246, 0.08);
}

.section-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 15px;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 14px 0;
}

.duration-info {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.duration-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: #f8fafc;
    border-radius: 10px;
}

.duration-icon {
    font-size: 28px;
    flex-shrink: 0;
}

.duration-text {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.duration-value {
    font-size: 15px;
    font-weight: 700;
    color: #1e293b;
}

.duration-label {
    font-size: 12px;
    color: #64748b;
}

.notice-card {
    display: flex;
    gap: 12px;
    padding: 16px;
    background: linear-gradient(135deg, rgba(251, 191, 36, 0.1), rgba(245, 158, 11, 0.1));
    border-radius: 12px;
    border-left: 4px solid #fbbf24;
    margin-bottom: 24px;
}

.notice-icon {
    flex-shrink: 0;
    color: #fbbf24;
}

.notice-content {
    flex: 1;
}

.notice-title {
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 6px 0;
}

.notice-text {
    font-size: 13px;
    color: #64748b;
    line-height: 1.5;
    margin: 0;
}

.auction-submit-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 16px;
    background: linear-gradient(135deg, #22c55e, #10b981);
    border: none;
    border-radius: 12px;
    color: #fff;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 16px rgba(34, 197, 94, 0.25);
    position: relative;
    overflow: hidden;
}

.auction-submit-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.auction-submit-btn:hover::before {
    left: 100%;
}

.auction-submit-btn:active {
    transform: scale(0.98);
    box-shadow: 0 2px 8px rgba(34, 197, 94, 0.2);
}

.swal2-mobile {
    border-radius: 16px !important;
    padding: 24px !important;
}

.swal-confirm-btn {
    border-radius: 10px !important;
    padding: 12px 24px !important;
    font-weight: 600 !important;
}
</style>
@endsection