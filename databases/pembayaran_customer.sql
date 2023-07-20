-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 17, 2023 at 07:04 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cctv`
--

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_customer`
--

CREATE TABLE `pembayaran_customer` (
  `no_pembayaran` varchar(30) NOT NULL,
  `tanggal` date NOT NULL,
  `kode_departemen` varchar(20) NOT NULL,
  `kode_customer` varchar(20) NOT NULL,
  `jenis_pembayaran` varchar(20) NOT NULL,
  `nama_bank` varchar(40) DEFAULT NULL,
  `attachment` longblob DEFAULT NULL,
  `total` double NOT NULL,
  `selisih` double NOT NULL,
  `cruser` varchar(20) NOT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran_customer`
--

INSERT INTO `pembayaran_customer` (`no_pembayaran`, `tanggal`, `kode_departemen`, `kode_customer`, `jenis_pembayaran`, `nama_bank`, `attachment`, `total`, `selisih`, `cruser`, `crtime`) VALUES
('PC/MIJY/2307/0001', '2023-07-17', 'D000002', 'C000003', 'tunai', '', NULL, 50000, 0, 'admin1', '2023-07-17 04:55:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pembayaran_customer`
--
ALTER TABLE `pembayaran_customer`
  ADD PRIMARY KEY (`no_pembayaran`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
