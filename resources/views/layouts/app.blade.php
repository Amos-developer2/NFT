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
            background: #f8fafc;
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
            max-width: 200px;
        }

        .preloader-logo {
            width: 100px;
            height: 100px;
            margin: 0 auto 32px;
            animation: logoFloat 2.5s ease-in-out infinite;
            filter: drop-shadow(0 10px 30px rgba(37, 99, 235, 0.2));
        }

        .preloader-rings {
            width: 60px;
            height: 60px;
            margin: 0 auto 24px;
            position: relative;
        }

        .preloader-rings div {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 3px solid transparent;
            border-top-color: #60a5fa;
            border-radius: 50%;
            animation: ringRotate 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        }

        .preloader-rings div:nth-child(1) {
            animation-delay: -0.45s;
            border-top-color: #2563eb;
        }

        .preloader-rings div:nth-child(2) {
            animation-delay: -0.3s;
            border-top-color: #60a5fa;
        }

        .preloader-rings div:nth-child(3) {
            animation-delay: -0.15s;
            border-top-color: #93c5fd;
        }

        .preloader-text {
            color: #1e293b;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .preloader-subtext {
            color: #64748b;
            font-size: 12px;
            font-weight: 400;
        }

        .preloader-dots {
            display: inline-block;
            animation: dotsPulse 1.4s ease-in-out infinite;
        }

        @keyframes ringRotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-15px) scale(1.05); }
        }

        @keyframes dotsPulse {
            0%, 80%, 100% { opacity: 0; }
            40% { opacity: 1; }
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="preloader-content">
            <img src="{{ asset('images/vortex.png') }}" alt="VortexNFT" class="preloader-logo">
            <div class="preloader-rings">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="preloader-text">Loading VortexNFT<span class="preloader-dots">...</span></div>
            <div class="preloader-subtext">Please wait</div>
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