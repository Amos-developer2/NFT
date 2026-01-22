@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Control Panel')

@section('content')
<!-- Info boxes -->
<div class="row">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Users</span>
        <span class="info-box-number">{{ number_format($totalUsers) }}</span>
      </div>
    </div>
  </div>
  
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-image"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total NFTs</span>
        <span class="info-box-number">{{ number_format($totalNfts) }}</span>
      </div>
    </div>
  </div>
  
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-gavel"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Active Auctions</span>
        <span class="info-box-number">{{ number_format($activeAuctions) }}</span>
      </div>
    </div>
  </div>
  
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-dollar"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Deposits</span>
        <span class="info-box-number">${{ number_format($totalDeposits, 2) }}</span>
      </div>
    </div>
  </div>
</div>

<!-- Second row of stats -->
<div class="row">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-aqua">
      <span class="info-box-icon"><i class="fa fa-user-plus"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">New Users (Today)</span>
        <span class="info-box-number">{{ number_format($newUsersToday) }}</span>
        <div class="progress">
          <div class="progress-bar" style="width: {{ min($newUsersToday * 10, 100) }}%"></div>
        </div>
        <span class="progress-description">Registered today</span>
      </div>
    </div>
  </div>
  
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-green">
      <span class="info-box-icon"><i class="fa fa-money"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Bids</span>
        <span class="info-box-number">{{ number_format($totalBids) }}</span>
        <div class="progress">
          <div class="progress-bar" style="width: 70%"></div>
        </div>
        <span class="progress-description">All time bids</span>
      </div>
    </div>
  </div>
  
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-yellow">
      <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Pending Deposits</span>
        <span class="info-box-number">{{ number_format($pendingDeposits) }}</span>
        <div class="progress">
          <div class="progress-bar" style="width: {{ $pendingDeposits > 0 ? 50 : 0 }}%"></div>
        </div>
        <span class="progress-description">Awaiting confirmation</span>
      </div>
    </div>
  </div>
  
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-red">
      <span class="info-box-icon"><i class="fa fa-arrow-up"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Pending Withdrawals</span>
        <span class="info-box-number">{{ number_format($pendingWithdrawals) }}</span>
        <div class="progress">
          <div class="progress-bar" style="width: {{ $pendingWithdrawals > 0 ? 50 : 0 }}%"></div>
        </div>
        <span class="progress-description">Awaiting processing</span>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Recent Users -->
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Recent Users</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body no-padding">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Joined</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentUsers as $user)
            <tr>
              <td>{{ $user->id }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->created_at->diffForHumans() }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center">No users found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="box-footer text-center">
        <a href="{{ route('admin.users.index') }}" class="uppercase">View All Users</a>
      </div>
    </div>
  </div>

  <!-- Recent Deposits -->
  <div class="col-md-6">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Recent Deposits</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body no-padding">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>User</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentDeposits as $deposit)
            <tr>
              <td>{{ $deposit->user->name ?? 'N/A' }}</td>
              <td>${{ number_format($deposit->amount, 2) }}</td>
              <td>
                @if($deposit->status == 'confirmed' || $deposit->status == 'finished')
                  <span class="label label-success">{{ ucfirst($deposit->status) }}</span>
                @elseif($deposit->status == 'pending' || $deposit->status == 'waiting')
                  <span class="label label-warning">{{ ucfirst($deposit->status) }}</span>
                @else
                  <span class="label label-danger">{{ ucfirst($deposit->status) }}</span>
                @endif
              </td>
              <td>{{ $deposit->created_at->diffForHumans() }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center">No deposits found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="box-footer text-center">
        <a href="{{ route('admin.deposits.index') }}" class="uppercase">View All Deposits</a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Recent NFTs -->
  <div class="col-md-6">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Recent NFTs</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body no-padding">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Image</th>
              <th>Name</th>
              <th>Rarity</th>
              <th>Value</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentNfts as $nft)
            <tr>
              <td><img src="{{ asset($nft->image) }}" alt="{{ $nft->name }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;"></td>
              <td>{{ $nft->name }}</td>
              <td>
                <span class="label label-{{ $nft->rarity == 'legendary' ? 'warning' : ($nft->rarity == 'epic' ? 'primary' : ($nft->rarity == 'rare' ? 'info' : 'default')) }}">
                  {{ ucfirst($nft->rarity ?? 'common') }}
                </span>
              </td>
              <td>${{ number_format($nft->value, 2) }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center">No NFTs found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="box-footer text-center">
        <a href="{{ route('admin.nfts.index') }}" class="uppercase">View All NFTs</a>
      </div>
    </div>
  </div>

  <!-- Active Auctions -->
  <div class="col-md-6">
    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">Active Auctions</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body no-padding">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>NFT</th>
              <th>Starting Price</th>
              <th>Highest Bid</th>
              <th>Ends</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentAuctions as $auction)
            <tr>
              <td>{{ $auction->nft->name ?? 'N/A' }}</td>
              <td>${{ number_format($auction->starting_price, 2) }}</td>
              <td>${{ number_format($auction->highest_bid ?? 0, 2) }}</td>
              <td>{{ \Carbon\Carbon::parse($auction->end_time)->diffForHumans() }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center">No active auctions</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="box-footer text-center">
        <a href="{{ route('admin.auctions.index') }}" class="uppercase">View All Auctions</a>
      </div>
    </div>
  </div>
</div>
@endsection
