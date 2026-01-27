@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ $nft->image_url }}" alt="{{ $nft->name }}" class="img-fluid mb-3" />
        </div>
        <div class="col-md-6">
            <h2>{{ $nft->name }}</h2>
            <p>{{ $nft->description }}</p>
            <p><strong>Owner:</strong> {{ $nft->owner->name }}</p>
            <p><strong>Current Price:</strong> ${{ number_format($nft->current_price, 2) }}</p>
            <h4>Price Statistics</h4>
            <ul>
                <li>Highest Price: ${{ number_format($statistics['highest'], 2) }}</li>
                <li>Lowest Price: ${{ number_format($statistics['lowest'], 2) }}</li>
                <li>Last 7 Days Change: {{ $statistics['change_percent'] }}%</li>
            </ul>
            <h4>Bids</h4>
            @if(count($bids) > 0)
                <ul>
                    @foreach($bids as $bid)
                        <li>{{ $bid->user->name }}: ${{ number_format($bid->amount, 2) }}</li>
                    @endforeach
                </ul>
            @else
                <p>No bids yet.</p>
            @endif
            @if(auth()->id() === $nft->owner_id)
                <form action="{{ route('nft.sell', $nft->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Sell NFT</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
