 <?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../config/koneksi.php';
require 'function.php';

if (isset($_GET['barcode'])) {
    $barcode = mysqli_real_escape_string($conn, $_GET['barcode']);

    $query = mysqli_query($conn, "SELECT namabarang, satuan, lokasi, qty FROM stock WHERE barcode='$barcode' LIMIT 1");

    if (!$query) {
        http_response_code(500);
        echo json_encode(["error" => "Query failed: " . mysqli_error($conn)]);
        exit;
    }

    $data = mysqli_fetch_assoc($query);

    // Cek apakah data ditemukan
    if ($data) {
        echo json_encode($data);
    } else {
        echo json_encode(["error" => "Data tidak ditemukan"]);
    }
} else {
    echo json_encode(["error" => "Barcode tidak diberikan"]);
}
?>