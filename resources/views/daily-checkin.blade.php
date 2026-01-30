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
        background: linear-gradient(to bottom, #e0f2fe, #f8fafc);
        overflow-x: hidden;
    }

    /* ===== STADIUM LIGHT SWEEP ===== */
    body::before {
        content: '';
        position: fixed;
        top: -40%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(from 0deg, transparent, #93c5fd33, transparent);
        animation: stadiumLight 8s linear infinite;
        z-index: -1;
    }

    @keyframes stadiumLight {
        to {
            transform: rotate(360deg)
        }
    }

    /* CONTAINER */
    .game-container {
        max-width: 480px;
        margin: auto;
        padding: 14px 14px 120px;
    }

    /* CARDS */
    .cards-area {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .reward-card {
        height: 92px;
        border-radius: 16px;
        position: relative;
        transform-style: preserve-3d;
        transition: transform .7s cubic-bezier(.2, .8, .2, 1);
        animation: float 3s ease-in-out infinite;
    }

    .reward-card:nth-child(odd) {
        animation-delay: .5s
    }

    @keyframes float {
        50% {
            transform: translateY(-5px)
        }
    }

    .card-inner {
        position: absolute;
        inset: 0;
        border-radius: 16px;
        backface-visibility: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-front {
        background: linear-gradient(145deg, #2563eb, #38bdf8);
        box-shadow: 0 10px 20px rgba(37, 99, 235, .3);
    }

    .card-back {
        background: #fff;
        transform: rotateY(180deg);
        font-weight: 700;
        color: #2563eb;
    }

    .reward-card.reveal {
        transform: rotateY(180deg) scale(1.1);
    }

    /* TEXT */
    .instruction {
        text-align: center;
        margin: 22px 0 6px;
        font-size: 1.5rem;
        font-weight: 800;
        color: #1d4ed8;
    }

    .subtext {
        text-align: center;
        font-size: .95rem;
        color: #2563eb;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        50% {
            opacity: 1
        }
    }

    /* FIELD */
    .play-area {
        margin-top: 30px;
        height: 280px;
        border-radius: 24px;
        position: relative;
        background: linear-gradient(to top, #bbf7d0, #dcfce7);
        overflow: hidden;
        box-shadow: inset 0 10px 20px rgba(0, 0, 0, .1);
    }

    /* GOAL NET */
    .goal-net {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        height: 150px;
        background-image: repeating-linear-gradient(90deg, transparent, transparent 18px, #fff3 19px, #fff3 20px),
            repeating-linear-gradient(0deg, transparent, transparent 18px, #fff3 19px, #fff3 20px);
        opacity: .35;
    }

    /* BALL */
    .ball {
        width: 90px;
        position: absolute;
        bottom: 16px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 5;
        touch-action: none;
        filter: drop-shadow(0 14px 10px rgba(0, 0, 0, .25));
    }

    /* FIRE TRAIL */
    .ball.fire::after {
        content: '';
        position: absolute;
        width: 60px;
        height: 60px;
        background: radial-gradient(circle, #f97316, #facc15, transparent);
        border-radius: 50%;
        animation: fireTrail .4s infinite;
    }

    @keyframes fireTrail {
        from {
            opacity: .9;
            transform: scale(1)
        }

        to {
            opacity: 0;
            transform: scale(2)
        }
    }

    /* CAMERA SHAKE */
    .shake {
        animation: shake .3s
    }

    @keyframes shake {
        0% {
            transform: translate(0)
        }

        25% {
            transform: translate(-5px, 3px)
        }

        50% {
            transform: translate(5px, -3px)
        }

        75% {
            transform: translate(-4px, 2px)
        }

        100% {
            transform: translate(0)
        }
    }
</style>

<div class="game-container">
    <div class="instruction">⚽ Flick the ball!</div>
    <div class="subtext">Swipe UP to aim your shot</div>

    <div class="cards-area">
        @for($i=0;$i<9;$i++)
            <div class="reward-card" data-index="{{ $i }}">
            <div class="card-inner card-front">
                <img src="/images/card-back.png">
            </div>
            <div class="card-inner card-back"></div>
    </div>
    @endfor
</div>


<div class="play-area" id="field">
    <div class="goal-net"></div>
    <img src="/images/ball.png" id="ball" class="ball">
</div>

</div>

<audio id="cheer" src="/sounds/cheer.mp3"></audio>

<script>
    const field = document.getElementById('field');
    const ball = document.getElementById('ball');
    const cards = document.querySelectorAll('.reward-card');
    const cheer = document.getElementById('cheer');

    let startX, startY, played = false;

    function pos(e) {
        return e.touches ? e.touches[0] : e;
    }

    ball.addEventListener('touchstart', e => {
        if (played) return;
        let p = pos(e);
        startX = p.clientX;
        startY = p.clientY;
    });

    ball.addEventListener('touchend', e => {
        if (played) return;
        let p = pos(e.changedTouches[0]);
        let dx = p.clientX - startX;
        let dy = startY - p.clientY;
        if (dy < 40) return;

        played = true;
        ball.classList.add('fire');

        let col = dx < -50 ? 0 : dx > 50 ? 2 : 1;
        let row = Math.min(Math.floor(dy / 70), 2);
        let index = row * 3 + col;

        shootToCard(index);
    });

    function shootToCard(i) {
        let cardRect = cards[i].getBoundingClientRect();
        let fieldRect = field.getBoundingClientRect();

        let targetX = cardRect.left - fieldRect.left + cardRect.width / 2 - ball.offsetWidth / 2;
        let targetY = cardRect.top - fieldRect.top + cardRect.height / 2 - ball.offsetHeight / 2;

        ball.style.transition = "all .7s cubic-bezier(.2,.8,.2,1)";
        ball.style.left = targetX + 'px';
        ball.style.top = targetY + 'px';
        ball.style.transform = 'rotate(1080deg)';

        setTimeout(() => hitCard(i), 700);
    }

    function hitCard(i) {
        document.body.classList.add('shake');
        cheer.play();

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
            let card = cards[i];
            card.querySelector('.card-back').textContent = data.reward;
            card.classList.add('reveal');

            // LEGENDARY GOLD EXPLOSION
            if (data.reward.toLowerCase().includes('nft') || data.reward.toLowerCase().includes('legend')) {
                confetti({
                    particleCount: 250,
                    spread: 120,
                    colors: ['#facc15', '#fbbf24', '#fde047']
                });
            } else {
                confetti({
                    particleCount: 140,
                    spread: 100
                });
            }

            Swal.fire({
                    title: 'GOOOAAAL!!! ⚽🔥',
                    text: data.reward,
                    icon: 'success'
                })
                .then(() => location.reload());
        });
    }
</script>

@endsection