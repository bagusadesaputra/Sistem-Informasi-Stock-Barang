 <?php
    session_start();

    /* ============================================================
       Function: Tambah 'Barang'
       Deskripsi: Menambahkan barang baru ke tabel 'stock' 
       dengan data yang dikirim dari form.
    ============================================================ */
    if (isset($_POST['addnewbarang'])) {
        $barcode     = $_POST['barcode'];
        $namabarang  = $_POST['namabarang'];
        $jenis       = $_POST['jenis'];
        $lokasi       = $_POST['lokasi'];
        $satuan      = $_POST['satuan'];
        $qty         = $_POST['qty'];

        $addtotable = mysqli_query($conn, "INSERT INTO stock (barcode, namabarang, jenis_barang, lokasi, satuan, qty) VALUES ('$barcode', '$namabarang', '$jenis', '$lokasi', '$satuan', '$qty')");
        if ($addtotable) {
            header('location:index.php');
        } else {
            echo "<script>alert('Gagal menambahkan barang'); window.location='index.php';</script>";
        }
    }

    /* ============================================================
       Function: Hapus 'Barang'
       Deskripsi: Menghapus data barang dari tabel 'stock' 
       berdasarkan barcode yang dipilih.
    ============================================================ */
    if (isset($_POST['hapusbarang'])) {
        $barcodehapus = $_POST['barcodehapus'];

        $hapus = mysqli_query($conn, "DELETE FROM stock WHERE barcode = '$barcodehapus'");
        if ($hapus) {
            echo "<script>alert('Data berhasil dihapus'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data');</script>";
        }
    }

    /* ============================================================
       Function: Edit 'Barang'
       Deskripsi: Memperbarui data barang yang sudah ada di tabel 'stock' 
       berdasarkan barcode.
    ============================================================ */
    if (isset($_POST['updatebarang'])) {
        $barcode      = mysqli_real_escape_string($conn, $_POST['barcode']);
        $namabarang   = mysqli_real_escape_string($conn, $_POST['namabarang']);
        $jenis_barang = mysqli_real_escape_string($conn, $_POST['jenis_barang']);
        $lokasi       = mysqli_real_escape_string($conn, $_POST['lokasi']);
        $satuan       = mysqli_real_escape_string($conn, $_POST['satuan']);
        $qty          = intval($_POST['qty']);

        $update = mysqli_query($conn, 
            "UPDATE stock SET 
                namabarang = '$namabarang',
                jenis_barang = '$jenis_barang',
                lokasi = '$lokasi',
                satuan = '$satuan',
                qty = '$qty'
             WHERE barcode = '$barcode'"
        );

        if ($update) {
            echo "<script>alert('Data berhasil diperbarui'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data'); window.location='index.php';</script>";
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