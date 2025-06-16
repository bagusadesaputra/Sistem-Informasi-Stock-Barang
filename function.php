<?php
session_start();

//membuat koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "stockbarang");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//menambah barang baru
if(isset($_POST['addnewbarang'])){
    $barcode = $_POST['barcode'];
    $namabarang = $_POST['namabarang'];
    $satuan = $_POST['satuan'];
    $qty = $_POST['qty'];
    $keterangan = $_POST['keterangan'];

    $addtotable = mysqli_query($conn, "INSERT INTO stock (barcode, namabarang, satuan, qty, keterangan) VALUES ('$barcode', '$namabarang', '$satuan', '$qty', '$keterangan')");
    if($addtotable) {
        header('location:index.php');
    } else {
        //echo 'Input Gagal';
        header('location:index.php');
    }
}

//menambah barang masuk
if (isset($_POST['tambahbarangmasuk'])) {
    $barcode = $_POST['barcode'];
    $qty = intval($_POST['qty']);
    $petugas = $_POST['petugas'];

    // Ambil detail barang dari tabel stock
    $cek = mysqli_query($conn, "SELECT * FROM stock WHERE barcode='$barcode'");
    $data = mysqli_fetch_assoc($cek);

    if ($data) {
        $namabarang = $data['namabarang'];
        $satuan = $data['satuan'];

        // Insert ke tabel masuk
        $insert = mysqli_query($conn, "INSERT INTO masuk (barcode, namabarang, satuan, qty, petugas) VALUES (
            '$barcode',
            '$namabarang',
            '$satuan',
            '$qty',
            '$petugas'
        )");

        if ($insert) {
            // Update qty di tabel stock
            $update = mysqli_query($conn, "UPDATE stock SET qty = qty + $qty WHERE barcode='$barcode'");

            if ($update) {
                //echo "<script>alert('Barang masuk berhasil ditambahkan'); window.location.href='masuk.php';</script>";
            } else {
                //echo "<script>alert('Gagal update stock');</script>";
            }
        } else {
            //echo "<script>alert('Gagal insert ke tabel masuk');</script>";
        }
    } else {
        //echo "<script>alert('Barcode tidak ditemukan di tabel stock');</script>";
    }
}
//menambah barang keluar
if (isset($_POST['tambahbarangkeluar'])) {
    $barcode = $_POST['barcode'];
    $qty = intval($_POST['qty']);
    $petugas = $_POST['petugas'];

    // Ambil detail barang dari tabel stock
    $cek = mysqli_query($conn, "SELECT * FROM stock WHERE barcode='$barcode'");
    $data = mysqli_fetch_assoc($cek);

    if ($data) {
        $namabarang = $data['namabarang'];
        $satuan = $data['satuan'];

        // Insert ke tabel keluar
        $insert = mysqli_query($conn, "INSERT INTO keluar (barcode, namabarang, satuan, qty, petugas) VALUES (
            '$barcode',
            '$namabarang',
            '$satuan',
            '$qty',
            '$petugas'
        )");

        if ($insert) {
            // Update qty di tabel stock
            $update = mysqli_query($conn, "UPDATE stock SET qty = qty - $qty WHERE barcode='$barcode'");

            if ($update) {
                //echo "<script>alert('Barang masuk berhasil ditambahkan'); window.location.href='masuk.php';</script>";
            } else {
                //echo "<script>alert('Gagal update stock');</script>";
            }
        } else {
            //echo "<script>alert('Gagal insert ke tabel masuk');</script>";
        }
    } else {
        //echo "<script>alert('Barcode tidak ditemukan di tabel stock');</script>";
    }
}

// get nama barang
if (isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];
    $query = mysqli_query($conn, "SELECT namabarang FROM stock WHERE barcode = '$barcode'");
    $data = mysqli_fetch_array($query);
    
    if ($data) {
        //echo $data['namabarang'];
    } else {
       //echo "";
    }
}


?>