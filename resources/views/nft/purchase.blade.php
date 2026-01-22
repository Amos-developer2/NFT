<!DOCTYPE html>
<html lang="en">

<head>
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $nft['name'] }} - Purchase</title>
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/css/purchase.css">
</head>

<body>
    @include('partials.header', ['title' => 'NFT Purchase'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: @json(session('error')),
                confirmButtonColor: '#fbbf24', // gold accent
                background: '#1a1a1a', // dark background
                color: '#fee2e2', // error text color
                iconColor: '#f87171', // red icon
                customClass: {
                    popup: 'swal2-nft-popup',
                    title: 'swal2-nft-title',
                    confirmButton: 'swal2-nft-confirm',
                },
            });
            @endif
            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                html: @json(session('success')) + '<br><small>Redirecting to your collection...</small>',
                confirmButtonColor: '#34d399', // green accent
                background: '#1a1a1a', // dark background
                color: '#dcfce7', // success text color
                iconColor: '#34d399', // green icon
                customClass: {
                    popup: 'swal2-nft-popup',
                    title: 'swal2-nft-title',
                    confirmButton: 'swal2-nft-confirm',
                },
                timer: 3000,
                timerProgressBar: true,
                willClose: () => {
                    window.location.href = "{{ route('collection') }}";
                }
            });
            @endif
        });
    </script>
    <div class="mobile-container">
        <!-- Header with Back Button -->


        <!-- NFT Display Card -->
        <div class="nft-display-card">
            <div class="nft-display-bg" style="background: {{ $nft['background'] }};">
                <!-- Pattern Overlay -->
                <div class="pattern-overlay pattern-{{ $nft['backdrop_pattern'] ?? 'money' }}"></div>
                <!-- NFT Image -->
                <div class="nft-display-image">
                    <img src="{{ $nft['image'] }}" alt="{{ $nft['name'] }}">
                </div>
            </div>
            <!-- NFT Title -->
            <div class="nft-display-info">
                <h2 class="nft-display-name">{{ $nft['name'] }}</h2>
                <span class="nft-display-id">#{{ $nft['id'] }}</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="action-btn-round" disabled>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                </svg>
                <span>Send</span>
            </button>
            <button class="action-btn-round" disabled>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <circle cx="12" cy="12" r="8" />
                </svg>
                <span>Set</span>
            </button>
            <button class="action-btn-round" disabled>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z" />
                </svg>
                <span>Sell</span>
            </button>
        </div>

        <!-- NFT Details Table -->
        <div class="nft-details-card">
            <!-- Owner Row -->
            <div class="detail-row">
                <span class="detail-label">Owner</span>
                <div class="detail-value owner">
                    <div class="owner-avatar">
                        <img src="/icons/user.svg" alt="User">
                    </div>
                    <span class="owner-name">You (After Purchase)</span>
                </div>
            </div>

            <!-- Model Row -->
            <div class="detail-row">
                <span class="detail-label">Model</span>
                <div class="detail-value">
                    <span class="detail-name">{{ $nft['model'] ?? $nft['name'] }}</span>
                    <span class="detail-percent">2%</span>
                    <span class="detail-price">{{ number_format($nft['price'], 2) }} USDT</span>
                </div>
            </div>

            <!-- Symbol Row -->
            <div class="detail-row">
                <span class="detail-label">Symbol</span>
                <div class="detail-value">
                    <span class="detail-name">{{ $nft['symbol'] ?? 'Default' }}</span>
                    <span class="detail-percent">2%</span>
                    <span class="detail-price">{{ number_format($nft['price'], 2) }} USDT</span>
                </div>
            </div>

            <!-- Backdrop Row -->
            <div class="detail-row">
                <span class="detail-label">Backdrop</span>
                <div class="detail-value">
                    <span class="detail-name">{{ $nft['backdrop'] ?? 'Standard' }}</span>
                    <span class="detail-percent">2%</span>
                    <span class="detail-price">{{ number_format($nft['price'], 2) }} USDT</span>
                </div>
            </div>

            <!-- Supply Row -->
            <div class="detail-row">
                <span class="detail-label">Supply</span>
                <div class="detail-value">
                    <span class="detail-name bold">{{ $nft['supply'] ?? '100K' }}</span>
                </div>
            </div>

            <!-- Floor Price Row -->
            <div class="detail-row">
                <span class="detail-label">Floor Price</span>
                <div class="detail-value">
                    <span class="detail-name bold">{{ number_format($nft['price'], 2) }} USDT</span>
                </div>
            </div>
        </div>

        <!-- Purchase Section -->
        <div class="purchase-section">
            <div class="purchase-price">
                <span class="price-label">Purchase Price</span>
                <div class="price-amount">
                    <img src="/icons/ton.svg" alt="USDT" class="ton-icon">
                    <span>{{ number_format($nft['price'], 2) }} USDT</span>
                </div>
            </div>
            <form action="{{ route('nft.buy', $nft['id']) }}" method="POST">
                @csrf
                <button type="submit" class="confirm-btn">
                    <span>Confirm Purchase</span>
                </button>
            </form>
        </div>

        <!-- Footer -->
        @include('partials.footer')
        <div class="pb-20"></div>
    </div>
</body>

</html>