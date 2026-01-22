<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/css/home.css">
    <style>
        html,
        body,
        .mobile-container,
        .total-card,
        .stats-row,
        .history-list,
        .settings-container,
        .settings-section,
        .action-item,
        .item-title,
        .item-meta,
        .item-status,
        .btn-primary,
        .tab-btn,
        .stat-label,
        .stat-value,
        .account-card-name,
        .account-card-email,
        .account-card-id {
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif !important;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="mobile-container">
        <!-- Header -->
        <div class="header">
            <div style="display: flex; align-items: center; gap: 8px;">
                <div class="profile-icon">
                    <img src="/icons/user.svg" alt="Profile" width="20" height="20">
                </div>
                <span class="profile-star">
                    <img src="/icons/star.svg" alt="Stars" width="14" height="14" style="filter: invert(76%) sepia(64%) saturate(500%) hue-rotate(359deg) brightness(103%) contrast(104%);">
                    100
                </span>
            </div>
            <div class="balance-box">
                <span class="balance-amount">
                    <img src="/icons/diamond.svg" alt="Balance" width="16" height="16" style="filter: invert(56%) sepia(67%) saturate(500%) hue-rotate(176deg) brightness(96%) contrast(91%);">
                    23,32
                </span>
                <button class="balance-add">
                    <img src="/icons/plus.svg" alt="Add" width="16" height="16">
                </button>
            </div>
        </div>
        <!-- Spacer for fixed header -->
        <div class="header-spacer"></div>

        <!-- Dynamic Content -->
        <div class="content">
            @yield('content')
        </div>

        <!-- Bottom Navigation -->
        @include('partials.footer')
    </div>

    @stack('scripts')
</body>

</html>