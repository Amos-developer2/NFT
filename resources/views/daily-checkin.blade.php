@extends('layouts.app')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
@endpush

@section('content')

<style>
    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background: #dff6ff;
        overflow: hidden;
    }

    /* ===== STADIUM ===== */
    .stadium-bg {
        background: url('/images/stadium.jpg') center/cover no-repeat;
        min-height: 100vh;
        padding: 20px 14px 200px;
        position: relative;
    }

    .stadium-bg::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(255, 255, 255, .8), rgba(255, 255, 255, .96));
    }

    .game-wrap {
        position: relative;
        z-index: 2;
        max-width: 480px;
        margin: auto
    }

    /* ===== TITLE ===== */
    .game-title {
        text-align: center;
        font-size: 1.9rem;
        font-weight: 800;
        color: #1d4ed8;
        margin: 18px 0 6px;
        text-shadow: 0 4px 12px #93c5fd;
    }

    .spin-text {
        text-align: center;
        color: #2563eb;
        font-size: .95rem;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: .5
        }

        50% {
            opacity: 1
        }
    }

    /* ===== CARDS ===== */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 40px;
        perspective: 1000px;
    }

    .reward-card {
        height: 95px;
        border-radius: 14px;
        position: relative;
        transform-style: preserve-3d;
        transition: transform .7s cubic-bezier(.2, .8, .2, 1);
        cursor: pointer;
    }

    .card-inner {
        position: absolute;
        inset: 0;
        border-radius: 14px;
        backface-visibility: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-front {
        background: linear-gradient(145deg, #2563eb, #22d3ee);
        box-shadow: 0 8px 18px #2563eb44;
    }

    .card-front img {
        width: 42px;
        opacity: .9
    }

    .card-back {
        background: #fff;
        transform: rotateY(180deg);
        font-weight: 700;
        color: #2563eb;
    }

    .reward-card.reveal {
        transform: rotateY(180deg) scale(1.05)
    }

    /* glow */
    .reward-card::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 14px;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, .5), transparent);
        animation: shine 3s infinite;
    }

    @keyframes shine {
        0% {
            transform: translateX(-100%)
        }

        100% {
            transform: translateX(100%)
        }
    }

    /* ===== FIELD ===== */
    .field {
        height: 270px;
        background: linear-gradient(to top, #16a34a, #4ade80);
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        box-shadow: inset 0 12px 20px #0003;
    }

    .field::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at center, transparent 70px, rgba(255, 255, 255, .25) 72px, transparent 74px);
    }

    /* ===== BALL ===== */
    .ball {
        width: 110px;
        position: fixed;
        bottom: 90px;
        left: 50%;
        transform: translateX(-50%);
        touch-action: none;
        z-index: 10;
        filter: drop-shadow(0 10px 14px #0004);
    }

    .ball:active {
        transform: translateX(-50%) scale(1.1)
    }

    @media(max-width:420px) {
        .reward-card {
            height: 82px
        }

        .ball {
            width: 95px
        }
    }
</style>

<div class="stadium-bg">
    <div class="game-wrap">

        <div class="game-title">⚽ Flick & Win</div>
        <div class="spin-text">Swipe UP on the ball with power</div>

        <div class="cards-grid" id="cards">
            @for($i=0;$i<9;$i++)
                <div class="reward-card" data-index="{{ $i }}">
                <div class="card-inner card-front">
                    <img src="/images/card-back.png">
                </div>
                <div class="card-inner card-back"></div>
        </div>
        @endfor
    </div>

    <div class="field"></div>

    <img src="/images/ball.png" id="ball" class="ball">

</div>
</div>

<script>
    const ball = document.getElementById('ball');
    const cards = document.querySelectorAll('.reward-card');
    const rewards = ['+1 NFT', '+10 Coins', 'Mystery Box', '+5 Coins', 'Try Again', '+3 Coins', '+2 Coins', '+1 Coin', 'Bonus'];

    let startX, startY, isDragging = false;
    let vx = 0,
        vy = 0,
        gravity = 0.6,
        friction = 0.995;
    let played = false,
        spin = 0;

    function pos(e) {
        return e.touches ? e.touches[0] : e;
    }

    ball.addEventListener('mousedown', startDrag);
    ball.addEventListener('touchstart', startDrag);

    function startDrag(e) {
        if (played) return;
        let p = pos(e);
        startX = p.clientX;
        startY = p.clientY;
        isDragging = true;
    }

    document.addEventListener('mouseup', endDrag);
    document.addEventListener('touchend', endDrag);

    function endDrag(e) {
        if (!isDragging || played) return;
        isDragging = false;

        let p = pos(e.changedTouches ? e.changedTouches[0] : e);
        let dx = p.clientX - startX;
        let dy = startY - p.clientY;
        if (dy < 40) return;

        vx = dx * 0.18;
        vy = -dy * 0.28;
        played = true;
        launch();
    }

    function launch() {
        let rect = ball.getBoundingClientRect();
        let x = rect.left,
            y = rect.top;

        function step() {
            vy += gravity;
            vx *= friction;
            vy *= friction;
            x += vx;
            y += vy;
            spin += 10;

            ball.style.left = x + 'px';
            ball.style.top = y + 'px';
            ball.style.transform = `rotate(${spin}deg)`;

            let hitIndex = detectHit(x, y);
            if (hitIndex !== null) {
                hitCard(hitIndex);
                return;
            }

            requestAnimationFrame(step);
        }
        step();
    }

    /* 🎯 REAL COLLISION DETECTION */
    function detectHit(x, y) {
        let ballRect = ball.getBoundingClientRect();
        for (let i = 0; i < cards.length; i++) {
            let c = cards[i].getBoundingClientRect();
            if (!(ballRect.right < c.left ||
                    ballRect.left > c.right ||
                    ballRect.bottom < c.top ||
                    ballRect.top > c.bottom)) {
                return i;
            }
        }
        return null;
    }

    /* 🎁 Reveal correct card */
    function hitCard(i) {
        fetch('/daily-checkin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                index: i
            })
        }).then(r => r.json()).then(data => {
            let reward = rewards[i];
            let card = cards[i];
            card.querySelector('.card-back').textContent = reward;
            card.classList.add('reveal');

            confetti({
                particleCount: 120,
                spread: 90,
                origin: {
                    y: .6
                }
            });

            Swal.fire({
                title: 'GOAL!!! ⚽🎉',
                text: reward,
                icon: 'success',
                confirmButtonColor: '#2563eb'
            }).then(() => location.reload());
        });
    }
</script>


@endsection