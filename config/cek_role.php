<?php
session_start();
if (!isset($_SESSION['log'])) {
    header('Location: login.php');
    exit;
}

// Tentukan role yang diizinkan di halaman ini
if (!in_array($_SESSION['role'], $allowed_roles)) {
    echo "<h1>403 Forbidden</h1>";
    exit;
}
?>