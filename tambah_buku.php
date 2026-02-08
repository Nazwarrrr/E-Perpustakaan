<?php
include 'config/koneksi.php';

if (isset($_POST['simpan'])) {
    $judul   = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $status  = $_POST['status'];
    $rak     = $_POST['rak'];

    mysqli_query($koneksi, "INSERT INTO buku 
    (judul, penulis, status, rak) 
    VALUES 
    ('$judul', '$penulis', '$status', '$rak')");

    header("Location: test_buku.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
</head>
<body>

<h2>Tambah Buku</h2>

<form method="post">
    <label>Judul Buku</label><br>
    <input type="text" name="judul" required><br><br>

    <label>Penulis</label><br>
    <input type="text" name="penulis" required><br><br>

    <label>Status</label><br>
    <select name="status">
        <option value="tersedia">Tersedia</option>
        <option value="dipinjam">Dipinjam</option>
    </select><br><br>

    <label>Rak</label><br>
    <input type="text" name="rak" required><br><br>

    <button type="submit" name="simpan">Simpan</button>
</form>

</body>
</html>
