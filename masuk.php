 <?php
require 'config/koneksi.php';
require 'functions/masuk_functions.php';
require 'config/cek.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Barang Masuk</title>
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
                        </div>
                    </div>
                    <!--footer-->
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Admin
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
                            <li class="breadcrumb-item"><strong>Barang Masuk</strong></li>
                        </ol>
                        <div class="card mb-4">
                            <!-- Data Table -->
                            <div class="card-header">
                                <i class="fas fa-table"></i> DataTable Barang Masuk
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <!-- Kolom kiri: Search + Tanggal -->
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <!-- Dropdown Data Length -->
                                            <div class="col-auto mb-2">
                                                <label class="d-flex align-items-center mb-0">
                                                    <select id="customLength" class="custom-select custom-select-sm form-control form-control-sm mx-2">
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                </label>
                                            </div>
                                            <!-- Search -->
                                            <div class="col-sm-12 col-md-3 mb-2">
                                                <input type="text" id="customSearch" class="form-control" placeholder="Cari Barang Masuk">
                                            </div>
                                            <!-- Min Date -->
                                            <div class="col-sm-6 col-md-3 mb-2">
                                                <input type="date" id="minDate" class="form-control" placeholder="Dari Tanggal">
                                            </div>
                                            <!-- Max Date -->
                                            <div class="col-sm-6 col-md-3 mb-2">
                                                <input type="date" id="maxDate" class="form-control" placeholder="Sampai Tanggal">
                                            </div>
                                            <!-- Filter Button -->
                                            <div class="col-sm-12 col-md-1 mb-2">
                                                <button class="btn btn-info w-100" id="btnFilterTanggal">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Kolom kanan: Tombol Aksi -->
                                    <div class="col-lg-3 d-flex justify-content-lg-end flex-wrap align-items-start">
                                        <a href="masuk_tambah.php" class="btn btn-primary mr-2 mb-2">
                                            <i class="fas fa-plus"></i> Tambah
                                        </a>
                                        <button id="btnCetak" class="btn btn-secondary mb-2">
                                            <i class="fas fa-print"></i> Print
                                        </button>
                                    </div>
                                </div> 
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal & Waktu</th>
                                                <th>Barcode</th>
                                                <th>Nama Barang</th>
                                                <th>Satuan</th>
                                                <th>Jumlah Masuk</th>
                                                <th>Keterangan</th>
                                                <th>Petugas</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $bulanIndo = [
                                                    'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
                                                    'April' => 'April', 'May' => 'Mei', 'June' => 'Juni',
                                                    'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September',
                                                    'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
                                                ];

                                                $ambilsemuadatastock = mysqli_query($conn, "
                                                    SELECT masuk.*, stock.namabarang, stock.satuan 
                                                    FROM masuk 
                                                    LEFT JOIN stock ON masuk.barcode = stock.barcode
                                                ");

                                                $i = 1;
                                                while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                                    // Format tanggal untuk data-sort dan tampilan
                                                    $tglSort = date('Y-m-d', strtotime($data['tgl'])); // untuk filter
                                                    $tglIndo = strtr(date('d F Y', strtotime($data['tgl'])), $bulanIndo); // untuk tampilan

                                                    $barcode = $data['barcode'];
                                                    $namabarang = $data['namabarang'];
                                                    $satuan = $data['satuan'];
                                                    $qty = $data['qty'];
                                                    $keterangan = $data['keterangan'];
                                                    $petugas = $data['petugas'];
                                                ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td data-sort="<?= $tglSort; ?>"><?= $tglIndo; ?></td>
                                                    <td><?= $barcode; ?></td>
                                                    <td><?= $namabarang; ?></td>
                                                    <td><?= $satuan; ?></td>
                                                    <td><?= $qty; ?></td>
                                                    <td><?= $keterangan; ?></td>
                                                    <td><?= $petugas; ?></td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <!-- Tombol Edit -->
                                                            <a href="masuk_edit.php?id=<?= $data['id']; ?>" class="btn btn-warning btn-sm mr-1">
                                                                <i class="fas fa-edit"></i>
                                                            </a>

                                                            <!-- Tombol Hapus -->
                                                            <form method="post" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                                <input type="hidden" name="idmasuk" value="<?= $data['id']; ?>">
                                                                <button type="submit" name="hapusmasuk" class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                        </tbody>
                                    </table>
                                </div>
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <!-- End of Script -->
    </body>
</html>