@extends('admin.layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('page-description', 'Modify user details')

@section('breadcrumb')
<li><a href="{{ route('admin.users.index') }}">Users</a></li>
<li class="active">Edit</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Edit User: {{ $user->name }}</h3>
      </div>
      
      <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="box-body">
          <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="password">New Password <small class="text-muted">(leave blank to keep current)</small></label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
            @error('password')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="password_confirmation">Confirm New Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
          </div>

          <div class="form-group">
            <label for="role">Role <span class="text-danger">*</span></label>
            <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
              <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
              <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="balance">Balance</label>
            <div class="input-group">
              <span class="input-group-addon">$</span>
              <input type="number" step="0.01" min="0" class="form-control @error('balance') is-invalid @enderror" id="balance" name="balance" value="{{ old('balance', $user->balance ?? 0) }}">
            </div>
            @error('balance')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="box-footer">
          <a href="{{ route('admin.users.index') }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-warning pull-right">Update User</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
