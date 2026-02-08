<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'config/koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT stok FROM buku WHERE id_buku='$id'");
$data = mysqli_fetch_assoc($query);
$stok = $data['stok'];
if ($stok > 0) {
    $stok_baru = $stok - 1;
    $status_baru = ($stok_baru == 0) ? 'Habis' : 'Dipinjam';
    mysqli_query($koneksi, "UPDATE buku SET status='$status_baru', stok='$stok_baru' WHERE id_buku='$id'");
    // Catat riwayat
    $id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 0;
    mysqli_query($koneksi, "INSERT INTO riwayat (id_user, id_buku, aksi, tanggal) VALUES ('$id_user', '$id', 'Pinjam', NOW())");
}
header("Location: test_buku.php");
exit;
