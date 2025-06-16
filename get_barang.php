<?php
include 'function.php';

header('Content-Type: application/json'); // Menyatakan bahwa ini akan mengirim JSON

// Ambil barcode dari POST
$barcode = isset($_POST['barcode']) ? $_POST['barcode'] : '';

if ($barcode == '') {
    echo json_encode(['error' => 'Barcode kosong']);
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM stock WHERE barcode = '$barcode'");

if ($data = mysqli_fetch_assoc($query)) {
    echo json_encode([
        'namabarang' => $data['namabarang'],
        'satuan'     => $data['satuan']
    ]);
} else {
    echo json_encode(['error' => 'Data tidak ditemukan']);
}
?>
