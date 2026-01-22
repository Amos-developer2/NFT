@extends('layouts.app')

@section('content')
@push('styles')
<link rel="stylesheet" href="/css/account.css">
@endpush

@include('partials.header', ['title' => 'Profile'])

<!-- Page Header -->
<div class="page-header">
    <a href="{{ route('account') }}" class="back-btn">
        <img src="/icons/arrow-left.svg" alt="Back" width="20" height="20">
    </a>
    <h1 class="page-title">Personal Profile</h1>
</div>

<!-- SweetAlert2 for Success/Error -->
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
                    @if(session('success')) <
                        script src = "https://cdn.jsdelivr.net/npm/sweetalert2@11" >
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            toast: true,
            position: 'center',
            icon: 'success',
            title: @json(session('success')),
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast'
            },
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
        });
    });
</script>
@endif
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
                        html: @json($errors - > all()).join('<br>'),
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
                @if($errors && $errors - > any()) <
                    script src = "https://cdn.jsdelivr.net/npm/sweetalert2@11" >
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            toast: true,
            position: 'center',
            icon: 'error',
            title: @json(implode("\n", $errors - > all())),
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast'
            },
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
        });
    });
</script>
@endif
<style>
    .colored-toast {
        background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%) !important;
        color: #fff !important;
        font-weight: 700;
        font-size: 1rem;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.18);
    }
</style>
</div>
<form action="{{ route('account.profile') }}" method="POST" class="settings-form">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
    </div>
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" value="{{ Auth::user()->email }}" disabled readonly>
        <span class="form-hint">Email cannot be changed</span>
    </div>
    <button type="submit" class="btn-primary">
        <img src="/icons/check.svg" alt="Save" width="16" height="16">
        Save Changes
    </button>
</form>
</div>
</div>
@endsection