<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    @stack('head')
    @stack('styles')

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

        /* Preloader Styles */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        #preloader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .preloader-content {
            text-align: center;
        }

        .preloader-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            animation: float 3s ease-in-out infinite;
        }

        .preloader-spinner {
            width: 50px;
            height: 50px;
            margin: 0 auto 20px;
            border: 4px solid rgba(255, 255, 255, 0.2);
            border-top: 4px solid #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .preloader-text {
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 1px;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="preloader-content">
            <img src="{{ asset('images/vortex.png') }}" alt="VortexNFT" class="preloader-logo">
            <div class="preloader-spinner"></div>
            <div class="preloader-text">Loading...</div>
        </div>
    </div>
    <div class="mobile-container">
        @if(!isset($hideHeader) || !$hideHeader)
        <!-- Header -->
        <div class="header">
            <div style="display: flex; align-items: center; gap: 8px;">
                <img src="{{ asset('images/vortex.png') }}" alt="" style="width:80%">
            </div>
            <div class="balance-box">
                <span class="balance-amount" style="margin-bottom:0">
                    <img src="/icons/diamond.svg" alt="Balance" width="16" height="16" style="filter: invert(56%) sepia(67%) saturate(500%) hue-rotate(176deg) brightness(96%) contrast(91%);">
                    {{ Auth::user()->germs }}
                </span>
                <button class="balance-add">
                    <img src="/icons/plus.svg" alt="Add" width="16" height="16">
                </button>
            </div>
        </div>
        <!-- Spacer for fixed header -->
        <div class="header-spacer"></div>
        @endif

        <!-- Dynamic Content -->
        <div class="content">
            @include('partials.login_popup')
            @yield('content')
        </div>

        <!-- Bottom Navigation -->
        @if(!isset($hideFooter) || !$hideFooter)
        @include('partials.footer')
        @endif
    </div>

    @include('partials.native-alert')

    <script>
        // Hide preloader when page is fully loaded
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                setTimeout(function() {
                    preloader.classList.add('hidden');
                }, 500); // Small delay for smooth transition
            }
        });
    </script>

    @stack('scripts')
</body>

</html>