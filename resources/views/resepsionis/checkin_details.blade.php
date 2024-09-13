<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Check In Details</title>

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
                <a href="{{ url('resepsionis/checkin') }}" class="nav-link active">
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
                <a href="{{ url('resepsionis/validate-payment') }}" class="nav-link">
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
            <h1 class="m-0">Check In Details</h1>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

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

        @if(!$paymentCompleted)
          <div class="alert alert-warning">
            Payment must be completed before check-in.
          </div>
        @endif

        <div class="card">
          <div class="card-body">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <th>Booking ID</th>
                  <td>{{ $booking->id }}</td>
                </tr>
                <tr>
                  <th>User</th>
                  <td>{{ $booking->user->name }}</td>
                </tr>
                <tr>
                  <th>Room</th>
                  <td>{{ $booking->room->nama_ruangan }}</td>
                </tr>
                <tr>
                  <th>Date</th>
                  <td>{{ $booking->tgl }}</td>
                </tr>
                <tr>
                  <th>Start Time</th>
                  <td>{{ $booking->jam_mulai }}</td>
                </tr>
                <tr>
                  <th>End Time</th>
                  <td>{{ $booking->jam_selesai }}</td>
                </tr>
                <tr>
                  <th>Phone Number</th>
                  <td>{{ $booking->no_tlp }}</td>
                </tr>
                <tr>
                  <th>Number of People</th>
                  <td>{{ $booking->jml_orang }}</td>
                </tr>
                <tr>
                  <th>Snack</th>
                  <td>{{ $booking->snack ? $booking->snack->jenis_snack : 'None' }}</td>
                </tr>
              </tbody>
            </table>

            @php
              $currentDate = \Carbon\Carbon::now()->startOfDay();
              $bookingDate = \Carbon\Carbon::parse($booking->tgl)->startOfDay();
            @endphp

            <form action="{{ route('resepsionis.checkin') }}" method="POST">
              @csrf
              <input type="hidden" name="booking_id" value="{{ $booking->id }}">
              <div class="d-flex justify-content-between">
                <a href="{{ url('resepsionis/checkin') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary" 
                        @if(!$paymentCompleted || $currentDate->lessThan($bookingDate)) 
                          disabled 
                        @endif>
                  Check In
                </button>
              </div>
            </form>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

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

    // Show message if Check In button is clicked but disabled
    $('.btn-primary').on('click', function(event) {
      if ($(this).is(':disabled')) {
        event.preventDefault();
        toastr.warning('Check-in is not allowed before the booking date or without payment completion.');
      }
    });
  });
</script>
</body>
</html>
