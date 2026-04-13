-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Database: `psaj`
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `psaj`
--
CREATE DATABASE IF NOT EXISTS `psaj`;
USE `psaj`;

-- --------------------------------------------------------

--
-- Table structure for table `guru_bk`
--

CREATE TABLE `guru_bk` (
  `id_bk` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telp` varchar(15),
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `tanggal_daftar` datetime DEFAULT current_timestamp(),
  `foto` varchar(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru_bk`
--

INSERT INTO `guru_bk` (`id_bk`, `nama`, `email`, `no_telp`, `username`, `password`, `tanggal_daftar`, `foto`) VALUES
(1, 'Ibu Sri Handayani', 'sri.bk@smkn10surabaya.sch.id', '081234567890', 'admin', 'admin123', '2026-01-15 08:00:00', NULL),
(2, 'Bapak Ahmad Wijaya', 'ahmad.bk@smkn10surabaya.sch.id', '081234567891', 'ahmad_bk', 'password123', '2026-01-16 08:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nisn` varchar(20) NOT NULL UNIQUE,
  `email` varchar(100),
  `no_telp` varchar(15),
  `kelas` varchar(20) NOT NULL,
  `jurusan` varchar(50),
  `password` varchar(100) NOT NULL,
  `tanggal_daftar` datetime DEFAULT current_timestamp(),
  `foto` varchar(255),
  `status` enum('aktif','nonaktif') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nama`, `nisn`, `email`, `no_telp`, `kelas`, `jurusan`, `password`, `tanggal_daftar`, `foto`, `status`) VALUES
(1, 'Andi Saputra', '2024001001', 'andi.saputra@student.sch.id', '082345678901', 'XII RPL 1', 'Rekayasa Perangkat Lunak', 'password123', '2026-01-20 09:00:00', NULL, 'aktif'),
(2, 'Siti Aisyah', '2024001002', 'siti.aisyah@student.sch.id', '082345678902', 'XII AKL 2', 'Akuntansi Keuangan Lembaga', 'password123', '2026-01-20 09:15:00', NULL, 'aktif'),
(3, 'Rizky Pratama', '2024001003', 'rizky.pratama@student.sch.id', '082345678903', 'XI RPL 1', 'Rekayasa Perangkat Lunak', 'password123', '2026-01-20 09:30:00', NULL, 'aktif'),
(4, 'Nur Azizah', '2024001004', 'nur.azizah@student.sch.id', '082345678904', 'XII TKJ 1', 'Teknik Komputer dan Jaringan', 'password123', '2026-01-20 10:00:00', NULL, 'aktif'),
(5, 'Budi Hermawan', '2024001005', 'budi.hermawan@student.sch.id', '082345678905', 'XI AKL 1', 'Akuntansi Keuangan Lembaga', 'password123', '2026-01-21 08:00:00', NULL, 'aktif'),
(6, 'Dewi Lestari', '2024001006', 'dewi.lestari@student.sch.id', '082345678906', 'X TMAS', 'Teknik Mesin Otomotik Servis', 'password123', '2026-01-21 08:15:00', NULL, 'aktif'),
(7, 'Arif Wiryanto', '2024001007', 'arif.wiryanto@student.sch.id', '082345678907', 'XII RPL 2', 'Rekayasa Perangkat Lunak', 'password123', '2026-01-21 08:30:00', NULL, 'aktif'),
(8, 'Indah Permatasari', '2024001008', 'indah.permatasari@student.sch.id', '082345678908', 'XI TKJ 1', 'Teknik Komputer dan Jaringan', 'password123', '2026-01-21 09:00:00', NULL, 'aktif'),
(9, 'Fajar Mulyana', '2024001009', 'fajar.mulyana@student.sch.id', '082345678909', 'XII TMAS 1', 'Teknik Mesin Otomotik Servis', 'password123', '2026-01-22 08:00:00', NULL, 'aktif'),
(10, 'Sinta Wahyuni', '2024001010', 'sinta.wahyuni@student.sch.id', '082345678910', 'X AKL', 'Akuntansi Keuangan Lembaga', 'password123', '2026-01-22 08:15:00', NULL, 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id_pengaduan` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_bk` int(11),
  `jenis_pengaduan` enum('bullying','masalah_belajar','konflik_teman','masalah_keluarga','masalah_ekonomi','masalah_kesehatan','lainnya') NOT NULL,
  `judul` varchar(150) NOT NULL,
  `isi` text NOT NULL,
  `tanggal_pengaduan` datetime DEFAULT current_timestamp(),
  `status` enum('baru','diproses','selesai') DEFAULT 'baru',
  `tanggapan` text,
  `tanggal_tanggapan` datetime,
  `file_lampiran` varchar(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`id_pengaduan`, `id_siswa`, `id_bk`, `jenis_pengaduan`, `judul`, `isi`, `tanggal_pengaduan`, `status`, `tanggapan`, `tanggal_tanggapan`, `file_lampiran`) VALUES
(1, 1, 1, 'bullying', 'Bullying dari Teman Sekelas', 'Saya sering mendapat ejekan dan hinaan dari beberapa teman di kelas. Hal ini membuat saya merasa tidak nyaman dan tidak percaya diri. Mohon bantuan dari Ibu/Pak BK.', '2026-02-10 10:00:00', 'diproses', NULL, NULL, NULL),
(2, 2, 1, 'masalah_belajar', 'Kesulitan Memahami Pelajaran Matematika', 'Saya kesulitan memahami materi matematika terutama tentang trigonometri. Nilai saya terus menurun dan saya khawatir tidak bisa lulus.', '2026-02-09 14:30:00', 'selesai', 'Coba ikuti remedial yang akan diadakan setiap hari Sabtu. Saya juga akan memberikan bimbingan tambahan secara pribadi.', '2026-02-09 15:00:00', NULL),
(3, 3, 2, 'konflik_teman', 'Konflik dengan Teman Sekelompok', 'Kami mengerjakan project kelompok namun ada yang tidak bisa dikerjakan. Teman-teman menjadi salah paham dan menyalahkan saya. Padahal saya sudah berusaha.', '2026-02-08 11:00:00', 'selesai', 'Coba komunikasi lebih baik dengan teman-teman. Buat rencana pembagian tugas yang jelas agar tidak ada kesalahpahaman lagi.', '2026-02-08 14:00:00', NULL),
(4, 4, 1, 'masalah_keluarga', 'Orang Tua Sering Bertengkar', 'Orang tua sering bertengkar di rumah dan hal ini mempengaruhi konsentrasi saya saat belajar. Kadang saya merasa sedih dan tidak bersemangat sekolah.', '2026-02-07 09:30:00', 'selesai', 'Saya pahami perasaan Anda. Mari kita bicarakan lebih lanjut tentang cara menghadapi situasi ini. Anda juga bisa menghubungi guru konseling kami.', '2026-02-08 10:00:00', NULL),
(5, 5, 2, 'masalah_ekonomi', 'Kesulitan Membayar Uang Sekolah', 'Orang tua saya sedang kesulitan ekonomi untuk membayar biaya sekolah. Saya khawatir dikeluarkan dari sekolah.', '2026-02-06 10:00:00', 'diproses', NULL, NULL, NULL),
(6, 6, 1, 'masalah_kesehatan', 'Sering Sakit Saat di Sekolah', 'Akhir-akhir ini saya sering sakit, terutama di sore hari. Ini membuat saya sering absen dan ketinggalan pelajaran.', '2026-02-05 08:30:00', 'selesai', 'Sebaiknya periksakan diri ke dokter untuk mengetahui penyebabnya. Sementara itu, manfaatkan sistem pembelajaran online jika ada.', '2026-02-05 14:00:00', NULL),
(7, 7, 2, 'bullying', 'Dimaki-maki Karena Penampilan', 'Beberapa siswa sering mengomentari penampilan saya dengan kata-kata yang menyakitkan. Saya merasa malu dan ingin pindah sekolah.', '2026-02-04 15:00:00', 'baru', NULL, NULL, NULL),
(8, 8, 1, 'masalah_belajar', 'Sulit Berkonsentrasi Saat Belajar', 'Saya sulit berkonsentrasi saat belajar karena sering merasa khawatir dan cemas. Ini membuat prestasi akademik saya menurun.', '2026-02-03 11:00:00', 'diproses', NULL, NULL, NULL),
(9, 9, 2, 'lainnya', 'Pertanyaan tentang Program Magang', 'Saya ingin mengetahui informasi lebih lanjut tentang program magang untuk jurusan saya. Di mana saya bisa mendapatkan informasi tersebut?', '2026-02-02 10:00:00', 'selesai', 'Anda bisa menghubungi bagian industri atau lihat di papan pengumuman sekolah. Saya akan email ke Anda daftar perusahaan yang menerima magang.', '2026-02-02 14:30:00', NULL),
(10, 10, 1, 'masalah_belajar', 'Tidak Memahami Cara Belajar Efektif', 'Saya belajar setiap hari namun nilai tetap jelek. Saya tidak tahu apa yang salah dengan cara belajar saya.', '2026-02-01 09:00:00', 'selesai', 'Mari kita diskusikan teknik belajar yang tepat. Ada beberapa metode yang bisa kita coba sesuai dengan gaya belajar Anda.', '2026-02-01 13:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notif` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `pesan` varchar(255) NOT NULL,
  `tipe` enum('pengaduan','pesan','informasi') DEFAULT 'informasi',
  `status` enum('belum dibaca','sudah dibaca') DEFAULT 'belum dibaca',
  `waktu` datetime DEFAULT current_timestamp(),
  `id_referensi` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id_notif`, `id_siswa`, `pesan`, `tipe`, `status`, `waktu`, `id_referensi`) VALUES
(1, 1, 'Pengaduan Anda sedang diproses oleh Guru BK', 'pengaduan', 'sudah dibaca', '2026-02-10 10:30:00', 1),
(2, 2, 'Guru BK telah memberikan tanggapan untuk pengaduan Anda', 'pengaduan', 'sudah dibaca', '2026-02-09 15:30:00', 2),
(3, 3, 'Guru BK telah memberikan tanggapan untuk pengaduan Anda', 'pengaduan', 'sudah dibaca', '2026-02-08 14:30:00', 3),
(4, 4, 'Guru BK telah memberikan tanggapan untuk pengaduan Anda', 'pengaduan', 'sudah dibaca', '2026-02-08 10:30:00', 4),
(5, 5, 'Pengaduan Anda sedang diproses oleh Guru BK', 'pengaduan', 'sudah dibaca', '2026-02-06 10:30:00', 5),
(6, 6, 'Guru BK telah memberikan tanggapan untuk pengaduan Anda', 'pengaduan', 'sudah dibaca', '2026-02-05 14:30:00', 6),
(7, 7, 'Pengaduan Anda baru diterima', 'pengaduan', 'belum dibaca', '2026-02-04 15:30:00', 7),
(8, 8, 'Pengaduan Anda sedang diproses oleh Guru BK', 'pengaduan', 'sudah dibaca', '2026-02-03 11:30:00', 8),
(9, 9, 'Guru BK telah memberikan tanggapan untuk pengaduan Anda', 'pengaduan', 'sudah dibaca', '2026-02-02 14:30:00', 9),
(10, 10, 'Guru BK telah memberikan tanggapan untuk pengaduan Anda', 'pengaduan', 'sudah dibaca', '2026-02-01 13:30:00', 10),
(11, 1, 'Anda memiliki pesan baru dari Guru BK', 'pesan', 'belum dibaca', '2026-02-11 08:00:00', NULL),
(12, 2, 'Anda memiliki pesan baru dari Guru BK', 'pesan', 'sudah dibaca', '2026-02-10 14:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id_chat` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_bk` int(11) NOT NULL,
  `pengirim` enum('siswa','guru') NOT NULL,
  `pesan` text NOT NULL,
  `waktu` datetime DEFAULT current_timestamp(),
  `dibaca` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id_chat`, `id_siswa`, `id_bk`, `pengirim`, `pesan`, `waktu`, `dibaca`) VALUES
(1, 2, 1, 'siswa', 'Bu, saya ingin tanya tentang remedial matematika', '2026-02-11 09:00:00', 1),
(2, 2, 1, 'guru', 'Tentu saja. Remedial akan dimulai minggu depan setiap Sabtu pagi jam 07.30', '2026-02-11 09:15:00', 1),
(3, 2, 1, 'siswa', 'Ok Bu, nanti saya sampai tepat waktu', '2026-02-11 09:20:00', 1),
(4, 1, 1, 'siswa', 'Bu, bagaimana dengan masalah bullying di kelas saya?', '2026-02-10 14:00:00', 1),
(5, 1, 1, 'guru', 'Saya sudah bicarakan dengan wali kelas dan teman-teman Anda. Mereka sudah diberi nasehat. Semoga masalahnya bisa diselesaikan dengan baik', '2026-02-10 14:30:00', 1),
(6, 7, 2, 'siswa', 'Pak, saya menerima banyak komentar yang menyakitkan', '2026-02-04 16:00:00', 1),
(7, 7, 2, 'guru', 'Saya mengerti perasaan Anda. Setiap orang itu unik dan berharga. Jangan dengarkan komentar negatif dari orang lain', '2026-02-05 08:00:00', 1),
(8, 7, 2, 'guru', 'Ingat bahwa kepercayaan diri datang dari dalam diri. Anda sangat berharga', '2026-02-05 08:05:00', 1);

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guru_bk`
--
ALTER TABLE `guru_bk`
  ADD PRIMARY KEY (`id_bk`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_bk` (`id_bk`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notif`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id_chat`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_bk` (`id_bk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guru_bk`
--
ALTER TABLE `guru_bk`
  MODIFY `id_bk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id_pengaduan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `pengaduan_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`),
  ADD CONSTRAINT `pengaduan_ibfk_2` FOREIGN KEY (`id_bk`) REFERENCES `guru_bk` (`id_bk`);

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`);

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`),
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`id_bk`) REFERENCES `guru_bk` (`id_bk`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
