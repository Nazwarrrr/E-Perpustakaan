<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'config/koneksi.php';

$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic validation of POST fields to avoid undefined index errors
    $id_buku = isset($_POST['id_buku']) ? intval($_POST['id_buku']) : 0;
    $nama_peminjam = isset($_POST['nama_peminjam']) ? mysqli_real_escape_string($koneksi, $_POST['nama_peminjam']) : '';
    $kelas = isset($_POST['kelas']) ? mysqli_real_escape_string($koneksi, $_POST['kelas']) : '';
    $tgl_pinjam = isset($_POST['tanggal_pinjam']) ? $_POST['tanggal_pinjam'] : '';
    $tgl_kembali = isset($_POST['tanggal_kembali']) ? $_POST['tanggal_kembali'] : '';

    if (!$id_buku || !$nama_peminjam || !$kelas || !$tgl_pinjam || !$tgl_kembali) {
        $error = 'Form peminjaman belum lengkap. Mohon isi semua kolom.';
    } else {
        // cek stok
        $q = mysqli_query($koneksi, "SELECT stok FROM buku WHERE id_buku='$id_buku'");
        if (!$q) {
            $error = 'Gagal membaca data buku: ' . mysqli_error($koneksi);
        } else {
            $d = mysqli_fetch_assoc($q);
            $stok = $d ? intval($d['stok']) : 0;
            if ($stok > 0) {
                $stok_baru = $stok - 1;
                $status_baru = ($stok_baru == 0) ? 'Habis' : 'Dipinjam';
                if (!mysqli_query($koneksi, "UPDATE buku SET status='$status_baru', stok='$stok_baru' WHERE id_buku='$id_buku'")) {
                    $error = 'Gagal memperbarui stok buku: ' . mysqli_error($koneksi);
                } else {
                    $id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 0;
                    $ins = mysqli_query($koneksi, "INSERT INTO peminjaman (id_user, id_buku, nama_peminjam, kelas, tanggal_pinjam, tanggal_kembali, status) VALUES ('$id_user','$id_buku','$nama_peminjam','$kelas','$tgl_pinjam','$tgl_kembali','Dipinjam')");
                    if (!$ins) {
                        $error = 'Gagal menyimpan peminjaman: ' . mysqli_error($koneksi);
                    } else {
                        mysqli_query($koneksi, "INSERT INTO riwayat (id_user, id_buku, aksi, tanggal) VALUES ('$id_user', '$id_buku', 'Pinjam', NOW())");
                    }
                }
            } else {
                $error = 'Stok buku tidak tersedia.';
            }
        }
    }

    if (!$error) {
        header("Location: test_buku.php");
        exit;
    }
}

// show form (validate id exists)
$qbook = null;
if ($id) {
    $qbook = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku='$id'");
}
$book = $qbook ? mysqli_fetch_assoc($qbook) : null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Form Peminjaman</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div style="max-width:520px;margin:48px auto;">
    <h2>Form Peminjaman - <?= htmlspecialchars($book['judul'] ?? 'Buku'); ?></h2>
    <?php if ($error): ?>
        <div class="login-error" style="margin-bottom:12px;"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (!$book && $_SERVER['REQUEST_METHOD'] !== 'POST'): ?>
        <div style="padding:18px;background:#fff;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.05);">Buku tidak ditemukan atau ID peminjaman kosong. Kembali ke daftar buku.</div>
        <div style="margin-top:12px;"><a href="test_buku.php" class="book-back">Kembali</a></div>
    <?php else: ?>
    <form method="post">
        <input type="hidden" name="id_buku" value="<?= $id; ?>">
        <label>Nama</label>
        <input type="text" name="nama_peminjam" required value="<?= isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : '' ?>">
        <label>Kelas</label>
        <input type="text" name="kelas" required placeholder="contoh: X IPA 1">
        <label>Tanggal Pinjam</label>
        <input type="date" name="tanggal_pinjam" required value="<?= date('Y-m-d'); ?>">
        <label>Tanggal Kembali</label>
        <input type="date" name="tanggal_kembali" required>
        <button type="submit">Konfirmasi Pinjam</button>
    </form>
    <div style="margin-top:12px;"><a href="test_buku.php" class="book-back">Batal</a></div>
    <?php endif; ?>
</div>
</body>
</html>
