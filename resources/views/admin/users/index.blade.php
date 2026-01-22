@extends('admin.layouts.app')

@section('title', 'Users')
@section('page-title', 'Users')
@section('page-description', 'Manage all users')

@section('breadcrumb')
<li class="active">Users</li>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Users List</h3>
        <div class="box-tools">
          <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Add New User
          </a>
        </div>
      </div>
      
      <!-- Filters -->
      <div class="box-body">
        <form action="{{ route('admin.users.index') }}" method="GET" class="form-inline">
          <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name, email, or ID" value="{{ request('search') }}">
          </div>
          <div class="form-group">
            <select name="role" class="form-control">
              <option value="">All Roles</option>
              <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
              <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
          </div>
          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Filter</button>
          <a href="{{ route('admin.users.index') }}" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</a>
        </form>
      </div>

      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Account ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Balance</th>
              <th>Role</th>
              <th>Referrals</th>
              <th>Joined</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($users as $user)
            <tr>
              <td>{{ $user->id }}</td>
              <td><code>{{ $user->account_id }}</code></td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>${{ number_format($user->balance ?? 0, 2) }}</td>
              <td>
                @if($user->role == 'admin')
                  <span class="label label-danger">Admin</span>
                @else
                  <span class="label label-primary">User</span>
                @endif
              </td>
              <td>{{ $user->referral_count ?? 0 }}</td>
              <td>{{ $user->created_at->format('M d, Y') }}</td>
              <td>
                <div class="btn-group">
                  <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info btn-xs" title="View">
                    <i class="fa fa-eye"></i>
                  </a>
                  <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-xs" title="Edit">
                    <i class="fa fa-edit"></i>
                  </a>
                  <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this user?')">
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
              <td colspan="9" class="text-center">No users found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      
      <div class="box-footer clearfix">
        {{ $users->appends(request()->query())->links() }}
      </div>
    </div>
  </div>
</div>
@endsection