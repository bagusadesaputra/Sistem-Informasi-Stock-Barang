<?php
require 'config/koneksi.php';
require 'functions/function.php';
require 'config/cek.php';

if (!isset($_SESSION['log'])) {
    header('Location: login.php');
    exit;
}

// Validasi role
if ($_SESSION['role'] != 'superadmin') {
    echo "<script>alert('Anda tidak punya akses ke halaman ini!'); window.location='index.php';</script>";
    exit;
}

// Ambil role dari ENUM di database
$roles = [];
$result = $conn->query("SHOW COLUMNS FROM login LIKE 'role'");
if ($result) {
    $row = $result->fetch_assoc();
    preg_match("/^enum\('(.*)'\)$/", $row['Type'], $matches);
    $roles = explode("','", $matches[1]);
}

// Proses simpan user baru
if (isset($_POST['simpan'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password']; // langsung simpan plain text
    $role = $_POST['role'];

    if (!empty($username) && !empty($password) && !empty($role)) {
        $stmt = $conn->prepare("INSERT INTO login (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $role); // password tanpa hash

        if ($stmt->execute()) {
            echo "<script>alert('Akun berhasil dibuat!'); window.location='petugas.php';</script>";
        } else {
            echo "<script>alert('Gagal membuat akun!');</script>";
        }
    } else {
        echo "<script>alert('Semua field harus diisi!');</script>";
    }
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
        <title>Satuan</title>
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


<!-- page of Content -->
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4"></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="petugas.php">Petugas</a></li>
                            <li class="breadcrumb-item"><strong>Tambah</strong></li>
                        </ol>
                        <div class="card shadow mb-4">
                            <div class="card-header">Tambah Petugas</div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select name="role" class="form-control" required>
                                                <option value="">Pilih Role</option>
                                                <?php foreach ($roles as $role): ?>
                                                    <option value="<?= htmlspecialchars($role) ?>"><?= ucfirst($role) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                                        <a href="petugas.php" class="btn btn-secondary">Kembali</a>
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
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="js/scripts.js"></script>
        <!-- Functions -->
        
            <!-- AJAX - Autofill text dari barcode -->
            <script>
                $(document).ready(function () {
                    $('#barcode').on('keyup', function () {
                        var barcode = $(this).val();
                        if (barcode.length > 0) {
                        $.ajax({
                            url: 'get_barang.php',
                            method: 'POST',
                            data: { barcode: barcode },
                            dataType: 'json',
                            success: function (data) {
                            if (data && data.namabarang) {
                                $('#namabarang').val(data.namabarang);
                                $('#satuan').val(data.satuan);
                            } else {
                                $('#namabarang').val('');
                                $('#satuan').val('');
                            }
                            },
                            error: function (xhr, status, error) {
                            console.error('AJAX Error:', error);
                            }
                        });
                        } else {
                        $('#namabarang').val('');
                        $('#satuan').val('');
                        }
                    });
                });
            </script>
            
            <script>
                function fetchBarang(barcode) {
                    fetch('get_barang.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'barcode=' + encodeURIComponent(barcode)
                    })
                    .then(response => response.text()) // ubah dulu ke .text() untuk debug
                    .then(data => {
                        console.log('Respon dari PHP:', data); // LIHAT apa yang dikembalikan
                        try {
                            let json = JSON.parse(data);
                            if (json.namabarang && json.satuan) {
                                document.getElementById('namabarang').value = json.namabarang;
                                document.getElementById('satuan').value = json.satuan;
                            } else {
                                alert("Data tidak ditemukan");
                            }
                        } catch (e) {
                            console.error("Gagal parse JSON:", e);
                            alert("Respon bukan JSON: " + data);
                        }
                    })
                    .catch(error => {
                        console.error("AJAX Error:", error);
                    });
                }
            </script>

            <!-- Barcode Scanner -->
            <script>
                function startScanner() {
                    document.getElementById('scanner-container').style.display = 'flex';
                    Quagga.init({
                        inputStream: {
                            name: "Live",
                            type: "LiveStream",
                            target: document.querySelector('#scanner')
                        },
                        decoder: {
                            readers: ["code_128_reader", "ean_reader", "ean_8_reader", "upc_reader", "code_39_reader"]
                        }
                    }, function (err) {
                        if (err) {
                            console.log(err);
                            alert("Error: " + err);
                            return;
                        }
                        Quagga.start();
                    });
                    Quagga.onDetected(function (result) {
                        var kode = result.codeResult.code;
                        document.getElementById('barcode').value = kode;
                        fetchBarang(kode); // PANGGIL AJAX untuk mengisi nama dan satuan
                        stopScanner(); // otomatis close scanner setelah dapat barcode
                    });
                }

                function stopScanner() {
                    Quagga.stop();
                    document.getElementById('scanner-container').style.display = 'none';
                }
            </script>

            <!-- Untuk Ekspor datatable menjadi csv -->
            <script>
                $(document).ready(function () {
                    // Hancurkan jika sebelumnya sudah ada
                    if ($.fn.DataTable.isDataTable('#dataTable')) {
                        $('#dataTable').DataTable().destroy();
                    }

                    // Inisialisasi ulang dengan tombol CSV
                    var table = $('#dataTable').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'csvHtml5',
                                title: 'Laporan_BarangMasuk',
                                className: 'd-none' // tombol tidak terlihat
                            }
                        ]
                    });

                    // Saat tombol diklik, trigger ekspor
                    $('#btnCetak').on('click', function () {
                        table.button('.buttons-csv').trigger();
                    });
                });
            </script>

    <!-- End of Script -->

    </body>
    
    <!-- Scanner Container -->
    <div id="scanner-container" style="display:none; justify-content:center; align-items:center; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999;">
        <div id="scanner" style="width:500px; height:400px; background-color:#fff;"></div>
        <button type="button" class="btn btn-danger mt-3" onclick="stopScanner()">Tutup</button>
    </div>

</html>
