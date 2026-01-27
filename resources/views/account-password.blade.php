@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="/css/account.css">
@endpush

@section('content')
@include('partials.header', ['title' => 'Password'])
<div class="page-header">
    <a href="{{ route('account') }}" class="back-btn">
        <img src="/icons/arrow-left.svg" alt="Back" width="20" height="20">
    </a>
    <h1 class="page-title">Change Password</h1>
</div>

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
        function showColoredError() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: @json($errors->all()).join('<br>'),
                background: '#020101',
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

<div class="settings-container">
    <div class="settings-section">
        <div class="settings-title">
            <img src="/icons/settings.svg" alt="Password" width="20" height="20">
            <span>Update Password</span>
        </div>
        <form action="{{ route('account.password') }}" method="POST" class="settings-form" id="password-form">
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
            <div class="form-group">
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
    <div class="settings-section">
        <div class="info-box">
            <p>Your password is required for account security. Use a strong password and never share it with anyone.</p>
            <ul class="info-list" style="font-size:0.70rem;">
                <li>At least <strong>8 characters</strong> long</li>
                <li>Mix uppercase, lowercase, numbers, and symbols</li>
                <li>Avoid personal or common words</li>
                <li>Never share your password</li>
                <li>Change it regularly</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
        document.getElementById('password-form').addEventListener('submit', function(e) {
            let errors = [];
            if (!currentPassword.value.trim() || !newPassword.value.trim() || !confirmPassword.value.trim() || !codeInput.value.trim()) {
                errors.push('All fields are required. Please fill in every field.');
            }
            if (newPassword.value.length < 8) {
                errors.push('New password must be at least 8 characters.');
            }
            if (currentPassword.value === newPassword.value) {
                errors.push('New password must not be the same as current password.');
            }
            if (newPassword.value !== confirmPassword.value) {
                errors.push('New password and confirm password do not match.');
            }
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