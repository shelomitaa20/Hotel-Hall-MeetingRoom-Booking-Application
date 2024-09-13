<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detail Ruangan</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('template/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('template/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('template/plugins/summernote/summernote-bs4.min.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <div class="sidebar">
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
                <i class="nav-icon fas fa-home"></i>
                <p>Booking<i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{url('user')}}" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Hall/Meeting Room</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="{{url('riwayat_booking')}}" class="nav-link">
                <i class="nav-icon fas fa-history"></i>
                <p>Riwayat Booking</p>
              </a>
            </li>
            <li class="nav-item">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link btn btn-link">
                  <i class="nav-icon fas fa-sign-out-alt"></i>
                  <p>Logout</p>
                </button>
              </form>
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
              <!-- Add any header content here if needed -->
            </div>
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <h5 class="mb-2">Detail Ruangan</h5>
          <div class="card card-success">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="card">
                    <img class="card-img-top" src="{{ asset('template/dist/img/ruanganfoto.jpeg') }}" alt="Ruangan Image">
                    <div class="card-body">
                      <h5 class="card-title text-black">{{ $room->nama_ruangan }}</h5>
                      <p class="card-text pb-1 pt-1 text-black">
                        {{ $room->deskripsi }} <br>
                        Fasilitas: {{ $room->fasilitas }} <br>
                        Harga: Rp{{ number_format($room->harga, 0, ',', '.') }}/hari
                      </p>
                      <p class="card-text text-white mb-0">Terakhir diperbarui {{ $room->updated_at->diffForHumans() }}</p>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Booking Form</h3>
                    </div>
                    <div class="card-body">
                      <form action="{{ url('booking', $room->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                          <label for="no_tlp">Nomor Telepon:</label>
                          <input type="text" class="form-control" id="no_tlp" name="no_tlp" required>
                        </div>
                        <div class="form-group">
                          <label for="jml_orang">Jumlah Orang:</label>
                          <input type="number" class="form-control" id="jml_orang" name="jml_orang" min="1" max="{{ $room->kapasitas }}" required>
                        </div>
                        <div class="form-group">
                          <label for="tgl">Tanggal:</label>
                          <input type="date" class="form-control" id="tgl" name="tgl" required>
                        </div>
                        <div class="form-group">
                          <label for="jam_mulai">Jam Mulai:</label>
                          <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                        </div>
                        <div class="form-group">
                          <label for="jam_selesai">Jam Selesai:</label>
                          <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                        </div>
                        
                        <div class="form-group">
                          <label for="snack_id">Paket Snack/Meal:</label>
                          <select class="form-control" id="snack_id" name="snack_id">
                            <option value="">None</option>
                            @foreach($snacks as $snack)
                              <option value="{{ $snack->id }}">{{ $snack->jenis_snack }} - Rp{{ number_format($snack->harga, 0, ',', '.') }}</option>
                            @endforeach
                          </select>
                        </div>
                        @if($room->jumlah > 0)
                          <button type="submit" class="btn btn-primary">Book Now</button>
                        @else
                          <button type="button" class="btn btn-secondary" disabled>Fully Booked</button>
                        @endif
                      </form>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
        </div>
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
  <!-- JavaScript -->
  <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
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
</body>
</html>
