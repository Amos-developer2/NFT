@extends('layouts.app')

@push('styles')
<style>
    body {
        background: #f4f6f9;
    }

    .auction-details-container {
        max-width: 520px;
        margin: 0 auto 2rem auto;
        padding: 0 14px;
    }

    .auction-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .nft-cover {
        width: 100%;
        height: 240px;
        object-fit: cover;
        background: #f3f4f6;
    }

    .card-body {
        padding: 1.2rem;
    }

    .title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .auction-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #111827;
    }

    .auction-id {
        font-size: 0.85rem;
        color: #9ca3af;
    }

    .status-pill {
        padding: 0.3rem 0.8rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #fff;
    }

    .status-pill.auction {
        background: #0ea5e9;
    }

    .status-pill.sold {
        background: #22c55e;
    }

    .status-pill.failed {
        background: #ef4444;
    }

    .price-box {
        margin: 1rem 0;
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        color: #fff;
        border-radius: 16px;
        padding: 1rem;
        text-align: center;
    }

    .price-label {
        font-size: 0.85rem;
        opacity: 0.9;
    }

    .price-value {
        font-size: 1.6rem;
        font-weight: 800;
        margin-top: 0.3rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.7rem;
        margin-top: 0.5rem;
        font-size: 0.9rem;
        color: #6b7280;
    }

    .info-grid strong {
        display: block;
        color: #111827;
        font-weight: 600;
    }

    .bid-section {
        margin-top: 1.2rem;
    }

    .auction-bid-form {
        display: flex;
        gap: 10px;
    }

    .auction-bid-form input {
        flex: 1;
        padding: 0.9rem;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        font-size: 1rem;
    }

    .auction-bid-form button {
        padding: 0 1.2rem;
        border-radius: 12px;
        background: #111827;
        color: #fff;
        font-weight: 600;
        border: none;
    }

    .bid-history {
        margin-top: 1.6rem;
    }

    .bid-history h4 {
        margin-bottom: 0.7rem;
    }

    .bid-item {
        display: flex;
        justify-content: space-between;
        padding: 0.7rem 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.9rem;
    }

    .bid-item .amount {
        color: #0ea5e9;
        font-weight: 700;
    }

    @media (max-width: 480px) {
        .nft-cover {
            height: 200px;
        }
    }
</style>
@endpush

@section('content')
@include('partials.header', ['title' => 'Auction Details'])
<div class="market-header-spacer"></div>

@php
$status = $auction->status;
$isActive = $status === 'auction';
$nft = $auction->nft;
@endphp

<div class="auction-details-container">
    <div class="auction-card">

        <img src="{{ $nft->image ?? '/images/default-auction.png' }}" class="nft-cover">

        <div class="card-body">

            <div class="title-row">
                <div>
                    <div class="auction-title">{{ $nft->name ?? 'NFT Item' }}</div>
                    <div class="auction-id">#{{ $auction->id }}</div>
                </div>
                <span class="status-pill {{ $status }}">{{ ucfirst($status) }}</span>
            </div>

            <div class="price-box">
                <div class="price-label">Current / Final Price</div>
                <div class="price-value">
                    {{ number_format($auction->final_price ?? $auction->current_bid ?? 0, 2) }} USDT
                </div>
            </div>

            <div class="info-grid">
                <div><strong>Seller</strong>{{ $auction->seller->username ?? '-' }}</div>
                <div><strong>Highest Bidder</strong>{{ $auction->highestBidder->username ?? '-' }}</div>
                <div><strong>Auction Ends</strong>{{ \Carbon\Carbon::parse($auction->end_time)->diffForHumans() }}</div>
                <div><strong>Status</strong>{{ ucfirst($status) }}</div>
            </div>

            @if($isActive)
            <div class="bid-section">
                <form method="POST" action="{{ route('auction.bid', $auction->id) }}" class="auction-bid-form">
                    @csrf
                    <input type="number"
                        step="0.01"
                        min="{{ ($auction->current_bid ?? 0) + ($auction->min_increment ?? 1) }}"
                        name="amount"
                        placeholder="Enter bid amount"
                        required>
                    <button type="submit">Place Bid</button>
                </form>
            </div>
            @endif

            <div class="bid-history">
                <h4>Bid History</h4>
                @forelse($auction->bids as $bid)
                <div class="bid-item">
                    <span>{{ $bid->user->name ?? 'User' }}</span>
                    <span class="amount">{{ number_format($bid->amount, 2) }} USDT</span>
                    <span>{{ $bid->created_at->diffForHumans() }}</span>
                </div>
                @empty
                <div style="color:#9ca3af;">No bids yet</div>
                @endforelse
            </div>

        </div>
    </div>
</div>

@include('partials.footer')
<div class="pb-20"></div>
@endsection