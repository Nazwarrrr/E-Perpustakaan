<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include 'config/koneksi.php';
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $query = mysqli_query(
        $koneksi,
        "SELECT * FROM buku 
         WHERE judul LIKE '%$keyword%' 
         OR penulis LIKE '%$keyword%'"
    );
} else {
    $query = mysqli_query($koneksi, "SELECT * FROM buku");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Buku</title>
</head>
<body>

<p>
    Halo, <?= $_SESSION['nama']; ?> 👋 |
    <a href="logout.php">Logout</a>
</p>

<h2>Daftar Buku Perpustakaan</h2>
<a href="tambah_buku.php">+ Tambah Buku</a>
<br><br>

<form method="get">
    <input type="text" name="keyword" placeholder="Cari judul / penulis">
    <button type="submit">Cari</button>
</form>

<br>


<table border="1" cellpadding="8">
<tr>
    <th>No</th>
    <th>Judul</th>
    <th>Penulis</th>
    <th>Status</th>
    <th>Rak</th>
    <th>Aksi</th>
</tr>

<?php $no = 1; ?>
<?php while ($data = mysqli_fetch_assoc($query)) : ?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $data['judul']; ?></td>
    <td><?= $data['penulis']; ?></td>
    <td><?= $data['status']; ?></td>
    <td><?= $data['rak']; ?></td>
<td>
    <?php if ($data['status'] == 'tersedia') { ?>
        <a href="pinjam.php?id=<?= $data['id_buku']; ?>">Pinjam</a>
    <?php } else { ?>
        <a href="kembalikan.php?id=<?= $data['id_buku']; ?>">Kembalikan</a>
    <?php } ?>
</td>

</tr>
<?php endwhile; ?>

</table>

</body>
</html>
