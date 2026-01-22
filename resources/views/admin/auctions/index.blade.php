@extends('admin.layouts.app')

@section('title', 'Auctions')
@section('page-title', 'Auctions')
@section('page-description', 'Manage all auctions')

@section('breadcrumb')
<li class="active">Auctions</li>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Auctions List</h3>
        <div class="box-tools">
          <a href="{{ route('admin.auctions.create') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Create Auction
          </a>
        </div>
      </div>
      
      <!-- Filters -->
      <div class="box-body">
        <form action="{{ route('admin.auctions.index') }}" method="GET" class="form-inline">
          <div class="form-group">
            <select name="status" class="form-control">
              <option value="">All Statuses</option>
              <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
              <option value="ended" {{ request('status') == 'ended' ? 'selected' : '' }}>Ended</option>
              <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
          </div>
          <div class="form-group">
            <select name="active" class="form-control">
              <option value="">All Time</option>
              <option value="active" {{ request('active') == 'active' ? 'selected' : '' }}>Currently Active</option>
              <option value="ended" {{ request('active') == 'ended' ? 'selected' : '' }}>Time Expired</option>
            </select>
          </div>
          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Filter</button>
          <a href="{{ route('admin.auctions.index') }}" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</a>
        </form>
      </div>

      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>NFT</th>
              <th>Starting Price</th>
              <th>Highest Bid</th>
              <th>Total Bids</th>
              <th>Status</th>
              <th>End Time</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($auctions as $auction)
            <tr>
              <td>{{ $auction->id }}</td>
              <td>
                @if($auction->nft)
                  <img src="{{ asset($auction->nft->image) }}" alt="{{ $auction->nft->name }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; margin-right: 5px;">
                  {{ $auction->nft->name }}
                @else
                  <span class="text-muted">N/A</span>
                @endif
              </td>
              <td>${{ number_format($auction->starting_price, 2) }}</td>
              <td>${{ number_format($auction->highest_bid ?? 0, 2) }}</td>
              <td>{{ $auction->bids->count() }}</td>
              <td>
                @if($auction->status == 'active' && $auction->end_time > now())
                  <span class="label label-success">Active</span>
                @elseif($auction->status == 'ended')
                  <span class="label label-default">Ended</span>
                @elseif($auction->status == 'cancelled')
                  <span class="label label-danger">Cancelled</span>
                @elseif($auction->end_time <= now())
                  <span class="label label-warning">Expired</span>
                @else
                  <span class="label label-info">{{ ucfirst($auction->status) }}</span>
                @endif
              </td>
              <td>
                {{ \Carbon\Carbon::parse($auction->end_time)->format('M d, Y H:i') }}
                <br>
                <small class="text-muted">{{ \Carbon\Carbon::parse($auction->end_time)->diffForHumans() }}</small>
              </td>
              <td>
                <div class="btn-group">
                  <a href="{{ route('admin.auctions.show', $auction) }}" class="btn btn-info btn-xs" title="View">
                    <i class="fa fa-eye"></i>
                  </a>
                  <a href="{{ route('admin.auctions.edit', $auction) }}" class="btn btn-warning btn-xs" title="Edit">
                    <i class="fa fa-edit"></i>
                  </a>
                  @if($auction->status == 'active' && $auction->end_time > now())
                    <form action="{{ route('admin.auctions.end', $auction) }}" method="POST" style="display: inline;">
                      @csrf
                      <button type="submit" class="btn btn-default btn-xs" title="End Auction" onclick="return confirm('End this auction now?')">
                        <i class="fa fa-stop"></i>
                      </button>
                    </form>
                  @endif
                  <form action="{{ route('admin.auctions.destroy', $auction) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this auction?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-xs" title="Delete">
                      <i class="fa fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center">No auctions found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      
      <div class="box-footer clearfix">
        {{ $auctions->appends(request()->query())->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
