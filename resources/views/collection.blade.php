<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Collection</title>
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/css/collection.css">
</head>

<body>
    @include('partials.header', ['title' => 'Collection'])

    <!-- Header Spacer -->
    <div class="market-header-spacer"></div>

    <!-- Portfolio Summary -->
    <div class="portfolio-summary">
        <div class="portfolio-stats">
            <div class="stat-box">
                <span class="stat-label">Portfolio Value</span>
                <div class="stat-value">
                    <img src="/icons/usdt.svg" alt="USDT" class="stat-ton">
                    <span>{{ number_format($totalValue, 2) }} USDT</span>
                </div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-box">
                <span class="stat-label">Total P/L</span>
                <div class="stat-value {{ $totalProfit >= 0 ? 'profit' : 'loss' }}">
                    <span>{{ $totalProfit >= 0 ? '+' : '' }}{{ number_format($totalProfit, 2) }}</span>
                </div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-box">
                <span class="stat-label">NFTs Owned</span>
                <div class="stat-value">
                    <span>{{ $totalNfts }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="search-container">
        <div class="search-wrapper">
            <img src="/icons/search.svg" alt="Search" class="search-icon">
            <input type="text" class="search-input" placeholder="Search NFTs">
        </div>
        <button class="filter-btn">
            <img src="/icons/filter.svg" alt="Filter">
        </button>
    </div>

    <!-- Category Tabs -->
    <div class="category-tabs">
        <button class="category-tab active">All NFTs</button>
        <button class="category-tab profit-tab">
            <span class="indicator up"></span>
            Profitable
        </button>
        <button class="category-tab loss-tab">
            <span class="indicator down"></span>
            At Loss
        </button>
        <button class="category-tab">Recent</button>
    </div>

    <!-- NFT Cards List -->
    <div class="nfts-list">
        @forelse($nfts as $nft)
        @php
        $isProfit = $nft['current_price'] >= $nft['bought_price'];
        $changeAmount = $nft['current_price'] - $nft['bought_price'];
        $changePercent = $nft['bought_price'] > 0 ? (($changeAmount / $nft['bought_price']) * 100) : 0;
        $canSell = $nft['can_sell'] ?? true;
        $daysHeld = $nft['days_held'] ?? 0;
        @endphp
        <div class="nft-card {{ $isProfit ? 'card-profit' : 'card-loss' }}" data-status="{{ $isProfit ? 'profit' : 'loss' }}">
            <!-- Left: NFT Image -->
            <div class="nft-image">
                <img src="{{ $nft['image'] }}" alt="{{ $nft['name'] }}" class="nft-img">
                <!-- Days Held Badge -->
                <div class="days-badge">
                    <span>{{ $daysHeld }}d</span>
                </div>
            </div>
            <!-- Right: NFT Details -->
            <div class="nft-details">
                <!-- Name & Change % -->
                <div class="nft-header">
                    <div class="nft-title">
                        <span class="nft-name">{{ $nft['name'] }}</span>
                        <span class="nft-id">#{{ $nft['id'] }}</span>
                    </div>
                    <div class="value-badge {{ $isProfit ? 'up' : 'down' }}">
                        <img id="change-arrow-{{ $nft['id'] }}" src="/icons/{{ $isProfit ? 'arrow-up' : 'arrow-down' }}.svg" alt="">
                        <span id="change-percent-{{ $nft['id'] }}">{{ $isProfit ? '+' : '' }}{{ number_format($changePercent, 1) }}%</span>
                    </div>
                </div>

                <!-- Price Comparison -->
                <div class="price-row">
                    <div class="price-item">
                        <span class="price-label">Bought at</span>
                        <span class="price-value bought"><img src="/icons/usdt.svg" width="14"> {{ number_format($nft['bought_price'], 2) }} USDT</span>
                    </div>
                    <div class="price-arrow">→</div>
                    <div class="price-item">
                        <span class="price-label">Now worth</span>
                        <span class="price-value current {{ $isProfit ? 'up' : 'down' }}"><img src="/icons/usdt.svg" width="14"> <span id="sell-price-{{ $nft['id'] }}">{{ number_format($nft['price'], 2) }}</span> USDT</span>
                    </div>
                </div>

                <!-- Profit/Loss & Sell Button -->
                <div class="action-row">
                    <div class="pl-badge {{ $isProfit ? 'profit' : 'loss' }}">
                        <span class="pl-label">{{ $isProfit ? 'Profit' : 'Loss' }}:</span>
                        <span class="pl-amount" id="pl-amount-{{ $nft['id'] }}">{{ $isProfit ? '+' : '' }}{{ number_format($changeAmount, 2) }} USDT</span>
                    </div>
                    @elseif($canSell && $isProfit)
                    <a href="{{ url('/auction/create/' . $nft['id']) }}" class="sell-btn ready">Sell Now</a>
                    @elseif($canSell)
                    <a href="{{ url('/auction/create/' . $nft['id']) }}" class="sell-btn">Sell</a>
                    @else
                    <button class="sell-btn disabled" disabled>Hold</button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <img src="/icons/gift.svg" alt="No NFTs" class="empty-icon">
            <h3>No NFTs Yet</h3>
            <p>Buy NFTs from the marketplace. Hold them and sell when the value increases!</p>
            <a href="{{ route('home') }}" class="browse-btn">Buy NFTs</a>
        </div>
        @endforelse
    </div>

    <!-- Footer -->
    @include('partials.footer')
    <div class="pb-20"></div>
    </div>

    <script>
        // Dynamic up/down percent demo updater, sell price, and profit/loss updater
        document.addEventListener('DOMContentLoaded', function() {
            setInterval(function() {
                document.querySelectorAll('.nft-card').forEach(function(card) {
                    var id = card.querySelector('.nft-id').textContent.replace('#', '');
                    var bought = parseFloat(card.querySelector('.price-value.bought').textContent.replace(/[^\d.]/g, ''));
                    var percent = (Math.random() * (0.5 - 0.1) + 0.1).toFixed(1);
                    var isUp = Math.random() > 0.5;
                    var arrow = isUp ? 'arrow-up' : 'arrow-down';
                    var sign = isUp ? '+' : '-';
                    var badge = card.querySelector('.value-badge');
                    if (badge) {
                        badge.classList.remove('up', 'down');
                        badge.classList.add(isUp ? 'up' : 'down');
                    }
                    var arrowImg = document.getElementById('change-arrow-' + id);
                    if (arrowImg) {
                        arrowImg.src = '/icons/' + arrow + '.svg';
                    }
                    var percentSpan = document.getElementById('change-percent-' + id);
                    if (percentSpan) {
                        percentSpan.textContent = sign + percent + '%';
                    }
                    // Update sell price
                    var sellPrice = isUp ?
                        bought * (1 + (percent / 100)) :
                        bought * (1 - (percent / 100));
                    var sellPriceSpan = document.getElementById('sell-price-' + id);
                    if (sellPriceSpan) {
                        sellPriceSpan.textContent = sellPrice.toFixed(2);
                    }
                    // Update profit/loss USDT and color
                    var plAmountSpan = document.getElementById('pl-amount-' + id);
                    var plBadge = plAmountSpan ? plAmountSpan.closest('.pl-badge') : null;
                    if (plAmountSpan) {
                        var pl = sellPrice - bought;
                        var plSign = pl > 0 ? '+' : '';
                        plAmountSpan.textContent = plSign + pl.toFixed(2) + ' USDT';
                        if (plBadge) {
                            plBadge.style.color = pl < 0 ? '#ef4444' : '#22c55e';
                        }
                    }
                });
            }, 5000);
        });
        // Category tab functionality with filtering
        document.querySelectorAll('.category-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const cards = document.querySelectorAll('.nft-card');
                const isProfit = this.classList.contains('profit-tab');
                const isLoss = this.classList.contains('loss-tab');

                cards.forEach(card => {
                    if (isProfit) {
                        card.style.display = card.dataset.status === 'profit' ? 'flex' : 'none';
                    } else if (isLoss) {
                        card.style.display = card.dataset.status === 'loss' ? 'flex' : 'none';
                    } else {
                        card.style.display = 'flex';
                    }
                });
            });
        });

        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.nft-card').forEach(card => {
                const name = card.querySelector('.nft-name').textContent.toLowerCase();
                card.style.display = name.includes(query) ? 'flex' : 'none';
            });
        });
    </script>
</body>

</html>