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
        echo 'Input Gagal';
        header('location:index.php');
    }
}

//menambah barang masuk
if(isset($_POST['barangmasuk'])){
    $barcodenya = $_POST['barcode'];
    $petugas = $_POST['petugas'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where barcode= '$barcodenya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;

    $addtomasuk = mysqli_query($conn,"INSERT INTO masuk (barcode, petugas, qty) values('$$barcodenya', '$penerima', '$qty')");
    $updatestockmasuk = mysqli_query($conn, "update stock set stock= '$tambahkanstocksekarangdenganquantity' where barcode= '$$barcodenya'");
    if($addtomasuk&&$updatestockmasuk) {
        header('location:masuk.php');
    } else {
        echo 'Input Gagal';
        header('location:masuk.php');
    }
}

// get nama barang
if (isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];
    $query = mysqli_query($conn, "SELECT namabarang FROM stock WHERE barcode = '$barcode'");
    $data = mysqli_fetch_array($query);
    
    if ($data) {
        echo $data['namabarang'];
    } else {
        echo "";
    }
}

//menambah barang keluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang= '$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;

    $addtokeluar = mysqli_query($conn,"INSERT INTO keluar (idbarang, penerima, qty) values('$barangnya', '$penerima', '$qty')");
    $updatestockkeluar = mysqli_query($conn, "update stock set stock= '$tambahkanstocksekarangdenganquantity' where idbarang= '$barangnya'");
    if($addtokeluar&&$updatestockkeluar) {
        header('location:keluar.php');
    } else {
        echo 'Input Gagal';
        header('location:keluar.php');
    }
}

?>