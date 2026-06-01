-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2026 at 05:41 AM
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
-- Database: `solusi_sampah`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id_account` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user','nasabah') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id_account`, `username`, `password`, `role`) VALUES
(8, 'Ligas', '$2y$10$IPIynmT6zRhe/T2vekFd6..P5D8/pqNmeaRZPZSDDz6SS1dKM1LK.', 'admin'),
(13, 'AL', '$2y$10$ieTKdkwxA08SuOR1FRgZV.3txN/KLmFosPT7FcCiNnJjd4Jk9LCxq', 'nasabah'),
(16, 'Kyzenn', '$2y$10$TyK235319CdR7naEz9Hpz.QfOM91GHcOFZzqGzxq2DHCIylcRb5GG', 'nasabah'),
(17, 'Coba', '$2y$10$UoMDHRq7rXBPc35HHMXn/.o.gIOSUf5DwSUOjGQxVb..xkpQvLZAm', 'user'),
(19, 'Kyzen', '$2y$10$eC7AWcBZIvqPbvgM5oDSGOKHYyo5aHME4QyzsMZ7pzza9FwBbavX.', 'nasabah'),
(20, 'haha', '$2y$10$DFD3SvHlQ3Jdj02sk4BJteEzhnibKp7h5mSILBRflezLaBYpZGY82', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_sampah`
--

CREATE TABLE `kategori_sampah` (
  `id_kategori` int(11) NOT NULL,
  `nama_sampah` varchar(50) NOT NULL,
  `poin_per_kg` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_sampah`
--

INSERT INTO `kategori_sampah` (`id_kategori`, `nama_sampah`, `poin_per_kg`, `deskripsi`) VALUES
(2, 'Plastik PET', 450, 'Khusus plastik yang belogo PET seperti galon, kemasan air mineral, dll.');

-- --------------------------------------------------------

--
-- Table structure for table `log_penukaran`
--

CREATE TABLE `log_penukaran` (
  `id_tukar` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `id_voucher` int(11) NOT NULL,
  `poin_digunakan` int(11) NOT NULL DEFAULT 0,
  `status` enum('pending','berhasil','gagal','diklaim') NOT NULL DEFAULT 'berhasil',
  `tgl_tukar` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_penukaran`
--

INSERT INTO `log_penukaran` (`id_tukar`, `id_profile`, `id_voucher`, `poin_digunakan`, `status`, `tgl_tukar`) VALUES
(1, 3, 1, 0, 'berhasil', '2026-05-17 18:40:16'),
(2, 3, 2, 0, 'berhasil', '2026-05-21 07:03:54'),
(3, 3, 2, 0, 'berhasil', '2026-05-25 08:26:14'),
(4, 3, 4, 0, 'berhasil', '2026-05-25 08:29:04');

-- --------------------------------------------------------

--
-- Table structure for table `nasabah`
--

CREATE TABLE `nasabah` (
  `id_nasabah` int(11) NOT NULL,
  `id_account` int(11) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `total_poin` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nasabah`
--

INSERT INTO `nasabah` (`id_nasabah`, `id_account`, `nama_lengkap`, `alamat`, `no_telp`, `total_poin`) VALUES
(2, 16, 'Fulan bin Fulan', 'Sidoarjo', '0832973727', 0),
(3, 19, 'Fulan', 'Sidoarjo', '08261836517', 42);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_setor`
--

CREATE TABLE `transaksi_setor` (
  `id_setor` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `berat` float NOT NULL,
  `poin` int(11) NOT NULL DEFAULT 0,
  `tgl_setor` datetime DEFAULT current_timestamp(),
  `status` enum('pending','claimed') DEFAULT 'pending',
  `catatan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_setor`
--

INSERT INTO `transaksi_setor` (`id_setor`, `id_admin`, `id_profile`, `id_kategori`, `berat`, `poin`, `tgl_setor`, `status`, `catatan`) VALUES
(1, 8, 1, 2, 3, 1350, '2026-05-16 19:51:52', 'pending', ''),
(2, 8, 1, 2, 3, 1350, '2026-05-16 19:52:44', 'pending', ''),
(3, 8, 1, 2, 3, 1350, '2026-05-16 19:55:57', 'pending', ''),
(4, 8, 3, 2, 3, 1350, '2026-05-16 20:03:53', 'claimed', ''),
(5, 8, 3, 2, 6.55, 2948, '2026-05-16 20:04:50', 'claimed', ''),
(6, 8, 2, 2, 4, 1800, '2026-05-18 07:12:08', 'pending', ''),
(7, 8, 3, 2, 4, 1800, '2026-05-18 07:16:47', 'claimed', ''),
(8, 8, 3, 2, 1.43, 644, '2026-05-21 06:44:43', 'claimed', ''),
(9, 8, 3, 3, 3, 750, '2026-05-21 17:57:31', 'pending', ''),
(10, 8, 3, 2, 2, 900, '2026-05-21 17:57:48', 'pending', ''),
(11, 8, 3, 2, 3, 1350, '2026-05-21 17:58:07', 'pending', ''),
(12, 8, 3, 3, 3, 750, '2026-05-21 18:00:24', 'claimed', ''),
(13, 8, 3, 2, 3, 1350, '2026-05-25 08:22:26', 'claimed', '');

-- --------------------------------------------------------

--
-- Table structure for table `voucher_reward`
--

CREATE TABLE `voucher_reward` (
  `id_voucher` int(11) NOT NULL,
  `nama_voucher` varchar(100) NOT NULL,
  `deskripsi` varchar(150) DEFAULT NULL,
  `biaya_poin` int(11) NOT NULL,
  `stok_voucher` int(11) NOT NULL,
  `gambar_voucher` varchar(255) DEFAULT NULL,
  `kategori_voucher` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voucher_reward`
--

INSERT INTO `voucher_reward` (`id_voucher`, `nama_voucher`, `deskripsi`, `biaya_poin`, `stok_voucher`, `gambar_voucher`, `kategori_voucher`) VALUES
(1, 'Dana Rp 10.000', '', 2500, 14, '', 'ewallet'),
(2, 'Listrik', '', 3000, 21, '', 'listrik'),
(3, 'Beras', '', 500, 12, '', 'sembako'),
(4, 'Minyak', '', 300, 11, '', 'sembako');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id_account`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `kategori_sampah`
--
ALTER TABLE `kategori_sampah`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `log_penukaran`
--
ALTER TABLE `log_penukaran`
  ADD PRIMARY KEY (`id_tukar`),
  ADD KEY `id_profile` (`id_profile`),
  ADD KEY `id_voucher` (`id_voucher`);

--
-- Indexes for table `nasabah`
--
ALTER TABLE `nasabah`
  ADD PRIMARY KEY (`id_nasabah`),
  ADD KEY `fk_nasabah_acc` (`id_account`);

--
-- Indexes for table `transaksi_setor`
--
ALTER TABLE `transaksi_setor`
  ADD PRIMARY KEY (`id_setor`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `id_profile` (`id_profile`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `voucher_reward`
--
ALTER TABLE `voucher_reward`
  ADD PRIMARY KEY (`id_voucher`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id_account` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `kategori_sampah`
--
ALTER TABLE `kategori_sampah`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `log_penukaran`
--
ALTER TABLE `log_penukaran`
  MODIFY `id_tukar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `nasabah`
--
ALTER TABLE `nasabah`
  MODIFY `id_nasabah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi_setor`
--
ALTER TABLE `transaksi_setor`
  MODIFY `id_setor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `voucher_reward`
--
ALTER TABLE `voucher_reward`
  MODIFY `id_voucher` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
