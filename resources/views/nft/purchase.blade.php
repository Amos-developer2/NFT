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
            background: #fff;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .purchase-container {
            max-width: 430px;
            margin: 0 auto;
            min-height: 100vh;
            background: #fff;
            position: relative;
            padding-bottom: 100px;
        }

        /* Hero Section with Image */
        .nft-hero {
            position: relative;
            width: 100%;
            height: 420px;
            overflow: hidden;
        }
        .nft-hero-bg {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, #e8b4c8 0%, #b8c4e8 50%, #d4c4f0 100%);
        }
        .nft-hero-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('{{ $nft['image'] }}') center/cover no-repeat;
            filter: blur(40px) saturate(1.2);
            opacity: 0.6;
            transform: scale(1.2);
        }
        .nft-hero-image {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 85%;
            max-width: 320px;
            aspect-ratio: 1;
            object-fit: contain;
            z-index: 2;
            filter: drop-shadow(0 20px 40px rgba(0,0,0,0.3));
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
            padding: 16px 20px;
        }
        .btn-back {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.2);
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
            background: rgba(255,255,255,0.3);
        }
        .header-actions {
            display: flex;
            gap: 10px;
        }
        .btn-icon {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.2);
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
            background: #ff4757;
        }
        .btn-icon svg {
            width: 20px;
            height: 20px;
            color: #fff;
            fill: #fff;
        }

        /* Price Badge */
        .price-badge {
            position: absolute;
            bottom: -20px;
            right: 24px;
            background: #fff;
            border-radius: 16px;
            padding: 12px 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            z-index: 5;
        }
        .price-badge-label {
            font-size: 12px;
            color: #9ca3af;
            margin-bottom: 2px;
        }
        .price-badge-value {
            font-size: 18px;
            font-weight: 700;
            color: #6366f1;
        }

        /* Content Section */
        .nft-content {
            padding: 40px 24px 24px;
        }

        /* Timestamp */
        .nft-timestamp {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #9ca3af;
            font-size: 13px;
            margin-bottom: 20px;
        }
        .nft-timestamp svg {
            width: 16px;
            height: 16px;
        }

        /* Tabs */
        .nft-tabs {
            display: flex;
            gap: 32px;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 24px;
        }
        .nft-tab {
            padding: 12px 0;
            font-size: 15px;
            font-weight: 600;
            color: #9ca3af;
            background: none;
            border: none;
            cursor: pointer;
            position: relative;
            transition: color 0.2s;
        }
        .nft-tab.active {
            color: #6366f1;
        }
        .nft-tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background: #6366f1;
            border-radius: 2px 2px 0 0;
        }

        /* NFT Title */
        .nft-title {
            font-size: 28px;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 12px;
            letter-spacing: -0.02em;
        }

        /* Description */
        .nft-description {
            font-size: 14px;
            line-height: 1.6;
            color: #6b7280;
            margin-bottom: 8px;
        }
        .read-more {
            color: #6366f1;
            font-size: 14px;
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
            gap: 24px;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #f3f4f6;
        }
        .meta-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .meta-label {
            font-size: 13px;
            color: #9ca3af;
            font-weight: 500;
        }
        .meta-value {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .meta-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
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
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
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
            padding: 16px 24px 24px;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.08);
            display: flex;
            gap: 12px;
            z-index: 100;
        }
        .btn-buy {
            flex: 1;
            padding: 16px 24px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-buy:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
        }
        .btn-bid {
            flex: 1;
            padding: 16px 24px;
            background: #fff;
            color: #6366f1;
            font-size: 16px;
            font-weight: 600;
            border: 2px solid #6366f1;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-bid:hover {
            background: #f5f3ff;
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
        .header, .header-spacer, .bottom-nav, .nav-spacer { display: none !important; }
        .mobile-container { padding: 0; }
        .content { padding: 0; }
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
                        <path d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div class="header-actions">
                    <button class="btn-icon active">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                    <button class="btn-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="5" r="2"/>
                            <circle cx="12" cy="12" r="2"/>
                            <circle cx="12" cy="19" r="2"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- NFT Image -->
            <img src="{{ $nft['image'] }}" alt="{{ $nft['name'] }}" class="nft-hero-image">

            <!-- Price Badge -->
            <div class="price-badge">
                <div class="price-badge-label">Reserve price</div>
                <div class="price-badge-value">{{ number_format($nft['purchase_price'], 2) }} USDT</div>
            </div>
        </div>

        <!-- Content -->
        <div class="nft-content">
            <!-- Timestamp -->
            <div class="nft-timestamp">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
                <span>{{ $nft['created_at'] ?? 'Just listed' }}</span>
            </div>

            <!-- Tabs -->
            <div class="nft-tabs">
                <button class="nft-tab active">Details</button>
                <button class="nft-tab">History</button>
            </div>

            <!-- Title -->
            <h1 class="nft-title">{{ strtoupper($nft['name']) }}</h1>

            <!-- Description -->
            <p class="nft-description">
                {{ Str::limit($nft['description'] ?? 'A unique digital collectible with rare attributes and exclusive ownership rights on the blockchain.', 100) }}
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
                        <span class="meta-name">@{{ $nft['creator'] ?? 'tradex' }}</span>
                    </div>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Collection</span>
                    <div class="meta-value">
                        <div class="meta-avatar">
                            <img src="/icons/user.svg" alt="Collection">
                        </div>
                        <span class="meta-name">@{{ $nft['collection'] ?? 'tradex' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Action Bar -->
        <div class="bottom-bar">
            <form action="{{ route('nft.buy', $nft['id']) }}" method="POST" style="flex:1; display:flex;">
                @csrf
                <button type="submit" class="btn-buy">Buy now</button>
            </form>
            <button class="btn-bid" onclick="window.location.href='{{ route('auction.index') }}'">Place a bid</button>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.addEventListener('DOMContentLoaded', function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'center',
            iconColor: 'white',
            customClass: { popup: 'colored-toast' },
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
        });
        @if(session('error'))
        Toast.fire({ icon: 'error', title: @json(session('error')) });
        @endif
        @if(session('success'))
        Toast.fire({ icon: 'success', title: @json(session('success')) });
        setTimeout(function() { window.location.href = "{{ route('collection') }}"; }, 1600);
        @endif
    });

    // Tab switching
    document.querySelectorAll('.nft-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.nft-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>
@endpush