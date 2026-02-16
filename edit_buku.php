<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: test_buku.php");
    exit;
}
include 'config/koneksi.php';

// Ambil dan validasi id dari query string
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: test_buku.php");
    exit;
}

// Ambil data buku secara aman dengan prepared statement
$stmtGet = mysqli_prepare($koneksi, "SELECT * FROM buku WHERE id_buku = ? LIMIT 1");
if ($stmtGet) {
    mysqli_stmt_bind_param($stmtGet, 'i', $id);
    mysqli_stmt_execute($stmtGet);
    $resGet = mysqli_stmt_get_result($stmtGet);
    $data = mysqli_fetch_assoc($resGet);
    mysqli_stmt_close($stmtGet);
} else {
    // fallback: jika prepare gagal, redirect
    header("Location: test_buku.php");
    exit;
}

if (isset($_POST['save'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = isset($_POST['tahun_terbit']) && $_POST['tahun_terbit'] !== '' ? intval($_POST['tahun_terbit']) : null;
    $jumlah_halaman = isset($_POST['jumlah_halaman']) && $_POST['jumlah_halaman'] !== '' ? intval($_POST['jumlah_halaman']) : null;
    $stok = isset($_POST['stok']) ? intval($_POST['stok']) : 0;
    $rak = $_POST['rak'];
    $status = $_POST['status'];
    $deskripsi = isset($_POST['deskripsi']) ? trim($_POST['deskripsi']) : '';
    $foto = $data['foto'];
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto_name = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $namaFotoBaru = time() . '_' . $foto_name;
        $uploadPath = "upload/" . $namaFotoBaru;
        if (move_uploaded_file($tmp, $uploadPath)) {
            // hapus file lama jika ada
            if (!empty($data['foto']) && file_exists(__DIR__ . '/upload/' . $data['foto'])) {
                @unlink(__DIR__ . '/upload/' . $data['foto']);
            }
            $foto = $namaFotoBaru;
        }
    }

    // Prepared statement untuk update semua field
    $upd = mysqli_prepare($koneksi, "UPDATE buku SET judul=?, penulis=?, penerbit=?, tahun_terbit=?, jumlah_halaman=?, rak=?, stok=?, status=?, foto=?, deskripsi=? WHERE id_buku=?");
    if ($upd) {
        $types = str_repeat('s', 10) . 'i';
        mysqli_stmt_bind_param($upd, $types, $judul, $penulis, $penerbit, $tahun_terbit, $jumlah_halaman, $rak, $stok, $status, $foto, $deskripsi, $id);
        mysqli_stmt_execute($upd) or die('Update gagal: ' . mysqli_error($koneksi));
        mysqli_stmt_close($upd);
        $_SESSION['flash'] = 'Perubahan buku berhasil disimpan.';
        header("Location: test_buku.php");
        exit;
    } else {
        die('Prepare update gagal: ' . mysqli_error($koneksi));
    }
}
// Hapus buku (ditrigger dari tombol di bawah form)
if (isset($_POST['delete'])) {
    // ambil nama file foto dulu
    $q = mysqli_prepare($koneksi, "SELECT foto FROM buku WHERE id_buku = ?");
    mysqli_stmt_bind_param($q, 'i', $id);
    mysqli_stmt_execute($q);
    $resf = mysqli_stmt_get_result($q);
    $rowf = mysqli_fetch_assoc($resf);
    mysqli_stmt_close($q);

    // hapus record
    $del = mysqli_prepare($koneksi, "DELETE FROM buku WHERE id_buku = ?");
    mysqli_stmt_bind_param($del, 'i', $id);
    mysqli_stmt_execute($del);
    mysqli_stmt_close($del);

    // hapus file foto jika ada
    if (!empty($rowf['foto']) && file_exists(__DIR__ . '/upload/' . $rowf['foto'])) {
        @unlink(__DIR__ . '/upload/' . $rowf['foto']);
    }

    $_SESSION['flash'] = 'Buku berhasil dihapus.';
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
<div class="profile-container profile-large" style="max-width:900px;">
    <h2 style="text-align:center;">Edit Buku</h2>
    <?php if (!empty($_SESSION['flash'])): ?>
        <div style="background:#e6ffed;border:1px solid #b8f3c7;padding:10px;border-radius:6px;margin-bottom:10px;color:#05683a;">
            <?= htmlspecialchars($_SESSION['flash']); unset($_SESSION['flash']); ?>
        </div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <label>Judul Buku</label>
        <input type="text" name="judul" value="<?= htmlspecialchars($data['judul']); ?>" required>
        <label>Penulis</label>
        <input type="text" name="penulis" value="<?= htmlspecialchars($data['penulis']); ?>" required>
        <label>Penerbit</label>
        <input type="text" name="penerbit" value="<?= htmlspecialchars($data['penerbit']); ?>" required>
        <label>Tahun Terbit</label>
        <input type="number" name="tahun_terbit" value="<?= htmlspecialchars(isset($data['tahun_terbit']) ? $data['tahun_terbit'] : (isset($data['tahun']) ? $data['tahun'] : '')); ?>" min="1000" max="9999" required>
        <label>Stok</label>
        <input type="number" name="stok" value="<?= $data['stok']; ?>" min="0" required>
        <label>Status</label>
        <select name="status">
            <option value="Tersedia" <?= $data['status']=='Tersedia'?'selected':'' ?>>Tersedia</option>
            <option value="Dipinjam" <?= $data['status']=='Dipinjam'?'selected':'' ?>>Dipinjam</option>
        </select>
        <label>Rak</label>
        <input type="text" name="rak" value="<?= htmlspecialchars($data['rak']); ?>" required>
        <label>Jumlah Halaman</label>
        <input type="number" name="jumlah_halaman" value="<?= htmlspecialchars(isset($data['jumlah_halaman']) ? $data['jumlah_halaman'] : ''); ?>" min="1">
        <label>Deskripsi</label>
        <textarea name="deskripsi" rows="6"><?= isset($data['deskripsi']) ? htmlspecialchars($data['deskripsi']) : '' ; ?></textarea>
        <label>Foto Buku (Cover)</label>
        <input type="file" name="foto" accept="image/*">
        <div style="margin:12px 0;">
            <img src="upload/<?= htmlspecialchars($data['foto']); ?>" width="100" alt="Cover Buku">
        </div>
        <div style="display:flex;gap:12px;align-items:center;">
            <button type="submit" name="save" class="action-btn primary">Simpan Perubahan</button>
            </form>

            <form method="post" onsubmit="return confirm('Yakin ingin menghapus buku ini? Semua data akan dihapus.');">
                <button type="submit" name="delete" class="action-btn warn">Hapus Buku</button>
            </form>

            <a href="test_buku.php" class="btn-kembali">Kembali</a>
        </div>
</div>
</body>
</html>
