<?php
require 'function.php';
require 'cek.php'
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Petugas</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" >
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

    </head>

    <body class="sb-nav-fixed">

        <!-- Navigation Bar -->
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <a class="navbar-brand" href="index.html">Rumah Parquet</a>
        </nav>

        <!-- Side Navigation -->
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">

                    <!-- List -->
                        <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-solid fa-warehouse"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="petugas.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Petugas
                            </a>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>

                    </div>
                </nav>
            </div>
        <!-- End Navigation Bar -->


        <!-- Page of Content -->
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Petugas</h1>
                        <div class="card mb-4">

                            <div class="card-header">

                            <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Tambah Petugas
                                </button>

                            </div>

                            <!-- Data Table -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Petugas</th>
                                                <th>Alamat</th>
                                                <th>No. HP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ambilsemuadatastock = mysqli_query($conn, "select * from petugas");
                                            $i = 1;
                                            while ($data=mysqli_fetch_array($ambilsemuadatastock)){
                                                $nama = $data['namapetugas'];
                                                $alamat = $data['alamat'];
                                                $telp = $data['notelp'];
                                            ?>

                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$nama;?></td>
                                                <td><?=$alamat;?></td>
                                                <td><?=$telp;?></td>
                                            </tr>
                                            <?php

                                            };

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

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Petugas</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form method="post">
                <div class="modal-body">
                    <p>Nama Petugas</p>
                    <input type="text" id="namapetugas" name="namapetugas" class="form-control" required>
                    <br>
                    <p>Alamat</p>
                    <input type="text" id="alamat" name="alamat" class="form-control" required>
                    <br>
                    <p>No. HP</p>
                    <input type="text" name="notelp" id="notelp" class="form-control" required>
                    <br>
                    <button type="submit" class="btn btn-primary" name="tambahpetugasbaru">Submit</button>
                </div>
            </form>

            </div>
        </div>
    </div>

    
    <!-- Scanner Container -->
    <div id="scanner-container" style="display:none; justify-content:center; align-items:center; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999;">
        <div id="scanner" style="width:500px; height:400px; background-color:#fff;"></div>
        <button type="button" class="btn btn-danger mt-3" onclick="stopScanner()">Tutup</button>
    </div>

</html>
