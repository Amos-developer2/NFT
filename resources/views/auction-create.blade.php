@extends('layouts.app')


@section('content')

<div class="auction-create-mobile-card" style="max-width:400px;margin:10px 10px;padding:1.5rem 1rem;background:#fff;border-radius:16px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
    <div class="nft-card card-profit" style="display:flex;flex-direction:row;align-items:center;gap:1rem;">
        <div class="nft-image" style="flex:0 0 90px;">
            <img src="{{ $nft->image }}" alt="{{ $nft->name }}" class="nft-img" style="width:90px;height:90px;object-fit:cover;border-radius:12px;">
        </div>
        <div class="nft-details" style="flex:1;">
            <div class="nft-title" style="font-weight:600;font-size:1.1rem;">{{ $nft->name }}</div>
            <div class="nft-desc" style="font-size:0.97rem;color:#666;margin-bottom:0.5rem;">{{ $nft->description }}</div>
            <div class="nft-buy" style="font-size:0.97rem;margin-bottom:0.2rem;"><strong>Buy Price:</strong> {{ number_format($nft->purchase_price, 2) }} USDT</div>
            @php
            $minSell = $nft->purchase_price * 1.001;
            $maxSell = $nft->purchase_price * 1.005;
            @endphp
            <div class="nft-sell" style="font-size:0.97rem;"><strong>Suggested Sell Price:</strong> {{ number_format($minSell, 2) }} - {{ number_format($maxSell, 2) }} USDT <span style="color:#888;font-size:0.92em;">(0.1% - 0.5% above buy price)</span></div>
        </div>
    </div>
    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.onload = function() {
            Swal.fire({
                icon: 'success',
                title: 'Auction Started',
                text: '{{ session('
                success ') }}',
                confirmButtonColor: '#22c55e',
                customClass: {
                    popup: 'swal2-mobile'
                }
            });
        };
    </script>
    @endif
    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.onload = function() {
            Swal.fire({
                icon: 'success',
                title: 'The NFT is now on market, both profit and capital will be credited after 2 hours of auction!',
                text: '{{ session('
                success ') }}',
                confirmButtonColor: '#22c55e',
                customClass: {
                    popup: 'swal2-mobile'
                }
            });
        };
    </script>
    @endif
    <form action="{{ route('auction.store') }}" method="POST" style="margin-top:1.5rem;">
        @csrf
        <input type="hidden" name="nft_id" value="{{ $nft->id }}">
        <input type="hidden" name="starting_price" value="{{ $minSell }}">
        <input type="hidden" name="duration" value="2">
        <button type="submit" class="btn btn-primary" style="width:100% !important; padding:0.9rem 0 !important; font-size:1.1rem !important; border-radius:8px !important; background:linear-gradient(90deg,#22c55e 0%,#0ea5e9 100%) !important; color:#fff !important; font-weight:600 !important; border:none !important; box-shadow:0 2px 8px rgba(34,197,94,0.10) !important; cursor:pointer !important; transition:transform 0.18s cubic-bezier(.4,2,.6,1),box-shadow 0.18s !important; position:relative !important; overflow:hidden !important;">Start Auction</button>
    </form>
</div>
@endsection