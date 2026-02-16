<?php
session_start();
include 'config/koneksi.php';

// Ambil id dari URL dan validasi
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    $notFound = true;
} else {
    // Prepared statement: coba ambil kolom baru dulu. Jika DB belum diubah, fallback secara aman ke kolom lama.
    $book = null;
    $notFound = true;
    $sql = "SELECT id_buku, judul, penulis, penerbit, tahun_terbit, rak, stok, status, foto, deskripsi, jumlah_halaman FROM buku WHERE id_buku = ? LIMIT 1";
    try {
        $stmt = mysqli_prepare($koneksi, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            $book = mysqli_fetch_assoc($res);
            mysqli_stmt_close($stmt);
            $notFound = !$book;
        }
    } catch (mysqli_sql_exception $e) {
        // Kemungkinan kolom `tahun_terbit` belum ada. Coba fallback: ambil kolom `tahun` dan alias ke `tahun_terbit`.
        $fallbackSql = "SELECT id_buku, judul, penulis, penerbit, tahun AS tahun_terbit, rak, stok, status, foto, deskripsi, jumlah_halaman FROM buku WHERE id_buku = ? LIMIT 1";
        $stmt2 = @mysqli_prepare($koneksi, $fallbackSql);
        if ($stmt2) {
            mysqli_stmt_bind_param($stmt2, 'i', $id);
            mysqli_stmt_execute($stmt2);
            $res2 = mysqli_stmt_get_result($stmt2);
            $book = mysqli_fetch_assoc($res2);
            mysqli_stmt_close($stmt2);
            $notFound = !$book;
        } else {
            // Sebagai langkah terakhir, coba ambil tanpa jumlah_halaman/tahun_terbit
            $fallbackSql2 = "SELECT id_buku, judul, penulis, penerbit, tahun, rak, stok, status, foto, deskripsi FROM buku WHERE id_buku = ? LIMIT 1";
            $stmt3 = @mysqli_prepare($koneksi, $fallbackSql2);
            if ($stmt3) {
                mysqli_stmt_bind_param($stmt3, 'i', $id);
                mysqli_stmt_execute($stmt3);
                $res3 = mysqli_stmt_get_result($stmt3);
                $book = mysqli_fetch_assoc($res3);
                mysqli_stmt_close($stmt3);
                $notFound = !$book;
            } else {
                $notFound = true;
            }
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Buku</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Vertical detail layout, responsive and consistent with theme */
        .detail-container { max-width: 900px; margin: 16px auto; padding: 18px; background:#fff; border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.06); position:relative; }
        .back-btn { position:absolute; left:16px; top:16px; display:inline-block; padding:8px 10px; background:#0b5ed7; color:#fff; text-decoration:none; border-radius:4px; }
        .detail-title { text-align:center; margin:14px 0 8px; font-size:28px; color:#0b5ed7; }
        .detail-cover { text-align:center; margin:12px 0; }
        .detail-cover img { max-width:320px; width:80%; height:auto; border-radius:6px; box-shadow:0 1px 4px rgba(0,0,0,0.08); }
        .detail-info { margin-top:12px; color:#333; line-height:1.6; }
        .detail-info .row { padding:8px 0; border-bottom:1px solid #f0f0f0; }
        .detail-info .label { display:block; font-weight:600; color:#0b5ed7; margin-bottom:4px; }
        .pinjam-btn { display:block; width:100%; max-width:260px; margin:18px auto 6px; padding:12px 16px; background:#0b5ed7; color:#fff; text-align:center; text-decoration:none; border-radius:6px; }
        .pinjam-btn.disabled { background:#ccc; pointer-events:none; }
        .notfound { text-align:center; padding:40px; }
        @media (max-width:600px) { .detail-title{font-size:22px;} .detail-cover img{width:100%;max-width:260px;} }
    </style>
</head>
<body>
<div class="page-center">
    <div class="detail-container">
        <?php if (!empty($notFound)) : ?>
            <div class="notfound">
                <h2>Buku tidak ditemukan</h2>
                <p>Data buku dengan ID yang diberikan tidak tersedia.</p>
                <a class="back-btn" href="test_buku.php">Kembali ke Daftar Buku</a>
            </div>
        <?php else: ?>
            <a class="back-btn" href="test_buku.php">&larr; Kembali</a>
            <h1 class="detail-title"><?= htmlspecialchars($book['judul']); ?></h1>

            <div class="detail-cover">
                <?php if (!empty($book['foto']) && file_exists(__DIR__ . '/upload/' . $book['foto'])): ?>
                    <img src="upload/<?= htmlspecialchars($book['foto']); ?>" alt="<?= htmlspecialchars($book['judul']); ?>">
                <?php else: ?>
                    <img src="assets/img/no-image.png" alt="No Image">
                <?php endif; ?>
            </div>

            <div class="detail-info">
                <div class="row"><span class="label">Penulis</span><?= htmlspecialchars($book['penulis']); ?></div>
                <div class="row"><span class="label">Penerbit</span><?= htmlspecialchars($book['penerbit']); ?></div>
                <div class="row"><span class="label">Tahun Terbit</span><?= !empty($book['tahun_terbit']) ? htmlspecialchars($book['tahun_terbit']) : 'Tidak tersedia'; ?></div>
                <div class="row"><span class="label">Jumlah Halaman</span><?= !empty($book['jumlah_halaman']) ? htmlspecialchars($book['jumlah_halaman']) : 'Tidak tersedia'; ?></div>
                <div class="row"><span class="label">Rak</span><?= htmlspecialchars($book['rak']); ?></div>
                <div class="row"><span class="label">Stok</span><?= htmlspecialchars($book['stok']); ?></div>
                <div class="row"><span class="label">Status</span><?= htmlspecialchars($book['status']); ?></div>

                <div class="row"><span class="label">Deskripsi</span>
                    <div><?= nl2br(htmlspecialchars($book['deskripsi'] ?? 'Tidak ada deskripsi untuk buku ini.')); ?></div>
                </div>

                <?php
                // Tombol pinjam: aktifkan hanya jika tersedia stok
                $canBorrow = (!empty($book['stok']) && $book['stok'] > 0 && $book['status'] == 'Tersedia');
                ?>
                <a href="<?= $canBorrow ? 'pinjam.php?id=' . urlencode($book['id_buku']) : '#' ?>" class="pinjam-btn <?= $canBorrow ? '' : 'disabled' ?>"><?= $canBorrow ? 'Pinjam Buku' : 'Tidak bisa dipinjam' ?></a>

            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
