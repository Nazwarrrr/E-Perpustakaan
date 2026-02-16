<?php
header('Content-Type: application/json; charset=utf-8');
// Simple endpoint to return latest books as JSON
// Usage: api/get_latest_books.php?limit=20

require_once __DIR__ . '/../config/koneksi.php';

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
if ($limit <= 0 || $limit > 200) $limit = 20; // sanitize

$sql = "SELECT id_buku, judul, penulis, penerbit, stok, rak, status, foto FROM buku ORDER BY id_buku DESC LIMIT ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, 'i', $limit);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$books = [];
while ($row = mysqli_fetch_assoc($res)) {
    $books[] = [
        'id_buku' => intval($row['id_buku']),
        'judul' => $row['judul'],
        'penulis' => $row['penulis'],
        'penerbit' => $row['penerbit'],
        'stok' => intval($row['stok']),
        'rak' => $row['rak'],
        'status' => $row['status'],
        'foto' => $row['foto']
    ];
}

echo json_encode(['ok' => true, 'count' => count($books), 'books' => $books], JSON_UNESCAPED_UNICODE);
exit;
