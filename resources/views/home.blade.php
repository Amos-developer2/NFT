    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-nft-popup {
            border-radius: 16px !important;
            box-shadow: 0 4px 32px 0 #0008 !important;
        }

        .swal2-nft-title {
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif !important;
            font-weight: 700 !important;
            letter-spacing: 0.01em;
        }

        .swal2-nft-confirm {
            border-radius: 8px !important;
            font-weight: 600 !important;
            font-size: 1.1em !important;
            padding: 0.6em 2em !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: @json(session('error')),
                confirmButtonColor: '#fbbf24',
                background: '#1a1a1a',
                color: '#fee2e2',
                iconColor: '#f87171',
                customClass: {
                    popup: 'swal2-nft-popup',
                    title: 'swal2-nft-title',
                    confirmButton: 'swal2-nft-confirm',
                },
            });
            @endif
        });
    </script>
    @extends('layouts.app')

    @section('content')
    <!-- Balance Card -->
    <div class="balance-card">
        <div class="balance-card-header">
            <div class="balance-label">
                <img src="/icons/wallet.svg" alt="Wallet" width="18" height="18">
                <span>Total Balance</span>
            </div>
            <button class="refresh-btn" aria-label="Refresh" onclick="location.reload()">
                <img src="/icons/settings.svg" alt="Settings" width="16" height="16">
            </button>
        </div>
        <div class="balance-amount-large">
            <span class="currency" style="font-size:2em;vertical-align:baseline;">$</span>
            <span class="amount" style="font-size:2em;">{{ number_format(Auth::user()->balance ?? 0, 2) }}</span>
        </div>
        <div class="balance-crypto">
            <img src="/icons/diamond.svg" alt="USDT" width="14" height="14">
            <span>{{ number_format($userStats['balance'] ?? 143.67, 2) }} USDT</span>
            <span class="badge-stars">
                <img src="/icons/star.svg" alt="Stars" width="12" height="12">
                {{ $userStats['stars'] ?? 100 }}
            </span>
        </div>
        <div class="balance-actions">
            <a href="{{ route('user.deposit') }}" class="action-btn deposit">Deposit</a>
            <a href="{{ route('user.withdrawal') }}" class="action-btn withdraw">Withdraw</a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="quick-stats">
        <div class="stat-item">
            <span class="stat-value">{{ $userStats['nftsOwned'] ?? 12 }}</span>
            <span class="stat-label">NFTs Owned</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <span class="stat-value">${{ number_format($userStats['netWorth'] ?? 0, 2) }}</span>
            <span class="stat-label">Net Worth</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <span class="stat-value" style="color: {{ ($userStats['profit'] ?? 0) >= 0 ? '#22c55e' : '#ef4444' }};">
                {{ ($userStats['profit'] ?? 0) >= 0 ? '+' : '' }}${{ number_format($userStats['profit'] ?? 0, 2) }}
            </span>
            <span class="stat-label">Profit</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <span id="change2m-value" class="stat-value" style="color: #a1a1aa; font-weight: 600;">
                <span id="change2m-arrow"></span><span id="change2m-sign"></span><span id="change2m-num">{{ number_format($userStats['change24h'] ?? 0, 2) }}</span>%
            </span>
            <span class="stat-label">2m Change</span>
        </div>
        <script>
            function updateChange2m() {
                fetch('/api/portfolio-change')
                    .then(res => res.json())
                    .then(data => {
                        let change = parseFloat(data.change24h || 0);
                        let isUp = change > 0;
                        let isDown = change < 0;
                        let arrow = isUp ? '▲' : (isDown ? '▼' : '');
                        let color = isUp ? '#22c55e' : (isDown ? '#ef4444' : '#a1a1aa');
                        let sign = isUp ? '+' : '';
                        document.getElementById('change2m-value').style.color = color;
                        document.getElementById('change2m-arrow').textContent = arrow;
                        document.getElementById('change2m-sign').textContent = sign;
                        document.getElementById('change2m-num').textContent = change.toFixed(2);
                    });
            }
            setInterval(updateChange2m, 15000); // Poll every 15 seconds
        </script>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <span class="stat-value">{{ count($nfts ?? []) }}</span>
            <span class="stat-label">Available</span>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="search-section">
        <div class="search-bar">
            <img src="/icons/search.svg" alt="Search" width="18" height="18" class="search-icon">
            <input type="text" placeholder="Search NFTs..." class="search-input-new" id="nftSearch" />
            <button class="filter-btn">
                <img src="/icons/filter.svg" alt="Filter" width="18" height="18">
            </button>
        </div>
        <div class="filter-chips">
            <button class="chip active" data-filter="all">Trend NFTs</button>
            <button class="chip" data-filter="Common">Top Sellers</button>
            <button class="chip" data-filter="Rare">Recently Viewed</button>
            <button class="chip" data-filter="Epic">Categories</button>
            <button class="chip" data-filter="Legendary">Legendary</button>
        </div>
    </div>

    <!-- Section Header -->
    <div class="section-header">
        <h2 class="section-title">NFT Market</h2>
        <a href="{{ route('collection') }}" class="see-all">My Collection</a>
    </div>

    <!-- NFT Cards Grid -->
    <div class="nft-grid-new">
        @forelse($nfts ?? [] as $nft)
        @php
        $profit = $nft['value'] - $nft['price'];
        $profitPercent = $nft['price'] > 0 ? (($profit / $nft['price']) * 100) : 0;
        @endphp
        <div class="nft-card-new" data-rarity="{{ $nft['rarity'] }}" data-name="{{ strtolower($nft['name']) }}">
            <!-- Image Section -->
            <div class="nft-image-wrapper" style="background: {{ $nft['background'] }};">
                <img src="{{ $nft['image'] }}" alt="{{ $nft['name'] }}" class="nft-image" />
                <!-- Rarity Badge -->
                <span class="nft-badge rarity-{{ strtolower($nft['rarity']) }}">
                    {{ $nft['rarity'] }}
                </span>
                <!-- Potential Profit Badge -->
                <span class="profit-badge">
                    <span class="profit-icon">📈</span>
                    <span>+{{ number_format($profitPercent, 0) }}%</span>
                </span>
            </div>

            <!-- Card Content -->
            <div class="nft-content">
                <!-- Name & ID -->
                <div class="nft-header">
                    <h3 class="nft-name">{{ $nft['name'] }}</h3>
                    <span class="nft-id">#{{ $nft['id'] }}</span>
                </div>

                <!-- Price Display -->
                <div class="nft-price-display">
                    <div class="current-price">
                        <img src="/icons/usdt.svg" alt="USDT" class="ton-icon-sm">
                        <span class="price-label">Net Price: </span>
                        <span class="price-amount">{{ number_format($nft['purchase_price'], 2) }}</span>
                        <span class="price-label">USDT</span>
                    </div>
                    <!-- <div class="potential-value">
                        <span class="value-label">Est. Value</span>
                        <span class="value-amount">{{ number_format($nft['value'], 2) }} USDT</span>
                    </div> -->
                </div>

                <!-- Buy Button -->
                <a href="{{ route('nft.purchase', $nft['id']) }}" class="buy-btn">Buy Now</a>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <p>No NFTs available</p>
        </div>
        @endforelse
    </div>

    <script>
        // Filter functionality
        document.querySelectorAll('.chip').forEach(chip => {
            chip.addEventListener('click', function() {
                document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
                this.classList.add('active');

                const filter = this.dataset.filter;
                document.querySelectorAll('.nft-card-new').forEach(card => {
                    if (filter === 'all' || card.dataset.rarity === filter) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Filter functionality for sections
        document.querySelectorAll('.chip').forEach(chip => {
            chip.addEventListener('click', function() {
                document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
                this.classList.add('active');

                const filter = this.dataset.filter;

                // Hide all sections
                document.querySelectorAll('.trending-nfts, .top-sellers, .recently-viewed, .nft-categories').forEach(section => {
                    section.style.display = 'none';
                });

                // Show the relevant section based on filter
                if (filter === 'all') {
                    document.querySelector('.trending-nfts').style.display = 'block';
                } else if (filter === 'Common') {
                    document.querySelector('.top-sellers').style.display = 'block';
                } else if (filter === 'Rare') {
                    document.querySelector('.recently-viewed').style.display = 'block';
                } else if (filter === 'Epic') {
                    document.querySelector('.nft-categories').style.display = 'block';
                }
            });
        });

        // Search functionality
        document.getElementById('nftSearch').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.nft-card-new').forEach(card => {
                const name = card.dataset.name;
                card.style.display = name.includes(query) ? 'block' : 'none';
            });
        });

        // Carousel functionality for Trending NFTs
        const carousel = document.querySelector('.trending-carousel');
        if (carousel) {
            let isDown = false;
            let startX;
            let scrollLeft;

            carousel.addEventListener('mousedown', (e) => {
                isDown = true;
                carousel.classList.add('active');
                startX = e.pageX - carousel.offsetLeft;
                scrollLeft = carousel.scrollLeft;
            });
            carousel.addEventListener('mouseleave', () => {
                isDown = false;
                carousel.classList.remove('active');
            });
            carousel.addEventListener('mouseup', () => {
                isDown = false;
                carousel.classList.remove('active');
            });
            carousel.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - carousel.offsetLeft;
                const walk = (x - startX) * 3; //scroll-fast
                carousel.scrollLeft = scrollLeft - walk;
            });
        }
    </script>
    @endsection