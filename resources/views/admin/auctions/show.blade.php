@extends('admin.layouts.app')

@section('title', 'Auction Details')
@section('page-title', 'Auction Details')
@section('page-description', 'Auction #' . $auction->id)

@section('breadcrumb')
<li><a href="{{ route('admin.auctions.index') }}">Auctions</a></li>
<li class="active">Auction #{{ $auction->id }}</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-4">
    <!-- Auction Info -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Auction Information</h3>
      </div>
      <div class="box-body">
        @if($auction->nft)
        <div class="text-center margin-bottom">
          <img src="{{ asset($auction->nft->image) }}" alt="{{ $auction->nft->name }}" style="max-width: 200px; max-height: 200px; object-fit: cover; border-radius: 8px;">
          <h4>{{ $auction->nft->name }}</h4>
          <span class="label label-{{ $auction->nft->rarity == 'legendary' ? 'warning' : ($auction->nft->rarity == 'epic' ? 'primary' : ($auction->nft->rarity == 'rare' ? 'info' : 'default')) }}">
            {{ ucfirst($auction->nft->rarity ?? 'common') }}
          </span>
        </div>
        @endif

        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            <b>Status</b>
            <span class="pull-right">
              @if($auction->status == 'active' && $auction->end_time > now())
                <span class="label label-success">Active</span>
              @elseif($auction->status == 'ended')
                <span class="label label-default">Ended</span>
              @elseif($auction->status == 'cancelled')
                <span class="label label-danger">Cancelled</span>
              @else
                <span class="label label-warning">Expired</span>
              @endif
            </span>
          </li>
          <li class="list-group-item">
            <b>Starting Price</b>
            <span class="pull-right">${{ number_format($auction->starting_price, 2) }}</span>
          </li>
          <li class="list-group-item">
            <b>Highest Bid</b>
            <span class="pull-right text-green">${{ number_format($auction->highest_bid ?? 0, 2) }}</span>
          </li>
          <li class="list-group-item">
            <b>Total Bids</b>
            <span class="pull-right">{{ $auction->bids->count() }}</span>
          </li>
          <li class="list-group-item">
            <b>End Time</b>
            <span class="pull-right">{{ \Carbon\Carbon::parse($auction->end_time)->format('M d, Y H:i') }}</span>
          </li>
          <li class="list-group-item">
            <b>Time Left</b>
            <span class="pull-right">
              @if($auction->end_time > now())
                {{ \Carbon\Carbon::parse($auction->end_time)->diffForHumans() }}
              @else
                <span class="text-danger">Ended</span>
              @endif
            </span>
          </li>
        </ul>

        <a href="{{ route('admin.auctions.edit', $auction) }}" class="btn btn-warning btn-block">Edit Auction</a>
        
        @if($auction->status == 'active' && $auction->end_time > now())
        <form action="{{ route('admin.auctions.end', $auction) }}" method="POST" class="margin-top">
          @csrf
          <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to end this auction now?')">
            End Auction Now
          </button>
        </form>
        @endif
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <!-- Bids History -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Bid History ({{ $auction->bids->count() }} bids)</h3>
      </div>
      <div class="box-body">
        @if($auction->bids->count() > 0)
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>User</th>
                <th>Amount</th>
                <th>Time</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($auction->bids->sortByDesc('amount') as $index => $bid)
              <tr class="{{ $index == 0 ? 'success' : '' }}">
                <td>
                  {{ $index + 1 }}
                  @if($index == 0)
                    <span class="label label-success">Highest</span>
                  @endif
                </td>
                <td>
                  @if($bid->user)
                    <a href="{{ route('admin.users.show', $bid->user) }}">{{ $bid->user->name }}</a>
                  @else
                    <span class="text-muted">Unknown User</span>
                  @endif
                </td>
                <td>${{ number_format($bid->amount, 2) }}</td>
                <td>{{ $bid->created_at->format('M d, Y H:i:s') }}</td>
                <td>
                  <form action="{{ route('admin.bids.destroy', $bid) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this bid?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-xs">
                      <i class="fa fa-trash"></i> Delete
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @else
        <p class="text-center text-muted">No bids placed yet.</p>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
