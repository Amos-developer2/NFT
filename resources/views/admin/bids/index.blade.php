@extends('admin.layouts.app')

@section('title', 'Bids')
@section('page-title', 'Bids')
@section('page-description', 'View all bids')

@section('breadcrumb')
<li class="active">Bids</li>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">All Bids</h3>
      </div>
      
      <!-- Filters -->
      <div class="box-body">
        <form action="{{ route('admin.bids.index') }}" method="GET" class="form-inline">
          <div class="form-group">
            <select name="auction_id" class="form-control">
              <option value="">All Auctions</option>
              @foreach($auctions as $auction)
                <option value="{{ $auction->id }}" {{ request('auction_id') == $auction->id ? 'selected' : '' }}>
                  #{{ $auction->id }} - {{ $auction->nft->name ?? 'Unknown NFT' }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <select name="user_id" class="form-control">
              <option value="">All Users</option>
              @foreach($users as $user)
                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <input type="number" step="0.01" name="min_amount" class="form-control" placeholder="Min Amount" value="{{ request('min_amount') }}" style="width: 120px;">
          </div>
          <div class="form-group">
            <input type="number" step="0.01" name="max_amount" class="form-control" placeholder="Max Amount" value="{{ request('max_amount') }}" style="width: 120px;">
          </div>
          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Filter</button>
          <a href="{{ route('admin.bids.index') }}" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</a>
        </form>
      </div>

      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Auction</th>
              <th>NFT</th>
              <th>User</th>
              <th>Amount</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($bids as $bid)
            <tr>
              <td>{{ $bid->id }}</td>
              <td>
                @if($bid->auction)
                  <a href="{{ route('admin.auctions.show', $bid->auction) }}">#{{ $bid->auction_id }}</a>
                @else
                  <span class="text-muted">N/A</span>
                @endif
              </td>
              <td>
                @if($bid->auction && $bid->auction->nft)
                  <img src="{{ asset($bid->auction->nft->image) }}" alt="" style="width: 30px; height: 30px; object-fit: cover; border-radius: 4px; margin-right: 5px;">
                  {{ $bid->auction->nft->name }}
                @else
                  <span class="text-muted">N/A</span>
                @endif
              </td>
              <td>
                @if($bid->user)
                  <a href="{{ route('admin.users.show', $bid->user) }}">{{ $bid->user->name }}</a>
                @else
                  <span class="text-muted">Unknown</span>
                @endif
              </td>
              <td>${{ number_format($bid->amount, 2) }}</td>
              <td>{{ $bid->created_at->format('M d, Y H:i') }}</td>
              <td>
                <form action="{{ route('admin.bids.destroy', $bid) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this bid?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-xs" title="Delete">
                    <i class="fa fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center">No bids found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      
      <div class="box-footer clearfix">
        {{ $bids->appends(request()->query())->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
