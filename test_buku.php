<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'config/koneksi.php';

// Filter buku
$where = [];
$params = [];
$types = '';
if (!empty($_GET['keyword'])) {
    $where[] = "(judul LIKE ? OR penulis LIKE ?)";
    $params[] = '%' . $_GET['keyword'] . '%';
    $params[] = '%' . $_GET['keyword'] . '%';
    $types .= 'ss';
}
if (!empty($_GET['status'])) {
    $where[] = "status = ?";
    $params[] = $_GET['status'];
    $types .= 's';
}
// Filter penulis dihapus
$sql = "SELECT * FROM buku";
if ($where) {
    $sql .= " WHERE " . implode(' AND ', $where);
}
if ($params) {
    $query = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($query, $types, ...$params);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);
} else {
    $result = mysqli_query($koneksi, $sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Buku</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- Tombol kembali ke dashboard dihapus -->


<div class="top-bar">
    <a href="profil.php" class="top-profile">Profil</a>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
        <a href="admin_peminjaman.php" class="top-profile" style="margin-left:12px;">Peminjaman</a>
    <?php endif; ?>
</div>
<div style="text-align:center;margin-bottom:8px;">
    <img src="assets/img/logo.png" alt="Logo" class="list-logo-img" style="width:90px;height:90px;object-fit:contain;">
</div>
<h2 style="text-align:center;">Daftar Buku Perpustakaan</h2>
<?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
<div class="add-book-fixed">
    <a href="tambah_buku.php" title="Tambah Buku">+</a>
</div>
<?php endif; ?>


<form method="get" class="book-filter-form">
    <input type="text" name="keyword" placeholder="Cari judul / penulis" value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
    <select name="status">
        <option value="">Semua Status</option>
        <option value="Tersedia" <?= (isset($_GET['status']) && $_GET['status'] == 'Tersedia') ? 'selected' : '' ?>>Tersedia</option>
        <option value="Dipinjam" <?= (isset($_GET['status']) && $_GET['status'] == 'Dipinjam') ? 'selected' : '' ?>>Dipinjam</option>
    </select>
    <!-- Filter penulis dihapus -->
    <button type="submit">Filter</button>
</form>



<div class="book-list">
<?php
$no = 1;
$perPage = 3;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$books = [];
while ($data = isset($result) && $result ? mysqli_fetch_assoc($result) : mysqli_fetch_assoc($query)) {
    $books[] = $data;
}
$totalBooks = count($books);
$totalPages = ceil($totalBooks / $perPage);
$start = ($page - 1) * $perPage;
$booksPage = array_slice($books, $start, $perPage);
foreach ($booksPage as $data) : ?>
    <div class="book-card">
        <div class="book-title">#<?= $no++; ?> - <?= $data['judul']; ?></div>
        <div class="book-img">
            <img src="upload/<?= $data['foto']; ?>" alt="<?= $data['judul']; ?>" width="140">
        </div>
        <div class="book-info">
            <div><span class="book-label">Penulis:</span> <?= $data['penulis']; ?></div>
            <div><span class="book-label">Penerbit:</span> <?= $data['penerbit']; ?></div>
            <div><span class="book-label">Stok:</span> <?= $data['stok']; ?></div>
            <div><span class="book-label">Status:</span> <span class="badge-status <?= ($data['stok'] == 0) ? 'habis' : strtolower($data['status']); ?>">
                <?= ($data['stok'] == 0) ? 'Habis' : $data['status']; ?>
            </span></div>
            <div><span class="book-label">Rak:</span> <?= $data['rak']; ?></div>
            <div class="book-action">
                <?php if ($data['status'] == 'Tersedia' && $data['stok'] > 0) { ?>
                    <a href="pinjam.php?id=<?= $data['id_buku']; ?>">Pinjam</a>
                <?php } elseif ($data['status'] == 'Dipinjam' || ($data['status'] == 'Habis' && $data['stok'] == 0)) { ?>
                    <a href="kembalikan.php?id=<?= $data['id_buku']; ?>">Kembalikan</a>
                <?php } ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                    <a href="edit_buku.php?id=<?= $data['id_buku']; ?>" class="book-edit">Edit</a>
                    <a href="hapus_buku.php?id=<?= $data['id_buku']; ?>" class="book-delete" onclick="return confirm('Yakin hapus buku ini?')">Hapus</a>
                <?php } ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

<div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
        <a href="?page=<?= $i ?><?= isset($_GET['keyword']) ? '&keyword=' . urlencode($_GET['keyword']) : '' ?><?= isset($_GET['status']) ? '&status=' . urlencode($_GET['status']) : '' ?>" class="<?= $i == $page ? 'active' : '' ?>"> <?= $i ?> </a>
    <?php endfor; ?>
</div>

<script src="assets/js/ui.js"></script>
</body>
</html>
