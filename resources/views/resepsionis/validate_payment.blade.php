<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Validate Payment</title>
    <!-- Add the same CSS includes as your previous views -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('template/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-key"></i>
              <p>
                Receptionist
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('resepsionis/checkin') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Check In</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('resepsionis/checkout') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Check Out</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('resepsionis/validate-payment') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Validate Payment</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Validate Payment</h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @if(Session::has('message'))
          <div class="alert alert-success">
            {{ Session::get('message') }}
          </div>
        @endif

        @if(Session::has('error'))
          <div class="alert alert-danger">
            {{ Session::get('error') }}
          </div>
        @endif

        <div class="card">
          <div class="card-body">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">User</th>
                  <th scope="col">Room</th>
                  <th scope="col">Booking Date</th>
                  <th scope="col">Transaction Date</th>
                  <th scope="col">Total Price</th>
                  <th scope="col">Payment Method</th>
                  <th scope="col">Payment Proof</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($transactions as $transaction)
                  <tr id="transaction-{{ $transaction->id }}">
                    <th scope="row">{{ $transaction->id }}</th>
                    <td>{{ $transaction->booking->user->name }}</td>
                    <td>{{ $transaction->booking->room->nama_ruangan }}</td>
                    <td>{{ $transaction->booking->created_at }}</td>
                    <td>{{ $transaction->created_at }}</td>
                    <td>{{ $transaction->total_harga }}</td>
                    <td>{{ $transaction->metode }}</td>
                    <td>
                      @if($transaction->bukti_pembayaran)
                        <a href="{{ asset('storage/' . $transaction->bukti_pembayaran) }}" target="_blank">
                          View Proof
                        </a>
                      @else
                        No proof provided
                      @endif
                    </td>
                    <td>
                      <form action="{{ route('resepsionis.validate.payment') }}" method="POST" onsubmit="return confirm('Are you sure you want to proceed?')">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                        <button type="submit" name="status" value="valid" class="btn btn-success">Valid</button>
                        <button type="submit" name="status" value="invalid" class="btn btn-danger">Invalid</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
<!-- jQuery -->
<script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('template/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('template/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('template/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('template/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('template/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('template/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('template/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('template/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('template/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('template/dist/js/adminlte.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
  $(document).ready(function() {
    @if(Session::has('message'))
      toastr.success("{{ Session::get('message') }}");
    @endif

    @if(Session::has('error'))
      toastr.error("{{ Session::get('error') }}");
    @endif
  });
</script>
</body>
</html>
