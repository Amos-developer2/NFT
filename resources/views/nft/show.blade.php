@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 mb-4">
                <div class="row g-0">
                    <div class="col-md-5 d-flex align-items-center justify-content-center bg-light p-4">
                        <img src="{{ $nft->image_url ?? $nft->image }}" alt="{{ $nft->name }}" class="img-fluid rounded" style="max-height: 350px; object-fit: contain;" />
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h2 class="card-title fw-bold mb-2">{{ $nft->name }}</h2>
                            <p class="text-muted mb-3">{{ $nft->description }}</p>
                            <div class="mb-3">
                                <span class="badge bg-primary me-2">Owner: {{ $nft->user->name }}</span>
                                <span class="badge bg-secondary">ID: #{{ $nft->id }}</span>
                            </div>
                            <div class="mb-4">
                                <h4 class="fw-semibold mb-1">Current Price</h4>
                                <span class="display-6 fw-bold text-success">${{ number_format($nft->current_price ?? $nft->price ?? $nft->purchase_price, 2) }}</span>
                            </div>
                            <div class="mb-4">
                                <h5 class="fw-semibold">Price Statistics</h5>
                                <ul class="list-group list-group-flush mb-2">
                                    <li class="list-group-item">Highest Price: <span class="fw-bold text-success">${{ number_format($statistics['highest'], 2) }}</span></li>
                                    <li class="list-group-item">Lowest Price: <span class="fw-bold text-danger">${{ number_format($statistics['lowest'], 2) }}</span></li>
                                    <li class="list-group-item">Change: <span class="fw-bold {{ $statistics['change_percent'] >= 0 ? 'text-success' : 'text-danger' }}">{{ $statistics['change_percent'] }}%</span></li>
                                </ul>
                            </div>
                            <div class="mb-4">
                                <h5 class="fw-semibold">Bids</h5>
                                @if(count($bids) > 0)
                                    <ul class="list-group mb-2">
                                        @foreach($bids as $bid)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span><i class="bi bi-person-circle me-2"></i>{{ $bid->user->name }}</span>
                                                <span class="fw-bold text-primary">${{ number_format($bid->amount, 2) }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="alert alert-info mb-0">No bids yet.</div>
                                @endif
                            </div>
                            @if(auth()->id() === $nft->user_id)
                                <form action="{{ route('nft.sell', $nft->id) }}" method="POST" class="mt-3">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold">Sell NFT</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
