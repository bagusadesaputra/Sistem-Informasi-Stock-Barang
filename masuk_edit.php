<?php
require 'config/koneksi.php';
require 'functions/masuk_functions.php';
require 'config/cek.php';

if (!isset($_SESSION['log'])) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['role'] != 'superadmin') {
    echo "<script>alert('Anda tidak punya akses ke halaman ini!'); window.location='index.php';</script>";
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data dari tabel masuk dan join dengan stock
    $query = mysqli_query($conn, "
        SELECT masuk.*, stock.namabarang, stock.satuan 
        FROM masuk 
        LEFT JOIN stock ON masuk.barcode = stock.barcode 
        WHERE masuk.id = '$id'
    ");

    if ($data = mysqli_fetch_assoc($query)) {
        $barcode = $data['barcode'];
        $namabarang = $data['namabarang'];
        $satuan = $data['satuan'];
        $qty = $data['qty'];
        $tgl = $data['tgl'];
        $petugas = $_SESSION['username'];
    } else {
        echo "<script>alert('Data tidak ditemukan'); window.location='masuk.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID tidak ditemukan'); window.location='masuk.php';</script>";
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Edit - Barang Masuk</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" >
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

    </head>

    <body class="sb-nav-fixed">

        <!-- Navigation Bar -->
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-light">
            <a class="navbar-brand" href="index.php">Rumah Parquet</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>

            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>

        </nav>

        <!-- Side Navigation -->
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                    <!-- List -->
                        <div class="nav">
                            <?php if ($_SESSION['role'] == 'superadmin'): ?>
                                <div class="sb-sidenav-menu-heading">Master</div>
                                <a class="nav-link" href="index.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-dolly-flatbed"></i></div>
                                    Barang
                                </a>
                                <a class="nav-link" href="jenis.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-th-large"></i></div>
                                    Jenis Barang
                                </a>
                                <a class="nav-link" href="lokasi.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-map-marker-alt"></i></div>
                                    Lokasi Barang
                                </a>
                                <a class="nav-link" href="satuan.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-sort-numeric-up"></i></div>
                                    Satuan Barang
                                </a>
                                <a class="nav-link" href="petugas.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                    Petugas
                                </a>

                                <div class="sb-sidenav-menu-heading">Transaksi Barang</div>
                                <a class="nav-link" href="opname.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-cubes"></i></div>
                                    Opname
                                </a>
                                <a class="nav-link" href="masuk.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-sign-in-alt"></i></div>
                                    Barang Masuk
                                </a>
                                <a class="nav-link" href="keluar.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                                    Barang Keluar
                                </a>
                                <a class="nav-link" href="reject.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-times-circle"></i></div>
                                    Barang Reject
                                </a>

                            <?php elseif ($_SESSION['role'] == 'admin_so'): ?>
                                <div class="sb-sidenav-menu-heading">Menu</div>
                                <a class="nav-link" href="index.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                                    Barang
                                </a>
                                <a class="nav-link" href="opname.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-cubes"></i></div>
                                    Opname
                                </a>
                            
                            <?php elseif ($_SESSION['role'] == 'admin_gudang'): ?>
                                <!-- Menu Admin Gudang -->
                                <div class="sb-sidenav-menu-heading">Menu</div>
                                <a class="nav-link" href="keluar.php">
                                    <div class="sb-nav-link-icon">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </div>Barang Keluar
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!--footer-->
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </div>
                </nav>
            </div>
        <!-- End Navigation Bar -->



        <!-- Page of Content -->
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4"></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="masuk.php">Barang Masuk</a></li>
                            <li class="breadcrumb-item"><strong>Edit</strong></li>
                        </ol>
                        <div class="card shadow mb-4">
                            <div class="card-header">Edit Barang Masuk</div>
                            <div class="card-body">
                                <form method="post">
                                    <input type="hidden" name="id" value="<?= $data['id']; ?>">
                                    <label>Barcode</label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="barcode" class="form-control" value="<?= $data['barcode']; ?>" readonly>
                                    </div>
                                    <label>Nama Barang</label>
                                    <input type="text" id="namabarang" name="namabarang" class="form-control" value="<?= $namabarang ?>" readonly>
                                    <br>
                                    <label>Satuan</label>
                                    <input type="text" id="satuan" name="satuan" class="form-control" value="<?= $satuan ?>" readonly>
                                    <br>
                                    <label>Quantity</label>
                                    <input type="text" name="qty" class="form-control" value="<?= $data['qty']; ?>" required>
                                    <br>
                                    <label>Keterangan</label>
                                    <input type="text" id="" name="keterangan" class="form-control" value="<?= $data['keterangan']; ?>">
                                    <br>
                                    <button type="submit" class="btn btn-warning" name="editmasuk">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>

                <!-- footer -->
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                        </div>
                    </div>
                </footer>
            </div>

        <!-- End of Page Content -->

        </div>

    <!-- Scripts -->
    
        <!-- JavaScript: CDN, Pkg, Script -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="assets/js/datatable.js"></script>
        <script src="assets/js/scanner.js"></script>
        <script src="assets/js/ui.js"></script>
        <!-- Functions -->
    </body>
    <!-- Scanner Container -->
    <div id="scanner-container" style="display:none; justify-content:center; align-items:center; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999;">
        <div id="scanner" style="width:500px; height:400px; background-color:#fff;"></div>
        <button type="button" class="btn btn-danger mt-3" onclick="stopScanner()">Tutup</button>
    </div>

</html>
