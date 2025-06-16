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
        <title>Barang Masuk</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
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
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
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
                        <h1 class="mt-4">Barang Masuk</h1>
                        <div class="card mb-4">

                            <!-- Button to Open the Modal -->
                            <div class="card-header">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Tambah Barang
                                </button>
                            </div>

                            <!-- Data Table -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Barcode</th>
                                                <th>Nama Barang</th>
                                                <th>Satuan</th>
                                                <th>Jumlah Masuk</th>
                                                <th>Petugas
                                                <th>Tanggal & Waktu</th>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ambilsemuadatastock = mysqli_query($conn, "select * from masuk");
                                            $i = 1;
                                            while ($data=mysqli_fetch_array($ambilsemuadatastock)){
                                                $barcode = $data['barcode'];
                                                $namabarang = $data['namabarang'];
                                                $satuan = $data['satuan'];
                                                $qty = $data['qty'];
                                                $petugas = $data['petugas'];
                                                $tgl = $data['tgl'];
                                            ?>

                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$barcode;?></td>
                                                <td><?=$namabarang;?></td>
                                                <td><?=$satuan;?></td>
                                                <td><?=$qty;?></td>
                                                <td><?=$petugas;?></td>
                                                <td><?=$tgl;?></td>
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

    <!-- End of Script -->

    </body>

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Barang</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form method="post">
                <div class="modal-body">
                    <p>Barcode</p>
                    <div class="input-group mb-3">
                        <input type="text" id="barcode" name="barcode" class="form-control" required>
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button" id="btnBarcode" onclick="startScanner()">
                                <i class="fas fa-camera"></i>  Scan
                            </button>
                        </div>
                    </div>

                    <p>Nama Barang</p>
                    <input type="text" id="namabarang" name="namabarang" class="form-control" readonly>
                    <br>
                    <p>Satuan</p>
                    <input type="text" id="satuan" name="satuan" class="form-control" readonly>
                    <br>
                    <p>Quantity</p>
                    <input type="number" name="qty" placeholder="0" class="form-control" required>
                    <br>
                    <p>Petugas</p>
                    <input type="text" name="petugas" class="form-control" required>
                    <br>
                    <button type="submit" class="btn btn-primary" name="tambahbarangmasuk">Submit</button>
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
