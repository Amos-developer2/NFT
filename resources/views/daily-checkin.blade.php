@extends('layouts.app')

@section('content')
<div class="daily-checkin-stadium">
    <div class="stadium-bg"></div>

    <!-- <div class="checkin-header-row">
        <button onclick="window.history.back()" class="back-btn">Back</button>
        <div class="checkin-title-row">
            <span class="checkin-title">
                Kick Ball to Challenge<br>
                <span class="bigger">Bigger Rewards!</span>
            </span>
        </div>
    </div> -->

    <!-- <div class="checkin-grid-area">
        @if($alreadyCheckedIn)
        <div class="already-played-grid">
            <div class="smile-big">😄</div>
            <div class="already-msg">
                You already played today!<br>
                Your reward:
                <span class="reward-highlight">{{ $reward }}</span><br>
                <span class="come-back">Come back tomorrow!</span>
            </div>
        </div>
        @else
        <div class="checkin-grid">
            @for($i = 0; $i < 9; $i++)
                <div class="checkin-card"
                data-reward="{{ $rewards[$i % count($rewards)] }}"
                data-index="{{ $i }}">
                <div class="card-front">
                    <img src="/images/checkin/card-bg.svg" class="card-bg-img">
                </div>
                <div class="card-back">
                    <img src="/images/checkin/trophy.svg" class="reward-icon">
                    <span class="reward-label">{{ $rewards[$i % count($rewards)] }}</span>
                </div>
        </div>
        @endfor
    </div>

    <div class="checkin-message"></div>

    <div class="kick-area">
        <div class="ball" id="ball">
            <img src="/images/checkin/ball.svg" class="kick-ball-img">
        </div>
    </div>
    @endif
</div>
</div> -->


<style>
    .daily-checkin-stadium {
        min-height: 100vh;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        background: linear-gradient(180deg, #0a2e13 0%, #1a4d2e 60%, #2A6CF6 100%);
    }

    .stadium-bg {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, #0a2e13 0%, #1a4d2e 60%, #2A6CF6 100%);
        z-index: 0;
    }

    .checkin-header-row {
        padding: 16px;
        z-index: 2;
        width: 100%;
    }

    .back-btn {
        background: rgba(0, 0, 0, .3);
        color: #fff;
        border-radius: 8px;
        padding: 8px 14px;
        font-weight: bold;
        border: none;
    }

    .checkin-title {
        color: #2A6CF6;
        font-weight: 800;
        font-size: 1.3rem;
        text-shadow: 0 2px 8px rgba(42, 108, 246, 0.12);
    }

    .bigger {
        color: #fbbf24;
        text-shadow: 0 2px 8px rgba(251, 191, 36, 0.12);
    }

    .checkin-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 20px;
        z-index: 2;
        background: rgba(42, 108, 246, 0.04);
        border-radius: 18px;
        box-shadow: 0 2px 12px rgba(42, 108, 246, 0.08);
        padding: 18px 10px 10px 10px;
        max-width: 370px;
    }

    .checkin-card {
        width: 90px;
        height: 90px;
        position: relative;
        transform-style: preserve-3d;
        transition: transform .6s;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(42, 108, 246, 0.10);
        border: 2px solid #2A6CF6;
    }

    .checkin-card.flipped {
        transform: rotateY(180deg);
    }

    .card-front,
    .card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        border-radius: 12px;
    }

    .card-front {
        background: #2A6CF6;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-back {
        transform: rotateY(180deg);
        background: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border: 2px solid #22c55e;
    }

    .card-bg-img {
        width: 60%;
        opacity: .6;
    }

    .reward-icon {
        width: 36px;
    }

    .reward-label {
        font-weight: 700;
        color: #22c55e;
        font-size: 1.1em;
    }

    .checkin-message {
        margin: 18px 0;
        font-weight: 800;
        color: #22c55e;
        z-index: 2;
        text-shadow: 0 2px 8px rgba(34, 197, 94, 0.12);
    }

    .kick-area {
        position: relative;
        width: 100%;
        height: 200px;
        background: rgba(42, 108, 246, 0.04);
        border-radius: 12px;
    }

    .ball {
        width: 64px;
        height: 64px;
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translate(-50%, 0);
        touch-action: none;
        cursor: grab;
        z-index: 10;
        background: #fff;
        border: 2px solid #2A6CF6;
        box-shadow: 0 2px 8px rgba(42, 108, 246, 0.10);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .kick-ball-img {
        width: 100%;
    }

    .already-played-grid {
        margin-top: 40px;
        text-align: center;
        color: #fff;
    }

    .reward-highlight {
        color: #fbbf24;
        font-weight: 800;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(!$alreadyCheckedIn)

        let picked = false;
        const ball = document.getElementById('ball');
        const cards = document.querySelectorAll('.checkin-card');
        const message = document.querySelector('.checkin-message');
        const stadium = document.querySelector('.daily-checkin-stadium');

        let dragging = false;
        let offsetX = 0,
            offsetY = 0;
        let currentX = 0,
            currentY = 0;

        function getPos(e) {
            return e.type.includes('touch') ?
                {
                    x: e.touches[0].clientX,
                    y: e.touches[0].clientY
                } :
                {
                    x: e.clientX,
                    y: e.clientY
                };
        }

        function setBallPosition(x, y) {
            ball.style.transform = `translate(${x}px, ${y}px)`;
            currentX = x;
            currentY = y;
        }

        ball.addEventListener('mousedown', start);
        ball.addEventListener('touchstart', start);

        function start(e) {
            if (picked) return;
            dragging = true;

            const pos = getPos(e);
            const rect = ball.getBoundingClientRect();

            offsetX = pos.x - rect.left;
            offsetY = pos.y - rect.top;

            ball.style.transition = 'none';
        }

        window.addEventListener('mousemove', move);
        window.addEventListener('touchmove', move);

        function move(e) {
            if (!dragging || picked) return;

            const pos = getPos(e);
            const sRect = stadium.getBoundingClientRect();

            let x = pos.x - sRect.left - offsetX;
            let y = pos.y - sRect.top - offsetY;

            // Boundaries
            x = Math.max(0, Math.min(x, sRect.width - ball.offsetWidth));
            y = Math.max(0, Math.min(y, sRect.height - ball.offsetHeight));

            setBallPosition(x, y);
        }

        window.addEventListener('mouseup', end);
        window.addEventListener('touchend', end);

        function end() {
            if (!dragging || picked) return;
            dragging = false;

            const ballRect = ball.getBoundingClientRect();
            let hit = null;

            cards.forEach(card => {
                const r = card.getBoundingClientRect();
                if (!(r.right < ballRect.left || r.left > ballRect.right || r.bottom < ballRect.top || r.top > ballRect.bottom)) {
                    hit = card;
                }
            });

            if (!hit) {
                // return to start position smoothly
                ball.style.transition = 'transform .5s ease';
                setBallPosition(0, 0);
                return;
            }

            picked = true;
            hit.classList.add('flipped');

            const reward = hit.dataset.reward;
            message.textContent = "You won: " + reward + " 🎉";

            fetch("{{ route('daily.checkin.submit') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({
                    index: hit.dataset.index
                })
            });

            ball.style.opacity = 0;
        }
        @endif
    });
</script>

@endsection