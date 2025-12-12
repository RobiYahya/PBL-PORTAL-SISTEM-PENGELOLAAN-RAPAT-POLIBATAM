-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2025 at 11:22 AM
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
-- Database: `db_sipera`
--

-- --------------------------------------------------------

--
-- Table structure for table `notulen`
--

CREATE TABLE `notulen` (
  `id_notulen` int(11) NOT NULL,
  `id_rapat` int(11) NOT NULL,
  `konten` text DEFAULT NULL,
  `penulis` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peserta_rapat`
--

CREATE TABLE `peserta_rapat` (
  `id_peserta` int(11) NOT NULL,
  `id_rapat` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `status_kehadiran` enum('hadir','tidak_hadir','izin') DEFAULT 'hadir',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id_presensi` int(11) NOT NULL,
  `id_rapat` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `status` enum('menunggu','hadir','izin','alpa') NOT NULL DEFAULT 'alpa',
  `waktu_absen` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rapat`
--

CREATE TABLE `rapat` (
  `id_rapat` int(11) NOT NULL,
  `judul_rapat` varchar(200) NOT NULL,
  `deskripsi` text NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `tgl_rapat` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `status` enum('terjadwal','mulai','selesai','batal') NOT NULL DEFAULT 'terjadwal',
  `file_notulen` varchar(255) DEFAULT NULL,
  `id_pembuat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jabatan` enum('admin','dosen') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nik`, `password`, `nama_lengkap`, `jabatan`) VALUES
(1, '3312501036', '12345', 'Rangga Surya Saputra', 'dosen');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notulen`
--
ALTER TABLE `notulen`
  ADD PRIMARY KEY (`id_notulen`),
  ADD KEY `id_rapat` (`id_rapat`),
  ADD KEY `penulis` (`penulis`);

--
-- Indexes for table `peserta_rapat`
--
ALTER TABLE `peserta_rapat`
  ADD PRIMARY KEY (`id_peserta`),
  ADD UNIQUE KEY `unique_peserta` (`id_rapat`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id_presensi`),
  ADD UNIQUE KEY `id_rapat` (`id_rapat`,`id_user`),
  ADD KEY `fk_presensi_user` (`id_user`);

--
-- Indexes for table `rapat`
--
ALTER TABLE `rapat`
  ADD PRIMARY KEY (`id_rapat`),
  ADD KEY `fk_rapat_pembuat` (`id_pembuat`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notulen`
--
ALTER TABLE `notulen`
  MODIFY `id_notulen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peserta_rapat`
--
ALTER TABLE `peserta_rapat`
  MODIFY `id_peserta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rapat`
--
ALTER TABLE `rapat`
  MODIFY `id_rapat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notulen`
--
ALTER TABLE `notulen`
  ADD CONSTRAINT `notulen_ibfk_1` FOREIGN KEY (`id_rapat`) REFERENCES `rapat` (`id_rapat`) ON DELETE CASCADE,
  ADD CONSTRAINT `notulen_ibfk_2` FOREIGN KEY (`penulis`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `peserta_rapat`
--
ALTER TABLE `peserta_rapat`
  ADD CONSTRAINT `peserta_rapat_ibfk_1` FOREIGN KEY (`id_rapat`) REFERENCES `rapat` (`id_rapat`) ON DELETE CASCADE,
  ADD CONSTRAINT `peserta_rapat_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `fk_presensi_rapat` FOREIGN KEY (`id_rapat`) REFERENCES `rapat` (`id_rapat`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_presensi_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `rapat`
--
ALTER TABLE `rapat`
  ADD CONSTRAINT `fk_rapat_pembuat` FOREIGN KEY (`id_pembuat`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
