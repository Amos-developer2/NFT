@extends('layouts.app')

@push('head')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    .track-auctions-container,
    .total-card {
        max-width: 100%;
        box-sizing: border-box;
    }

    .auction-card img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }

    @media (max-width: 600px) {
        .track-auctions-container {
            padding: 1rem 0.3rem;
        }

        .auction-card {
            padding: 0.7rem 0.5rem;
        }

        .total-card {
            padding: 0.8rem 0.5rem 0.5rem 0.5rem;
        }

        .stats-row {
            gap: 0.5rem !important;
        }

        .stat-label,
        .stat-value {
            font-size: 0.95rem !important;
        }
    }

    .auction-filter-btn.active {
        background: #fff !important;
        color: #2563eb !important;
    }
</style>
@endpush


@section('content')

<!-- ================= Auction Summary Card ================= -->
<div class="total-card" style="margin:70px 10px;background:linear-gradient(135deg,#60a5fa,#2563eb);border-radius:14px;padding:1.1rem 1.2rem 0.7rem;box-shadow:0 2px 8px rgba(14,165,233,0.10);color:#fff;">

    <div style="display:flex;justify-content:space-between;margin-bottom:0.7rem;font-weight:600;font-size:1.08rem;">
        Auction Summary
    </div>

    <div class="stats-row" style="display:flex;justify-content:space-between;gap:1.2rem;">
        <div style="flex:1;text-align:center;">
            <span class="stat-value" style="font-size:1.25rem;font-weight:700;">{{ $totalAuctions }}</span>
            <span class="stat-label" style="display:block;font-size:0.98rem;">Total</span>
        </div>
        <div style="width:1px;height:32px;background:rgba(255,255,255,0.25);"></div>
        <div style="flex:1;text-align:center;">
            <span class="stat-value" style="font-size:1.25rem;font-weight:700;">{{ $activeCount }}</span>
            <span class="stat-label" style="display:block;font-size:0.98rem;">Active</span>
        </div>
        <div style="width:1px;height:32px;background:rgba(255,255,255,0.25);"></div>
        <div style="flex:1;text-align:center;">
            <span class="stat-value" style="font-size:1.25rem;font-weight:700;">{{ $soldCount }}</span>
            <span class="stat-label" style="display:block;font-size:0.98rem;">Sold</span>
        </div>
    </div>

    <!-- Filter Buttons -->
    <div style="display:flex;gap:12px;justify-content:center;margin:13px auto 1.2rem;max-width:500px;">
        <button id="btn-active" class="auction-filter-btn active" style="flex:1;padding:0.85rem;background:rgba(255,255,255,0.13);border:none;border-radius:10px;font-weight:600;color:#fff;">Active</button>
        <button id="btn-completed" class="auction-filter-btn" style="flex:1;padding:0.85rem;background:rgba(255,255,255,0.13);border:none;border-radius:10px;font-weight:600;color:#fff;">Completed</button>
    </div>
</div>


<!-- ================= Auctions List Card ================= -->
<div class="track-auctions-container" style="max-width:500px;margin:-60px auto 40px;background:#fff;border-radius:16px;box-shadow:0 2px 8px rgba(0,0,0,0.06);padding:1.5rem 1rem;">

    @if(($activeAuctions->isEmpty() ?? true) && ($completedAuctions->isEmpty() ?? true))
    <div style="text-align:center;padding:2rem;">
        <h3>No NFTs Yet</h3>
        <p>Buy NFTs and start bidding today.</p>
        <a href="{{ route('auction.index') }}" style="padding:0.7rem 1.5rem;background:#0ea5e9;color:#fff;border-radius:8px;text-decoration:none;">Go to Auctions</a>
    </div>
    @else

    <div id="auction-list" style="display:flex;flex-direction:column;gap:1.2rem;">
        @foreach($activeAuctions as $auction)
        <div class="auction-card" data-status="Live" style="border:1px solid #e5e7eb;border-radius:10px;padding:1rem;background:#f9fafb;display:flex;align-items:center;gap:1rem;">
            <img src="{{ $auction->nft->image }}" width="60" height="60" style="object-fit:cover;border-radius:8px;">
            <div style="flex:1;">
                <strong>{{ $auction->nft->name }}</strong><br>
                Start: {{ number_format($auction->starting_price,2) }} USDT<br>
                Highest: {{ number_format($auction->highest_bid,2) }} USDT
            </div>
            <a href="{{ route('auction',['id'=>$auction->id]) }}" style="background:#0ea5e9;color:#fff;padding:0.5rem 1rem;border-radius:7px;text-decoration:none;">View</a>
        </div>
        @endforeach
    </div>

    <div id="completed-auction-list" style="display:flex;flex-direction:column;gap:1.2rem;margin-top:2rem;">
        @foreach($completedAuctions as $auction)
        <div class="auction-card" data-status="Ended" style="border:1px solid #e5e7eb;border-radius:10px;padding:1rem;background:#f3f4f6;display:flex;align-items:center;gap:1rem;">
            <img src="{{ $auction->nft->image }}" width="60" height="60" style="object-fit:cover;border-radius:8px;">
            <div style="flex:1;">
                <strong>{{ $auction->nft->name }}</strong><br>
                Sold for: {{ number_format($auction->highest_bid,2) }} USDT
            </div>
            <a href="{{ route('auction',['id'=>$auction->id]) }}" style="background:#22c55e;color:#fff;padding:0.5rem 1rem;border-radius:7px;text-decoration:none;">View</a>
        </div>
        @endforeach
    </div>

    @endif
</div>


<!-- ================= Filter Script ================= -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnActive = document.getElementById('btn-active');
        const btnCompleted = document.getElementById('btn-completed');
        const cards = document.querySelectorAll('.auction-card');

        btnActive.onclick = () => {
            btnActive.classList.add('active');
            btnCompleted.classList.remove('active');
            cards.forEach(c => c.style.display = c.dataset.status === 'Live' ? 'flex' : 'none');
        };

        btnCompleted.onclick = () => {
            btnCompleted.classList.add('active');
            btnActive.classList.remove('active');
            cards.forEach(c => c.style.display = c.dataset.status === 'Ended' ? 'flex' : 'none');
        };

        btnActive.click();
    });
</script>

@endsection