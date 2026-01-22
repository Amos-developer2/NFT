<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdrawal History</title>
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/css/withdrawal-history.css">
</head>

<body>
    <div class="mobile-container">
        <!-- Page Header -->
        @include('partials.header', ['title' => 'Withdrawals history'])



        <!-- Summary Card -->
        <div class="total-card">
            <div class="top">
                <div class="info">Withdrawal History <img src="/icons/info.svg" alt="Info" class="icon-sm icon-white"></div>
            </div>
            <div class="stats-row">
                <div class="stat-item">
                    <span class="stat-value">{{ $totalWithdrawals ?? 5 }}</span>
                    <span class="stat-label">Total</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-value pending">{{ $pendingCount ?? 2 }}</span>
                    <span class="stat-label">Pending</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-value completed">{{ $completedCount ?? 3 }}</span>
                    <span class="stat-label">Completed</span>
                </div>
            </div>
        </div>



        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <button class="tab-btn active" data-filter="all">All</button>
            <button class="tab-btn" data-filter="pending">Pending</button>
            <button class="tab-btn" data-filter="completed">Completed</button>
            <button class="tab-btn" data-filter="failed">Failed</button>
        </div>

        <!-- Withdrawals List -->
        <div class="history-list">
            @if(session('success'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        toast: true,
                        position: 'center',
                        icon: 'success',
                        title: @json(session('success')),
                        iconColor: 'white',
                        customClass: {
                            popup: 'colored-toast'
                        },
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true
                    });
                });
            </script>
            @endif
            @if($errors && $errors->any())
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        toast: true,
                        position: 'center',
                        icon: 'error',
                        title: @json(implode("\n", $errors -> all())),
                        iconColor: 'white',
                        customClass: {
                            popup: 'colored-toast'
                        },
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true
                    });
                });
            </script>
            @endif
            <style>
                .colored-toast {
                    background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%) !important;
                    color: #fff !important;
                    font-weight: 700;
                    font-size: 1rem;
                    border-radius: 12px;
                    box-shadow: 0 4px 16px rgba(37, 99, 235, 0.18);
                }
            </style>

            <!-- Sample Pending Withdrawal -->
            <div class="history-item" data-status="pending">
                <div class="item-left">
                    <div class="item-icon pending">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12,6 12,12 16,14"></polyline>
                        </svg>
                    </div>
                    <div class="item-info">
                        <div class="item-title">Withdrawal</div>
                        <div class="item-meta">
                            <span class="network-tag">TRC20</span>
                            <span class="item-date">Jan 19, 2026 • 2:30 PM</span>
                        </div>
                    </div>
                </div>
                <div class="item-right">
                    <div class="item-amount">-$150.00</div>
                    <div class="item-status pending">Pending</div>
                </div>
            </div>

            <!-- Sample Pending Withdrawal 2 -->
            <div class="history-item" data-status="pending">
                <div class="item-left">
                    <div class="item-icon pending">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12,6 12,12 16,14"></polyline>
                        </svg>
                    </div>
                    <div class="item-info">
                        <div class="item-title">Withdrawal</div>
                        <div class="item-meta">
                            <span class="network-tag">BEP20</span>
                            <span class="item-date">Jan 19, 2026 • 1:15 PM</span>
                        </div>
                    </div>
                </div>
                <div class="item-right">
                    <div class="item-amount">-$75.50</div>
                    <div class="item-status pending">Pending</div>
                </div>
            </div>

            <!-- Sample Completed Withdrawal -->
            <div class="history-item" data-status="completed">
                <div class="item-left">
                    <div class="item-icon completed">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20,6 9,17 4,12"></polyline>
                        </svg>
                    </div>
                    <div class="item-info">
                        <div class="item-title">Withdrawal</div>
                        <div class="item-meta">
                            <span class="network-tag">TRC20</span>
                            <span class="item-date">Jan 18, 2026 • 4:45 PM</span>
                        </div>
                    </div>
                </div>
                <div class="item-right">
                    <div class="item-amount">-$200.00</div>
                    <div class="item-status completed">Completed</div>
                </div>
            </div>

            <!-- Sample Completed Withdrawal 2 -->
            <div class="history-item" data-status="completed">
                <div class="item-left">
                    <div class="item-icon completed">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20,6 9,17 4,12"></polyline>
                        </svg>
                    </div>
                    <div class="item-info">
                        <div class="item-title">Withdrawal</div>
                        <div class="item-meta">
                            <span class="network-tag">BEP20</span>
                            <span class="item-date">Jan 17, 2026 • 10:20 AM</span>
                        </div>
                    </div>
                </div>
                <div class="item-right">
                    <div class="item-amount">-$500.00</div>
                    <div class="item-status completed">Completed</div>
                </div>
            </div>

            <!-- Sample Failed Withdrawal -->
            <div class="history-item" data-status="failed">
                <div class="item-left">
                    <div class="item-icon failed">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                    <div class="item-info">
                        <div class="item-title">Withdrawal</div>
                        <div class="item-meta">
                            <span class="network-tag">TRC20</span>
                            <span class="item-date">Jan 15, 2026 • 8:00 AM</span>
                        </div>
                    </div>
                </div>
                <div class="item-right">
                    <div class="item-amount">-$50.00</div>
                    <div class="item-status failed">Failed</div>
                </div>
            </div>

            <!-- Empty State (hidden by default) -->
            <div class="empty-state" style="display: none;">
                <div class="empty-icon">📭</div>
                <div class="empty-title">No withdrawals found</div>
                <div class="empty-text">Your withdrawal history will appear here</div>
            </div>
        </div>

        <!-- New Withdrawal Button -->
        <div class="action-container">
            <a href="{{ route('user.withdrawal') }}" class="btn btn-primary btn-block">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                New Withdrawal
            </a>
        </div>

        <!-- Footer -->
        @include('partials.footer')
        <div class="pb-20"></div>
    </div>

    <script>
        // Filter tabs functionality
        const tabs = document.querySelectorAll('.tab-btn');
        const items = document.querySelectorAll('.history-item');
        const emptyState = document.querySelector('.empty-state');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Update active tab
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                const filter = tab.dataset.filter;
                let visibleCount = 0;

                items.forEach(item => {
                    if (filter === 'all' || item.dataset.status === filter) {
                        item.style.display = 'flex';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Show empty state if no items
                if (visibleCount === 0) {
                    emptyState.style.display = 'flex';
                } else {
                    emptyState.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>