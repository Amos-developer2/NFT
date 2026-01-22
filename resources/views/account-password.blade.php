@extends('layouts.app')

@section('content')

@push('styles')
<link rel="stylesheet" href="/css/account.css">
<style>
    /* =========================
   PAGE LAYOUT
========================= */
    .page-wrapper {
        padding: 16px;
        max-width: 520px;
        margin: 0 auto;
    }



    /* =========================
   HEADER
========================= */
    .page-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        // Enable verification code input after Send
    }

    .page-title {
        font-size: 20px;
        font-weight: 600;
        color: #111827;
    }

    /* =========================
   ALERTS
========================= */
    .alert-success,
    .alert-error {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        padding: 14px;
        border-radius: 14px;
        font-size: 14px;
        margin-bottom: 16px;
    }

    .alert-success {
        background: #ecfdf5;
        color: #065f46;
    }

    .alert-error {
        background: #fef2f2;
        color: #991b1b;
    }


    .alert-error ul {
        padding-left: 18px;
        margin: 0;
    }

    /* =========================
        // Form validation
        document.querySelector('.settings-form').addEventListener('submit', function(e) {
                let errors = [];
                // Check for empty fields
                if (!currentPassword.value.trim() || !newPassword.value.trim() || !confirmPassword.value.trim() || !codeInput.value.trim()) {
                    errors.push('All fields are required. Please fill in every field.');
                }
                // Password length
                if (newPassword.value.length < 8) {
                    errors.push('New password must be at least 8 characters.');
                }
                // New password not same as current
                if (currentPassword.value === newPassword.value) {
                    errors.push('New password must not be the same as current password.');
                }
                // New password matches confirm
                if (newPassword.value !== confirmPassword.value) {
                    errors.push('New password and confirm password do not match.');
                }
                // Verification code
                if (!codeVerified) {
                    errors.push('Please enter a valid verification code before changing password.');
                }
                if (errors.length > 0) {
                    e.preventDefault();
                    // Wait for SweetAlert2 to load
                    function showAlert() {
                        Swal.fire({ icon: 'error', title: 'Error', html: errors.join('<br>') });
                    }
                    if (typeof Swal === 'undefined') {
                        swalScript.onload = showAlert;
                    } else {
                        showAlert();
                    }
                    return false;
                }
        });
   CARD / SECTION
========================= */
    .settings-card {
        background: #ffffff;
        border-radius: 18px;
        window.codeVerified=true;
        padding: 18px;
        box-shadow:
            0 4px 12px rgba(0, 0, 0, 0.04),
            window.codeVerified=false;
        0 1px 3px rgba(0, 0, 0, 0.06);
    }

    .settings-title {
        display: flex;
        align-items: center;
        gap: 10px;
        window.codeVerified=false;
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 14px;

        // Password validation and SweetAlert
        document.querySelector('.settings-form').addEventListener('submit', function(e) {
                // Prevent form submit for client validation
                let errors=[];

                if (currentPassword.value===newPassword.value) {
                    errors.push('New password must not be the same as current password.');
                }

                if (newPassword.value !==confirmPassword.value) {
                    errors.push('New password and confirm password do not match.');
                }

                if ( !window.codeVerified) {
                    errors.push('Please enter a valid verification code before changing password.');
                }

                if (errors.length > 0) {
                    e.preventDefault();

                    // Wait for SweetAlert2 to load
                    if (typeof Swal==='undefined') {
                        swalScript.onload=function() {
                            Swal.fire({
                                icon: 'error', title: 'Error', html: errors.join('<br>')
                            });
                    }

                    ;
                }

                else {
                    Swal.fire({
                        icon: 'error', title: 'Error', html: errors.join('<br>')
                    });
            }

            return false;
        }

        // Success message will be handled server-side after redirect
    });
    color: #111827;
    }

    /* =========================
   FORM
========================= */
    .settings-form {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 500;
        color: #374151;
    }

    .form-group input {
        padding: 12px 14px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        font-size: 14px;
        transition: border .2s ease, box-shadow .2s ease;
    }

    .form-group input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, .15);
    }

    .form-hint {
        font-size: 12px;
        color: #9ca3af;
    }

    /* =========================
   BUTTON
========================= */
    .btn-primary {
        margin-top: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px;
        border-radius: 14px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        box-shadow: 0 6px 16px rgba(37, 99, 235, .35);
    }

    .btn-primary:active {
        transform: scale(.98);
    }

    /* =========================
   INFO LIST
========================= */
    .info-list {
        padding-left: 18px;
        /* margin: 10px; */
        display: flex;
        flex-direction: column;
        gap: 8px;
        font-size: 13px;
        color: #374151;
    }

    /* =========================
   DESKTOP ENHANCEMENTS
========================= */
    @media (min-width: 768px) {
        .page-wrapper {
            padding: 32px;
        }

        .page-title {
            font-size: 22px;
        }
    }
</style>
@endpush

@include('partials.header', ['title' => 'Password'])

<div class="page-wrapper">

    {{-- Header --}}
    <div class="page-header">
        <a href="{{ route('account') }}" class="back-btn">
            <img src="/icons/arrow-left.svg" alt="Back" width="20" height="20">
        </a>
        <h1 class="page-title">Change Password</h1>
    </div>


    {{-- SweetAlert2 for Success/Error --}}
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function showColoredSuccess() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: @json(session('success')),
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
            let errorHtml = @json($errors -> all());
            if (typeof Swal === 'undefined') {
                const swalScript = document.createElement('script');
                swalScript.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
                swalScript.onload = function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: errorHtml.join('<br>')
                    });
                };
                document.head.appendChild(swalScript);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: errorHtml.join('<br>')
                });
            }
        });
    </script>
    @endif

    {{-- Password Form --}}
    <div class="settings-card" style="margin-top: -50px;">
        <div class="settings-title">
            <img src="/icons/settings.svg" width="20" height="20">
            <span>Update Password</span>
        </div>

        <form action="{{ route('account.password') }}" method="POST" class="settings-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" required>
                <span class="form-hint">Minimum 8 characters</span>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="form-group" id="verification-group">
                <label for="verification_code">Verification Code</label>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <input type="text" id="verification_code" name="verification_code" maxlength="6" style="flex:1;" required>
                    <button type="button" class="btn-primary" id="send-code-btn" style="width:auto;min-width:70px;">Send</button>
                </div>
                <span class="form-hint" id="code-hint">Enter your passwords above, then click Send to receive a code by email.</span>
            </div>

            <button type="submit" class="btn-primary" id="update-password-btn" disabled>
                <img src="/icons/check.svg" width="16" height="16">
                Update Password
            </button>
        </form>
    </div>

    {{-- Security Tips --}}
    <div class="settings-card" style="margin-top: 10px;">
        <div class="settings-title">
            <img src="/icons/info.svg" width="20" height="20">
            <span>Password Security Tips</span>
        </div>

        <ul class="info-list">
            <li>At least <strong>8 characters</strong> long</li>
            <li>Mix uppercase, lowercase, numbers, and symbols</li>
            <li>Avoid personal or common words</li>
            <li>Never share your password</li>
            <li>Change it regularly</li>
        </ul>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Load SweetAlert2 if not present
        if (typeof Swal === 'undefined') {
            const swalScript = document.createElement('script');
            swalScript.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
            document.head.appendChild(swalScript);
        }

        const sendBtn = document.getElementById('send-code-btn');
        const codeInput = document.getElementById('verification_code');
        const codeHint = document.getElementById('code-hint');
        const updateBtn = document.getElementById('update-password-btn');
        const currentPassword = document.getElementById('current_password');
        const newPassword = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        let codeVerified = false;

        sendBtn.addEventListener('click', function() {
            sendBtn.disabled = true;
            codeHint.textContent = 'Sending code...';
            fetch("{{ route('account.password.sendCode') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(res => res.json())
                .then(data => {
                    codeInput.disabled = false;
                    codeHint.textContent = 'Code sent! Check your email.';
                    codeInput.focus();
                    sendBtn.disabled = false;
                    // Optionally show SweetAlert for code sent
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Verification Code Sent',
                            text: 'Check your email for the code.'
                        });
                    }
                })
                .catch(() => {
                    codeHint.textContent = 'Failed to send code. Try again.';
                    sendBtn.disabled = false;
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to send code. Try again.'
                        });
                    }
                });
        });

        codeInput.addEventListener('input', function() {
            if (codeInput.value.length === 6) {
                codeHint.textContent = 'Verifying code...';
                fetch("{{ route('account.password.verifyCode') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            code: codeInput.value
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.valid) {
                            codeHint.textContent = 'Code verified! You may now submit.';
                            updateBtn.disabled = false;
                            codeInput.disabled = true;
                            sendBtn.disabled = true;
                            codeVerified = true;
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Code Verified',
                                    text: 'You may now change your password.'
                                });
                            }
                        } else {
                            codeHint.textContent = 'Invalid code. Please check your email.';
                            updateBtn.disabled = true;
                            codeVerified = false;
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Invalid Code',
                                    text: 'Please check your email and enter the correct code.'
                                });
                            }
                        }
                    })
                    .catch(() => {
                        codeHint.textContent = 'Verification failed. Try again.';
                        codeVerified = false;
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Verification Failed',
                                text: 'Try again.'
                            });
                        }
                    });
            } else {
                updateBtn.disabled = true;
                codeVerified = false;
            }
        });

        document.querySelector('.settings-form').addEventListener('submit', function(e) {
            let errors = [];
            // Check for empty fields
            if (!currentPassword.value.trim() || !newPassword.value.trim() || !confirmPassword.value.trim() || !codeInput.value.trim()) {
                errors.push('All fields are required. Please fill in every field.');
            }
            // Password length
            if (newPassword.value.length < 8) {
                errors.push('New password must be at least 8 characters.');
            }
            // New password not same as current
            if (currentPassword.value === newPassword.value) {
                errors.push('New password must not be the same as current password.');
            }
            // New password matches confirm
            if (newPassword.value !== confirmPassword.value) {
                errors.push('New password and confirm password do not match.');
            }
            // Verification code
            if (!codeVerified) {
                errors.push('Please enter a valid verification code before changing password.');
            }
            if (errors.length > 0) {
                e.preventDefault();

                function showAlert() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: errors.join('<br>')
                    });
                }
                if (typeof Swal === 'undefined') {
                    const swalScript = document.createElement('script');
                    swalScript.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
                    swalScript.onload = showAlert;
                    document.head.appendChild(swalScript);
                } else {
                    showAlert();
                }
                return false;
            }
        });
    });
</script>
@endpush
@endsection