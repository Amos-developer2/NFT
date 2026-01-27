@extends('layouts.app')

@section('content')
@push('styles')
<link rel="stylesheet" href="/css/account.css">
@endpush

@include('partials.header', ['title' => 'PIN'])

<!-- Page Header -->
<div class="page-header">
    <a href="{{ route('account') }}" class="back-btn">
        <img src="/icons/arrow-left.svg" alt="Back" width="20" height="20">
    </a>
    <h1 class="page-title">Withdrawal PIN</h1>
</div>

<!-- SweetAlert2 for Success/Error -->
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        nativeAlert(@json(session('success')), {
            type: 'success',
            title: 'Success'
        });
    });
</script>
@endif

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let errorList = @json($errors->all());
        // If only one error and it is 'Current PIN is incorrect.', show as alert
        if (errorList.length === 1 && errorList[0] === 'Current PIN is incorrect.') {
            nativeAlert(errorList[0], {
                type: 'error',
                title: 'Error'
            });
        } else {
            nativeAlert(errorList.join('\n'), {
                type: 'error',
                title: 'Error'
            });
        }
    });
</script>
@endif

<!-- PIN Form -->
<div class="settings-container">
    <div class="settings-section">
        <div class="settings-title">
            <img src="/icons/settings.svg" alt="PIN" width="20" height="20">
            <span>{{ Auth::user()->withdrawal_pin ? 'Change PIN' : 'Set PIN' }}</span>
        </div>
        <form action="{{ route('account.pin') }}" method="POST" class="settings-form" id="pin-form">
            @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const pinForm = document.getElementById('pin-form');
                    if (pinForm) {
                        pinForm.addEventListener('submit', function(e) {
                            let errors = [];
                            const currentPin = document.getElementById('current_pin');
                            const pin = document.getElementById('pin');
                            const pinConfirmation = document.getElementById('pin_confirmation');
                            // If current pin is required, check not empty
                            if (currentPin && !currentPin.value.trim()) {
                                errors.push('Current PIN is required.');
                            }
                            // New pin required and must be 4 digits
                            if (!pin.value.trim() || !/^\d{4}$/.test(pin.value)) {
                                errors.push('PIN must be a 4-digit number.');
                            }
                            // Confirm pin required and must match
                            if (!pinConfirmation.value.trim() || pin.value !== pinConfirmation.value) {
                                errors.push('PIN and confirmation must match.');
                            }
                            if (errors.length > 0) {
                                e.preventDefault();
                                nativeAlert(errors.join('\n'), {
                                    type: 'error',
                                    title: 'Error'
                                });
                                return false;
                            }
                        });
                    }
                });
            </script>
            @endpush
            @csrf
            @method('PUT')
            @if(Auth::user()->withdrawal_pin)
            <div class="form-group">
                <label for="current_pin">Current PIN</label>
                <input type="password" id="current_pin" name="current_pin" maxlength="4" pattern="[0-9]{4}" inputmode="numeric" required>
            </div>
            @endif
            <div class="form-group">
                <label for="pin">{{ Auth::user()->withdrawal_pin ? 'New PIN' : 'PIN' }}</label>
                <input type="password" id="pin" name="pin" maxlength="4" pattern="[0-9]{4}" inputmode="numeric" required>
                <span class="form-hint">4-digit numeric PIN</span>
            </div>
            <div class="form-group">
                <label for="pin_confirmation">Confirm PIN</label>
                <input type="password" id="pin_confirmation" name="pin_confirmation" maxlength="4" pattern="[0-9]{4}" inputmode="numeric" required>
            </div>
            <button type="submit" class="btn-primary">
                <img src="/icons/check.svg" alt="Save" width="16" height="16">
                {{ Auth::user()->withdrawal_pin ? 'Update PIN' : 'Set PIN' }}
            </button>
        </form>
    </div>

    <div class="settings-section">
        <div class="info-box">
            <p>Your withdrawal PIN is required when making withdrawals to protect your funds. Keep it safe and don't share it with anyone.</p>
        </div>
    </div>
</div>
@endsection