<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: test_buku.php");
    exit;
}
include 'config/koneksi.php';

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM buku WHERE id_buku='$id'");
header("Location: test_buku.php");
exit;
