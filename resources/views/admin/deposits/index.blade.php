@extends('admin.layouts.app')

@section('title', 'Deposits')
@section('page-title', 'Deposits')
@section('page-description', 'Manage all deposits')

@section('breadcrumb')
<li class="active">Deposits</li>
@endsection

@section('content')
<!-- Stats boxes -->
<div class="row">
  <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-dollar"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Deposits</span>
        <span class="info-box-number">${{ number_format($totalDeposits, 2) }}</span>
      </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-clock-o"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Pending Deposits</span>
        <span class="info-box-number">${{ number_format($pendingDeposits, 2) }}</span>
      </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="fa fa-calendar"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Today's Deposits</span>
        <span class="info-box-number">${{ number_format($todayDeposits, 2) }}</span>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Deposits List</h3>
        <div class="box-tools">
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createDepositModal">
            <i class="fa fa-plus"></i> Manual Deposit
          </button>
        </div>
      </div>
      
      <!-- Filters -->
      <div class="box-body">
        <form action="{{ route('admin.deposits.index') }}" method="GET" class="form-inline">
          <div class="form-group">
            <select name="status" class="form-control">
              <option value="">All Statuses</option>
              <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Waiting</option>
              <option value="confirming" {{ request('status') == 'confirming' ? 'selected' : '' }}>Confirming</option>
              <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
              <option value="finished" {{ request('status') == 'finished' ? 'selected' : '' }}>Finished</option>
              <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
              <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
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
            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}" placeholder="From Date">
          </div>
          <div class="form-group">
            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}" placeholder="To Date">
          </div>
          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Filter</button>
          <a href="{{ route('admin.deposits.index') }}" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</a>
        </form>
      </div>

      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>User</th>
              <th>Amount</th>
              <th>Pay ID</th>
              <th>Status</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($deposits as $deposit)
            <tr>
              <td>{{ $deposit->id }}</td>
              <td>
                @if($deposit->user)
                  <a href="{{ route('admin.users.show', $deposit->user) }}">{{ $deposit->user->name }}</a>
                @else
                  <span class="text-muted">Unknown</span>
                @endif
              </td>
              <td>${{ number_format($deposit->amount, 2) }}</td>
              <td><code>{{ $deposit->pay_id ?? 'N/A' }}</code></td>
              <td>
                @if($deposit->status == 'finished')
                  <span class="label label-success">Finished</span>
                @elseif($deposit->status == 'confirmed')
                  <span class="label label-info">Confirmed</span>
                @elseif(in_array($deposit->status, ['pending', 'waiting', 'confirming']))
                  <span class="label label-warning">{{ ucfirst($deposit->status) }}</span>
                @else
                  <span class="label label-danger">{{ ucfirst($deposit->status) }}</span>
                @endif
              </td>
              <td>{{ $deposit->created_at->format('M d, Y H:i') }}</td>
              <td>
                <div class="btn-group">
                  <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown">
                    Status <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="#" onclick="updateStatus({{ $deposit->id }}, 'pending')">Pending</a></li>
                    <li><a href="#" onclick="updateStatus({{ $deposit->id }}, 'waiting')">Waiting</a></li>
                    <li><a href="#" onclick="updateStatus({{ $deposit->id }}, 'confirming')">Confirming</a></li>
                    <li><a href="#" onclick="updateStatus({{ $deposit->id }}, 'confirmed')">Confirmed</a></li>
                    <li><a href="#" onclick="updateStatus({{ $deposit->id }}, 'finished')">Finished</a></li>
                    <li class="divider"></li>
                    <li><a href="#" onclick="updateStatus({{ $deposit->id }}, 'failed')">Failed</a></li>
                    <li><a href="#" onclick="updateStatus({{ $deposit->id }}, 'expired')">Expired</a></li>
                  </ul>
                </div>
                <form action="{{ route('admin.deposits.destroy', $deposit) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this deposit?')">
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
              <td colspan="7" class="text-center">No deposits found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      
      <div class="box-footer clearfix">
        {{ $deposits->appends(request()->query())->links() }}
      </div>
    </div>
  </div>
</div>

<!-- Create Deposit Modal -->
<div class="modal fade" id="createDepositModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('admin.deposits.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Manual Deposit (Admin Credit)</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>User</label>
            <select name="user_id" class="form-control" required>
              <option value="">Select User</option>
              @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
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
          <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
              <option value="finished">Finished (Credit immediately)</option>
              <option value="pending">Pending</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create Deposit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Hidden forms for status updates -->
@foreach($deposits as $deposit)
<form id="status-form-{{ $deposit->id }}" action="{{ route('admin.deposits.updateStatus', $deposit) }}" method="POST" style="display: none;">
  @csrf
  <input type="hidden" name="status" id="status-input-{{ $deposit->id }}">
</form>
@endforeach
@endsection

@push('scripts')
<script>
function updateStatus(depositId, status) {
  if (confirm('Are you sure you want to change the status to ' + status + '?')) {
    document.getElementById('status-input-' + depositId).value = status;
    document.getElementById('status-form-' + depositId).submit();
  }
}
</script>
@endpush
