-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2025 at 09:16 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekolah`
--

-- --------------------------------------------------------

--
-- Table structure for table `absen`
--

CREATE TABLE `absen` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `waktu` datetime DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Hadir',
  `valid` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absen`
--

INSERT INTO `absen` (`id`, `id_siswa`, `tanggal`, `jam`, `waktu`, `status`, `valid`) VALUES
(2, NULL, '2025-07-13', NULL, '2025-07-13 19:06:41', 'Hadir', 0),
(3, NULL, '2025-07-13', NULL, '2025-07-13 15:38:26', 'Hadir', 0),
(4, 54, '2025-08-30', NULL, '2025-08-30 08:39:01', 'Hadir', 1),
(5, 54, '2025-09-07', NULL, '2025-09-07 07:48:53', 'Hadir', 0),
(6, 54, '2025-09-08', NULL, '2025-09-08 08:49:09', 'Hadir', 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `email`, `password`) VALUES
(4, 'Administrator', 'admin@gmail.com', '$2y$10$dc8jJCu.AODM.oSeJ91TtOiJy.a88GooZ1kTWBooA8/rQf.XPhpQS'),
(7, 'ryan', 'reiner@gmail.com', '$2y$10$k7848EGjn5ZDQIkFn0YwzuUnGSmdIqTAgjMIttXD5aV0tjV1zV2Nq');

-- --------------------------------------------------------

--
-- Table structure for table `bimbingan`
--

CREATE TABLE `bimbingan` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `id_guru` int(11) NOT NULL,
  `tanggal_bimbingan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bimbingan`
--

INSERT INTO `bimbingan` (`id`, `id_siswa`, `id_guru`, `tanggal_bimbingan`) VALUES
(17, 54, 1, '2025-09-08 14:02:42');

-- --------------------------------------------------------

--
-- Table structure for table `chat_bimbingan`
--

CREATE TABLE `chat_bimbingan` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `pengirim` varchar(100) NOT NULL,
  `penerima` varchar(100) DEFAULT NULL,
  `pesan` text NOT NULL,
  `waktu` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_bimbingan`
--

INSERT INTO `chat_bimbingan` (`id`, `id_siswa`, `pengirim`, `penerima`, `pesan`, `waktu`) VALUES
(19, 54, 'Siswa', NULL, 'pak', '2025-09-07 12:57:13'),
(20, 54, 'budi@gmail.com', NULL, 'ya nak', '2025-09-07 12:57:24'),
(21, 54, 'guru', NULL, 'tes', '2025-09-07 15:28:26'),
(22, 54, 'guru', NULL, 'tes', '2025-09-07 15:28:38'),
(23, 54, 'guru', NULL, 'tes', '2025-09-07 15:29:11'),
(24, 54, 'Siswa', NULL, 'tes', '2025-09-08 13:50:09'),
(25, 54, 'Siswa', NULL, 'tes', '2025-09-08 13:50:15'),
(26, 54, 'guru', NULL, 'ya nak', '2025-09-08 13:50:26');

-- --------------------------------------------------------

--
-- Table structure for table `dataguru`
--

CREATE TABLE `dataguru` (
  `id_guru` int(11) NOT NULL,
  `nama_guru` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `jurusan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dataguru`
--

INSERT INTO `dataguru` (`id_guru`, `nama_guru`, `email`, `password`, `jurusan`) VALUES
(1, 'Budi Santoso', 'budi@gmail.com', '$2y$10$0ps9uzNvn22ROglD86Ht4usRqMEyZDeu/cE9.776x.0LEdhlV6nWK', 'Teknik Kendaraan Ringan'),
(7, 'ahmad', 'ahmad@gmail.com', '$2y$10$PqMKFLRoVhzgLVsnMmXyZuwmO/lIMYa87Ky7be3vOO4.EYUe.s.7i', 'Rekayasa Perangkat Lunak');

-- --------------------------------------------------------

--
-- Table structure for table `datasiswa`
--

CREATE TABLE `datasiswa` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nis` int(11) NOT NULL,
  `jurusan` varchar(255) NOT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `tahun_pkl` year(4) DEFAULT NULL,
  `semester_pkl` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `datasiswa`
--

INSERT INTO `datasiswa` (`id`, `email`, `password`, `nama`, `nis`, `jurusan`, `kelas`, `tahun_pkl`, `semester_pkl`) VALUES
(54, 'lahguamah@gmail.com', '$2y$10$ZHe0P6ilgDGIvMtRddbolegp9tVsmpN96vuUhmV9nnHJWNGI6t5du', 'ryan', 672022174, 'Rekayasa Perangkat Lunak', 'RPL 1', '2025', 'Ganjil');

-- --------------------------------------------------------

--
-- Table structure for table `flowchart_pkl`
--

CREATE TABLE `flowchart_pkl` (
  `id` int(11) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `label` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flowchart_pkl`
--

INSERT INTO `flowchart_pkl` (`id`, `kode`, `label`) VALUES
(1, 'mulai', 'mulai'),
(2, 'pembentukan', 'Pembentukan panitia dan pembimbing PKL'),
(3, 'monitoring', 'Monitoring dan bimbingan PKL oleh pembimbing'),
(4, 'sosialisasi', 'Sosialisasi PKL kepada siswa'),
(5, 'daftar', 'Siswa mendaftar untuk PKL'),
(6, 'pengantar', 'Pembuatan surat pengantar ke tempat PKL'),
(7, 'kirim', 'Siswa mengirim surat ke tempat PKL'),
(8, 'konfirmasi', 'Tempat PKL mengkonfirmasi diterima atau ditolak'),
(9, 'isi_tempat', 'Siswa mengisi informasi tempat PKL di aplikasi'),
(10, 'pelaksanaan', 'Siswa melaksanakan PKL sesuai jadwal'),
(11, 'laporan', 'Siswa mengumpulkan laporan dan jurnal'),
(12, 'evaluasi', 'Guru melakukan evaluasi dan penilaian'),
(13, 'sertifikat', 'Penerbitan sertifikat PKL'),
(14, 'selesai', 'Proses PKL selesai'),
(15, 'feedback', 'Feedback dari tempat PKL untuk monitoring');

-- --------------------------------------------------------

--
-- Table structure for table `jurnal`
--

CREATE TABLE `jurnal` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `kegiatan` text NOT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurnal`
--

INSERT INTO `jurnal` (`id`, `id_siswa`, `tanggal`, `waktu`, `kegiatan`, `catatan`) VALUES
(18, 54, '2025-09-08', '13:32:00', 'Recode', '');

-- --------------------------------------------------------

--
-- Table structure for table `lamaran`
--

CREATE TABLE `lamaran` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `id_mitra` int(11) DEFAULT NULL,
  `tanggal_lamar` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lamaran`
--

INSERT INTO `lamaran` (`id`, `id_siswa`, `id_mitra`, `tanggal_lamar`) VALUES
(0, 54, 12, '2025-09-08 14:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tanggal_upload` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `id_siswa`, `judul`, `file`, `tanggal_upload`) VALUES
(14, 54, 'tes5', 'https://www.youtube.com/watch?v=gnqbxbb8dvU&list=RDF0d8JJUNkqo&index=2&ab_channel=LIRIKINOFFICIAL', '2025-08-30 13:43:20'),
(15, 54, 'revisi code', 'https://www.youtube.com/watch?v=gnqbxbb8dvU&list=RDF0d8JJUNkqo&index=2&ab_channel=LIRIKINOFFICIAL', '2025-09-02 00:56:03'),
(16, 54, 'revisi code', 'https://www.youtube.com/watch?v=agu22bqGHto&list=RDmuXmT0F-FiI&index=12&ab_channel=Charlixcx', '2025-09-02 00:57:22'),
(19, 54, 'Recode', 'https://www.youtube.com/watch?v=gnqbxbb8dvU&list=RDF0d8JJUNkqo&index=2&ab_channel=LIRIKINOFFICIAL', '2025-09-08 13:36:31');

-- --------------------------------------------------------

--
-- Table structure for table `mitra`
--

CREATE TABLE `mitra` (
  `id` int(11) NOT NULL,
  `nama_perusahaan` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mitra`
--

INSERT INTO `mitra` (`id`, `nama_perusahaan`, `alamat`, `deskripsi`, `jurusan`) VALUES
(1, 'Bumen Redja Abadi', 'Jalan kalisombo', 'tes', 'Teknik Kendaraan Ringan'),
(2, 'Astra Motor', 'Jalan kalisombo', 'tes1', 'Teknik Sepeda Motor'),
(3, 'Fanny Cake & Bakery', 'Jalan Kalisombo', 'tes2', 'Kuliner'),
(4, 'Karir Anak', 'Jalan jalan', 'tes3', 'a'),
(5, 'Nasmoco', 'Jalan Jalan', 'tes4', 'b'),
(6, 'Axioo Class Program', 'Jalan jalan', 'tes5', 'Teknik Komputer Jaringan'),
(7, 'Selalu Cinta Indonesia', 'Jalan Jalan', 'tes6', 'Desain Produksi Busana'),
(8, 'Diamondfit Garment Indonesia', 'Jalan Jalan', 'tes7', 'Desain Produksi Busana'),
(10, 'erger', 'asdasdgere', 'asdsdgerge', 'asdasdregerg'),
(12, 'tes', 'tes', '', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_pkl`
--

CREATE TABLE `penilaian_pkl` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `aspek_1` int(11) DEFAULT NULL,
  `aspek_2` int(11) DEFAULT NULL,
  `aspek_3` int(11) DEFAULT NULL,
  `aspek_4` int(11) DEFAULT NULL,
  `rata_rata` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penilaian_pkl`
--

INSERT INTO `penilaian_pkl` (`id`, `id_siswa`, `aspek_1`, `aspek_2`, `aspek_3`, `aspek_4`, `rata_rata`) VALUES
(0, 54, 90, 90, 90, 90, 90),
(1, 7, 100, 100, 100, 100, 100),
(5, 13, 80, 91, 80, 98, 87);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absen`
--
ALTER TABLE `absen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_absen_siswa_id` (`id_siswa`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bimbingan`
--
ALTER TABLE `bimbingan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_guru` (`id_guru`),
  ADD KEY `fk_bimbingan_siswa_id` (`id_siswa`);

--
-- Indexes for table `chat_bimbingan`
--
ALTER TABLE `chat_bimbingan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_chat_siswa` (`id_siswa`);

--
-- Indexes for table `dataguru`
--
ALTER TABLE `dataguru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `datasiswa`
--
ALTER TABLE `datasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `flowchart_pkl`
--
ALTER TABLE `flowchart_pkl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurnal`
--
ALTER TABLE `jurnal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jurnal_siswa_id` (`id_siswa`);

--
-- Indexes for table `lamaran`
--
ALTER TABLE `lamaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mitra` (`id_mitra`),
  ADD KEY `fk_lamaran_siswa_id` (`id_siswa`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_laporan_siswa_id` (`id_siswa`);

--
-- Indexes for table `mitra`
--
ALTER TABLE `mitra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penilaian_pkl`
--
ALTER TABLE `penilaian_pkl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_siswa` (`id_siswa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absen`
--
ALTER TABLE `absen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bimbingan`
--
ALTER TABLE `bimbingan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `chat_bimbingan`
--
ALTER TABLE `chat_bimbingan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `dataguru`
--
ALTER TABLE `dataguru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `datasiswa`
--
ALTER TABLE `datasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `flowchart_pkl`
--
ALTER TABLE `flowchart_pkl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jurnal`
--
ALTER TABLE `jurnal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `mitra`
--
ALTER TABLE `mitra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absen`
--
ALTER TABLE `absen`
  ADD CONSTRAINT `fk_absen_siswa_id` FOREIGN KEY (`id_siswa`) REFERENCES `datasiswa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bimbingan`
--
ALTER TABLE `bimbingan`
  ADD CONSTRAINT `fk_bimbingan_siswa_id` FOREIGN KEY (`id_siswa`) REFERENCES `datasiswa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_bimbingan`
--
ALTER TABLE `chat_bimbingan`
  ADD CONSTRAINT `fk_chat_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `datasiswa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jurnal`
--
ALTER TABLE `jurnal`
  ADD CONSTRAINT `fk_jurnal_siswa_id` FOREIGN KEY (`id_siswa`) REFERENCES `datasiswa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lamaran`
--
ALTER TABLE `lamaran`
  ADD CONSTRAINT `fk_lamaran_siswa_id` FOREIGN KEY (`id_siswa`) REFERENCES `datasiswa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `fk_laporan_siswa_id` FOREIGN KEY (`id_siswa`) REFERENCES `datasiswa` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
