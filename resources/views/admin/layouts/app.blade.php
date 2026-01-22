<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title', 'Admin Panel') | NFT Admin</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('admin-assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('admin-assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('admin-assets/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin-assets/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="{{ asset('admin-assets/dist/css/skins/_all-skins.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('admin-assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  
  @stack('styles')

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{ route('admin.dashboard') }}" class="logo">
      <span class="logo-mini"><b>NFT</b></span>
      <span class="logo-lg"><b>NFT</b> Admin</span>
    </a>
    
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('admin-assets/dist/img/user2-160x160.jpg') }}" class="user-image" alt="Admin">
              <span class="hidden-xs">{{ Auth::user()->name ?? 'Admin' }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="{{ asset('admin-assets/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="Admin">
                <p>
                  {{ Auth::user()->name ?? 'Admin' }}
                  <small>Administrator</small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ route('home') }}" class="btn btn-default btn-flat">Main Site</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Sign out
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- Left side column -->
  <aside class="main-sidebar">
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('admin-assets/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="Admin">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name ?? 'Admin' }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        
        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <a href="{{ route('admin.dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <li class="header">MANAGEMENT</li>
        
        <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
          <a href="{{ route('admin.users.index') }}">
            <i class="fa fa-users"></i> <span>Users</span>
          </a>
        </li>

        <li class="{{ request()->routeIs('admin.nfts.*') ? 'active' : '' }}">
          <a href="{{ route('admin.nfts.index') }}">
            <i class="fa fa-image"></i> <span>NFTs</span>
          </a>
        </li>

        <li class="{{ request()->routeIs('admin.auctions.*') ? 'active' : '' }}">
          <a href="{{ route('admin.auctions.index') }}">
            <i class="fa fa-gavel"></i> <span>Auctions</span>
          </a>
        </li>

        <li class="{{ request()->routeIs('admin.bids.*') ? 'active' : '' }}">
          <a href="{{ route('admin.bids.index') }}">
            <i class="fa fa-money"></i> <span>Bids</span>
          </a>
        </li>

        <li class="header">TRANSACTIONS</li>

        <li class="{{ request()->routeIs('admin.deposits.*') ? 'active' : '' }}">
          <a href="{{ route('admin.deposits.index') }}">
            <i class="fa fa-arrow-down"></i> <span>Deposits</span>
          </a>
        </li>

        <li class="{{ request()->routeIs('admin.withdrawals.*') ? 'active' : '' }}">
          <a href="{{ route('admin.withdrawals.index') }}">
            <i class="fa fa-arrow-up"></i> <span>Withdrawals</span>
          </a>
        </li>

        <li class="header">SETTINGS</li>
        
        <li class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
          <a href="{{ route('admin.settings.index') }}">
            <i class="fa fa-cog"></i> <span>Settings</span>
          </a>
        </li>
      </ul>
    </section>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
      <h1>
        @yield('page-title', 'Dashboard')
        <small>@yield('page-description', '')</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        @yield('breadcrumb')
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @if(session('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-check"></i> Success!</h4>
          {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-ban"></i> Error!</h4>
          {{ session('error') }}
        </div>
      @endif

      @if($errors->any())
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-ban"></i> Validation Error!</h4>
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @yield('content')
    </section>
  </div>

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; {{ date('Y') }} <a href="{{ route('home') }}">NFT Platform</a>.</strong> All rights reserved.
  </footer>

</div>

<!-- jQuery 3 -->
<script src="{{ asset('admin-assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('admin-assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('admin-assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin-assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin-assets/dist/js/adminlte.min.js') }}"></script>

<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>

@stack('scripts')

</body>
</html>
