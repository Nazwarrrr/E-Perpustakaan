<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
include 'config/koneksi.php';

// Stats
$totalBooksQ = mysqli_query($koneksi, "SELECT COUNT(*) as cnt FROM buku");
$totalBooksR = mysqli_fetch_assoc($totalBooksQ);
$totalBooks = $totalBooksR ? intval($totalBooksR['cnt']) : 0;

$availableQ = mysqli_query($koneksi, "SELECT COUNT(*) as cnt FROM buku WHERE (status='Tersedia' OR stok>0)");
$availableR = mysqli_fetch_assoc($availableQ);
$availableBooks = $availableR ? intval($availableR['cnt']) : 0;

$borrowedQ = mysqli_query($koneksi, "SELECT COUNT(*) as cnt FROM buku WHERE status='Dipinjam' OR stok=0");
$borrowedR = mysqli_fetch_assoc($borrowedQ);
$borrowedBooks = $borrowedR ? intval($borrowedR['cnt']) : 0;

$usersQ = mysqli_query($koneksi, "SELECT COUNT(*) as cnt FROM users");
$usersR = mysqli_fetch_assoc($usersQ);
$totalUsers = $usersR ? intval($usersR['cnt']) : 0;

// Recent books
$recent = mysqli_query($koneksi, "SELECT id_buku, judul, penulis, foto, status FROM buku ORDER BY id_buku DESC LIMIT 6");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Perpustakaan</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="admin-header">
        <div class="admin-header-left">
            <img src="assets/img/logo.png" alt="Logo" class="admin-logo">
            <div>
                <div class="admin-title">Dashboard Admin Perpustakaan</div>
                <div class="admin-sub">Kelola buku, pengguna, dan peminjaman</div>
            </div>
        </div>
        <div class="admin-header-right">
            <a href="logout.php" class="profile-logout">Logout</a>
        </div>
    </div>

    <div class="admin-container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Buku</div>
                <div class="stat-value"><?= $totalBooks; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Buku Tersedia</div>
                <div class="stat-value"><?= $availableBooks; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Buku Dipinjam</div>
                <div class="stat-value"><?= $borrowedBooks; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Jumlah User</div>
                <div class="stat-value"><?= $totalUsers; ?></div>
            </div>
        </div>

        <div class="quick-actions">
            <a href="tambah_buku.php" class="btn-kembali">Tambah Buku</a>
            <a href="test_buku.php" class="btn-kembali">Lihat Daftar Buku</a>
            <a href="admin_peminjaman.php" class="btn-kembali">Kelola Peminjaman</a>
        </div>

        <div class="recent-section">
            <h3>Daftar Buku Terbaru</h3>
            <div class="recent-table-wrapper">
            <table class="recent-table">
                <thead>
                    <tr><th>#</th><th>Foto</th><th>Judul</th><th>Penulis</th><th>Status</th></tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($recent)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td style="width:90px;"><img src="upload/<?= htmlspecialchars($row['foto']); ?>" alt="<?= htmlspecialchars($row['judul']); ?>"></td>
                            <td><?= htmlspecialchars($row['judul']); ?></td>
                            <td><?= htmlspecialchars($row['penulis']); ?></td>
                            <td><span class="badge-status <?= ($row['status'] == 'Tersedia') ? 'tersedia' : 'dipinjam' ?>"><?= htmlspecialchars($row['status']); ?></span></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</body>
</html>
