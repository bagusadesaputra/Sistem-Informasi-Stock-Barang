 <?php
    session_start();

    //Tambah Jenis barang
    if(isset($_POST['tambahjenis'])){
        $jenis_barang = $_POST['jenis'];

        $addtotable = mysqli_query($conn, "INSERT INTO jenis (jenis_barang) VALUES ('$jenis_barang')");
        if($addtotable) {
            echo "<script>alert('Data berhasil ditambahkan'); window.location='jenis.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data');</script>";
        }
    }

    // Hapus data dari tabel jenis
    if (isset($_POST['hapusjenis'])) {
        $idjenis = $_POST['idjenis'];

        $hapus = mysqli_query($conn, "DELETE FROM jenis WHERE id = '$idjenis'");
        if ($hapus) {
            echo "<script>alert('Data berhasil dihapus'); window.location='jenis.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data');</script>";
        }
    }

    //Tambah lokasi barang
    if(isset($_POST['tambahlokasi'])){
        $lokasi_barang = $_POST['lokasi'];

        $addtotable = mysqli_query($conn, "INSERT INTO lokasi (lokasi_barang) VALUES ('$lokasi_barang')");
        if($addtotable) {
            echo "<script>alert('Data berhasil ditambahkan'); window.location='lokasi.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data');</script>";
        }
    }

    // Hapus data dari tabel lokasi
    if (isset($_POST['hapuslokasi'])) {
        $idlokasi = $_POST['idlokasi'];

        $hapus = mysqli_query($conn, "DELETE FROM lokasi WHERE id = '$idlokasi'");
        if ($hapus) {
            echo "<script>alert('Data berhasil dihapus'); window.location='lokasi.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data');</script>";
        }
    }

    //Tambah satuan barang
    if(isset($_POST['tambahsatuan'])){
        $satuan_barang = $_POST['satuan'];

        $addtotable = mysqli_query($conn, "INSERT INTO satuan (satuan_barang) VALUES ('$satuan_barang')");
        if($addtotable) {
            echo "<script>alert('Data berhasil ditambahkan'); window.location='satuan.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data');</script>";
        }
    }

    // Hapus data dari tabel jenis
    if (isset($_POST['hapussatuan'])) {
        $idsatuan = $_POST['idsatuan'];

        $hapus = mysqli_query($conn, "DELETE FROM satuan WHERE id = '$idsatuan'");
        if ($hapus) {
            echo "<script>alert('Data berhasil dihapus'); window.location='satuan.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data');</script>";
        }
    }


    //Tambah Petugas
    if(isset($_POST['tambahpetugasbaru'])){
        $namapetugas = $_POST['namapetugas'];
        $alamat = $_POST['alamat'];
        $notelp = $_POST['notelp'];

        $addtotable = mysqli_query($conn, "INSERT INTO petugas (namapetugas, alamat, notelp) VALUES ('$namapetugas', '$alamat', '$notelp')");
        if($addtotable) {
            header('location:petugas.php');
        } else {
            //echo 'Input Gagal';
            header('location:petugas.php');
        }
    }

if (isset($_POST['hapusakun'])) {
    $id = intval($_POST['id']);

    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM login WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<script>alert('Akun berhasil dihapus!'); window.location='petugas.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus akun!');</script>";
        }
    }
}

    // option data jenis
    $data_jenis = mysqli_query($conn, "SELECT * FROM jenis");

    // option data lokasi
    $data_lokasi = mysqli_query($conn, "SELECT * FROM lokasi");

    // option data satuan
    $data_satuan = mysqli_query($conn, "SELECT * FROM satuan");

    // option data petugas
    $data_petugas = mysqli_query($conn, "SELECT * FROM petugas");

?>