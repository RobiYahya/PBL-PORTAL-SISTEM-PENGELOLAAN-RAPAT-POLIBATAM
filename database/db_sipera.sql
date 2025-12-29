-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2025 at 02:00 PM
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
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `id_peserta` int(11) NOT NULL,
  `id_rapat` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `status_kehadiran` enum('hadir','sakit','izin','alpa') DEFAULT 'hadir',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `notifikasi_status` enum('unread','read') DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`id_peserta`, `id_rapat`, `id_user`, `status_kehadiran`, `created_at`, `notifikasi_status`) VALUES
(3, 1, 2, 'hadir', '2025-12-15 02:30:36', 'read'),
(4, 1, 3, 'hadir', '2025-12-15 02:30:36', 'read'),
(7, 2, 4, 'hadir', '2025-12-15 02:41:24', 'read'),
(8, 2, 2, 'hadir', '2025-12-15 02:41:24', 'read'),
(9, 2, 3, 'hadir', '2025-12-15 02:41:24', 'read'),
(10, 3, 7, '', '2025-12-15 07:28:51', 'read'),
(11, 3, 4, '', '2025-12-15 07:28:51', 'read'),
(12, 3, 2, '', '2025-12-15 07:28:51', 'read'),
(16, 4, 4, 'hadir', '2025-12-15 08:54:53', 'read'),
(17, 4, 3, 'hadir', '2025-12-15 08:54:53', 'read'),
(18, 4, 1, 'hadir', '2025-12-15 08:54:53', 'read'),
(22, 5, 4, 'hadir', '2025-12-16 17:07:21', 'read'),
(23, 5, 2, 'hadir', '2025-12-16 17:07:21', 'read'),
(24, 5, 3, 'hadir', '2025-12-16 17:07:21', 'unread'),
(25, 6, 4, 'hadir', '2025-12-17 07:17:04', 'read'),
(26, 6, 2, 'izin', '2025-12-17 07:17:04', 'read'),
(27, 6, 3, 'hadir', '2025-12-17 07:17:04', 'unread'),
(29, 7, 4, '', '2025-12-18 04:01:32', 'unread'),
(30, 7, 2, '', '2025-12-18 04:01:32', 'read'),
(31, 7, 3, '', '2025-12-18 04:01:32', 'unread'),
(32, 8, 4, '', '2025-12-22 01:56:39', 'unread'),
(33, 8, 3, '', '2025-12-22 01:56:39', 'unread'),
(34, 8, 1, '', '2025-12-22 01:56:39', 'read'),
(35, 9, 4, '', '2025-12-25 12:15:18', 'unread'),
(36, 9, 2, '', '2025-12-25 12:15:18', 'read'),
(37, 9, 3, '', '2025-12-25 12:15:18', 'unread'),
(42, 11, 4, 'hadir', '2025-12-29 12:59:21', 'unread'),
(43, 11, 3, 'sakit', '2025-12-29 12:59:21', 'unread'),
(44, 11, 1, 'alpa', '2025-12-29 12:59:21', 'unread');

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
  `status` enum('terjadwal','selesai','dibatalkan','draft','menunggu_konfirmasi') DEFAULT 'menunggu_konfirmasi',
  `file_notulen` varchar(255) DEFAULT NULL,
  `id_pembuat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rapat`
--

INSERT INTO `rapat` (`id_rapat`, `judul_rapat`, `deskripsi`, `lokasi`, `tgl_rapat`, `jam_mulai`, `jam_selesai`, `status`, `file_notulen`, `id_pembuat`) VALUES
(1, 'Rapat Koordinasi', 'Membahas jadwal mata kuliah terkhusus prodi if', 'GU 704', '2025-12-16', '09:30:00', '11:30:00', 'selesai', 'notulen_1_1765765890.pdf', 1),
(2, 'Rapat Dosen Siskom', 'Membahas RPS', 'GU 706', '2025-12-16', '09:00:00', '11:00:00', 'selesai', NULL, 1),
(3, 'Rapat Angsuran Masjid Polibatam', 'Membuat laporan RAB', 'TA lt 10.a', '2025-12-16', '13:00:00', '15:30:00', 'dibatalkan', NULL, 3),
(4, 'rapat kinerja mingguan', 'Membahas RPS ', 'GU 704', '2025-12-16', '13:30:00', '15:30:00', 'selesai', NULL, 2),
(5, 'Rapat HUT Polibatam', 'Membahas agenda hut polibatam', 'GU 705', '2025-12-17', '09:30:00', '12:00:00', 'selesai', NULL, 1),
(6, 'Rapat Dosen IF', 'Membahas semester 2 prodi if', 'GU 705', '2025-12-22', '09:00:00', '15:00:00', 'selesai', 'notulen_6_1765956257.pdf', 1),
(7, 'Rapat Dosen IF', 'Membahas semester 2 prodi IF', 'GU 704', '2025-12-19', '10:00:00', '12:00:00', 'dibatalkan', NULL, 1),
(8, 'rapat kinerja mingguan', 'qqq', 'GU 601', '2025-12-22', '09:00:00', '09:05:00', 'selesai', NULL, 2),
(9, 'Rapat seminar dengan guest elon musk', 'Membahas rundown acara seminar', 'Auditorium Utama', '2025-12-27', '12:00:00', '15:00:00', 'dibatalkan', NULL, 1),
(11, 'Rapat Dosen IF', 'Testing and debugging', 'TA 12.3A', '2025-12-31', '12:00:00', '15:00:00', 'selesai', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jabatan` enum('admin','dosen') NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nik`, `password`, `nama_lengkap`, `email`, `jabatan`, `foto`) VALUES
(1, '112093', '$2y$10$0oMzzct1dENgQbRE3f8hjOi0De9zhPAeURWiiRaq2R.XJ4ki0WqJ2', 'Yeni Rokhayati', 'yeni@polibatam.ac.id', 'dosen', 'profile_1_1765878303.jpg'),
(2, '112094', '$2y$10$wSBgHBEd3hJqJyD/5yETY.prIwQ9RQzV1gOyg/w/JVoWpudSj/0wi', 'Ir. Dwi Ely Kurniawan', 'dwialikhs@polibatam.ac.id', 'dosen', 'profile_2_1765878341.jpg'),
(3, '122283', '$2y$10$Wbfw3IEAJd2Ci/uBNVFuIuY8hROwpuq/fz4qWZ/Y/cD6U57SJGBfO', 'Muhammad Idris', 'idris@polibatam.ac.id', 'dosen', 'profile_3_1765878372.jpg'),
(4, '0005099007', '$2y$10$NpDLOmuhTrZ7mcOFuh6tYe4GaTTnKbcuO/w.cZep6fq1InEHYsTH6', 'Dwi Amalia Purnamasari', 'dwiamaliaps@gmail.com', 'dosen', 'profile_4_1765878279.jpg'),
(5, '213162', '$2a$12$SR6oYTw0Kj6MOs449aBBOeoeiTK/Rkg54ZfQIeFqMlOO7qw2GwZHS', 'Novia syafitriani', 'tu-if@polibatam.ac.id', 'admin', 'profile_5_1765878399.jpg'),
(7, '218292', '$2a$12$c0Qcr9S1IkSlvxAsRklwDOwQwP/KKLm5vTNfpNAva0iFE7gA8Owxq', 'Dede Nurdiansyah', 'tu-if@polibatam.ac.id', 'admin', 'profile_7_1765878460.jpg'),
(8, '224345', '$2a$12$Z7IWovHP9AMnGfxjaRU9s.RBfh34rlSZeWZda7TVv46D9.rhxBvRK', 'Rhanna Mawira', 'tu-if@polibatam.ac.id', 'admin', 'profile_8_1765878486.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`id_peserta`),
  ADD UNIQUE KEY `unique_peserta` (`id_rapat`,`id_user`),
  ADD KEY `id_user` (`id_user`);

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
-- AUTO_INCREMENT for table `peserta`
--
ALTER TABLE `peserta`
  MODIFY `id_peserta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `rapat`
--
ALTER TABLE `rapat`
  MODIFY `id_rapat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peserta`
--
ALTER TABLE `peserta`
  ADD CONSTRAINT `peserta_ibfk_1` FOREIGN KEY (`id_rapat`) REFERENCES `rapat` (`id_rapat`) ON DELETE CASCADE,
  ADD CONSTRAINT `peserta_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `rapat`
--
ALTER TABLE `rapat`
  ADD CONSTRAINT `fk_rapat_pembuat` FOREIGN KEY (`id_pembuat`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
