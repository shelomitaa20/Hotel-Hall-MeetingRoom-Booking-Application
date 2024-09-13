<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hotel</title>

    <!-- Styles -->
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
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('template/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Alexander Pierce</a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ url('admin') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Ruangan<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('tambah_ruangan') }}" class="nav-link active">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tambah Data</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('lihat_ruangan') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Lihat Data</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row" style="display: flex; justify-content: center;">
                    <div class="col-md-8">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Tambah Data Ruangan</h3>
                            </div>
                            <form action="{{ url('tambah_data') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nama Ruangan</label>
                                        <input type="text" class="form-control" name="nama_ruangan" placeholder="Masukkan Nama">
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Ruangan</label>
                                        <select name="jenis_ruangan" class="form-control select2" style="width: 100%;">
                                            <option value="meeting_room" selected="selected">Meeting Room</option>
                                            <option value="hall">Hall</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Harga</label>
                                        <input type="text" class="form-control" name="harga" placeholder="Masukkan Harga">
                                    </div>
                                    <div class="form-group">
                                        <label>Fasilitas</label>
                                        <textarea class="form-control" name="fasilitas" placeholder="Masukkan Fasilitas"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea class="form-control" name="deskripsi" placeholder="Masukkan Deskripsi"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Jumlah</label>
                                        <input type="number" class="form-control" name="jumlah" placeholder="Masukkan Jumlah">
                                    </div>
                                    <div class="form-group">
                                        <label>Kapasitas</label>
                                        <input type="number" class="form-control" name="kapasitas" placeholder="Masukkan Kapasitas">
                                    </div>
                                    <div class="form-group">
                                        <label>Gambar</label>
                                        <input type="file" class="form-control" name="gambar">
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
</div>

<script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('template/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('template/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/sparklines/sparkline.js') }}"></script>
<script src="{{ asset('template/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('template/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ asset('template/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<script src="{{ asset('template/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('template/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('template/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('template/dist/js/adminlte.js') }}"></script>
</body>
</html>
