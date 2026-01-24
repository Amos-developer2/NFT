@extends('layouts.app')

@section('content')
<div class="track-auctions-container" style="max-width:500px;margin:0 auto;padding:1.5rem 1rem;background:#fff;border-radius:16px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
    <h2 style="font-size:1.4rem;font-weight:700;margin-bottom:1.2rem;text-align:center;">Track My Auctions</h2>
    <!-- Category Tabs -->
    <!-- <div class="category-tabs" style="margin-bottom:1.2rem;">
        <button class="category-tab active" data-status="all">All Auctions</button>
        <button class="category-tab" data-status="Live">Active</button>
        <button class="category-tab" data-status="Ended">Completed</button>
    </div> -->
    @if($auctions->isEmpty())
    <div class="empty-state" style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2.5rem 1.2rem 2.2rem 1.2rem;background:#f9fafb;border-radius:18px;box-shadow:0 2px 8px rgba(0,0,0,0.06);margin:2.5rem auto 1.5rem auto;max-width:350px;">
        <img src="/icons/gift.svg" alt="No NFTs" class="empty-icon" style="width:70px;height:70px;margin-bottom:1.2rem;">
        <h3 style="font-size:1.25rem;font-weight:700;margin-bottom:0.7rem;color:#222;">No NFTs Yet</h3>
        <p style="color:#666;font-size:1.07rem;margin-bottom:1.2rem;text-align:center;">Buy NFTs from the marketplace. Hold them and sell when the value increases!</p>
        <a href="{{ route('auction.index') }}" class="browse-btn" style="display:inline-block;padding:0.85rem 2.1rem;background:linear-gradient(90deg,#0ea5e9 0%,#22c55e 100%);color:#fff;font-weight:600;font-size:1.08rem;border-radius:8px;text-decoration:none;box-shadow:0 2px 8px rgba(14,165,233,0.10);transition:background 0.18s;">Go to Auctions</a>
    </div>
    @else
    <div id="auction-list" style="display:flex;flex-direction:column;gap:1.2rem;">
        @foreach($auctions as $auction)
        <div class="auction-card" data-status="{{ $auction->status }}" style="border:1px solid #e5e7eb;border-radius:10px;padding:1rem 1.2rem;background:#f9fafb;">
            <div style="display:flex;align-items:center;gap:1rem;">
                <img src="{{ $auction->nft->image }}" alt="{{ $auction->nft->name }}" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                <div style="flex:1;">
                    <div style="font-weight:600;font-size:1.08rem;">{{ $auction->nft->name }}</div>
                    <div style="font-size:0.97rem;color:#666;">Status: <span style="font-weight:500;color:#0ea5e9;">{{ $auction->status }}</span></div>
                    <div style="font-size:0.97rem;color:#666;">Start Price: {{ number_format($auction->starting_price, 2) }} USDT</div>
                    <div style="font-size:0.97rem;color:#666;">Highest Bid: {{ number_format($auction->highest_bid, 2) }} USDT</div>
                    @php $endTime = \Carbon\Carbon::parse($auction->end_time); @endphp
                    <div style="font-size:0.97rem;color:#666;">Ends: {{ $endTime->format('Y-m-d H:i') }}</div>
                </div>
                <a href="{{ route('auction', ['id' => $auction->id]) }}" style="padding:0.5rem 1rem;background:#0ea5e9;color:#fff;border-radius:7px;font-weight:500;font-size:0.98rem;text-decoration:none;">View</a>
            </div>
        </div>
        @endforeach
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.category-tab');
            const cards = document.querySelectorAll('.auction-card');
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    const status = this.getAttribute('data-status');
                    cards.forEach(card => {
                        if (status === 'all' || card.getAttribute('data-status') === status) {
                            card.style.display = 'flex';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
    @endpush
    @endif
</div>
@endsection