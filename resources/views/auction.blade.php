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



@endsection