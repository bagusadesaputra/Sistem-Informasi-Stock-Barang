 <?php
    session_start();

    // Tambah "barang reject"
    if (isset($_POST['tambahbarangreject'])) {
        $barcode = $_POST['barcode'];
        $jumlah = intval($_POST['jumlah']);
        $petugas = $_SESSION['username'];
        $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']); // hindari SQL injection

        // Ambil detail barang dari tabel stock
        $cek = mysqli_query($conn, "SELECT * FROM stock WHERE barcode='$barcode'");
        $data = mysqli_fetch_assoc($cek);

        if ($data) {
            $namabarang = $data['namabarang'];
            $satuan = $data['satuan'];
            $tanggal = date("Y-m-d H:i:s");

            // Insert ke tabel reject_barang
            $insert = mysqli_query($conn, "INSERT INTO reject_barang (tanggal, barcode, namabarang, satuan, jumlah, petugas, keterangan) VALUES (
                '$tanggal',
                '$barcode',
                '$namabarang',
                '$satuan',
                '$jumlah',
                '$petugas',
                '$keterangan'
            )");

            if ($insert) {
                // Update stock: kurangi jumlah barang
                $update = mysqli_query($conn, "UPDATE stock SET qty = qty - $jumlah WHERE barcode='$barcode'");

                if ($update) {
                    echo "<script>alert('Barang Reject berhasil ditambahkan'); window.location.href='reject.php';</script>";
                } else {
                    echo "<script>alert('Gagal update stock');</script>";
                }
            } else {
                echo "<script>alert('Gagal insert ke tabel reject_barang');</script>";
            }
        } else {
            echo "<script>alert('Barcode tidak ditemukan di tabel stock');</script>";
        }
    }

    // Hapus data barang reject + kembalikan ke stock
    if (isset($_POST['hapusreject'])) {
        $id = $_POST['id_reject'];

        // Ambil data reject berdasarkan id
        $ambil = mysqli_query($conn, "SELECT * FROM reject_barang WHERE id_reject = '$id'");
        $data = mysqli_fetch_array($ambil);

        if ($data) {
            $barcode = $data['barcode'];
            $jumlah = $data['jumlah'];

            // Ambil stok sekarang dari tabel stock
            $cekstock = mysqli_query($conn, "SELECT * FROM stock WHERE barcode = '$barcode'");
            $datastock = mysqli_fetch_array($cekstock);
            $stocksekarang = $datastock['qty'];

            // Hitung stok baru (kembalikan barang ke stok)
            $stokbaru = $stocksekarang + $jumlah;

            // Update stok
            $update = mysqli_query($conn, "UPDATE stock SET qty = '$stokbaru' WHERE barcode = '$barcode'");

            // Hapus data dari tabel reject_barang
            $hapus = mysqli_query($conn, "DELETE FROM reject_barang WHERE id_reject = '$id'");

            if ($update && $hapus) {
                echo "<script>alert('Data reject berhasil dihapus dan stok dikembalikan'); window.location='reject.php';</script>";
            } else {
                echo "<script>alert('Gagal menghapus data reject');</script>";
            }
        } else {
            echo "<script>alert('Data tidak ditemukan');</script>";
        }
    }

    // edit reject
    if (isset($_POST['editreject'])) {
        $id = $_POST['id'];
        $jumlahBaru = $_POST['jumlah']; // karena kolomnya 'jumlah' bukan 'qty'
        $petugas = $_SESSION['username'];
        $keterangan = $_POST['keterangan'];

        // Ambil data lama dari database
        $ambil = mysqli_query($conn, "SELECT * FROM reject_barang WHERE id_reject='$id'");
        $dataLama = mysqli_fetch_array($ambil);
        $jumlahLama = $dataLama['jumlah'];
        $barcode = $dataLama['barcode'];

        // Hitung selisih (jumlah baru - jumlah lama)
        $selisih = $jumlahBaru - $jumlahLama;

        // Update data di tabel reject_barang
        $updateReject = mysqli_query($conn, "
            UPDATE reject_barang 
            SET jumlah='$jumlahBaru', petugas='$petugas', keterangan='$keterangan' 
            WHERE id_reject='$id'
        ");

        if ($updateReject) {
            // Karena reject = barang rusak atau ditolak, maka stock tetap berkurang
            $updateStock = mysqli_query($conn, "UPDATE stock SET qty = qty - $selisih WHERE barcode = '$barcode'");

            if ($updateStock) {
                echo "<script>alert('Data berhasil diupdate'); window.location='reject.php';</script>";
            } else {
                echo "<script>alert('Gagal update stok barang');</script>";
            }
        } else {
            echo "<script>alert('Gagal update data reject');</script>";
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