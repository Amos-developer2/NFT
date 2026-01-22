@extends('admin.layouts.app')

@section('title', 'NFTs')
@section('page-title', 'NFTs')
@section('page-description', 'Manage all NFTs')

@section('breadcrumb')
<li class="active">NFTs</li>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">NFTs List</h3>
        <div class="box-tools">
          <a href="{{ route('admin.nfts.create') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Add New NFT
          </a>
        </div>
      </div>
      
      <!-- Filters -->
      <div class="box-body">
        <form action="{{ route('admin.nfts.index') }}" method="GET" class="form-inline">
          <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name" value="{{ request('search') }}">
          </div>
          <div class="form-group">
            <select name="rarity" class="form-control">
              <option value="">All Rarities</option>
              <option value="common" {{ request('rarity') == 'common' ? 'selected' : '' }}>Common</option>
              <option value="uncommon" {{ request('rarity') == 'uncommon' ? 'selected' : '' }}>Uncommon</option>
              <option value="rare" {{ request('rarity') == 'rare' ? 'selected' : '' }}>Rare</option>
              <option value="epic" {{ request('rarity') == 'epic' ? 'selected' : '' }}>Epic</option>
              <option value="legendary" {{ request('rarity') == 'legendary' ? 'selected' : '' }}>Legendary</option>
            </select>
          </div>
          <div class="form-group">
            <select name="user_id" class="form-control">
              <option value="">All Owners</option>
              <option value="0" {{ request('user_id') === '0' ? 'selected' : '' }}>Unowned</option>
              @foreach($users as $user)
                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Filter</button>
          <a href="{{ route('admin.nfts.index') }}" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</a>
        </form>
      </div>

      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Image</th>
              <th>Name</th>
              <th>Rarity</th>
              <th>Value</th>
              <th>Price</th>
              <th>Owner</th>
              <th>Created</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($nfts as $nft)
            <tr>
              <td>{{ $nft->id }}</td>
              <td>
                <img src="{{ asset($nft->image) }}" alt="{{ $nft->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
              </td>
              <td>{{ $nft->name }}</td>
              <td>
                <span class="label label-{{ $nft->rarity == 'legendary' ? 'warning' : ($nft->rarity == 'epic' ? 'primary' : ($nft->rarity == 'rare' ? 'info' : ($nft->rarity == 'uncommon' ? 'success' : 'default'))) }}">
                  {{ ucfirst($nft->rarity ?? 'common') }}
                </span>
              </td>
              <td>${{ number_format($nft->value, 2) }}</td>
              <td>${{ number_format($nft->price ?? 0, 2) }}</td>
              <td>
                @if($nft->user)
                  <a href="{{ route('admin.users.show', $nft->user) }}">{{ $nft->user->name }}</a>
                @else
                  <span class="text-muted">Unowned</span>
                @endif
              </td>
              <td>{{ $nft->created_at->format('M d, Y') }}</td>
              <td>
                <div class="btn-group">
                  <a href="{{ route('admin.nfts.show', $nft) }}" class="btn btn-info btn-xs" title="View">
                    <i class="fa fa-eye"></i>
                  </a>
                  <a href="{{ route('admin.nfts.edit', $nft) }}" class="btn btn-warning btn-xs" title="Edit">
                    <i class="fa fa-edit"></i>
                  </a>
                  <form action="{{ route('admin.nfts.destroy', $nft) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this NFT?')">
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
              <td colspan="9" class="text-center">No NFTs found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      
      <div class="box-footer clearfix">
        {{ $nfts->appends(request()->query())->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
