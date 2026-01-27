@extends('layouts.app', ['hideHeader' => true])

@section('title', 'My Purchase Receipts')

@push('styles')
<style>
    .receipts-wrapper {
        padding: 0 16px 100px;
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
    }

    .receipts-header {
        margin-bottom: 24px;
    }

    .receipts-title {
        font-size: 24px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .receipts-subtitle {
        font-size: 14px;
        color: #64748b;
    }

    .receipts-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
        margin-bottom: 24px;
    }

    .receipt-card {
        background: #fff;
        border-radius: 14px;
        padding: 16px;
        border: 1px solid rgba(42, 108, 246, 0.08);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: all 0.2s ease;
    }

    .receipt-card:active {
        transform: scale(0.98);
    }

    .receipt-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .receipt-number {
        font-family: monospace;
        font-size: 12px;
        font-weight: 600;
        color: #2A6CF6;
    }

    .receipt-date {
        font-size: 12px;
        color: #64748b;
    }

    .receipt-status {
        display: inline-block;
        padding: 4px 10px;
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .receipt-body {
        display: flex;
        gap: 12px;
        margin-bottom: 12px;
    }

    .receipt-image {
        width: 70px;
        height: 70px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .receipt-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .receipt-info {
        flex: 1;
    }

    .receipt-nft-name {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .receipt-nft-id {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 8px;
    }

    .receipt-price {
        font-size: 16px;
        font-weight: 800;
        color: #2A6CF6;
    }

    .receipt-price small {
        font-size: 11px;
        color: #64748b;
        font-weight: 500;
        margin-left: 4px;
    }

    .receipt-footer {
        border-top: 1px solid #f1f5f9;
        padding-top: 12px;
        display: flex;
        gap: 10px;
    }

    .receipt-action-btn {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .receipt-action-btn.download {
        background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
        color: #fff;
    }

    .receipt-action-btn.view {
        background: #f1f5f9;
        color: #2A6CF6;
    }

    .empty-state {
        text-align: center;
        padding: 48px 24px;
        background: #fff;
        border-radius: 14px;
        border: 1px solid rgba(42, 108, 246, 0.08);
    }

    .empty-icon {
        font-size: 48px;
        margin-bottom: 16px;
    }

    .empty-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .empty-text {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 20px;
    }

    .empty-action {
        display: inline-block;
        padding: 12px 24px;
        background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
        color: #fff;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
    }

    .email-status {
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 3px;
        margin-top: 6px;
        display: inline-block;
    }

    .email-status.sent {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .email-status.failed {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .email-status.pending {
        background: rgba(168, 85, 247, 0.1);
        color: #a855f7;
    }
</style>
@endpush

@section('content')
<div class="receipts-wrapper">
    <!-- Page Header -->
    @include('partials.header', ['title' => 'Purchase Receipts'])

    <div class="receipts-header">
        <h2 class="receipts-title">🧾 Your Receipts</h2>
        <p class="receipts-subtitle">All your NFT purchase receipts and transaction history</p>
    </div>

    @if($receipts->count() > 0)
        <div class="receipts-grid">
            @foreach($receipts as $receipt)
            <div class="receipt-card">
                <div class="receipt-header">
                    <div>
                        <div class="receipt-number">{{ $receipt->receipt_number }}</div>
                        <div class="receipt-date">{{ $receipt->created_at->format('M d, Y H:i A') }}</div>
                    </div>
                    <span class="receipt-status">✓ {{ $receipt->status }}</span>
                </div>

                <div class="receipt-body">
                    <div class="receipt-image">
                        <img src="{{ $receipt->nft->image }}" alt="{{ $receipt->nft->name }}">
                    </div>
                    <div class="receipt-info">
                        <div class="receipt-nft-name">{{ $receipt->nft->name }}</div>
                        <div class="receipt-nft-id">#{{ $receipt->nft->id }} • {{ $receipt->nft->rarity }}</div>
                        <div class="receipt-price">
                            {{ number_format($receipt->amount, 2) }}
                            <small>USDT</small>
                        </div>
                        <span class="email-status {{ $receipt->email_status }}">
                            @if($receipt->email_status === 'sent')
                                ✓ Receipt sent
                            @elseif($receipt->email_status === 'failed')
                                ✗ Send failed
                            @else
                                ⏱ Pending
                            @endif
                        </span>
                    </div>
                </div>

                <div class="receipt-footer">
                    <a href="{{ route('receipt.download', $receipt->id) }}" class="receipt-action-btn download">⬇ Download PDF</a>
                    <a href="{{ route('receipt.view', $receipt->id) }}" class="receipt-action-btn view">👁 View Details</a>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">🎨</div>
            <h3 class="empty-title">No Receipts Yet</h3>
            <p class="empty-text">You haven't purchased any NFTs yet. Start your collection today!</p>
            <a href="{{ route('collection') }}" class="empty-action">Browse NFTs</a>
        </div>
    @endif
</div>
@endsection
