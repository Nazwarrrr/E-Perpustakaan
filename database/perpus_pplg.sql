-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Feb 2026 pada 05.02
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpus_pplg`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `penulis` varchar(100) DEFAULT NULL,
  `penerbit` varchar(100) DEFAULT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `rak` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `jumlah_halaman` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `stok`, `rak`, `status`, `foto`, `deskripsi`, `jumlah_halaman`) VALUES
(3, 'Negeri 5 Menara', 'Ahmad Fuadi', 'Gramedia', NULL, 10, 'C3', 'Tersedia', '', NULL, NULL),
(4, 'bumi', 'Tere Liye', 'Gramedia', NULL, 1, 'A1', 'Tersedia', '', NULL, NULL),
(6, 'Laskar Pelangi', 'Andrea Hirata', 'Bentang', NULL, 3, 'A1', 'Tersedia', NULL, NULL, NULL),
(7, 'Bumi', 'Tere Liye', 'Gramedia', NULL, 1, 'B2', 'Tersedia', NULL, NULL, NULL),
(10, 'matahari', 'tere liye', 'Gramedia', '1945', 10, 'A1', 'Tersedia', '1771248289_download (7).jpeg', 'buku buatan tere liye', 435);

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `nama_peminjam` varchar(150) DEFAULT NULL,
  `kelas` varchar(100) DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_user`, `id_buku`, `nama_peminjam`, `kelas`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `created_at`) VALUES
(1, 2, 3, 'siswa', 'X PPLG 2', '2026-02-14', '2026-02-23', 'Kembali', '2026-02-14 19:48:17'),
(2, 2, 2, 'siswa', 'X PPLG 2', '2026-02-14', '2026-02-16', 'Kembali', '2026-02-14 19:48:35'),
(3, 2, 10, 'abdul', 'X PPLG 2', '2026-02-16', '2026-02-18', 'Kembali', '2026-02-16 20:57:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat`
--

CREATE TABLE `riwayat` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `aksi` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `riwayat`
--

INSERT INTO `riwayat` (`id`, `id_user`, `id_buku`, `aksi`, `tanggal`) VALUES
(1, 1, 3, 'Pinjam', '2026-02-08 19:46:42'),
(2, 1, 3, 'Kembalikan', '2026-02-08 19:46:44'),
(3, 1, 2, 'Kembalikan', '2026-02-08 19:46:45'),
(4, 1, 2, 'Pinjam', '2026-02-08 19:46:47'),
(5, 1, 3, 'Pinjam', '2026-02-08 19:54:57'),
(6, 1, 3, 'Kembalikan', '2026-02-08 19:54:59'),
(7, 1, 3, 'Pinjam', '2026-02-14 17:45:12'),
(8, 1, 3, 'Kembalikan', '2026-02-14 17:45:14'),
(9, 2, 2, 'Kembalikan', '2026-02-14 18:05:54'),
(10, 2, 3, 'Pinjam', '2026-02-14 18:05:59'),
(11, 1, 3, 'Kembalikan', '2026-02-14 19:41:07'),
(12, 1, 4, 'Kembalikan', '2026-02-14 19:41:09'),
(13, 2, 3, 'Pinjam', '2026-02-14 19:48:17'),
(14, 2, 3, 'Kembalikan', '2026-02-14 19:48:21'),
(15, 2, 2, 'Pinjam', '2026-02-14 19:48:35'),
(16, 1, 2, 'Kembalikan', '2026-02-14 19:48:57'),
(17, 1, 3, 'Kembalikan', '2026-02-14 19:48:59'),
(18, 1, 8, 'Kembalikan', '2026-02-16 19:58:16'),
(19, 2, 10, 'Pinjam', '2026-02-16 20:57:40'),
(20, 1, 10, 'Kembalikan', '2026-02-16 20:58:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Admin Perpustakaan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin', 'admin'),
(2, 'siswa', 'siswa', 'siswa'),
(3, 'admin', 'admin', 'admin'),
(4, 'siswa', 'siswa', 'siswa');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
