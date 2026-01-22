@extends('admin.layouts.app')

@section('title', 'User Details')
@section('page-title', 'User Details')
@section('page-description', $user->name)

@section('breadcrumb')
<li><a href="{{ route('admin.users.index') }}">Users</a></li>
<li class="active">{{ $user->name }}</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-4">
    <!-- User Profile -->
    <div class="box box-primary">
      <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" src="{{ asset('admin-assets/dist/img/user2-160x160.jpg') }}" alt="User profile">
        <h3 class="profile-username text-center">{{ $user->name }}</h3>
        <p class="text-muted text-center">
          @if($user->role == 'admin')
            <span class="label label-danger">Administrator</span>
          @else
            <span class="label label-primary">User</span>
          @endif
        </p>

        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            <b>Account ID</b> <a class="pull-right"><code>{{ $user->account_id }}</code></a>
          </li>
          <li class="list-group-item">
            <b>Email</b> <a class="pull-right">{{ $user->email }}</a>
          </li>
          <li class="list-group-item">
            <b>Balance</b> <a class="pull-right text-green">${{ number_format($user->balance ?? 0, 2) }}</a>
          </li>
          <li class="list-group-item">
            <b>Referral Code</b> <a class="pull-right"><code>{{ $user->referral_code }}</code></a>
          </li>
          <li class="list-group-item">
            <b>Referrals</b> <a class="pull-right">{{ $user->referral_count ?? 0 }}</a>
          </li>
          <li class="list-group-item">
            <b>NFTs Owned</b> <a class="pull-right">{{ $user->nfts->count() }}</a>
          </li>
          <li class="list-group-item">
            <b>Joined</b> <a class="pull-right">{{ $user->created_at->format('M d, Y') }}</a>
          </li>
        </ul>

        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-block"><b>Edit User</b></a>
      </div>
    </div>

    <!-- Balance Management -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Balance Management</h3>
      </div>
      <div class="box-body">
        <form action="{{ route('admin.users.addBalance', $user) }}" method="POST" class="margin-bottom">
          @csrf
          <div class="input-group">
            <span class="input-group-addon">$</span>
            <input type="number" step="0.01" min="0.01" name="amount" class="form-control" placeholder="Amount" required>
            <span class="input-group-btn">
              <button type="submit" class="btn btn-success">Add Balance</button>
            </span>
          </div>
        </form>

        <form action="{{ route('admin.users.deductBalance', $user) }}" method="POST">
          @csrf
          <div class="input-group">
            <span class="input-group-addon">$</span>
            <input type="number" step="0.01" min="0.01" name="amount" class="form-control" placeholder="Amount" required>
            <span class="input-group-btn">
              <button type="submit" class="btn btn-danger">Deduct Balance</button>
            </span>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <!-- User's NFTs -->
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">User's NFTs ({{ $user->nfts->count() }})</h3>
      </div>
      <div class="box-body">
        @if($user->nfts->count() > 0)
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Rarity</th>
                <th>Value</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($user->nfts as $nft)
              <tr>
                <td>
                  <img src="{{ asset($nft->image) }}" alt="{{ $nft->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                </td>
                <td>{{ $nft->name }}</td>
                <td>
                  <span class="label label-{{ $nft->rarity == 'legendary' ? 'warning' : ($nft->rarity == 'epic' ? 'primary' : ($nft->rarity == 'rare' ? 'info' : 'default')) }}">
                    {{ ucfirst($nft->rarity ?? 'common') }}
                  </span>
                </td>
                <td>${{ number_format($nft->value, 2) }}</td>
                <td>
                  <a href="{{ route('admin.nfts.show', $nft) }}" class="btn btn-info btn-xs">View</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @else
        <p class="text-center text-muted">This user doesn't own any NFTs yet.</p>
        @endif
      </div>
    </div>

    <!-- Activity Timeline (placeholder) -->
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Recent Activity</h3>
      </div>
      <div class="box-body">
        <ul class="timeline timeline-inverse">
          <li class="time-label">
            <span class="bg-blue">Account Information</span>
          </li>
          <li>
            <i class="fa fa-user bg-aqua"></i>
            <div class="timeline-item">
              <span class="time"><i class="fa fa-clock-o"></i> {{ $user->created_at->diffForHumans() }}</span>
              <h3 class="timeline-header">Account Created</h3>
              <div class="timeline-body">
                User registered on {{ $user->created_at->format('F d, Y at H:i') }}
              </div>
            </div>
          </li>
          @if($user->email_verified_at)
          <li>
            <i class="fa fa-check bg-green"></i>
            <div class="timeline-item">
              <span class="time"><i class="fa fa-clock-o"></i> {{ $user->email_verified_at->diffForHumans() }}</span>
              <h3 class="timeline-header">Email Verified</h3>
            </div>
          </li>
          @endif
          <li>
            <i class="fa fa-clock-o bg-gray"></i>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
