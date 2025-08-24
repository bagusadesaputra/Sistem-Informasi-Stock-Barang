 <?php 
    session_start();

    //Tambah "barang keluar"
    if (isset($_POST['tambahbarangkeluar'])) {
        $barcode = $_POST['barcode'];
        $qty = intval($_POST['qty']);
        $petugas = $_SESSION['username'];
        $keterangan = $_POST['keterangan'];

        // Ambil detail barang dari tabel stock
        $cek = mysqli_query($conn, "SELECT * FROM stock WHERE barcode='$barcode'");
        $data = mysqli_fetch_assoc($cek);

        if ($data) {
            $namabarang = $data['namabarang'];
            $satuan = $data['satuan'];

            // Insert ke tabel keluar
            $insert = mysqli_query($conn, "INSERT INTO keluar (barcode, namabarang, satuan, qty, keterangan, petugas) VALUES (
                '$barcode',
                '$namabarang',
                '$satuan',
                '$qty',
                '$keterangan',
                '$petugas'
            )");

            if ($insert) {
                // Update qty di tabel stock
                $update = mysqli_query($conn, "UPDATE stock SET qty = qty - $qty WHERE barcode='$barcode'");

                if ($update) {
                    echo "<script>alert('Barang Keluar berhasil ditambahkan'); window.location.href='keluar.php';</script>";
                } else {
                    echo "<script>alert('Gagal update stock');</script>";
                }
            } else {
                echo "<script>alert('Gagal insert ke tabel masuk');</script>";
            }
        } else {
            echo "<script>alert('Barcode tidak ditemukan di tabel stock');</script>";
        }
    }

    // Hapus data barang keluar + kembalikan stock
    if (isset($_POST['hapuskeluar'])) {
        $id = $_POST['idkeluar'];

        // Ambil data keluar berdasarkan id
        $ambil = mysqli_query($conn, "SELECT * FROM keluar WHERE id = '$id'");
        $data = mysqli_fetch_array($ambil);

        if ($data) {
            $barcode = $data['barcode'];
            $qty = $data['qty'];

            // Ambil stok sekarang dari tabel stock
            $cekstock = mysqli_query($conn, "SELECT * FROM stock WHERE barcode = '$barcode'");
            $datastock = mysqli_fetch_array($cekstock);
            $stocksekarang = $datastock['qty'];

            // Hitung stok baru
            $stokbaru = $stocksekarang + $qty;

            // Update stok
            $update = mysqli_query($conn, "UPDATE stock SET qty = '$stokbaru' WHERE barcode = '$barcode'");

            // Hapus data dari tabel keluar
            $hapus = mysqli_query($conn, "DELETE FROM keluar WHERE id = '$id'");

            if ($update && $hapus) {
                echo "<script>alert('Data berhasil dihapus dan stok diperbarui'); window.location='keluar.php';</script>";
            } else {
                echo "<script>alert('Gagal menghapus data');</script>";
            }
        } else {
            echo "<script>alert('Data tidak ditemukan');</script>";
        }
    }

    // edit keluar
    if (isset($_POST['editkeluar'])) {
        $id = $_POST['id'];
        $qtyBaru = intval($_POST['qty']);
        $petugas = $_SESSION['username'];
        $keterangan = $_POST['keterangan']; // ambil keterangan dari form

        // Ambil data lama dari database
        $ambil = mysqli_query($conn, "SELECT * FROM keluar WHERE id='$id'");
        $dataLama = mysqli_fetch_array($ambil);
        $qtyLama = intval($dataLama['qty']);
        $barcode = $dataLama['barcode'];

        // Hitung selisih (qty baru - qty lama)
        $selisih = $qtyBaru - $qtyLama;

        // Update data di tabel keluar
        $updateKeluar = mysqli_query($conn, "UPDATE keluar 
            SET qty='$qtyBaru', keterangan='$keterangan', petugas='$petugas' 
            WHERE id='$id'");

        if ($updateKeluar) {
            // Update stock: karena ini data keluar, maka stock berkurang
            $updateStock = mysqli_query($conn, "UPDATE stock 
                SET qty = qty - $selisih 
                WHERE barcode = '$barcode'");

            if ($updateStock) {
                echo "<script>alert('Data berhasil diupdate'); window.location='keluar.php';</script>";
            } else {
                echo "<script>alert('Gagal update stok barang');</script>";
            }
        } else {
            echo "<script>alert('Gagal update data keluar');</script>";
        }
    }

    /* ============================================================
    Function: getAllJenis
    Deskripsi: Mengambil semua data jenis barang
    ============================================================ */
    $data_jenis = mysqli_query($conn, "SELECT * FROM jenis");
    
    /* ============================================================
    Function: getAllLokasi
    Deskripsi: Mengambil semua data lokasi barang
    ============================================================ */
    $data_lokasi = mysqli_query($conn, "SELECT * FROM lokasi");
    
    /* ============================================================
    Function: getAllSatuan
    Deskripsi: Mengambil semua data satuan barang
    ============================================================ */
    $data_satuan = mysqli_query($conn, "SELECT * FROM satuan");

    /* ============================================================
    Function: getAllPetugas
    Deskripsi: Mengambil semua data petugas
    ============================================================ */
    $data_petugas = mysqli_query($conn, "SELECT * FROM petugas");

?>