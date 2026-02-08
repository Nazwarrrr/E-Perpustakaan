<?php
include 'config/koneksi.php';

$id = $_GET['id'];

mysqli_query(
    $koneksi,
    "UPDATE buku SET status='dipinjam' WHERE id_buku='$id'"
);

header("Location: test_buku.php");
exit;
