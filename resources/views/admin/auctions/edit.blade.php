@extends('admin.layouts.app')

@section('title', 'Edit Auction')
@section('page-title', 'Edit Auction')
@section('page-description', 'Modify auction details')

@section('breadcrumb')
<li><a href="{{ route('admin.auctions.index') }}">Auctions</a></li>
<li class="active">Edit</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Auction #{{ $auction->id }}</h3>
      </div>
      
      <form action="{{ route('admin.auctions.update', $auction) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="box-body">
          <div class="form-group">
            <label for="nft_id">Select NFT <span class="text-danger">*</span></label>
            <select class="form-control @error('nft_id') is-invalid @enderror" id="nft_id" name="nft_id" required>
              @foreach($nfts as $nft)
                <option value="{{ $nft->id }}" {{ old('nft_id', $auction->nft_id) == $nft->id ? 'selected' : '' }}>
                  {{ $nft->name }} - ${{ number_format($nft->value, 2) }} ({{ ucfirst($nft->rarity ?? 'common') }})
                </option>
              @endforeach
            </select>
            @error('nft_id')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="starting_price">Starting Price <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-addon">$</span>
              <input type="number" step="0.01" min="0" class="form-control @error('starting_price') is-invalid @enderror" id="starting_price" name="starting_price" value="{{ old('starting_price', $auction->starting_price) }}" required>
            </div>
            @error('starting_price')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="highest_bid">Highest Bid</label>
            <div class="input-group">
              <span class="input-group-addon">$</span>
              <input type="number" step="0.01" min="0" class="form-control @error('highest_bid') is-invalid @enderror" id="highest_bid" name="highest_bid" value="{{ old('highest_bid', $auction->highest_bid) }}">
            </div>
            @error('highest_bid')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="end_time">End Time <span class="text-danger">*</span></label>
            <input type="datetime-local" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($auction->end_time)->format('Y-m-d\TH:i')) }}" required>
            @error('end_time')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
              <option value="active" {{ old('status', $auction->status) == 'active' ? 'selected' : '' }}>Active</option>
              <option value="ended" {{ old('status', $auction->status) == 'ended' ? 'selected' : '' }}>Ended</option>
              <option value="cancelled" {{ old('status', $auction->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @error('status')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="box-footer">
          <a href="{{ route('admin.auctions.index') }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-warning pull-right">Update Auction</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
