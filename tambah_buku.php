<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'config/koneksi.php';

if (isset($_POST['simpan'])) {
    $judul    = $_POST['judul'];
    $penulis  = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $stok     = $_POST['stok'];
    $rak      = $_POST['rak'];
    $status   = $_POST['status'];

    // Validasi upload foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto = $_FILES['foto']['name'];
        $tmp  = $_FILES['foto']['tmp_name'];
        $namaFotoBaru = time() . '_' . $foto;
        $uploadPath = "upload/" . $namaFotoBaru;
        if (move_uploaded_file($tmp, $uploadPath)) {
            // Insert data sesuai urutan tabel
            $query = "INSERT INTO buku (judul, penulis, penerbit, stok, rak, status, foto) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($koneksi, $query);
            mysqli_stmt_bind_param($stmt, "sssssss", $judul, $penulis, $penerbit, $stok, $rak, $status, $namaFotoBaru);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("Location: test_buku.php");
            exit;
        } else {
            echo "<p style='color:red'>Upload foto gagal!</p>";
        }
    } else {
        echo "<p style='color:red'>Foto buku wajib diupload!</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <a href="test_buku.php" class="btn-kembali" style="position:absolute;top:24px;left:24px;">Kembali</a>

<h2 style="text-align:center; margin-bottom:24px;">Tambah Buku</h2>
<form method="post" enctype="multipart/form-data">
    <label>Judul Buku</label><br>
    <input type="text" name="judul" required><br><br>

    <label>Penulis</label><br>
    <input type="text" name="penulis" required><br><br>

    <label>Penerbit</label><br>
    <input type="text" name="penerbit" required><br><br>

    <label>Stok</label><br>
    <input type="number" name="stok" min="0" required><br><br>

    <label>Status</label><br>
    <select name="status">
        <option value="Tersedia">Tersedia</option>
        <option value="Dipinjam">Dipinjam</option>
    </select><br><br>

    <label>Rak</label><br>
    <input type="text" name="rak" required><br><br>


    <label>Foto Buku</label><br>
    <input type="file" name="foto" accept="image/*" required><br><br>

    <button type="submit" name="simpan">Simpan</button>

</form>


</body>
</html>
