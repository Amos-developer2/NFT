@extends('layouts.auth')

@section('content')
<div class="nft-login-wrapper">
    <!-- Animated Background -->
    <div class="nft-bg-effects">
        <div class="nft-grid-overlay"></div>
        <div class="nft-glow-line"></div>
    </div>

    <!-- Header -->
    <div class="nft-header">
        <a href="{{ route('account') }}" class="nft-back-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
        </a>
        <div class="nft-header-badge">
            <span class="badge-dot"></span>
            <span>Account Security</span>
        </div>
    </div>

    <!-- Logo Section -->
    <div class="nft-logo-section">
        <img src="/images/vortex.png" alt="Vortex" class="vortex-logo">
        <p class="nft-tagline">
            <span class="tagline-icon">🔒</span>
            Secure your account
            <span class="tagline-icon">🔒</span>
        </p>
    </div>

    <!-- Password Change Form -->
    <div class="nft-login-form-wrapper">
        <div class="nft-form-header">
            <h2 class="nft-form-title">Change Password</h2>
            <p class="nft-form-subtitle">Update your password for enhanced security</p>
        </div>

        @if(session('success'))
        <div class="nft-alert nft-alert-success">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                <polyline points="22 4 12 14.01 9 11.01" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif
        @if($errors->any())
        <div class="nft-alert nft-alert-error">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
            </svg>
            <span>{!! implode('<br>', $errors->all()) !!}</span>
        </div>
        @endif

        <form action="{{ route('account.password') }}" method="POST" class="nft-login-form">
            @csrf
            @method('PUT')

            <!-- Current Password -->
            <div class="nft-input-group">
                <label for="current_password" class="nft-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    Current Password
                </label>
                <div class="nft-input-wrapper">
                    <svg class="input-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    <input type="password" id="current_password" name="current_password" class="nft-input" required placeholder="Enter current password">
                </div>
            </div>

            <!-- New Password -->
            <div class="nft-input-group">
                <label for="password" class="nft-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    New Password
                </label>
                <div class="nft-input-wrapper">
                    <svg class="input-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    <input type="password" id="password" name="password" class="nft-input" required placeholder="Enter new password">
                </div>
                <span class="form-hint">Minimum 8 characters</span>
            </div>

            <!-- Confirm New Password -->
            <div class="nft-input-group">
                <label for="password_confirmation" class="nft-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    Confirm New Password
                </label>
                <div class="nft-input-wrapper">
                    <svg class="input-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="nft-input" required placeholder="Confirm new password">
                </div>
            </div>

            <!-- Verification Code -->
            <div class="nft-input-group">
                <label for="verification_code" class="nft-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    Verification Code
                </label>
                <div class="nft-input-wrapper" style="display: flex; gap: 8px; align-items: center;">
                    <input type="text" id="verification_code" name="verification_code" maxlength="6" class="nft-input" style="flex:1;" required placeholder="Enter code">
                    <button type="button" class="nft-submit-btn" id="send-code-btn" style="width:auto;min-width:70px;padding:12px 18px;">Send</button>
                </div>
                <span class="form-hint" id="code-hint">Enter your passwords above, then click Send to receive a code by email.</span>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="nft-submit-btn" id="update-password-btn" disabled>
                <span class="btn-bg"></span>
                <span class="btn-content">
                    <span>Update Password</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </span>
            </button>
        </form>
    </div>

    <!-- Security Tips -->
    <div class="nft-login-form-wrapper">
        <div class="nft-form-header">
            <h2 class="nft-form-title" style="font-size:18px;">Password Security Tips</h2>
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

@push('styles')
<style>
    @import url('/css/auth.css');

    .info-list {
        padding-left: 18px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        font-size: 13px;
        color: #374151;
        margin-bottom: 24px;
    }
</style>
@endpush

@push('scripts')
<script>
    // ...existing code...
</script>
@endpush
@endsection
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
    if (currentPassword.value===newPassword.value) {
    errors.push('New password must not be the same as current password.');
    }
    // New password matches confirm
    if (newPassword.value !==confirmPassword.value) {
    errors.push('New password and confirm password do not match.');
    }
    // Verification code
    if (!codeVerified) {
    errors.push('Please enter a valid verification code before changing password.');
    }
    if (errors.length> 0) {
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
                let errorHtml = @json($errors - > all());
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