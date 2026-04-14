-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2026 at 04:30 PM
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
-- Database: `db_psaj`
--
CREATE DATABASE IF NOT EXISTS `db_psaj` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_psaj`;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE IF NOT EXISTS `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `tingkat` varchar(50) NOT NULL,
  `jurusan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE IF NOT EXISTS `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `telpon` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guru_bk`
--

CREATE TABLE IF NOT EXISTS `guru_bk` (
  `id_bk` int(11) NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `telpon` varchar(15) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru_bk`
--

INSERT INTO `guru_bk` (`id_bk`, `nip`, `nama`, `jenis_kelamin`, `telpon`, `email`, `username`, `password`, `status`) VALUES
(1, '19700101', 'Guru BK', 'Laki-laki', '081234567890', 'bk@sekolah.sch.id', 'admin', 'admin123', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE IF NOT EXISTS `pengaduan` (
  `id_pengaduan` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_bk` int(11) DEFAULT NULL,
  `jenis` enum('pengaduan','laporan') NOT NULL,
  `judul` varchar(150) NOT NULL,
  `isi` text NOT NULL,
  `file_dokumen` varchar(255) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `status` enum('baru','diproses','selesai') DEFAULT 'baru',
  `tanggapan` text DEFAULT NULL,
  `tanggal_tanggapan` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id_chat` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_bk` int(11) NOT NULL,
  `pengirim` enum('siswa','guru') NOT NULL,
  `pesan` text NOT NULL,
  `file_chat` varchar(255) DEFAULT NULL,
  `dibaca` enum('belum','sudah') DEFAULT 'belum',
  `waktu` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE IF NOT EXISTS `notifikasi` (
  `id_notif` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_bk` int(11) DEFAULT NULL,
  `judul` varchar(150) NOT NULL,
  `pesan` text NOT NULL,
  `tipe` enum('pengaduan','chat','sistem') DEFAULT 'sistem',
  `status` enum('belum','sudah') DEFAULT 'belum',
  `link` varchar(255) DEFAULT NULL,
  `waktu` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `guru_bk`
--
ALTER TABLE `guru_bk`
  ADD PRIMARY KEY (`id_bk`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_bk` (`id_bk`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id_chat`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_bk` (`id_bk`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notif`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_bk` (`id_bk`);

-- --------------------------------------------------------

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guru_bk`
--
ALTER TABLE `guru_bk`
  MODIFY `id_bk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id_pengaduan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Constraints for dumped tables
--

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE SET NULL;

--
-- Constraints for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `pengaduan_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengaduan_ibfk_2` FOREIGN KEY (`id_bk`) REFERENCES `guru_bk` (`id_bk`) ON DELETE SET NULL;

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`id_bk`) REFERENCES `guru_bk` (`id_bk`) ON DELETE CASCADE;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifikasi_ibfk_2` FOREIGN KEY (`id_bk`) REFERENCES `guru_bk` (`id_bk`) ON DELETE SET NULL;

-- ============================================
-- SAMPLE DATA UNTUK TESTING - PSAJ DATABASE
-- ============================================

-- ============================================
-- INSERT DATA KE TABEL KELAS
-- ============================================
INSERT INTO kelas (id_kelas, nama_kelas, tingkat, jurusan) VALUES
(1, 'XII RPL 1', 'XII', 'Rekayasa Perangkat Lunak'),
(2, 'XII RPL 2', 'XII', 'Rekayasa Perangkat Lunak'),
(3, 'XI RPL 1', 'XI', 'Rekayasa Perangkat Lunak'),
(4, 'XII TKJ 1', 'XII', 'Teknik Komputer dan Jaringan'),
(5, 'XI TKJ 1', 'XI', 'Teknik Komputer dan Jaringan'),
(6, 'XII TKRO 1', 'XII', 'Teknik Kendaraan Ringan Otomotif');

-- ============================================
-- INSERT DATA KE TABEL SISWA
-- ============================================
INSERT INTO siswa (id_siswa, nisn, nama, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, telpon, email, id_kelas, password, foto, status) VALUES
(1, '0001234567', 'Muhammad Rizki Pratama', 'Laki-laki', 'Surabaya', '2006-05-15', 'Jl. Merdeka No. 10, Surabaya', '081234567890', 'rizki@email.com', 1, 'password123', 'foto_risqi.jpg', 'aktif'),
(2, '0009876543', 'Siti Aisyah Nurul', 'Perempuan', 'Sidoarjo', '2006-08-20', 'Jl. Ahmad Yani No. 5, Sidoarjo', '081245678901', 'siti@email.com', 1, 'password123', 'foto_siti.jpg', 'aktif'),
(3, '0002345678', 'Budi Santoso', 'Laki-laki', 'Gresik', '2006-12-10', 'Jl. Veteran No. 15, Gresik', '081256789012', 'budi@email.com', 1, 'password123', 'foto_budi.jpg', 'aktif'),
(4, '0003456789', 'Rina Kusuma Dewi', 'Perempuan', 'Surabaya', '2007-01-25', 'Jl. Diponegoro No. 8, Surabaya', '081267890123', 'rina@email.com', 2, 'password123', 'foto_rina.jpg', 'aktif'),
(5, '0004567890', 'Ahmad Surya Wijaya', 'Laki-laki', 'Jakarta', '2006-03-05', 'Jl. Sudirman No. 20, Jakarta', '081278901234', 'ahmad@email.com', 2, 'password123', 'foto_ahmad.jpg', 'aktif'),
(6, '0005678901', 'Lina Marlina', 'Perempuan', 'Bandung', '2007-06-12', 'Jl. Braga No. 12, Bandung', '081289012345', 'lina@email.com', 4, 'password123', 'foto_lina.jpg', 'aktif'),
(7, '0006789012', 'Reza Firmansyah', 'Laki-laki', 'Surabaya', '2006-09-18', 'Jl. Kalimantan No. 3, Surabaya', '081290123456', 'reza@email.com', 3, 'password123', 'foto_reza.jpg', 'aktif'),
(8, '0007890123', 'Devy Prastika', 'Perempuan', 'Malang', '2007-02-28', 'Jl. Hasanuddin No. 7, Malang', '081301234567', 'devy@email.com', 5, 'password123', 'foto_devy.jpg', 'aktif');

-- ============================================
-- INSERT DATA KE TABEL GURU_BK (TAMBAHAN)
-- ============================================
INSERT INTO guru_bk (id_bk, nip, nama, jenis_kelamin, telpon, email, username, password, status) VALUES
(2, '19700102', 'Ibu Siti Rahma S.Pd', 'Perempuan', '081312345678', 'siti.rahma@sekolah.sch.id', 'ibu_siti', 'password123', 'aktif'),
(3, '19700103', 'Bapak Haryanto M.Pd', 'Laki-laki', '081323456789', 'haryanto@sekolah.sch.id', 'pak_haryanto', 'password123', 'aktif');

-- ============================================
-- INSERT DATA KE TABEL PENGADUAN
-- ============================================
INSERT INTO pengaduan (id_pengaduan, id_siswa, id_bk, jenis, judul, isi, tanggal, status) VALUES
(1, 1, 1, 'pengaduan', 'Konflik dengan Teman Sekelas', 'Saya mengalami konflik dengan teman sekelas karena perbedaan pendapat dalam mengerjakan proyek kelompok. Situasi ini membuat saya merasa tidak nyaman berada di kelas.', NOW() - INTERVAL 7 DAY, 'selesai'),
(2, 2, 1, 'laporan', 'Fasilitas Lab Komputer Rusak', 'Beberapa unit komputer di lab RPL sudah tidak berfungsi dengan baik, layarnya gelap dan keyboard tidak merespons dengan baik. Hal ini menghambat pembelajaran praktik kami.', NOW() - INTERVAL 5 DAY, 'diproses'),
(3, 3, NULL, 'pengaduan', 'Perlakuan Tidak Adil dari Guru', 'Saya merasa diperlakukan tidak adil oleh salah satu guru. Ketika saya bertanya, pertanyaan saya tidak dijawab dengan sempurna dan membuat saya semakin bingung.', NOW() - INTERVAL 3 DAY, 'baru'),
(4, 4, 1, 'laporan', 'Kurangnya Buku Referensi di Perpustakaan', 'Buku-buku referensi untuk mata pelajaran dasar pemrograman sangat terbatas di perpustakaan sekolah. Kami kesulitan mencari sumber belajar yang lengkap.', NOW() - INTERVAL 2 DAY, 'diproses'),
(5, 5, NULL, 'pengaduan', 'Masalah Pertemanan dan Bullying', 'Saya mendapat perlakuan kurang baik dari kelompok siswa tertentu. Mereka sering membuat komentar pedas dan membuat saya merasa terasingkan.', NOW() - INTERVAL 1 DAY, 'baru'),
(6, 6, 2, 'pengaduan', 'Kesulitan Memahami Pelajaran', 'Saya kesulitan memahami beberapa materi pelajaran terutama dalam mata pelajaran matematika dan pemrograman. Penjelasan di kelas masih kurang jelas bagi saya.', NOW(), 'baru');

-- ============================================
-- UPDATE PENGADUAN DENGAN TANGGAPAN
-- ============================================
UPDATE pengaduan SET 
  tanggapan = 'Sudah kami mediasi antara Anda dan teman sekelas. Kedua belah pihak sudah berdiskusi dan menemukan solusi bersama. Silakan coba bekerja sama kembali dengan lebih baik.',
  tanggal_tanggapan = NOW() - INTERVAL 5 DAY
WHERE id_pengaduan = 1;

UPDATE pengaduan SET 
  tanggapan = 'Tim maintenance sedang mengurus perbaikan perangkat komputer. Harap ditunggu, pesanan spare part sudah masuk dan akan diperbaiki minggu depan.',
  tanggal_tanggapan = NOW() - INTERVAL 2 DAY
WHERE id_pengaduan = 2;

-- ============================================
-- INSERT DATA KE TABEL CHAT
-- ============================================
INSERT INTO chat (id_siswa, id_bk, pengirim, pesan, dibaca, waktu) VALUES
(1, 1, 'siswa', 'Selamat pagi Pak, saya ingin berkonsultasi tentang konflik yang saya alami', 'sudah', NOW() - INTERVAL 2 DAY),
(1, 1, 'guru', 'Baik, ceritakan apa yang terjadi. Saya siap mendengarkan dan membantu menyelesaikannya.', 'sudah', NOW() - INTERVAL 2 DAY + INTERVAL 5 MINUTE),
(1, 1, 'siswa', 'Jadi begini pak, kemarin saya merasa diperlakukan tidak adil oleh kelompok saya...', 'sudah', NOW() - INTERVAL 2 DAY + INTERVAL 10 MINUTE),
(1, 1, 'guru', 'Saya mengerti. Bagaimana kalau nanti sore kita bicarakan lebih detail di ruang BK?', 'sudah', NOW() - INTERVAL 2 DAY + INTERVAL 15 MINUTE),
(2, 1, 'siswa', 'Pak, tentang pengaduan saya tentang lab komputer', 'sudah', NOW() - INTERVAL 1 DAY),
(2, 1, 'guru', 'Iya, sudah kami report ke pihak IT. Mereka akan memperbaiki bulan depan.', 'sudah', NOW() - INTERVAL 1 DAY + INTERVAL 30 MINUTE),
(4, 1, 'siswa', 'Assalam pak, apa kabar?', 'sudah', NOW() - INTERVAL 3 HOUR),
(4, 1, 'guru', 'Wa\'alaikum assalam. Kabar baik, ada yang bisa saya bantu?', 'sudah', NOW() - INTERVAL 2 HOUR + INTERVAL 50 MINUTE),
(4, 1, 'siswa', 'Saya ingin tanya tentang pengaduan saya yang belum direspon', 'belum', NOW() - INTERVAL 2 HOUR),
(4, 1, 'guru', 'Baik, saya akan segera menceknya. Terima kasih sudah mengingatkan.', 'belum', NOW() - INTERVAL 1 HOUR);

-- ============================================
-- INSERT DATA KE TABEL NOTIFIKASI
-- ============================================
INSERT INTO notifikasi (id_siswa, id_bk, judul, pesan, tipe, status, link, waktu) VALUES
(1, 1, 'Pengaduan Selesai Ditanggapi', 'Pengaduan Anda "Konflik dengan Teman Sekelas" sudah ditanggapi oleh Guru BK. Silakan cek balasan kami.', 'pengaduan', 'sudah', 'data_pengaduan.php?id=1', NOW() - INTERVAL 5 DAY),
(1, 1, 'Pesan Baru dari Guru BK', 'Anda mendapat pesan baru dari Guru BK tentang jadwal konsultasi.', 'chat', 'sudah', 'guru_curhat.php', NOW() - INTERVAL 2 DAY),
(2, 1, 'Pengaduan dalam Proses', 'Pengaduan Anda "Fasilitas Lab Komputer Rusak" sedang dalam proses penanganan.', 'pengaduan', 'sudah', 'data_pengaduan.php?id=2', NOW() - INTERVAL 5 DAY),
(2, 1, 'Pesan dari Guru BK', 'Guru BK sudah mengirimkan balasan untuk pertanyaan Anda mengenai lab komputer.', 'chat', 'belum', 'guru_curhat.php', NOW() - INTERVAL 1 DAY),
(3, NULL, 'Pengaduan Baru Diterima', 'Pengaduan Anda telah kami terima dan akan diproses oleh Guru BK.', 'pengaduan', 'belum', 'data_pengaduan.php?id=3', NOW() - INTERVAL 3 DAY),
(4, 1, 'Pengaduan dalam Proses', 'Pengaduan Anda "Kurangnya Buku Referensi di Perpustakaan" sedang ditangani.', 'pengaduan', 'sudah', 'data_pengaduan.php?id=4', NOW() - INTERVAL 2 DAY),
(4, 1, 'Pesan dari Guru BK', 'Guru BK Ibu Siti Rahma ingin berbicara dengan Anda tentang persiapan ujian.', 'chat', 'sudah', 'guru_curhat.php', NOW() - INTERVAL 1 DAY),
(5, NULL, 'Pengaduan Diterima', 'Pengaduan Anda telah dicatat dalam sistem. Guru BK akan menghubungi Anda segera.', 'pengaduan', 'belum', 'data_pengaduan.php?id=5', NOW() - INTERVAL 1 DAY),
(6, 2, 'Konsultasi Tersedia', 'Ibu Siti Rahma tersedia untuk konsultasi jam 13:00 - 14:30 hari ini. Apakaah Anda berminat?', 'sistem', 'belum', 'profile.php', NOW() - INTERVAL 2 HOUR);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
COMMIT;
