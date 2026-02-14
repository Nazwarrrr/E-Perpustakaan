<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include 'config/koneksi.php';

$res = mysqli_query($koneksi, "SELECT p.*, b.judul, u.username FROM peminjaman p LEFT JOIN buku b ON p.id_buku=b.id_buku LEFT JOIN users u ON p.id_user=u.id ORDER BY p.created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Peminjaman - Admin</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div style="max-width:900px;margin:40px auto;">
    <h2 style="color:#3498db;">Daftar Peminjaman</h2>
    <table>
        <tr><th>#</th><th>Buku</th><th>Peminjam</th><th>Kelas</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th><th>Aksi</th></tr>
        <?php $no=1; while($r = mysqli_fetch_assoc($res)): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($r['judul']); ?></td>
            <td><?= htmlspecialchars($r['nama_peminjam']); ?> (<?= htmlspecialchars($r['username']); ?>)</td>
            <td><?= htmlspecialchars($r['kelas']); ?></td>
            <td><?= htmlspecialchars($r['tanggal_pinjam']); ?></td>
            <td><?= htmlspecialchars($r['tanggal_kembali']); ?></td>
            <td><?= htmlspecialchars($r['status']); ?></td>
            <td>
                <?php if($r['status'] !== 'Kembali'): ?>
                    <a href="admin_kembalikan.php?id=<?= $r['id']; ?>" onclick="return confirm('Tandai sebagai dikembalikan?')">Kembalikan</a>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <div style="margin-top:12px;"><a href="test_buku.php" class="book-back">Kembali</a></div>
</div>
</body>
</html>
