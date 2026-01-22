@extends('admin.layouts.app')

@section('title', 'Create Auction')
@section('page-title', 'Create Auction')
@section('page-description', 'Start a new auction')

@section('breadcrumb')
<li><a href="{{ route('admin.auctions.index') }}">Auctions</a></li>
<li class="active">Create</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">New Auction</h3>
      </div>
      
      <form action="{{ route('admin.auctions.store') }}" method="POST">
        @csrf
        <div class="box-body">
          <div class="form-group">
            <label for="nft_id">Select NFT <span class="text-danger">*</span></label>
            <select class="form-control @error('nft_id') is-invalid @enderror" id="nft_id" name="nft_id" required>
              <option value="">Choose an NFT</option>
              @foreach($nfts as $nft)
                <option value="{{ $nft->id }}" {{ old('nft_id') == $nft->id ? 'selected' : '' }}>
                  {{ $nft->name }} - ${{ number_format($nft->value, 2) }} ({{ ucfirst($nft->rarity ?? 'common') }})
                </option>
              @endforeach
            </select>
            @error('nft_id')
              <span class="text-danger">{{ $message }}</span>
            @enderror
            @if($nfts->count() == 0)
              <p class="help-block text-warning">No NFTs available for auction. All NFTs may already have active auctions.</p>
            @endif
          </div>

          <div class="form-group">
            <label for="starting_price">Starting Price <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-addon">$</span>
              <input type="number" step="0.01" min="0" class="form-control @error('starting_price') is-invalid @enderror" id="starting_price" name="starting_price" value="{{ old('starting_price') }}" required>
            </div>
            @error('starting_price')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="end_time">End Time <span class="text-danger">*</span></label>
            <input type="datetime-local" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time') }}" min="{{ now()->format('Y-m-d\TH:i') }}" required>
            @error('end_time')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
              <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
              <option value="ended" {{ old('status') == 'ended' ? 'selected' : '' }}>Ended</option>
              <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @error('status')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="box-footer">
          <a href="{{ route('admin.auctions.index') }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-primary pull-right">Create Auction</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
