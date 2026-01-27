@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="/css/account.css">
@endpush

@section('content')
@include('partials.header', ['title' => 'Choose Language'])
<div class="page-header">
    <a href="{{ route('account') }}" class="back-btn">
        <img src="/icons/arrow-left.svg" alt="Back" width="20" height="20">
    </a>
    <h1 class="page-title">Choose Language</h1>
</div>
<div class="settings-container">
    <div class="settings-section">
        <form action="{{ route('account.language.set') }}" method="POST" class="settings-form">
            @csrf
            <div class="form-group">
                <label for="language">Select your language</label>
                <select id="language" name="language" class="form-control">
                    <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                    <option value="es" {{ app()->getLocale() == 'es' ? 'selected' : '' }}>Español</option>
                    <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>Français</option>
                    <!-- Add more languages as needed -->
                </select>
            </div>
            <button type="submit" class="btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection