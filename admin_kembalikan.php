<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include 'config/koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id) {
    $q = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id='$id'");
    $p = mysqli_fetch_assoc($q);
    if ($p && $p['status'] !== 'Kembali') {
        // update peminjaman
        mysqli_query($koneksi, "UPDATE peminjaman SET status='Kembali' WHERE id='$id'");
        // increment stok buku
        $id_buku = intval($p['id_buku']);
        $qb = mysqli_query($koneksi, "SELECT stok FROM buku WHERE id_buku='$id_buku'");
        $db = mysqli_fetch_assoc($qb);
        $stok = $db ? intval($db['stok']) : 0;
        $stok_baru = $stok + 1;
        $status_baru = ($stok_baru > 0) ? 'Tersedia' : 'Habis';
        mysqli_query($koneksi, "UPDATE buku SET stok='$stok_baru', status='$status_baru' WHERE id_buku='$id_buku'");
        // catat riwayat (admin melakukan kembalikan)
        $admin_id = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 0;
        mysqli_query($koneksi, "INSERT INTO riwayat (id_user, id_buku, aksi, tanggal) VALUES ('$admin_id', '$id_buku', 'Kembalikan', NOW())");
    }
}
header("Location: admin_peminjaman.php");
exit;
