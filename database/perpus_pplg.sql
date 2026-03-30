-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2026 at 03:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `buku`
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
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `stok`, `rak`, `status`, `foto`, `deskripsi`, `jumlah_halaman`) VALUES
(11, 'Bumi', 'Tere Liye', 'Gramedia', '2014', 3, 'Fiksi', 'Tersedia', '1774874858_Bumi.png', 'Novel ini menceritakan tentang seorang remaja bernama Raib yang menyimpan rahasia besar dalam hidupnya. Ia memiliki kemampuan untuk menghilang, sesuatu yang tidak dimiliki oleh manusia biasa. Bersama dua temannya, Seli dan Ali, Raib kemudian terlibat dalam petualangan menegangkan ke dunia paralel yang penuh misteri dan bahaya. Mereka harus menghadapi berbagai tantangan, musuh kuat, serta mengungkap rahasia besar tentang dunia yang selama ini tersembunyi. Buku ini tidak hanya menyajikan petualangan seru, tetapi juga mengajarkan tentang persahabatan, keberanian, dan jati diri.', 440),
(12, 'Bulan', 'Tere Liye', 'Gramedia', '2015', 5, 'Fiksi', 'Tersedia', '1774874926_img20220905_11324048.jpg', 'Melanjutkan kisah dari buku sebelumnya, Raib, Seli, dan Ali kembali terlibat dalam perjalanan berbahaya ke dunia lain yang lebih kompleks dan penuh konflik. Mereka menghadapi ancaman dari kekuatan besar yang ingin menguasai dunia paralel. Dalam perjalanan ini, mereka harus bekerja sama, mengandalkan kemampuan masing-masing, serta membuat keputusan sulit demi keselamatan banyak orang. Cerita ini semakin memperdalam karakter tokohnya dan memperluas dunia yang diciptakan, membuat pembaca semakin tenggelam dalam kisah yang penuh aksi dan emosi.', 400),
(13, 'Matahari', 'Tere Liye', 'Gramedia', '2016', 1, 'Fiksi', 'Tersedia', '1774875151_85e970deed13ecc51c6ce6aba611d9fb.webp', 'Dalam seri ini, petualangan Raib dan teman-temannya semakin menegangkan. Mereka harus menghadapi musuh yang jauh lebih kuat dan berbahaya dibanding sebelumnya. Konflik yang terjadi tidak hanya menguji kekuatan fisik, tetapi juga mental dan kepercayaan antar teman. Banyak rahasia besar yang mulai terungkap, membuat perjalanan mereka menjadi semakin kompleks. Buku ini menghadirkan alur cerita yang cepat, penuh aksi, dan sarat dengan pesan tentang keberanian, pengorbanan, dan arti persahabatan sejati.', 420),
(14, 'Hujan', 'Tere Liye', 'Gramedia', '2016', 4, 'Fiksi', 'Tersedia', '1774875245_Hujan.png', 'Novel ini mengisahkan kehidupan seorang gadis bernama Lail di masa depan, di mana teknologi telah berkembang sangat pesat. Setelah kehilangan orang-orang terdekatnya akibat bencana besar, Lail harus menjalani hidup dengan penuh luka dan kenangan. Dalam perjalanannya, ia bertemu dengan seseorang yang perlahan mengubah hidupnya. Cerita ini menggambarkan perjuangan menghadapi kehilangan, kekuatan untuk bangkit, serta arti dari mencintai dan melepaskan. Dengan latar futuristik, novel ini tetap terasa dekat dengan emosi manusia yang mendalam.', 320),
(15, 'Rindu', 'Tere Liye', 'Republika', '2014', 3, 'Fiksi', 'Tersedia', '1774875321_9786028997904_rindu_tere_li.jpg', 'Buku ini mengambil latar perjalanan panjang menggunakan kapal menuju Tanah Suci untuk menunaikan ibadah haji. Selama perjalanan tersebut, para tokoh dengan latar belakang yang berbeda-beda dipertemukan dalam satu kapal. Masing-masing membawa kisah hidup, luka, harapan, dan rindu yang berbeda. Melalui interaksi mereka, pembaca diajak memahami makna kehidupan, memaafkan masa lalu, dan menemukan kedamaian dalam diri. Novel ini sarat dengan nilai religi, refleksi diri, dan pesan moral yang dalam.', 540),
(16, 'Bu, Aku Ingin Pelukmu', 'Reza Mustopa', 'Gradien Mediatama', '2025', 1, 'Non-Fiksi', 'Tersedia', '1774875613_c8436580-06a8-44b9-92f3-237a9dd538dd.jpeg', 'Buku ini berisi tulisan emosional tentang kerinduan seorang anak kepada ibunya yang telah tiada. Mengangkat tema kehilangan, perjuangan hidup, dan penguatan diri saat menghadapi kerasnya dunia tanpa sosok ibu. Ditulis dengan gaya reflektif dan menyentuh, cocok untuk pembaca yang sedang mencari ketenangan dan makna hidup.', 164),
(17, 'Maaf Tuhan, Aku Hampir Menyerah', 'Alvi Syahrin', 'GagasMedia', '2019', 6, 'Non-Fiksi', 'Tersedia', '1774875795_a48c6514-f786-4b67-a592-1adb4fc4b20d.jpeg', 'Buku ini berisi refleksi tentang rasa lelah, putus asa, dan keinginan untuk menyerah dalam hidup. Penulis mengajak pembaca untuk kembali mendekat kepada Tuhan, menemukan makna di balik ujian, serta bangkit perlahan dari keterpurukan dengan sudut pandang yang lebih tenang dan penuh harapan.', 200),
(18, 'Laskar Pelangi', 'Andrea Hirata', 'Benteng Pustaka', '2005', 4, 'Fiksi', 'Tersedia', '1774876118_Laskar_pelangi_sampul.jpg', 'Novel yang mengisahkan tentang sepuluh anak di sebuah desa kecil di Belitung yang penuh semangat dan mimpi, dipimpin oleh seorang guru inspiratif,', 529),
(19, 'Dilan: Dia adalah Dilanku Tahun 1990', 'Pidi Baiq', 'Pastel Books', '2014', 10, 'Fiksi', 'Tersedia', '1774876226_1.webp', 'Novel romantis yang menceritakan kisah cinta remaja antara Dilan dan Milea di Bandung tahun 1990. Dilan dikenal unik, romantis, dan penuh kejutan, sehingga membuat hubungan mereka terasa berbeda dari kisah cinta pada umumnya.', 332),
(20, 'Harry Potter dan Batu Bertuah', 'J.K. Rowling', 'Gramedia Pustaka Utama', '1997', 8, 'Fiksi', 'Tersedia', '1774876319_9786020337647_harry-potter-dan-batu-bertuah-cover-baru.jpg', 'Kisah tentang Harry Potter, anak yatim yang menemukan bahwa dirinya adalah penyihir. Ia mulai belajar di Hogwarts dan menghadapi berbagai petualangan serta ancaman dari penyihir jahat', 384);

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
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
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_user`, `id_buku`, `nama_peminjam`, `kelas`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `created_at`) VALUES
(1, 2, 3, 'siswa', 'X PPLG 2', '2026-02-14', '2026-02-23', 'Kembali', '2026-02-14 19:48:17'),
(2, 2, 2, 'siswa', 'X PPLG 2', '2026-02-14', '2026-02-16', 'Kembali', '2026-02-14 19:48:35'),
(3, 2, 10, 'abdul', 'X PPLG 2', '2026-02-16', '2026-02-18', 'Kembali', '2026-02-16 20:57:40'),
(4, 2, 7, 'siswa', 'X PPLG 2', '2026-03-08', '2026-03-20', 'Kembali', '2026-03-08 13:37:03'),
(5, 2, 6, 'siswa', 'X PPLG 2', '2026-03-08', '2026-03-16', 'Kembali', '2026-03-08 13:37:27');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat`
--

CREATE TABLE `riwayat` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `aksi` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat`
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
(20, 1, 10, 'Kembalikan', '2026-02-16 20:58:13'),
(21, 2, 7, 'Pinjam', '2026-03-08 13:37:03'),
(22, 2, 6, 'Pinjam', '2026-03-08 13:37:27'),
(23, 1, 6, 'Kembalikan', '2026-03-08 13:37:56'),
(24, 1, 7, 'Kembalikan', '2026-03-08 13:37:59');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Admin Perpustakaan');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
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
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
