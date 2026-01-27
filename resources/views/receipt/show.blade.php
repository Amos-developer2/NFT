@extends('layouts.app', ['hideHeader' => true])

@section('title', 'Receipt ' . $receipt->receipt_number)

@push('styles')
<style>
    .receipt-view-wrapper {
        padding: 0 16px 100px;
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
    }

    .receipt-view-container {
        max-width: 500px;
        margin: 0 auto;
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
    }

    .receipt-view-header {
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        color: #fff;
        padding: 20px;
        text-align: center;
    }

    .receipt-view-header h1 {
        margin: 0 0 10px;
        font-size: 28px;
        font-weight: 800;
    }

    .receipt-view-header p {
        margin: 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .receipt-view-content {
        padding: 20px;
    }

    .receipt-section {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f1f5f9;
    }

    .receipt-section:last-child {
        border-bottom: none;
    }

    .receipt-section-title {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }

    .receipt-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .receipt-row:last-child {
        margin-bottom: 0;
    }

    .receipt-label {
        color: #64748b;
    }

    .receipt-value {
        color: #1e293b;
        font-weight: 600;
    }

    .receipt-nft-info {
        display: flex;
        gap: 12px;
        margin-bottom: 15px;
    }

    .receipt-nft-image {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        overflow: hidden;
    }

    .receipt-nft-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .receipt-nft-details {
        flex: 1;
    }

    .receipt-nft-name {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .receipt-nft-meta {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 8px;
    }

    .receipt-nft-rarity {
        display: inline-block;
        padding: 3px 8px;
        background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
        color: #fff;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .receipt-price-highlight {
        background: #f8fafc;
        border-radius: 8px;
        padding: 12px;
        margin: 15px 0;
    }

    .receipt-amount {
        display: flex;
        align-items: baseline;
    }

    .receipt-amount-value {
        font-size: 32px;
        font-weight: 800;
        color: #2A6CF6;
        letter-spacing: -1px;
    }

    .receipt-amount-currency {
        font-size: 16px;
        color: #64748b;
        margin-left: 8px;
    }

    .receipt-actions {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }

    .receipt-action-btn {
        flex: 1;
        padding: 14px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .receipt-action-btn.primary {
        background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
        color: #fff;
    }

    .receipt-action-btn.secondary {
        background: #f1f5f9;
        color: #2A6CF6;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #2A6CF6;
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 16px;
        font-size: 14px;
    }
</style>
@endpush

@section('content')
<div class="receipt-view-wrapper">
    <a href="{{ route('receipt.index') }}" class="back-btn">← Back to Receipts</a>

    <div class="receipt-view-container">
        <div class="receipt-view-header">
            <h1>✅ Receipt</h1>
            <p>{{ $receipt->receipt_number }}</p>
        </div>

        <div class="receipt-view-content">
            <!-- NFT Details -->
            <div class="receipt-section">
                <div class="receipt-section-title">🎨 NFT Details</div>
                <div class="receipt-nft-info">
                    <div class="receipt-nft-image">
                        <img src="{{ $receipt->nft->image }}" alt="{{ $receipt->nft->name }}">
                    </div>
                    <div class="receipt-nft-details">
                        <div class="receipt-nft-name">{{ $receipt->nft->name }}</div>
                        <div class="receipt-nft-meta">#{{ $receipt->nft->id }}</div>
                        <span class="receipt-nft-rarity">{{ $receipt->nft->rarity }}</span>
                    </div>
                </div>
            </div>

            <!-- Purchase Amount -->
            <div class="receipt-section">
                <div class="receipt-section-title">💰 Amount</div>
                <div class="receipt-price-highlight">
                    <div class="receipt-amount">
                        <span class="receipt-amount-value">{{ number_format($receipt->amount, 2) }}</span>
                        <span class="receipt-amount-currency">USDT</span>
                    </div>
                </div>
            </div>

            <!-- Transaction Details -->
            <div class="receipt-section">
                <div class="receipt-section-title">📋 Transaction Details</div>
                <div class="receipt-row">
                    <span class="receipt-label">Status</span>
                    <span class="receipt-value">{{ ucfirst($receipt->status) }}</span>
                </div>
                <div class="receipt-row">
                    <span class="receipt-label">Payment Method</span>
                    <span class="receipt-value">{{ $receipt->payment_method }}</span>
                </div>
                <div class="receipt-row">
                    <span class="receipt-label">Date & Time</span>
                    <span class="receipt-value">{{ $receipt->created_at->format('M d, Y H:i A') }}</span>
                </div>
            </div>

            <!-- Email Status -->
            <div class="receipt-section">
                <div class="receipt-section-title">📧 Email Status</div>
                <div class="receipt-row">
                    <span class="receipt-label">Email Address</span>
                    <span class="receipt-value">{{ $receipt->user->email }}</span>
                </div>
                <div class="receipt-row">
                    <span class="receipt-label">Receipt Status</span>
                    <span class="receipt-value">
                        @if($receipt->email_status === 'sent')
                            ✓ Sent {{ $receipt->email_sent_at->format('M d, Y') }}
                        @elseif($receipt->email_status === 'failed')
                            ✗ Failed to send
                        @else
                            ⏱ Pending
                        @endif
                    </span>
                </div>
            </div>

            <!-- Actions -->
            <div class="receipt-actions">
                <a href="{{ route('receipt.download', $receipt->id) }}" class="receipt-action-btn primary">⬇ Download</a>
                <a href="{{ route('receipt.index') }}" class="receipt-action-btn secondary">← All Receipts</a>
            </div>
        </div>
    </div>
</div>
@endsection
