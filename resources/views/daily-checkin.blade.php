@extends('layouts.app')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')

<style>
    body {
        margin: 0;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: #f8fafc;
        overflow: hidden;
    }

    .stadium-bg {
        background: url('/images/stadium.jpg') center/cover no-repeat;
        min-height: 100vh;
        padding: 20px 14px 160px;
        position: relative;
    }

    .stadium-bg::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(248, 250, 252, 0.85), rgba(248, 250, 252, 0.98));
    }

    .game-wrap {
        position: relative;
        z-index: 2;
        max-width: 480px;
        margin: auto
    }

    .cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 60px
    }

    .reward-card {
        height: 90px;
        border-radius: 12px;
        background: linear-gradient(145deg, #2563eb, #22d3ee);
        box-shadow: 0 0 14px #2563eb33;
        display: flex;
        align-items: center;
        justify-content: center;
        color: transparent;
        font-weight: 700;
        position: relative;
        transition: .6s;
        transform-style: preserve-3d;
    }

    .reward-card::after {
        content: '?';
        color: #fff;
        font-size: 1.8rem;
        text-shadow: 0 2px 8px #2563eb88;
    }

    .reward-card.reveal {
        transform: rotateY(180deg);
        background: #fff;
        color: #2563eb;
    }

    .reward-card.reveal::after {
        display: none;
    }

    .field {
        height: 240px;
        background: linear-gradient(to top, #e0f2fe, #bae6fd);
        border-radius: 14px;
        position: relative;
        overflow: hidden;
    }

    .ball {
        width: 80px;
        position: fixed;
        /* allows true movement */
        bottom: 80px;
        left: 50%;
        transform: translateX(-50%);
        touch-action: none;
        z-index: 10;
    }

    .game-title {
        text-align: center;
        font-size: 1.7rem;
        color: #2563eb;
        margin: 18px 0;
        text-shadow: 0 0 8px #22d3ee;
    }

    .spin-text {
        text-align: center;
        color: #2563eb;
        margin-top: 14px;
        font-size: .95rem;
    }
</style>

<div class="stadium-bg">
    <div class="game-wrap">

        <div class="cards-grid" id="cards">
            @for($i=0;$i<9;$i++)
                <div class="reward-card" data-index="{{ $i }}">
        </div>
        @endfor
    </div>

    <div class="game-title">Flick The Ball!</div>

    <div class="field" style="border: 2px solid red;">
        <img src="/images/ball.png" id="ball" class="ball">
    </div>

    <div class="spin-text">Swipe UP on the ball with power ⚡</div>

</div>
</div>

<script>
    const ball = document.getElementById('ball');
    const cards = document.querySelectorAll('.reward-card');
    const rewards = ['+1 NFT', '+10 Coins', 'Mystery Box', '+5 Coins', 'Try Again', '+3 Coins', '+2 Coins', '+1 Coin', 'Bonus'];

    let startX, startY, isDragging = false,
        vx = 0,
        vy = 0,
        gravity = 0.5,
        anim, played = false;

    function getPos(e) {
        if (e.touches) return {
            x: e.touches[0].clientX,
            y: e.touches[0].clientY
        };
        return {
            x: e.clientX,
            y: e.clientY
        };
    }

    ball.addEventListener('mousedown', startDrag);
    ball.addEventListener('touchstart', startDrag);

    function startDrag(e) {
        if (played) return;
        const pos = getPos(e);
        startX = pos.x;
        startY = pos.y;
        isDragging = true;
    }

    document.addEventListener('mouseup', endDrag);
    document.addEventListener('touchend', endDrag);

    function endDrag(e) {
        if (!isDragging || played) return;
        isDragging = false;

        const pos = getPos(e.changedTouches ? e.changedTouches[0] : e);
        let dx = pos.x - startX;
        let dy = startY - pos.y;

        if (dy < 30) return; // must swipe upward

        vx = dx * 0.15;
        vy = -dy * 0.2;
        played = true;
        launchBall();
    }

    function launchBall() {
        let rect = ball.getBoundingClientRect();
        let x = rect.left;
        let y = rect.top;

        function step() {
            vy += gravity;
            x += vx;
            y += vy;

            ball.style.left = x + 'px';
            ball.style.top = y + 'px';

            if (y < 150) { // card zone
                cancelAnimationFrame(anim);
                hitCard();
                return;
            }
            anim = requestAnimationFrame(step);
        }
        step();
    }

    function hitCard() {
        let idx = Math.floor(Math.random() * cards.length);

        fetch('/daily-checkin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                index: idx
            })
        }).then(r => r.json()).then(data => {
            let reward = rewards[idx];
            cards[idx].textContent = reward;
            cards[idx].classList.add('reveal');
            Swal.fire('Goal!!! ⚽🎉', reward, 'success');
        });
    }
</script>


@endsection