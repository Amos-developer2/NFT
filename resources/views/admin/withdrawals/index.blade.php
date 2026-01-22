@extends('admin.layouts.app')

@section('title', 'Withdrawals')
@section('page-title', 'Withdrawals')
@section('page-description', 'Manage withdrawals')

@section('breadcrumb')
<li class="active">Withdrawals</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">User Balances</h3>
      </div>
      
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>User</th>
              <th>Email</th>
              <th>Current Balance</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($users as $user)
            <tr>
              <td>{{ $user->id }}</td>
              <td>
                <a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a>
              </td>
              <td>{{ $user->email }}</td>
              <td>${{ number_format($user->balance ?? 0, 2) }}</td>
              <td>
                <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#withdrawModal{{ $user->id }}" {{ ($user->balance ?? 0) <= 0 ? 'disabled' : '' }}>
                  <i class="fa fa-arrow-up"></i> Process Withdrawal
                </button>
              </td>
            </tr>

            <!-- Withdraw Modal for each user -->
            <div class="modal fade" id="withdrawModal{{ $user->id }}" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form action="{{ route('admin.withdrawals.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Process Withdrawal for {{ $user->name }}</h4>
                    </div>
                    <div class="modal-body">
                      <p>Current Balance: <strong class="text-green">${{ number_format($user->balance ?? 0, 2) }}</strong></p>
                      <div class="form-group">
                        <label>Withdrawal Amount</label>
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input type="number" step="0.01" min="0.01" max="{{ $user->balance ?? 0 }}" name="amount" class="form-control" required>
                        </div>
                        <p class="help-block">This will deduct the amount from user's balance.</p>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-danger">Process Withdrawal</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            @empty
            <tr>
              <td colspan="5" class="text-center">No users found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Quick Withdrawal</h3>
      </div>
      <form action="{{ route('admin.withdrawals.process') }}" method="POST">
        @csrf
        <div class="box-body">
          <div class="form-group">
            <label>Select User</label>
            <select name="user_id" class="form-control" required>
              <option value="">Choose a user</option>
              @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} (${{ number_format($user->balance ?? 0, 2) }})</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Amount</label>
            <div class="input-group">
              <span class="input-group-addon">$</span>
              <input type="number" step="0.01" min="0.01" name="amount" class="form-control" required>
            </div>
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-danger btn-block">Process Withdrawal</button>
        </div>
      </form>
    </div>

    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Note</h3>
      </div>
      <div class="box-body">
        <p>Processing a withdrawal will:</p>
        <ul>
          <li>Deduct the specified amount from the user's balance</li>
          <li>Record the transaction for audit purposes</li>
        </ul>
        <p class="text-danger"><strong>Note:</strong> Make sure to complete the actual payment transfer to the user before processing here.</p>
      </div>
    </div>
  </div>
</div>
@endsection
