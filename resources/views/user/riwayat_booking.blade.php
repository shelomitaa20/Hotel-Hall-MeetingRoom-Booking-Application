<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Riwayat Booking</title>

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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
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
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>
                  Booking
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{url('user')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Hall/Meeting Room</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="{{url('riwayat_booking')}}" class="nav-link active">
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
              <h1 class="m-0">Riwayat Booking</h1>
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

          @if($bookings->isEmpty())
            <p>No bookings found.</p>
          @else
            <div class="row">
              @foreach($bookings as $booking)
                @if($booking->room)
                  <div class="col-md-12 col-lg-6 col-xl-4 mb-3">
                    <div class="card h-100 {{ $booking->transaction ? 'border-success' : '' }}">
                      <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-black display-5 font-weight-bold">{{ $booking->room->nama_ruangan }}</h5>
                        <p class="card-text pb-1 pt-1 text-black flex-grow-1">
                          {{ $booking->user->name }} <br>
                          Booking at {{ $booking->tgl }} <br>
                          Check In at {{ $booking->jam_mulai }} <br>
                          Check Out at {{ $booking->jam_selesai }} <br>
                          @if($booking->snack)
                            Paket Snack: {{ $booking->snack->jenis_snack }} <br>
                          @endif
                          @if($booking->transaction)
                            <span class="badge badge-success">Payment Status: {{ ucfirst($booking->transaction->status) }}</span>
                          @else
                            <form action="{{ url('booking/pay', $booking->id) }}" method="POST">
                              @csrf
                              <button type="submit" class="btn btn-primary mt-2">Proceed to Payment</button>
                            </form>
                          @endif
                        </p>
                        <div class="mt-auto d-flex justify-content-between">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bookingModal{{ $booking->id }}">
                            Detail Booking
                          </button>
                          <button type="button" class="btn btn-danger cancel-booking" data-id="{{ $booking->id }}">
                            Cancel Booking
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Booking Detail Modal -->
                  <div class="modal fade" id="bookingModal{{ $booking->id }}" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel{{ $booking->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="bookingModalLabel{{ $booking->id }}">Detail Booking</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <table class="table table-bordered">
                            <tr>
                              <th>Ruangan</th>
                              <td>{{ $booking->room->nama_ruangan }}</td>
                            </tr>
                            <tr>
                              <th>Nama</th>
                              <td>{{ $booking->user->name }}</td>
                            </tr>
                            <tr>
                              <th>Email</th>
                              <td>{{ $booking->user->email }}</td>
                            </tr>
                            <tr>
                              <th>Nomor Telepon</th>
                              <td>{{ $booking->no_tlp }}</td>
                            </tr>
                            <tr>
                              <th>Jumlah Orang</th>
                              <td>{{ $booking->jml_orang }}</td>
                            </tr>
                            <tr>
                              <th>Tanggal</th>
                              <td>{{ $booking->tgl }}</td>
                            </tr>
                            <tr>
                              <th>Jam Mulai</th>
                              <td>{{ $booking->jam_mulai }}</td>
                            </tr>
                            <tr>
                              <th>Jam Selesai</th>
                              <td>{{ $booking->jam_selesai }}</td>
                            </tr>
                            <tr>
                              <th>Status Pembayaran</th>
                              <td>
                                @if($booking->transaction)
                                  <span class="badge badge-success">Payment Status: {{ ucfirst($booking->transaction->status) }}</span>
                                @else
                                  <span class="badge badge-danger">Payment Pending</span>
                                @endif
                              </td>
                            </tr>
                            @if($booking->snack)
                              <tr>
                                <th>Paket Snack</th>
                                <td>{{ $booking->snack->jenis_snack }}</td>
                              </tr>
                            @endif
                          </table>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                @endif
              @endforeach
            </div>
          @endif
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.2.0
      </div>
      <strong>&copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>

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
  <!-- AdminLTE App -->
  <script src="{{ asset('template/dist/js/adminlte.js') }}"></script>

  <!-- Include Toastr JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <!-- Include SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <script>
    $(document).ready(function() {
        $('.cancel-booking').on('click', function() {
            var bookingId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to cancel this booking?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('booking/cancel') }}/' + bookingId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Cancelled!',
                                    response.message,
                                    'success'
                                );
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message,
                                    'error'
                                );
                            }
                        }
                    });
                }
            });
        });
    });
</script>
</body>
</html>
