<?php
include 'config/koneksi.php';

$id = $_GET['id'];

mysqli_query(
    $koneksi,
    "UPDATE buku SET status='tersedia' WHERE id_buku='$id'"
);

header("Location: test_buku.php");
exit;
