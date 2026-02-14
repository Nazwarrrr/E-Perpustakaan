<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'config/koneksi.php';
$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 0;
$res = mysqli_query($koneksi, "SELECT p.*, b.judul FROM peminjaman p LEFT JOIN buku b ON p.id_buku=b.id_buku WHERE p.id_user='$id_user' ORDER BY p.created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Peminjaman Saya</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div style="max-width:900px;margin:40px auto;">
    <h2 style="color:#3498db;">Peminjaman Saya</h2>
    <table>
        <tr><th>#</th><th>Buku</th><th>Kelas</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th></tr>
        <?php $no=1; while($r = mysqli_fetch_assoc($res)): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($r['judul']); ?></td>
            <td><?= htmlspecialchars($r['kelas']); ?></td>
            <td><?= htmlspecialchars($r['tanggal_pinjam']); ?></td>
            <td><?= htmlspecialchars($r['tanggal_kembali']); ?></td>
            <td><?= htmlspecialchars($r['status']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <div style="margin-top:12px;"><a href="test_buku.php" class="book-back">Kembali</a></div>
</div>
</body>
</html>
