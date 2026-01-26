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
</style>
@endpush

<!-- Summary Card -->
<div class="total-card"
    style="margin:70px 10px;background:linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);border-radius:14px;padding:1.1rem 1.2rem 0.7rem 1.2rem;box-shadow:0 2px 8px rgba(14,165,233,0.10);color:#fff;">
    <style>
        .total-car .total-card * {
            color: #fff !important;
        }
    </style>
    <div class="top" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.7rem;">
        <div class="info" style="font-weight:600;font-size:1.08rem;display:flex;align-items:center;gap:0.5rem;">Auction Summary <img src="/icons/info.svg" alt="Info" class="icon-sm icon-white" style="width:18px;height:18px;filter:invert(1);"></div>
    </div>
    <div class="stats-row" style="display:flex;align-items:center;justify-content:space-between;gap:1.2rem;">
        <div class="stat-item" style="flex:1;text-align:center;">
            <span class="stat-value" style="font-size:1.25rem;font-weight:700;color: #ffff;">{{ $totalAuctions ?? 5 }}</span>
            <span class="stat-label" style="display:block;font-size:0.98rem;font-weight:500;opacity:0.9;color: #ffff;">Total</span>
        </div>
        <div class="stat-divider" style="width:1px;height:32px;background:rgba(255,255,255,0.25);"></div>
        <div class="stat-item" style="flex:1;text-align:center;">
            <span class="stat-value pending" style="font-size:1.25rem;font-weight:700;color: #ffff;">{{ $activeCount ?? 2 }}</span>
            <span class="stat-label" style="display:block;font-size:0.98rem;font-weight:500;opacity:0.9;color: #ffff;">Active</span>
        </div>
        <div class="stat-divider" style="width:1px;height:32px;background:rgba(255,255,255,0.25);"></div>
        <div class="stat-item" style="flex:1;text-align:center;">
            <span class="stat-value completed" style="font-size:1.25rem;font-weight:700;color: #ffff;">{{ $soldCount ?? 3 }}</span>
            <span class="stat-label" style="display:block;font-size:0.98rem;font-weight:500;opacity:0.9;color: #ffff;">Sold</span>
        </div>
    </div>

    <!-- Filter Buttons -->
    <div class="auction-filter-btns" style="display:flex;gap:12px;justify-content:center;margin:13px auto 1.2rem auto;max-width:500px;width:100%;">
        <button id="btn-active" class="auction-filter-btn active" style="flex:1;padding:0.85rem 0;background:rgba(255,255,255,0.13);border:none;border-radius:10px;font-weight:600;font-size:1.08rem;color:#fff;transition:background 0.18s;">Active</button>
        <button id="btn-completed" class="auction-filter-btn" style="flex:1;padding:0.85rem 0;background:rgba(255,255,255,0.13);border:none;border-radius:10px;font-weight:600;font-size:1.08rem;color:#fff;transition:background 0.18s;">Completed</button>
    </div>
    <style>
        .auction-filter-btns {
            max-width: 500px;
            width: 100%;
        }

        .auction-filter-btn {
            box-sizing: border-box;
        }

        .auction-filter-btn.active,
        .auction-filter-btn:focus {
            background: #fff !important;
            color: #2563eb !important;
        }

        @media (max-width: 600px) {
            .auction-filter-btns {
                max-width: 100%;
                gap: 7px;
            }

            .auction-filter-btn {
                font-size: 1rem;
                padding: 0.7rem 0;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnActive = document.getElementById('btn-active');
            const btnCompleted = document.getElementById('btn-completed');
            const cards = document.querySelectorAll('.auction-card');
            btnActive.addEventListener('click', function() {
                btnActive.classList.add('active');
                btnCompleted.classList.remove('active');
                cards.forEach(card => {
                    card.style.display = card.getAttribute('data-status') === 'Live' ? 'flex' : 'none';
                });
            });
            btnCompleted.addEventListener('click', function() {
                btnCompleted.classList.add('active');
                btnActive.classList.remove('active');
                cards.forEach(card => {
                    card.style.display = card.getAttribute('data-status') === 'Ended' ? 'flex' : 'none';
                });
            });
            // Default: show only active
            btnActive.click();
        });
    </script>
</div>

@section('content')
<div class="track-auctions-container"
    style="max-width:500px;margin:-7.8rem 2px;padding:1.5rem 1rem;background:#fff;border-radius:16px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">

    @if($auctions->isEmpty())
    <div class="empty-state" style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2.5rem 1.2rem 2.2rem 1.2rem;background:#f9fafb;border-radius:18px;box-shadow:0 2px 8px rgba(0,0,0,0.06);margin:2.5rem auto 1.5rem auto;max-width:350px;">
        <img src="/icons/gift.svg" alt="No NFTs" class="empty-icon" style="width:70px;height:70px;margin-bottom:1.2rem;">
        <h3 style="font-size:1.25rem;font-weight:700;margin-bottom:0.7rem;color:#222;">No NFTs Yet</h3>
        <p style="color:#666;font-size:1.07rem;margin-bottom:1.2rem;text-align:center;">Buy NFTs from the marketplace. Hold them and sell when the value increases!</p>
        <a href="{{ route('auction.index') }}" class="browse-btn" style="display:inline-block;padding:0.85rem 2.1rem;background:linear-gradient(90deg,#0ea5e9 0%,#22c55e 100%);color:#fff;font-weight:600;font-size:1.08rem;border-radius:8px;text-decoration:none;box-shadow:0 2px 8px rgba(14,165,233,0.10);transition:background 0.18s;">Go to Auctions</a>
    </div>
    @else
    <div id="no-completed-auctions" style="display:none;max-width:500px;margin:0 auto 1.2rem auto;background:rgba(255,255,255,0.13);border-radius:10px;padding:1.2rem;text-align:center;color:#fff;font-weight:600;font-size:1.08rem;">No completed auctions yet.</div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnActive = document.getElementById('btn-active');
            const btnCompleted = document.getElementById('btn-completed');
            const cards = document.querySelectorAll('.auction-card');
            const noCompleted = document.getElementById('no-completed-auctions');
            btnActive.addEventListener('click', function() {
                btnActive.classList.add('active');
                btnCompleted.classList.remove('active');
                let any = false;
                cards.forEach(card => {
                    if (card.getAttribute('data-status') === 'Live') {
                        card.style.display = 'flex';
                        any = true;
                    } else {
                        card.style.display = 'none';
                    }
                });
                noCompleted.style.display = 'none';
            });
            btnCompleted.addEventListener('click', function() {
                btnCompleted.classList.add('active');
                btnActive.classList.remove('active');
                let any = false;
                cards.forEach(card => {
                    if (card.getAttribute('data-status') === 'Ended') {
                        card.style.display = 'flex';
                        any = true;
                    } else {
                        card.style.display = 'none';
                    }
                });
                noCompleted.style.display = any ? 'none' : 'block';
            });
            // Default: show only active
            btnActive.click();
        });
    </script>
    <div id="no-completed-auctions" style="display:none;max-width:500px;margin:0 auto 1.2rem auto;background:rgba(255,255,255,0.13);border-radius:10px;padding:1.2rem;text-align:center;color:#fff;font-weight:600;font-size:1.08rem;">No completed auctions yet.</div>

    @endpush
    @endif
</div>

@endsection