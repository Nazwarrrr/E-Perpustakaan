<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: test_buku.php");
    exit;
}
include 'config/koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku='$id'");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['save'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $stok = $_POST['stok'];
    $rak = $_POST['rak'];
    $status = $_POST['status'];
    $foto = $data['foto'];
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto_name = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $namaFotoBaru = time() . '_' . $foto_name;
        $uploadPath = "upload/" . $namaFotoBaru;
        if (move_uploaded_file($tmp, $uploadPath)) {
            $foto = $namaFotoBaru;
        }
    }
    mysqli_query($koneksi, "UPDATE buku SET judul='$judul', penulis='$penulis', penerbit='$penerbit', stok='$stok', rak='$rak', status='$status', foto='$foto' WHERE id_buku='$id'");
    header("Location: test_buku.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Buku</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="profile-container profile-large">
    <h2 style="text-align:center;">Edit Buku</h2>
    <form method="post" enctype="multipart/form-data">
        <label>Judul Buku</label>
        <input type="text" name="judul" value="<?= $data['judul']; ?>" required>
        <label>Penulis</label>
        <input type="text" name="penulis" value="<?= $data['penulis']; ?>" required>
        <label>Penerbit</label>
        <input type="text" name="penerbit" value="<?= $data['penerbit']; ?>" required>
        <label>Stok</label>
        <input type="number" name="stok" value="<?= $data['stok']; ?>" min="0" required>
        <label>Status</label>
        <select name="status">
            <option value="Tersedia" <?= $data['status']=='Tersedia'?'selected':'' ?>>Tersedia</option>
            <option value="Dipinjam" <?= $data['status']=='Dipinjam'?'selected':'' ?>>Dipinjam</option>
        </select>
        <label>Rak</label>
        <input type="text" name="rak" value="<?= $data['rak']; ?>" required>
        <label>Foto Buku (Cover)</label>
        <input type="file" name="foto" accept="image/*">
        <div style="margin:12px 0;">
            <img src="upload/<?= $data['foto']; ?>" width="100" alt="Cover Buku">
        </div>
        <button type="submit" name="save">Simpan Perubahan</button>
        </form>
        <a href="test_buku.php" class="btn-kembali">Kembali</a>
</div>
</body>
</html>
