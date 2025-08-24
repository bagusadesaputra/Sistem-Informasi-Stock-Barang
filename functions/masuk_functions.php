 <?php
    session_start();

    if (isset($_POST['tambahbarangmasuk'])) {
    $barcode = $_POST['barcode'];
    $qty = intval($_POST['qty']);
    $keterangan = $_POST['keterangan'];
    $petugas = $_SESSION['username'];

    // Data reject
    $qty_reject = isset($_POST['qty_reject']) ? intval($_POST['qty_reject']) : 0;
    $keterangan_reject = isset($_POST['keterangan_reject']) ? $_POST['keterangan_reject'] : '';

    $tgl_sekarang = date('Y-m-d');

    // === Ambil PO terakhir untuk generate PO baru ===
    $queryLastPO = mysqli_query($conn, "SELECT po FROM masuk ORDER BY id DESC LIMIT 1");
    $dataLastPO = mysqli_fetch_assoc($queryLastPO);

    if ($dataLastPO && !empty($dataLastPO['po'])) {
        $lastNumber = (int)substr($dataLastPO['po'], 2); // Ambil angka setelah RP
        $nextNumber = $lastNumber + 1;
    } else {
        $nextNumber = 1; // Jika belum ada data
    }

    $poBaru = 'RP' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

    // === Ambil data barang dari stock ===
    $cek = mysqli_query($conn, "SELECT * FROM stock WHERE barcode='$barcode'");
    $data = mysqli_fetch_assoc($cek);

    if ($data) {
        $namabarang = $data['namabarang'];
        $satuan = $data['satuan'];

        // Simpan barang masuk dengan PO
        $insertMasuk = mysqli_query($conn, "INSERT INTO masuk (tgl, po, barcode, namabarang, satuan, qty, keterangan, petugas) VALUES (
            '$tgl_sekarang',
            '$poBaru',
            '$barcode',
            '$namabarang',
            '$satuan',
            '$qty',
            '$keterangan',
            '$petugas'
        )");

        if ($insertMasuk) {
            // Update stok
            mysqli_query($conn, "UPDATE stock SET qty = qty + $qty WHERE barcode='$barcode'");

            // Jika ada reject
            if ($qty_reject > 0) {
                mysqli_query($conn, "INSERT INTO reject_barang (tanggal, barcode, namabarang, satuan, jumlah, petugas, keterangan) VALUES (
                    '$tgl_sekarang',
                    '$barcode',
                    '$namabarang',
                    '$satuan',
                    '$qty_reject',
                    '$petugas',
                    '$keterangan_reject'
                )");
            }

            echo "<script>alert('Barang masuk berhasil ditambahkan dengan PO $poBaru'); window.location.href='masuk.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan barang masuk');</script>";
        }
    } else {
        echo "<script>alert('Barcode tidak ditemukan di stock');</script>";
    }
}



    // Hapus data barang masuk + kembalikan stock
    if (isset($_POST['hapusmasuk'])) {
        $id = $_POST['idmasuk'];

        // Ambil data masuk berdasarkan id
        $ambil = mysqli_query($conn, "SELECT * FROM masuk WHERE id = '$id'");
        $data = mysqli_fetch_array($ambil);

        if ($data) {
            $barcode = $data['barcode'];
            $qty = $data['qty'];

            // Ambil stok sekarang dari tabel stock
            $cekstock = mysqli_query($conn, "SELECT * FROM stock WHERE barcode = '$barcode'");
            $datastock = mysqli_fetch_array($cekstock);
            $stocksekarang = $datastock['qty'];

            // Hitung stok baru
            $stokbaru = $stocksekarang - $qty;
            if ($stokbaru < 0) $stokbaru = 0;

            // Update stok
            $update = mysqli_query($conn, "UPDATE stock SET qty = '$stokbaru' WHERE barcode = '$barcode'");

            // Hapus data dari tabel masuk
            $hapus = mysqli_query($conn, "DELETE FROM masuk WHERE id = '$id'");

            if ($update && $hapus) {
                echo "<script>alert('Data berhasil dihapus dan stok diperbarui'); window.location='masuk.php';</script>";
            } else {
                echo "<script>alert('Gagal menghapus data');</script>";
            }
        } else {
            echo "<script>alert('Data tidak ditemukan');</script>";
        }
    }

    // edit masuk
    if (isset($_POST['editmasuk'])) {
        $id         = $_POST['id'];
        $qtyBaru    = $_POST['qty'];
        $petugas = $_SESSION['username'];
        $keterangan = $_POST['keterangan'];

        // Ambil data lama dari database
        $ambil = mysqli_query($conn, "SELECT * FROM masuk WHERE id='$id'");
        $dataLama = mysqli_fetch_array($ambil);
        $qtyLama = $dataLama['qty'];
        $barcode = $dataLama['barcode'];

        // Hitung selisih (qty baru - qty lama)
        $selisih = $qtyBaru - $qtyLama;

        // Update data di tabel masuk
        $updateMasuk = mysqli_query($conn, "
            UPDATE masuk 
            SET qty='$qtyBaru', 
                keterangan='$keterangan', 
                petugas='$petugas' 
            WHERE id='$id'
        ");

        if ($updateMasuk) {
            // Update stock juga
            $updateStock = mysqli_query($conn, "UPDATE stock SET qty = qty + $selisih WHERE barcode = '$barcode'");

            if ($updateStock) {
                echo "<script>alert('Data berhasil diupdate'); window.location='masuk.php';</script>";
            } else {
                echo "<script>alert('Gagal update stok barang');</script>";
            }
        } else {
            echo "<script>alert('Gagal update data masuk');</script>";
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