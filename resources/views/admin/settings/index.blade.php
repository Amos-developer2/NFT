@extends('admin.layouts.app')

@section('title', 'Settings')
@section('page-title', 'Settings')
@section('page-description', 'System configuration')

@section('breadcrumb')
<li class="active">Settings</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">General Settings</h3>
      </div>
      <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="box-body">
          <div class="form-group">
            <label>Site Name</label>
            <input type="text" name="site_name" class="form-control" value="{{ config('app.name') }}">
          </div>
          
          <div class="form-group">
            <label>Contact Email</label>
            <input type="email" name="contact_email" class="form-control" value="{{ config('mail.from.address') }}">
          </div>

          <div class="form-group">
            <label>Timezone</label>
            <select name="timezone" class="form-control">
              <option value="UTC" {{ config('app.timezone') == 'UTC' ? 'selected' : '' }}>UTC</option>
              <option value="America/New_York" {{ config('app.timezone') == 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
              <option value="America/Los_Angeles" {{ config('app.timezone') == 'America/Los_Angeles' ? 'selected' : '' }}>America/Los_Angeles</option>
              <option value="Europe/London" {{ config('app.timezone') == 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
              <option value="Asia/Tokyo" {{ config('app.timezone') == 'Asia/Tokyo' ? 'selected' : '' }}>Asia/Tokyo</option>
            </select>
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Save Settings</button>
        </div>
      </form>
    </div>

    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">NFT Settings</h3>
      </div>
      <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="box-body">
          <div class="form-group">
            <label>Default NFT Price</label>
            <div class="input-group">
              <span class="input-group-addon">$</span>
              <input type="number" step="0.01" name="default_nft_price" class="form-control" value="100.00">
            </div>
          </div>
          
          <div class="form-group">
            <label>Auction Minimum Bid Increment</label>
            <div class="input-group">
              <span class="input-group-addon">$</span>
              <input type="number" step="0.01" name="min_bid_increment" class="form-control" value="1.00">
            </div>
          </div>

          <div class="form-group">
            <label>Default Auction Duration (hours)</label>
            <input type="number" name="default_auction_duration" class="form-control" value="24">
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-warning">Save NFT Settings</button>
        </div>
      </form>
    </div>
  </div>

  <div class="col-md-6">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Payment Settings</h3>
      </div>
      <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="box-body">
          <div class="form-group">
            <label>Minimum Deposit Amount</label>
            <div class="input-group">
              <span class="input-group-addon">$</span>
              <input type="number" step="0.01" name="min_deposit" class="form-control" value="10.00">
            </div>
          </div>
          
          <div class="form-group">
            <label>Minimum Withdrawal Amount</label>
            <div class="input-group">
              <span class="input-group-addon">$</span>
              <input type="number" step="0.01" name="min_withdrawal" class="form-control" value="50.00">
            </div>
          </div>

          <div class="form-group">
            <label>Withdrawal Fee (%)</label>
            <div class="input-group">
              <input type="number" step="0.1" name="withdrawal_fee" class="form-control" value="2.5">
              <span class="input-group-addon">%</span>
            </div>
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-success">Save Payment Settings</button>
        </div>
      </form>
    </div>

    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">System Information</h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered">
          <tr>
            <td><strong>PHP Version</strong></td>
            <td>{{ PHP_VERSION }}</td>
          </tr>
          <tr>
            <td><strong>Laravel Version</strong></td>
            <td>{{ app()->version() }}</td>
          </tr>
          <tr>
            <td><strong>Environment</strong></td>
            <td>{{ config('app.env') }}</td>
          </tr>
          <tr>
            <td><strong>Debug Mode</strong></td>
            <td>
              @if(config('app.debug'))
                <span class="label label-warning">Enabled</span>
              @else
                <span class="label label-success">Disabled</span>
              @endif
            </td>
          </tr>
          <tr>
            <td><strong>Total Users</strong></td>
            <td>{{ \App\Models\User::count() }}</td>
          </tr>
          <tr>
            <td><strong>Total NFTs</strong></td>
            <td>{{ \App\Models\Nft::count() }}</td>
          </tr>
        </table>
      </div>
    </div>

    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">Danger Zone</h3>
      </div>
      <div class="box-body">
        <p>These actions are irreversible. Please be careful.</p>
        <button type="button" class="btn btn-danger" onclick="nativeConfirm('Are you sure you want to clear all cache?', { title: 'Clear Cache', danger: true, confirmText: 'Clear' }).then(ok => { if(ok) nativeSuccess('Cache cleared!', 'Done'); })">
          <i class="fa fa-refresh"></i> Clear All Cache
        </button>
      </div>
    </div>
  </div>
</div>
@endsection
