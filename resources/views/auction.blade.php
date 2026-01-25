@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="/css/collection.css">
@endpush

@section('content')
@include('partials.header', ['title' => 'Auction Details'])
<div class="market-header-spacer"></div>

@php
$status = $auction->status; // 'sold', 'auction', 'failed'
$isSold = $status === 'sold';
$isActive = $status === 'auction';
$isFailed = $status === 'failed';
$nft = $auction->nft ?? null;
@endphp
<div class="nfts-list" style="justify-content:center; margin: -50px 0 0 0;">
    <div class="nft-card auction-card" data-status="{{ $status }}" style="max-width:480px;width:100%;flex-direction:row;gap:16px;padding:1.2rem 1.2rem 1rem 1.2rem;">
        <div class="nft-image">
            <img src="{{ $nft->image ?? '/images/default-auction.png' }}" alt="{{ $nft->name ?? 'NFT' }}" class="nft-img">
            @if($isSold)
            <div class="days-badge sold">SOLD</div>
            @elseif($isActive)
            <div class="days-badge auction">ON AUCTION</div>
            @elseif($isFailed)
            <div class="days-badge failed">FAILED</div>
            @endif
        </div>
        <div class="nft-details">
            <div class="nft-header">
                <div class="nft-title">
                    <span class="nft-name">{{ $nft->name ?? $auction->title ?? 'NFT' }}</span>
                    <span class="nft-id">#{{ $nft->id ?? $auction->id }}</span>
                </div>
                <div class="value-badge {{ $isSold ? 'up' : ($isFailed ? 'down' : '') }}">
                    <span>{{ ucfirst($status) }}</span>
                </div>
            </div>
            <div class="price-row">
                <div class="price-item">
                    <span class="price-label">Current/Final Price</span>
                    <span class="price-value bought">
                        <img src="/icons/usdt.svg" width="14"> {{ number_format($auction->final_price ?? $auction->current_bid ?? 0, 2) }} USDT
                    </span>
                </div>
                <div class="price-arrow">→</div>
                <div class="price-item">
                    <span class="price-label">Status</span>
                    <span class="price-value current {{ $isSold ? 'up' : ($isFailed ? 'down' : '') }}">
                        {{ ucfirst($status) }}
                    </span>
                </div>
            </div>
            <div class="auction-info-row" style="margin-top:10px;display:flex;gap:18px;">
                <div style="font-size:0.97rem;color:#666;">
                    <div><strong>Seller:</strong> {{ $auction->seller->username ?? $auction->seller->name ?? '-' }}</div>
                    <div><strong>Highest Bidder:</strong>
                        @if($isSold && isset($auction->buyer))
                        {{ $auction->buyer->username ?? $auction->buyer->name ?? '-' }}
                        @elseif($auction->highestBidder)
                        {{ $auction->highestBidder->username ?? $auction->highestBidder->name ?? '-' }}
                        @else
                        -
                        @endif
                    </div>
                    <div><strong>Status:</strong>
                        @if($isSold)
                        <span style="color:#22c55e;font-weight:600;">Sold</span>
                        @elseif($isActive)
                        <span style="color:#0ea5e9;font-weight:600;">On Auction</span>
                        @elseif($isFailed)
                        <span style="color:#ef4444;font-weight:600;">Failed</span>
                        @else
                        -
                        @endif
                    </div>
                </div>
                <div style="font-size:0.97rem;color:#666;">
                    <div><strong>Auction ID:</strong> #{{ $auction->id }}</div>
                    <div><strong>Ends:</strong> @if(!empty($auction->end_time)){{ \Carbon\Carbon::parse($auction->end_time)->diffForHumans() }}@else - @endif</div>
                </div>
            </div>
            <div class="action-row" style="margin-top:12px;">
                @if($isActive)
                <form method="POST" action="{{ route('auction.bid', $auction->id) }}" style="display:flex;gap:10px;align-items:center;width:100%;">
                    @csrf
                    <input type="number" step="0.01" min="{{ ($auction->current_bid ?? 0) + ($auction->min_increment ?? 1) }}" name="amount" placeholder="Your Bid" required style="flex:1;padding:0.7rem 0.8rem;font-size:1.05rem;border-radius:8px;border:1px solid #e5e7eb;">
                    <button type="submit" class="sell-btn ready" style="min-width:110px;">Place Bid</button>
                </form>
                @elseif($isSold)
                <span class="sell-btn disabled" style="background:#22c55e;color:#fff;">Sold</span>
                @elseif($isFailed)
                <span class="sell-btn disabled" style="background:#ef4444;color:#fff;">Failed</span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- <div class="nfts-list" style="max-width:480px;margin:0 auto;">
    <div class="nft-card" style="flex-direction:column;align-items:stretch;">
        <div style="padding:1.2rem 1rem 1rem 1rem;">
            <h4 style="font-size:1.08rem;font-weight:600;margin-bottom:0.7rem;">Bid History</h4>
            <ul style="list-style:none;padding:0;margin:0;">
                @forelse($auction->bids ?? [] as $bid)
                <li style="display:flex;justify-content:space-between;align-items:center;padding:0.5rem 0;border-bottom:1px solid #e5e7eb;">
                    <span style="font-weight:500;">{{ $bid->user->name ?? 'User' }}</span>
                    <span style="color:#0ea5e9;font-weight:600;">${{ number_format($bid->amount, 2) }}</span>
                    <span style="color:#888;font-size:0.95em;">{{ $bid->created_at->diffForHumans() }}</span>
                </li>
                @empty
                <li style="color:#888;">No bids yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div> -->

@include('partials.footer')
<div class="pb-20"></div>
@endsection