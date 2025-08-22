 <?php
    session_start();

    /* ============================================================
    Function: tambahOpname
    Deskripsi: Tambah/update opname harian & sesuaikan stok jika perlu.
    ============================================================ */
    if (isset($_POST['tambah_opname'])) {
        $barcode = $_POST['barcode'];
        $jumlah_fisik = intval($_POST['jumlah']);
        $lokasi = $_POST['lokasi'];
        $petugas = $_POST['petugas'];
        $penyesuaian = isset($_POST['penyesuaian']) ? 1 : 0;
        $catatan = $_POST['catatan'] ?? '';

        // Ambil detail barang dari tabel stock
        $cek = mysqli_query($conn, "SELECT * FROM stock WHERE barcode='$barcode'");
        $data = mysqli_fetch_assoc($cek);

        if ($data) {
            $namabarang = $data['namabarang'];
            $satuan = $data['satuan'];
            $qty_sistem = intval($_POST['qty']);  // dari hidden input

            $tanggal_hari_ini = date('Y-m-d');
            $cek_opname = mysqli_query($conn, "SELECT * FROM opname WHERE barcode='$barcode' AND DATE(tanggal) = '$tanggal_hari_ini'");
            $opname_data = mysqli_fetch_assoc($cek_opname);

            if ($opname_data) {
                // Update opname (update langsung jumlah fisik dan penyesuaian)
                $update = mysqli_query($conn, "UPDATE opname SET 
                    jumlah_fisik = '$jumlah_fisik',
                    lokasi = '$lokasi',
                    petugas = '$petugas',
                    penyesuaian = '$penyesuaian',
                    catatan = '".mysqli_real_escape_string($conn, $catatan)."',
                    tanggal = NOW()
                    WHERE id_opname = '{$opname_data['id_opname']}'
                ");
            } else {
                // Insert opname baru, kolom penyesuaian ditambahkan
                    $insert = mysqli_query($conn, "INSERT INTO opname (barcode, namabarang, satuan, qty, jumlah_fisik, petugas, lokasi, penyesuaian, catatan, tanggal) VALUES (
                    '$barcode',
                    '$namabarang',
                    '$satuan',
                    '$qty_sistem',
                    '$jumlah_fisik',
                    '$petugas',
                    '$lokasi',
                    '$penyesuaian',
                    '".mysqli_real_escape_string($conn, $catatan)."',
                    NOW()
                )");
            }

            // Update stok sistem di tabel stock jika penyesuaian dicentang dan stok fisik berbeda
            if ($penyesuaian && $jumlah_fisik != $qty_sistem) {
                $update_stock = mysqli_query($conn, "UPDATE stock SET qty = '$jumlah_fisik' WHERE barcode = '$barcode'");
            }

            echo "<script>alert('Data opname berhasil diproses'); window.location.href='opname.php';</script>";

        } else {
            echo "<script>alert('Barcode tidak ditemukan di tabel stock');</script>";
        }
    }


    /* ============================================================
    Function: hapusOpname
    Deskripsi: Hapus opname & kembalikan stok ke jumlah sebelumnya.
    ============================================================ */
    if (isset($_POST['hapusopname'])) {
        $idopname = $_POST['id_opname'];

        // Ambil data opname sebelum dihapus
        $ambil_opname = mysqli_query($conn, "SELECT barcode, qty FROM opname WHERE id_opname='$idopname'");
        $data_opname = mysqli_fetch_assoc($ambil_opname);

        if ($data_opname) {
            $barcode = $data_opname['barcode'];
            $qty_lama = $data_opname['qty']; // qty stok sebelum penyesuaian

            // Update stok di tabel stock ke qty lama
            mysqli_query($conn, "UPDATE stock SET qty = '$qty_lama' WHERE barcode = '$barcode'");

            // Hapus data opname
            $hapus = mysqli_query($conn, "DELETE FROM opname WHERE id_opname='$idopname'");

            if ($hapus) {
                echo "<script>alert('Data berhasil dihapus dan stok dikembalikan'); window.location.href='opname.php';</script>";
            } else {
                echo "<script>alert('Gagal hapus data');</script>";
            }
        } else {
            echo "<script>alert('Data opname tidak ditemukan');</script>";
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

?