-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2026 at 06:24 AM
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
  `role` enum('admin','nasabah') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id_account`, `username`, `password`, `role`) VALUES
(8, 'Ligas', '$2y$10$IPIynmT6zRhe/T2vekFd6..P5D8/pqNmeaRZPZSDDz6SS1dKM1LK.', 'admin'),
(13, 'AL', '$2y$10$ieTKdkwxA08SuOR1FRgZV.3txN/KLmFosPT7FcCiNnJjd4Jk9LCxq', 'nasabah');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_sampah`
--

CREATE TABLE `kategori_sampah` (
  `id_kategori` int(11) NOT NULL,
  `nama_sampah` varchar(50) NOT NULL,
  `poin_per_kg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_penukaran`
--

CREATE TABLE `log_penukaran` (
  `id_tukar` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `id_voucher` int(11) NOT NULL,
  `tgl_tukar` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `tgl_setor` datetime DEFAULT current_timestamp(),
  `status` enum('pending','claimed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voucher_reward`
--

CREATE TABLE `voucher_reward` (
  `id_voucher` int(11) NOT NULL,
  `nama_voucher` varchar(100) NOT NULL,
  `biaya_poin` int(11) NOT NULL,
  `stok_voucher` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  MODIFY `id_account` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `kategori_sampah`
--
ALTER TABLE `kategori_sampah`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_penukaran`
--
ALTER TABLE `log_penukaran`
  MODIFY `id_tukar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nasabah`
--
ALTER TABLE `nasabah`
  MODIFY `id_nasabah` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_setor`
--
ALTER TABLE `transaksi_setor`
  MODIFY `id_setor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voucher_reward`
--
ALTER TABLE `voucher_reward`
  MODIFY `id_voucher` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
