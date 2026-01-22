@extends('admin.layouts.app')

@section('title', 'Create User')
@section('page-title', 'Create User')
@section('page-description', 'Add a new user')

@section('breadcrumb')
<li><a href="{{ route('admin.users.index') }}">Users</a></li>
<li class="active">Create</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">New User</h3>
      </div>
      
      <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="box-body">
          <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="password">Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
            @error('password')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
          </div>

          <div class="form-group">
            <label for="role">Role <span class="text-danger">*</span></label>
            <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
              <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
              <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="balance">Initial Balance</label>
            <div class="input-group">
              <span class="input-group-addon">$</span>
              <input type="number" step="0.01" min="0" class="form-control @error('balance') is-invalid @enderror" id="balance" name="balance" value="{{ old('balance', 0) }}">
            </div>
            @error('balance')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="box-footer">
          <a href="{{ route('admin.users.index') }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-primary pull-right">Create User</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
