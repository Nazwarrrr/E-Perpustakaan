CREATE TABLE riwayat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_buku INT,
    aksi VARCHAR(20),
    tanggal DATETIME
);
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(50),
    role VARCHAR(20)
);

INSERT INTO users (username, password, role) VALUES
('admin', 'admin', 'admin'),
('siswa', 'siswa', 'siswa');

CREATE TABLE buku (
    id_buku INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(100),
    penulis VARCHAR(100),
    penerbit VARCHAR(100),
    stok INT,
    rak VARCHAR(20),
    status VARCHAR(20),
    foto VARCHAR(255) NULL,
    deskripsi TEXT NULL,
    jumlah_halaman INT NULL,
    tahun_terbit YEAR NULL
);

INSERT INTO buku (judul, penulis, penerbit, stok, rak, status) VALUES
('Laskar Pelangi', 'Andrea Hirata', 'Bentang', 3, 'A1', 'Tersedia'),
('Bumi', 'Tere Liye', 'Gramedia', 1, 'B2', 'Tersedia'),
('Negeri 5 Menara', 'Ahmad Fuadi', 'Gramedia', 0, 'C3', 'Dipinjam');

-- Table for peminjaman dengan data peminjam (nama, kelas, tanggal pinjam/kembali)
CREATE TABLE peminjaman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_buku INT,
    nama_peminjam VARCHAR(150),
    kelas VARCHAR(100),
    tanggal_pinjam DATE,
    tanggal_kembali DATE,
    status VARCHAR(30),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_buku) REFERENCES buku(id_buku)
);

-- Add Foreign Key constraints to riwayat table
ALTER TABLE riwayat
ADD CONSTRAINT fk_riwayat_user FOREIGN KEY (id_user) REFERENCES users(id),
ADD CONSTRAINT fk_riwayat_buku FOREIGN KEY (id_buku) REFERENCES buku(id_buku);


