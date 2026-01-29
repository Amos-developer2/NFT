@extends('layouts.app')

@section('title','24/7 Support Center')

@push('styles')
<style>
    body {
        background: linear-gradient(180deg, #f8fafc, #eef2ff);
        font-family: 'Inter', sans-serif;
        color: #0f172a;
    }

    .support-wrapper {
        max-width: 720px;
        margin: 40px auto 80px;
        padding: 28px 18px 40px;
        border-radius: 24px;
        background: #ffffff;
        box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
        animation: fadeUp .6s ease;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(25px)
        }

        to {
            opacity: 1;
            transform: translateY(0)
        }
    }

    .support-header {
        text-align: center;
        margin-bottom: 22px;
    }

    .support-title {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(90deg, #2563eb, #7c3aed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .support-sub {
        font-size: .95rem;
        color: #64748b;
        margin-top: 6px;
    }

    /* STATUS */
    .status-bar {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 10px;
        font-size: .85rem;
        font-weight: 600;
    }

    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #22c55e;
        box-shadow: 0 0 10px #22c55e;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(.9)
        }

        50% {
            transform: scale(1.2)
        }

        100% {
            transform: scale(.9)
        }
    }

    /* CARDS */
    .support-grid {
        display: grid;
        gap: 14px;
        margin-top: 24px;
    }

    .support-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px;
        border-radius: 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        transition: .25s;
    }

    .support-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, .06);
    }

    .support-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #2563eb, #7c3aed);
        color: #fff;
        font-size: 18px;
    }

    .support-card h4 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
    }

    .support-card p {
        margin: 2px 0 0;
        font-size: .85rem;
        color: #64748b;
    }

    /* SEARCH FAQ */
    .faq-search {
        margin-top: 26px;
    }

    .faq-search input {
        width: 100%;
        padding: 14px;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        font-size: .9rem;
    }

    /* BUTTONS */
    .support-btn,
    .ticket-btn {
        width: 100%;
        padding: 14px;
        border-radius: 14px;
        border: none;
        font-size: 1rem;
        font-weight: 700;
        color: #fff;
        margin-top: 18px;
        cursor: pointer;
        transition: .25s;
    }

    .support-btn {
        background: linear-gradient(90deg, #2563eb, #7c3aed);
        box-shadow: 0 10px 30px rgba(124, 58, 237, .25);
    }

    .ticket-btn {
        background: #0f172a;
    }

    .support-btn:hover,
    .ticket-btn:hover {
        transform: translateY(-2px);
    }

    /* TYPING DOTS */
    .typing {
        margin-top: 12px;
        text-align: center;
        font-size: .9rem;
        color: #64748b;
    }

    .dots span {
        display: inline-block;
        width: 6px;
        height: 6px;
        margin: 0 2px;
        background: #64748b;
        border-radius: 50%;
        animation: blink 1.4s infinite both;
    }

    .dots span:nth-child(2) {
        animation-delay: .2s
    }

    .dots span:nth-child(3) {
        animation-delay: .4s
    }

    @keyframes blink {
        0% {
            opacity: .2
        }

        20% {
            opacity: 1
        }

        100% {
            opacity: .2
        }
    }
</style>
@endpush

@section('content')

<div class="support-wrapper">

    <div class="support-header">
        <div class="support-title">24/7 Customer Support</div>
        <div class="support-sub">We’re always here to help with NFTs, payments, or account issues.</div>

        <div class="status-bar">
            <div class="status-dot"></div>
            <span>Support Agents Online</span>
        </div>
    </div>

    <div class="support-grid">
        <div class="support-card">
            <div class="support-icon">💬</div>
            <div>
                <h4>Live Chat Assistance</h4>
                <p>Instant help from our support team anytime.</p>
            </div>
        </div>

        <div class="support-card">
            <div class="support-icon">⚡</div>
            <div>
                <h4>Fast Response</h4>
                <p>We reply quickly to resolve your issues.</p>
            </div>
        </div>

        <div class="support-card">
            <div class="support-icon">🔒</div>
            <div>
                <h4>Secure Conversations</h4>
                <p>Your chats are private and protected.</p>
            </div>
        </div>
    </div>


    <!-- CHAT BUTTON -->
    <button id="liveChatBtn" class="support-btn" disabled>Loading chat...</button>

</div>


<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/697bbf7135a2d2198418f9a2/1jg5m7m1l';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();

    // Enable chat button when Tawk is ready
    Tawk_API.onLoad = function() {
        var btn = document.getElementById('liveChatBtn');
        if (btn) {
            btn.disabled = false;
            btn.textContent = 'Start Live Chat';
            btn.onclick = function() {
                if (window.Tawk_API && typeof Tawk_API.maximize === 'function') {
                    Tawk_API.maximize();
                }
            };
        }
    };
</script>
<!--End of Tawk.to Script-->

@endsection