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
    $stok     = isset($_POST['stok']) ? intval($_POST['stok']) : 0;
    $rak      = $_POST['rak'];
    $status   = $_POST['status'];
    $deskripsi = isset($_POST['deskripsi']) ? trim($_POST['deskripsi']) : '';
    $jumlah_halaman = (isset($_POST['jumlah_halaman']) && $_POST['jumlah_halaman'] !== '') ? intval($_POST['jumlah_halaman']) : null;
    $tahun_terbit = (isset($_POST['tahun_terbit']) && $_POST['tahun_terbit'] !== '') ? intval($_POST['tahun_terbit']) : null;

    // Validasi sederhana server-side: pastikan field penting tidak kosong
    $errors = [];
    if (empty($judul)) $errors[] = 'Judul harus diisi.';
    if (empty($penulis)) $errors[] = 'Penulis harus diisi.';
    if (empty($penerbit)) $errors[] = 'Penerbit harus diisi.';
    if ($tahun_terbit === null) $errors[] = 'Tahun Terbit harus diisi.';
    if ($jumlah_halaman === null) $errors[] = 'Jumlah Halaman harus diisi.';

    // Jika ada error validasi, tampilkan dan jangan lanjut
    if (!empty($errors)) {
        foreach ($errors as $e) echo "<p style='color:red'>".htmlspecialchars($e)."</p>";
    }

    // Validasi upload foto
    if (empty($errors) && isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto = $_FILES['foto']['name'];
        $tmp  = $_FILES['foto']['tmp_name'];
        $namaFotoBaru = time() . '_' . $foto;
        $uploadPath = "upload/" . $namaFotoBaru;
        if (move_uploaded_file($tmp, $uploadPath)) {
            // Insert data sesuai urutan yang diminta:
            // judul, penulis, penerbit, tahun_terbit, jumlah_halaman, rak, stok, status, foto, deskripsi
            $query = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, jumlah_halaman, rak, stok, status, foto, deskripsi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($koneksi, $query);
            if ($stmt === false) {
                die('Prepare gagal: ' . mysqli_error($koneksi));
            }
            // Bind semua sebagai string sederhana (aman) atau gunakan tipe yang sesuai
            $types = str_repeat('s', 10);
            mysqli_stmt_bind_param($stmt, $types, $judul, $penulis, $penerbit, $tahun_terbit, $jumlah_halaman, $rak, $stok, $status, $namaFotoBaru, $deskripsi);
            mysqli_stmt_execute($stmt) or die('Execute gagal: ' . mysqli_error($koneksi));
            mysqli_stmt_close($stmt);
            header("Location: test_buku.php");
            exit;
        } else {
            echo "<p style='color:red'>Upload foto gagal!</p>";
        }
    } else {
        if (empty($errors)) echo "<p style='color:red'>Foto buku wajib diupload!</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
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

    <label>Tahun Terbit</label><br>
    <input type="number" name="tahun_terbit" min="1000" max="9999" placeholder="Contoh: 2020" required><br><br>

    <label>Deskripsi</label><br>
    <textarea name="deskripsi" rows="5" placeholder="Masukkan deskripsi singkat atau lengkap tentang buku (opsional)"></textarea><br><br>

    <label>Jumlah Halaman</label><br>
    <input type="number" name="jumlah_halaman" min="1" placeholder="Kosongkan jika tidak tersedia"><br><br>


    <label>Foto Buku</label><br>
    <input type="file" name="foto" accept="image/*" required><br><br>

    <button type="submit" name="simpan">Simpan</button>

</form>


</body>
</html>
