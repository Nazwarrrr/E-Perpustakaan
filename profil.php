<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// Dummy data profil
$nama = $_SESSION['nama'];
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'siswa';
$kunjungan = rand(1, 20); // Dummy kunjungan
$email = strtolower($nama) . '@mail.com';
$tanggal_gabung = '2024-01-01';
$total_pinjam = rand(0, 10);
$status = 'Aktif';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="profile-container">
    <div class="profile-avatar">
        <?php if (file_exists('assets/img/avatar.png')): ?>
            <img src="assets/img/avatar.png" alt="Avatar" style="width:80px;height:80px;border-radius:50%;object-fit:cover;">
        <?php else: ?>
            <span>👤</span>
        <?php endif; ?>
    </div>
    <div class="profile-name"><?= $nama; ?> <span class="profile-role">(<?= ucfirst($role); ?>)</span></div>
    <div class="profile-info">
        <div>Email: <span class="profile-count"><?= $email; ?></span></div>
        <div>Tanggal Gabung: <span class="profile-count"><?= $tanggal_gabung; ?></span></div>
        <div>Status Akun: <span class="profile-count"><?= $status; ?></span></div>
        <div>Kunjungan ke Perpustakaan: <span class="profile-count"><?= $kunjungan; ?></span></div>
        <div>Total Buku Dipinjam: <span class="profile-count"><?= $total_pinjam; ?></span></div>
        <div>Alamat: <span class="profile-count">Jl. Dummy No. 123</span></div>
        <div>No. HP: <span class="profile-count">0812-3456-7890</span></div>
        <div style="margin-top:18px;">Progress Kunjungan:</div>
        <div class="profile-progress">
            <div class="profile-progress-bar" style="width:<?= min(100, $kunjungan*5); ?>%"></div>
        </div>
    </div>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div style="margin-top:10px;"><a href="admin_dashboard.php" class="btn-kembali">Dashboard Admin</a></div>
    <?php endif; ?>
    <?php
    // show active borrowings count from peminjaman
    include 'config/koneksi.php';
    $id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 0;
    $q = mysqli_query($koneksi, "SELECT COUNT(*) as cnt FROM peminjaman WHERE id_user='$id_user' AND status<>'Kembali'");
    $c = mysqli_fetch_assoc($q);
    $active_borrow = $c ? intval($c['cnt']) : 0;
    ?>
    <div style="margin-top:8px;">Peminjaman Aktif: <strong><?= $active_borrow; ?></strong> <a href="user_peminjaman.php">Lihat</a></div>
    <div class="profile-history">
        <h3 style="color:#3498db;margin-top:24px;">Riwayat Pinjam/Kembalikan</h3>
        <ul style="text-align:left;max-width:320px;margin:0 auto;">
        <?php
        include 'config/koneksi.php';
        $id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 0;
        $riwayat = mysqli_query($koneksi, "SELECT r.*, b.judul FROM riwayat r JOIN buku b ON r.id_buku = b.id_buku WHERE r.id_user='$id_user' ORDER BY r.tanggal DESC LIMIT 10");
        while ($row = mysqli_fetch_assoc($riwayat)) {
            echo '<li>' . htmlspecialchars($row['judul']) . ' - ' . $row['aksi'] . ' (' . $row['tanggal'] . ')</li>';
        }
        ?>
        </ul>
    </div>
        <a href="edit_profil.php" class="profile-edit">Edit Profil</a>
        <!-- Tombol kembali ke dashboard dihapus -->
        <a href="logout.php" class="profile-logout">Logout</a>
    <div class="profile-top-bar">
        <a href="test_buku.php" class="profile-back">Kembali</a>
    </div>
</div>
</body>
</html>
