<style>
    #login-popup {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(16, 24, 39, 0.65);
        justify-content: center;
        align-items: center;
        animation: fadeInBg 0.4s;
    }

    @keyframes fadeInBg {
        from {
            background: rgba(16, 24, 39, 0);
        }

        to {
            background: rgba(16, 24, 39, 0.65);
        }
    }

    .login-popup-content {
        background: #181f2a;
        border-radius: 18px;
        padding: 36px 26px 28px 26px;
        max-width: 90vw;
        width: 340px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
        text-align: center;
        color: #fff;
        transform: translateY(-40px) scale(0.98);
        opacity: 0;
        animation: popupIn 0.45s cubic-bezier(.68, -0.55, .27, 1.55) forwards;
    }

    @keyframes popupIn {
        to {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
    }

    .login-popup-content h2 {
        margin-bottom: 18px;
        font-size: 1.35rem;
        color: #60a5fa;
        font-weight: 700;
    }

    .login-popup-content p {
        margin-bottom: 24px;
        color: #cbd5e1;
    }

    .login-popup-links {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-bottom: 10px;
    }

    .login-popup-links a {
        border-radius: 8px;
        padding: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.08rem;
        transition: background 0.18s, box-shadow 0.18s;
        box-shadow: 0 2px 8px rgba(16, 24, 39, 0.08);
    }

    .login-popup-links a:nth-child(1) {
        background: #2563eb;
        color: #fff;
    }

    .login-popup-links a:nth-child(2) {
        background: #10b981;
        color: #fff;
    }

    .login-popup-links a:nth-child(3) {
        background: #f59e42;
        color: #fff;
    }

    .login-popup-links a:hover {
        filter: brightness(1.08);
        box-shadow: 0 4px 16px rgba(16, 24, 39, 0.13);
    }

    #close-login-popup {
        margin-top: 24px;
        background: none;
        border: none;
        color: #60a5fa;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: color 0.18s;
    }

    #close-login-popup:hover {
        color: #2563eb;
    }
</style>
<div id="login-popup">
    <div class="login-popup-content">
        <h2>Welcome!</h2>
        <p>Join our community and get support:</p>
        <div class="login-popup-links">
            <a href="https://t.me/officialgroup" target="_blank">Official Group</a>
            <a href="https://t.me/news_channel" target="_blank">News Channel</a>
            <a href="https://t.me/support247" target="_blank">24/7 Support</a>
        </div>
        <button id="close-login-popup">Close</button>
    </div>
</div>
<script>
    (function() {
        document.addEventListener('DOMContentLoaded', function() {
            var popup = document.getElementById('login-popup');
            // Only show on home page and if user is authenticated
            var isHome = window.location.pathname === '/' || window.location.pathname === '/home';
            var isLoggedIn = {
                {
                    Auth::check() ? 'true' : 'false'
                }
            };
            if (popup && isHome && isLoggedIn) {
                popup.style.display = 'flex';
            }
            document.getElementById('close-login-popup').onclick = function() {
                popup.style.display = 'none';
            };
        });
    })();
</script>