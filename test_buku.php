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
// (Query untuk data per-halaman akan dieksekusi lebih bawah menggunakan LIMIT/OFFSET)
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
        <a href="admin_dashboard.php" class="top-profile" style="margin-left:12px;">Dashboard</a>
        <a href="admin_peminjaman.php" class="top-profile" style="margin-left:12px;">Peminjaman</a>
    <?php endif; ?>
</div>
<div class="page-center">
<div style="text-align:center;margin-bottom:12px;">
    <img src="assets/img/logo.png" alt="Logo" class="list-logo-img" style="width:90px;height:90px;object-fit:contain;">
</div>
<h2 style="text-align:center;margin-bottom:16px;">Daftar Buku Perpustakaan</h2>
<?php if (!empty($_SESSION['flash'])): ?>
    <div style="max-width:900px;margin:12px auto;background:#e6ffed;border:1px solid #b8f3c7;padding:10px;border-radius:6px;color:#05683a;text-align:center;">
        <?= htmlspecialchars($_SESSION['flash']); unset($_SESSION['flash']); ?>
    </div>
<?php endif; ?>
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
$perPage = 9; // maksimal buku per halaman
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Siapkan bagian WHERE (sudah dibangun di atas sebagai $where, $params, $types)
$whereSql = '';
if ($where) {
    $whereSql = ' WHERE ' . implode(' AND ', $where);
}

// 1) Hitung total data (tanpa LIMIT)
$countSql = "SELECT COUNT(*) AS total FROM buku" . $whereSql;
if ($params) {
    $stmtCount = mysqli_prepare($koneksi, $countSql);
    if ($stmtCount === false) {
        die('Prepare failed: ' . mysqli_error($koneksi));
    }
    mysqli_stmt_bind_param($stmtCount, $types, ...$params);
    mysqli_stmt_execute($stmtCount);
    $resCount = mysqli_stmt_get_result($stmtCount);
    $rowCount = mysqli_fetch_assoc($resCount);
    mysqli_stmt_close($stmtCount);
} else {
    $resCount = mysqli_query($koneksi, $countSql);
    $rowCount = mysqli_fetch_assoc($resCount);
}
$totalBooks = (int) ($rowCount['total'] ?? 0);
$totalPages = $totalBooks > 0 ? (int) ceil($totalBooks / $perPage) : 1;

// Pastikan halaman dalam rentang
if ($page > $totalPages) $page = $totalPages;

// 2) Hitung offset
$start = ($page - 1) * $perPage;
if ($start < 0) $start = 0;

// 3) Ambil data untuk halaman ini menggunakan LIMIT dan OFFSET
$dataSql = "SELECT * FROM buku" . $whereSql . " ORDER BY id_buku DESC LIMIT " . intval($start) . ", " . intval($perPage);
if ($params) {
    $stmt = mysqli_prepare($koneksi, $dataSql);
    if ($stmt === false) {
        die('Prepare failed: ' . mysqli_error($koneksi));
    }
    // Bind hanya parameter filter (LIMIT sudah di-interpolate sebagai integer aman)
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
} else {
    $res = mysqli_query($koneksi, $dataSql);
}

while ($data = mysqli_fetch_assoc($res)) : ?>
    <div class="book-card">
        <div class="book-title">#<?= $no++; ?> - <a href="detail_buku.php?id=<?= $data['id_buku']; ?>"><?= htmlspecialchars($data['judul']); ?></a></div>
        <div class="book-img">
            <a href="detail_buku.php?id=<?= $data['id_buku']; ?>"><img src="upload/<?= htmlspecialchars($data['foto']); ?>" alt="<?= htmlspecialchars($data['judul']); ?>" width="140"></a>
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
                    <a class="action-btn primary" href="pinjam.php?id=<?= $data['id_buku']; ?>">Pinjam</a>
                <?php } else { ?>
                    <a class="action-btn disabled">Pinjam</a>
                <?php } ?>
                <a class="action-btn ghost" href="detail_buku.php?id=<?= $data['id_buku']; ?>">Detail</a>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                    <a href="edit_buku.php?id=<?= $data['id_buku']; ?>" class="action-btn ghost">Edit</a>
                <?php } ?>
            </div>
        </div>
    </div>
<?php endwhile; ?>
</div>

<div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
        <a href="?page=<?= $i ?><?= isset($_GET['keyword']) ? '&keyword=' . urlencode($_GET['keyword']) : '' ?><?= isset($_GET['status']) ? '&status=' . urlencode($_GET['status']) : '' ?>" class="<?= $i == $page ? 'active' : '' ?>"> <?= $i ?> </a>
    <?php endfor; ?>
</div>

<script src="assets/js/ui.js"></script>
<script>
    // Beri tahu script client apakah user adalah admin (digunakan oleh live_books.js)
    window.IS_ADMIN = <?= (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') ? 'true' : 'false' ?>;
    // Hanya aktifkan live_books.js jika tidak ada filter pencarian
    const hasFilter = !!(new URLSearchParams(window.location.search).get('keyword') || new URLSearchParams(window.location.search).get('status'));
    if (!hasFilter) {
        var script = document.createElement('script');
        script.src = 'assets/js/live_books.js';
        document.body.appendChild(script);
    }
</script>
</div>
</body>
</html>
