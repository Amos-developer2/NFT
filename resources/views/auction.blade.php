@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auction.css') }}">
@endpush

@section('content')


<div style="max-width:480px;margin:0 auto;padding:1rem;">
    <!-- Auction Item Card -->
    <div style="background:#fff;border-radius:16px;box-shadow:0 2px 8px rgba(0,0,0,0.06);padding:1.2rem 1rem 1rem 1rem;margin-bottom:1.2rem;display:flex;flex-direction:row;align-items:center;gap:1rem;">
        <div style="flex:0 0 90px;">
            <img src="{{ $auction->image_url ?? '/images/default-auction.png' }}" alt="Auction Item" style="width:90px;height:90px;object-fit:cover;border-radius:12px;">
        </div>
        <div style="flex:1;">
            <div style="font-weight:600;font-size:1.1rem;">{{ $auction->title ?? 'Auction Item Title' }}</div>
            <div style="font-size:0.97rem;color:#666;margin-bottom:0.5rem;">{{ $auction->description ?? 'No description available.' }}</div>
            <div style="font-size:0.97rem;margin-bottom:0.2rem;">Auction ID: #{{ $auction->id ?? '-' }}</div>
            <div style="font-size:0.97rem;">Seller: {{ $auction->seller->name ?? '-' }}</div>
        </div>
    </div>

    <!-- Auction Status Card -->
    <div style="background:#f8fafc;border-radius:14px;padding:1rem 1rem 0.7rem 1rem;margin-bottom:1.1rem;display:flex;flex-direction:row;justify-content:space-between;align-items:center;gap:1rem;">
        <div>
            <div style="font-size:0.98rem;color:#666;">Current Bid</div>
            <div style="font-size:1.2rem;font-weight:600;">${{ number_format($auction->current_bid ?? 0, 2) }}</div>
            <div style="font-size:0.93rem;color:#888;">by {{ $auction->highestBidder->name ?? 'N/A' }}</div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:0.98rem;color:#666;">Ends in</div>
            <div style="font-size:1.1rem;font-weight:600;">
                @if(!empty($auction->end_time))
                {{ \Carbon\Carbon::parse($auction->end_time)->diffForHumans() }}
                @else
                -
                @endif
            </div>
        </div>
    </div>

    <!-- Bid Form Card -->
    <div style="background:#fff;border-radius:14px;padding:1.1rem 1rem 1rem 1rem;margin-bottom:1.1rem;box-shadow:0 1px 4px rgba(0,0,0,0.04);">
        <form method="POST" action="{{ route('auction.bid', $auction->id ?? 0) }}" style="display:flex;flex-direction:column;gap:0.7rem;">
            @csrf
            <label for="bid-amount" style="font-size:0.97rem;font-weight:500;">Your Bid</label>
            <input type="number" step="0.01" min="{{ ($auction->current_bid ?? 0) + ($auction->min_increment ?? 1) }}" name="amount" id="bid-amount" required style="padding:0.7rem 0.8rem;font-size:1.05rem;border-radius:8px;border:1px solid #e5e7eb;">
            <button type="submit" style="width:100%;padding:0.9rem 0;font-size:1.1rem;border-radius:8px;background:linear-gradient(90deg,#22c55e 0%,#0ea5e9 100%);color:#fff;font-weight:600;border:none;box-shadow:0 2px 8px rgba(34,197,94,0.10);cursor:pointer;transition:transform 0.18s cubic-bezier(.4,2,.6,1),box-shadow 0.18s;position:relative;overflow:hidden;">Place Bid</button>
        </form>
        @if(session('bid_status'))
        <div style="margin-top:0.7rem;" class="alert alert-info">{{ session('bid_status') }}</div>
        @endif
    </div>

    <!-- Bid History Card -->
    <div style="background:#f8fafc;border-radius:14px;padding:1rem 1rem 0.7rem 1rem;margin-bottom:1.1rem;">
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

    <!-- Auction Rules Card -->
    <div style="background:#fff;border-radius:14px;padding:1rem 1rem 0.7rem 1rem;margin-bottom:1.1rem;box-shadow:0 1px 4px rgba(0,0,0,0.04);">
        <h5 style="font-size:1.01rem;font-weight:600;margin-bottom:0.6rem;">Auction Rules</h5>
        <ul style="padding-left:1.1em;font-size:0.97rem;color:#666;">
            <li>Bids must be higher than the current bid by at least the minimum increment.</li>
            <li>Once placed, bids cannot be withdrawn.</li>
            <li>Highest bidder at auction end wins the item.</li>
            <li>Payment must be completed within 24 hours of winning.</li>
        </ul>
    </div>

    <!-- Notifications -->
    <div id="auction-notifications"></div>
</div>

@endsection