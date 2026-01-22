@extends('admin.layouts.app')

@section('title', 'NFT Details')
@section('page-title', 'NFT Details')
@section('page-description', $nft->name)

@section('breadcrumb')
<li><a href="{{ route('admin.nfts.index') }}">NFTs</a></li>
<li class="active">{{ $nft->name }}</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-4">
    <!-- NFT Profile -->
    <div class="box box-primary">
      <div class="box-body box-profile">
        <img class="profile-user-img img-responsive" src="{{ asset($nft->image) }}" alt="{{ $nft->name }}" style="border-radius: 8px; max-height: 300px; object-fit: cover;">
        <h3 class="profile-username text-center">{{ $nft->name }}</h3>
        <p class="text-muted text-center">
          <span class="label label-{{ $nft->rarity == 'legendary' ? 'warning' : ($nft->rarity == 'epic' ? 'primary' : ($nft->rarity == 'rare' ? 'info' : ($nft->rarity == 'uncommon' ? 'success' : 'default'))) }}">
            {{ ucfirst($nft->rarity ?? 'common') }}
          </span>
        </p>

        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            <b>ID</b> <a class="pull-right">{{ $nft->id }}</a>
          </li>
          <li class="list-group-item">
            <b>Value</b> <a class="pull-right text-green">${{ number_format($nft->value, 2) }}</a>
          </li>
          <li class="list-group-item">
            <b>Sale Price</b> <a class="pull-right">${{ number_format($nft->price ?? 0, 2) }}</a>
          </li>
          <li class="list-group-item">
            <b>Owner</b> 
            <a class="pull-right">
              @if($nft->user)
                <a href="{{ route('admin.users.show', $nft->user) }}">{{ $nft->user->name }}</a>
              @else
                <span class="text-muted">Unowned</span>
              @endif
            </a>
          </li>
          <li class="list-group-item">
            <b>Background</b> <a class="pull-right">{{ $nft->background ?? 'Default' }}</a>
          </li>
          <li class="list-group-item">
            <b>Created</b> <a class="pull-right">{{ $nft->created_at->format('M d, Y') }}</a>
          </li>
        </ul>

        <a href="{{ route('admin.nfts.edit', $nft) }}" class="btn btn-warning btn-block"><b>Edit NFT</b></a>
      </div>
    </div>

    <!-- Transfer Ownership -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Transfer Ownership</h3>
      </div>
      <div class="box-body">
        <form action="{{ route('admin.nfts.transfer', $nft) }}" method="POST">
          @csrf
          <div class="form-group">
            <label>Transfer to User</label>
            <select name="user_id" class="form-control" required>
              <option value="">Select User</option>
              @foreach(\App\Models\User::all() as $user)
                <option value="{{ $user->id }}" {{ $nft->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-success btn-block">Transfer NFT</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <!-- Auction History -->
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Auction History</h3>
      </div>
      <div class="box-body">
        @if($nft->auctions && $nft->auctions->count() > 0)
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Starting Price</th>
                <th>Highest Bid</th>
                <th>Status</th>
                <th>End Time</th>
                <th>Bids</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($nft->auctions as $auction)
              <tr>
                <td>{{ $auction->id }}</td>
                <td>${{ number_format($auction->starting_price, 2) }}</td>
                <td>${{ number_format($auction->highest_bid ?? 0, 2) }}</td>
                <td>
                  @if($auction->status == 'active' && $auction->end_time > now())
                    <span class="label label-success">Active</span>
                  @elseif($auction->status == 'ended')
                    <span class="label label-default">Ended</span>
                  @elseif($auction->status == 'cancelled')
                    <span class="label label-danger">Cancelled</span>
                  @else
                    <span class="label label-warning">{{ ucfirst($auction->status) }}</span>
                  @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($auction->end_time)->format('M d, Y H:i') }}</td>
                <td>{{ $auction->bids->count() }}</td>
                <td>
                  <a href="{{ route('admin.auctions.show', $auction) }}" class="btn btn-info btn-xs">View</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @else
        <p class="text-center text-muted">No auction history for this NFT.</p>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
