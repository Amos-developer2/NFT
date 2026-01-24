@extends('layouts.app')

@section('content')
<div class="track-auctions-container" style="max-width:500px;margin:0 auto;padding:1.5rem 1rem;background:#fff;border-radius:16px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
    <h2 style="font-size:1.4rem;font-weight:700;margin-bottom:1.2rem;text-align:center;">Track My Auctions</h2>
    @if($auctions->isEmpty())
    <div style="text-align:center;color:#888;font-size:1.1rem;">You have no NFTs on auction or sold yet.</div>
    @else
    <div style="display:flex;flex-direction:column;gap:1.2rem;">
        @foreach($auctions as $auction)
        <div style="border:1px solid #e5e7eb;border-radius:10px;padding:1rem 1.2rem;background:#f9fafb;">
            <div style="display:flex;align-items:center;gap:1rem;">
                <img src="{{ $auction->nft->image }}" alt="{{ $auction->nft->name }}" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                <div style="flex:1;">
                    <div style="font-weight:600;font-size:1.08rem;">{{ $auction->nft->name }}</div>
                    <div style="font-size:0.97rem;color:#666;">Status: <span style="font-weight:500;color:#0ea5e9;">{{ $auction->status }}</span></div>
                    <div style="font-size:0.97rem;color:#666;">Start Price: {{ number_format($auction->starting_price, 2) }} USDT</div>
                    <div style="font-size:0.97rem;color:#666;">Highest Bid: {{ number_format($auction->highest_bid, 2) }} USDT</div>
                    <div style="font-size:0.97rem;color:#666;">Ends: {{ (is_a($auction->end_time, 'Illuminate\Support\Carbon') ? $auction->end_time : \Carbon\Carbon::parse($auction->end_time))->format('Y-m-d H:i') }}</div>
                </div>
                <a href="{{ route('auction', ['id' => $auction->id]) }}" style="padding:0.5rem 1rem;background:#0ea5e9;color:#fff;border-radius:7px;font-weight:500;font-size:0.98rem;text-decoration:none;">View</a>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection