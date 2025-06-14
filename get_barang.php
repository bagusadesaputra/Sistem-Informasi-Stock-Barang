<?php
// Tidak boleh ada output sebelum ini
header('Content-Type: application/json');
include 'function.php';

// Matikan error output ke browser
ini_set('display_errors', 0);
error_reporting(0);

if (isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];

    $query = mysqli_query($conn, "SELECT * FROM stock WHERE barcode = '$barcode'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        // Output hanya JSON
        echo json_encode([
            'namabarang' => $data['namabarang'],
            'satuan' => $data['satuan']
        ]);
    } else {
        echo json_encode(null);
    }
}
?>
