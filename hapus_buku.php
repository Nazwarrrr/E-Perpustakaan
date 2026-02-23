<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: test_buku.php");
    exit;
}
include 'config/koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil foto sebelum dihapus
$q = mysqli_query($koneksi, "SELECT foto FROM buku WHERE id_buku='$id'");
$d = mysqli_fetch_assoc($q);

if (mysqli_query($koneksi, "DELETE FROM buku WHERE id_buku='$id'")) {
    if ($d && !empty($d['foto']) && file_exists(__DIR__ . '/upload/' . $d['foto'])) {
        @unlink(__DIR__ . '/upload/' . $d['foto']);
    }
}

header("Location: test_buku.php");
exit;
