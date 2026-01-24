@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auction.css') }}">
@endpush

@section('content')
<div class="auction-list-container">
    <h1>Live Auctions</h1>
    <div class="auction-list">
        @forelse($auctions as $auction)
        <div class="auction-list-card">
            <div class="auction-list-image">
                <img src="{{ $auction->nft->image ?? '/images/default-auction.png' }}" alt="Auction Item">
            </div>
            <div class="auction-list-details">
                <h2>{{ $auction->nft->name ?? 'Auction Item' }}</h2>
                <p>Starting Price: ${{ number_format($auction->starting_price, 2) }}</p>
                <p>Status: {{ $auction->status }}</p>
                <a href="{{ route('auction', ['id' => $auction->id]) }}" class="btn btn-primary">View Auction</a>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <h3>No live auctions at the moment.</h3>
        </div>
        @endforelse
    </div>
</div>
@endsection