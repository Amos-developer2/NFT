@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 mb-4 overflow-hidden">
                <div class="row g-0 flex-column flex-md-row">
                    <div class="col-md-5 bg-dark d-flex align-items-center justify-content-center p-0" style="min-height: 400px;">
                        <img src="{{ $nft->image_url ?? $nft->image }}" alt="{{ $nft->name }}" class="img-fluid rounded-0 w-100 h-100" style="object-fit: cover; max-height: 500px;" />
                    </div>
                    <div class="col-md-7 bg-white">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <h2 class="card-title fw-bold mb-0 flex-grow-1">{{ $nft->name }}</h2>
                                <span class="badge bg-gradient bg-primary text-white ms-2">#{{ $nft->id }}</span>
                            </div>
                            <p class="text-muted mb-3">{{ $nft->description }}</p>
                            <div class="mb-3">
                                <span class="badge bg-info text-dark me-2">Owner: {{ $nft->user->name }}</span>
                                <span class="badge bg-light text-secondary">Edition: {{ $nft->edition ?? 'Unique' }}</span>
                            </div>
                            <div class="row mb-4 g-2">
                                <div class="col-6">
                                    <div class="border rounded-3 p-3 text-center h-100">
                                        <div class="text-muted small">Current Price</div>
                                        <div class="fs-2 fw-bold text-success">${{ number_format($nft->current_price ?? $nft->price ?? $nft->purchase_price, 2) }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded-3 p-3 text-center h-100">
                                        <div class="text-muted small">Rarity</div>
                                        <div class="fs-5 fw-bold">{{ $nft->rarity ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <h5 class="fw-semibold mb-2">Price Statistics</h5>
                                <div class="row g-2">
                                    <div class="col-4">
                                        <div class="bg-light rounded-3 p-2 text-center">
                                            <div class="small text-muted">Highest</div>
                                            <div class="fw-bold text-success">${{ number_format($statistics['highest'], 2) }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="bg-light rounded-3 p-2 text-center">
                                            <div class="small text-muted">Lowest</div>
                                            <div class="fw-bold text-danger">${{ number_format($statistics['lowest'], 2) }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="bg-light rounded-3 p-2 text-center">
                                            <div class="small text-muted">Change</div>
                                            <div class="fw-bold {{ $statistics['change_percent'] >= 0 ? 'text-success' : 'text-danger' }}">{{ $statistics['change_percent'] }}%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <h5 class="fw-semibold mb-2">Bids</h5>
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
