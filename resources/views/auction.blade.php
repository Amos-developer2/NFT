@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auction.css') }}">
@endpush

@section('content')

{{-- ===================== BALANCE ===================== --}}
<div class="balance-card">
    <div class="balance-card-header">
        <div class="balance-label">
            <img src="/icons/wallet.svg">
            <span>My Auction Balance</span>
        </div>
        <button class="refresh-btn" onclick="refreshAuctions()">
            <img src="/icons/settings.svg">
        </button>
    </div>

    <div class="balance-amount-large">
        ${{ number_format(Auth::user()->balance ?? 0, 2) }}
    </div>

    <div class="balance-crypto">
        <img src="/icons/diamond.svg">
        {{ number_format($userStats['balance'] ?? 0, 2) }} USDT
        <span class="badge-stars">⭐ {{ $userStats['stars'] ?? 0 }}</span>
    </div>
</div>

{{-- ===================== QUICK STATS ===================== --}}
<div class="quick-stats">
    <div class="stat-item">
        <span class="stat-value">{{ $userStats['auctionsActive'] ?? 0 }}</span>
        <span class="stat-label">Active</span>
    </div>
    <div class="stat-divider"></div>
    <div class="stat-item">
        <span class="stat-value">{{ $userStats['auctionsWon'] ?? 0 }}</span>
        <span class="stat-label">Won</span>
    </div>
    <div class="stat-divider"></div>
    <div class="stat-item">
        <span class="stat-value">{{ $userStats['bidsPlaced'] ?? 0 }}</span>
        <span class="stat-label">Bids</span>
    </div>
</div>




{{-- ===================== AUCTION ITEM ===================== --}}
<div class="auction-item-card">
    <div class="auction-item-image">
        <img src="{{ $auction->image_url ?? '/images/default-auction.png' }}" alt="Auction Item">
    </div>
    <div class="auction-item-details">
        <h2>{{ $auction->title ?? 'Auction Item Title' }}</h2>
        <p>{{ $auction->description ?? 'No description available.' }}</p>
        <div class="auction-meta">
            <span class="auction-id">#{{ $auction->id ?? '-' }}</span>
            <span class="auction-seller">Seller: {{ $auction->seller->name ?? '-' }}</span>
        </div>
    </div>
</div>

{{-- ===================== AUCTION STATUS ===================== --}}
<div class="auction-status">
    <div class="current-bid">
        <span>Current Bid:</span>
        <strong>${{ number_format($auction->current_bid ?? 0, 2) }}</strong>
        <span class="bidder">by {{ $auction->highestBidder->name ?? 'N/A' }}</span>
    </div>
    <div class="auction-timer">
        <span>Ends in:</span>
        <span id="auction-countdown">
            @if(!empty($auction->end_time))
            {{ \Carbon\Carbon::parse($auction->end_time)->diffForHumans() }}
            @else
            -
            @endif
        </span>
    </div>
</div>

{{-- ===================== BIDDING INTERFACE ===================== --}}
<div class="bid-form-card">
    <form method="POST" action="{{ route('auction.bid', $auction->id ?? 0) }}">
        @csrf
        <label for="bid-amount">Your Bid</label>
        <input type="number" step="0.01" min="{{ ($auction->current_bid ?? 0) + ($auction->min_increment ?? 1) }}" name="amount" id="bid-amount" required>
        <button type="submit" class="btn btn-primary">Place Bid</button>
    </form>
    @if(session('bid_status'))
    <div class="alert alert-info mt-2">{{ session('bid_status') }}</div>
    @endif
</div>

{{-- ===================== BID HISTORY ===================== --}}
<div class="bid-history-card">
    <h4>Bid History</h4>
    <ul class="bid-history-list">
        @forelse($auction->bids ?? [] as $bid)
        <li>
            <span class="bidder">{{ $bid->user->name ?? 'User' }}</span>
            <span class="amount">${{ number_format($bid->amount, 2) }}</span>
            <span class="time">{{ $bid->created_at->diffForHumans() }}</span>
        </li>
        @empty
        <li>No bids yet.</li>
        @endforelse
    </ul>
</div>

{{-- ===================== AUCTION RULES ===================== --}}
<div class="auction-rules-card">
    <h5>Auction Rules</h5>
    <ul>
        <li>Bids must be higher than the current bid by at least the minimum increment.</li>
        <li>Once placed, bids cannot be withdrawn.</li>
        <li>Highest bidder at auction end wins the item.</li>
        <li>Payment must be completed within 24 hours of winning.</li>
    </ul>
</div>

{{-- ===================== NOTIFICATIONS ===================== --}}
<div id="auction-notifications"></div>

@endsection