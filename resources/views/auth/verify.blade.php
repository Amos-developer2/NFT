@extends('layouts.auth')

@section('content')

<!-- Header -->
<div class="auth-header-bar">
    <a href="{{ route('register') }}" class="back-btn">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7" />
        </svg>
    </a>
    <h1 class="header-title">Verification</h1>
    <div class="header-spacer"></div>
</div>

<!-- Icon Section -->
<div class="verify-icon-section">
    <div class="verify-icon">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
            <polyline points="22,6 12,13 2,6" />
        </svg>
    </div>
    <h2 class="verify-title">Check Your Email</h2>
    <p class="verify-subtitle">We've sent a 6-digit verification code to</p>
    <p class="verify-email">{{ $email }}</p>
</div>

<!-- Verification Card -->
<div class="auth-card-new">
    @if(session('status'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function showColoredSuccess() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: @json(session('status')),
                    background: '#ecfdf5',
                    color: '#065f46',
                    confirmButtonColor: '#22c55e',
                    iconColor: '#22c55e',
                });
            }
            if (typeof Swal === 'undefined') {
                const swalScript = document.createElement('script');
                swalScript.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
                swalScript.onload = showColoredSuccess;
                document.head.appendChild(swalScript);
            } else {
                showColoredSuccess();
            }
        });
    </script>
    @endif

    @if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function showColoredError() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: @json($errors -> all()).join('<br>'),
                    background: '#fef2f2',
                    color: '#991b1b',
                    confirmButtonColor: '#ef4444',
                    iconColor: '#ef4444',
                });
            }
            if (typeof Swal === 'undefined') {
                const swalScript = document.createElement('script');
                swalScript.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
                swalScript.onload = showColoredError;
                document.head.appendChild(swalScript);
            } else {
                showColoredError();
            }
        });
    </script>
    @endif

    <!-- Preview Code (Development Only - Remove in Production) -->
    @if(isset($preview_code))
    <div class="preview-code-box">
        <span class="preview-label">Development Preview:</span>
        <span class="preview-code">{{ $preview_code }}</span>
    </div>
    @endif

    <form method="POST" action="{{ route('register.verify.submit') }}" class="auth-form-new" id="verifyForm">
        @csrf

        <!-- Code Input -->
        <div class="input-group">
            <label class="input-label text-center">Enter Verification Code</label>
            <div class="code-input-container">
                <input type="text" maxlength="1" class="code-input" data-index="0" inputmode="numeric" pattern="[0-9]*" autofocus>
                <input type="text" maxlength="1" class="code-input" data-index="1" inputmode="numeric" pattern="[0-9]*">
                <input type="text" maxlength="1" class="code-input" data-index="2" inputmode="numeric" pattern="[0-9]*">
                <input type="text" maxlength="1" class="code-input" data-index="3" inputmode="numeric" pattern="[0-9]*">
                <input type="text" maxlength="1" class="code-input" data-index="4" inputmode="numeric" pattern="[0-9]*">
                <input type="text" maxlength="1" class="code-input" data-index="5" inputmode="numeric" pattern="[0-9]*">
            </div>
            <input type="hidden" name="verification_code" id="verificationCode">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn" id="verifyBtn" disabled>
            <span>Verify & Create Account</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                <polyline points="22 4 12 14.01 9 11.01" />
            </svg>
        </button>
    </form>

    <!-- Resend Code -->
    <div class="resend-section">
        <p class="resend-text">Didn't receive the code?</p>
        <form method="POST" action="{{ route('register.resend') }}" class="resend-form">
            @csrf
            <button type="submit" class="resend-btn" id="resendBtn">
                Resend Code
            </button>
        </form>
        <p class="resend-timer" id="resendTimer" style="display: none;">
            Resend available in <span id="countdown">60</span>s
        </p>
    </div>
</div>

<!-- Bottom Decoration -->
<div class="auth-decoration">
    <div class="decoration-circle"></div>
    <div class="decoration-circle small"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const codeInputs = document.querySelectorAll('.code-input');
        const hiddenInput = document.getElementById('verificationCode');
        const verifyBtn = document.getElementById('verifyBtn');
        const resendBtn = document.getElementById('resendBtn');
        const resendTimer = document.getElementById('resendTimer');
        const countdown = document.getElementById('countdown');

        // Handle input
        codeInputs.forEach((input, index) => {
            input.addEventListener('input', function(e) {
                // Only allow numbers
                this.value = this.value.replace(/[^0-9]/g, '');

                if (this.value && index < codeInputs.length - 1) {
                    codeInputs[index + 1].focus();
                }

                updateHiddenInput();
            });

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && index > 0) {
                    codeInputs[index - 1].focus();
                }
            });

            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 6);

                pastedData.split('').forEach((char, i) => {
                    if (codeInputs[i]) {
                        codeInputs[i].value = char;
                    }
                });

                updateHiddenInput();

                if (pastedData.length > 0) {
                    const focusIndex = Math.min(pastedData.length, codeInputs.length - 1);
                    codeInputs[focusIndex].focus();
                }
            });
        });

        function updateHiddenInput() {
            let code = '';
            codeInputs.forEach(input => {
                code += input.value;
            });
            hiddenInput.value = code;
            verifyBtn.disabled = code.length !== 6;
        }

        // Resend timer
        let timerInterval;

        resendBtn.addEventListener('click', function(e) {
            setTimeout(startCountdown, 100);
        });

        function startCountdown() {
            let seconds = 60;
            resendBtn.style.display = 'none';
            resendTimer.style.display = 'block';

            timerInterval = setInterval(() => {
                seconds--;
                countdown.textContent = seconds;

                if (seconds <= 0) {
                    clearInterval(timerInterval);
                    resendBtn.style.display = 'inline';
                    resendTimer.style.display = 'none';
                }
            }, 1000);
        }
    });
</script>
@endsection