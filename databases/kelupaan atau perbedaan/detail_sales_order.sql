-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 11, 2023 at 09:44 AM
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
-- Table structure for table `detail_sales_order`
--

CREATE TABLE `detail_sales_order` (
  `no_transaksi` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kode_barang` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `harga` double NOT NULL,
  `diskon` double NOT NULL,
  `diskon_persentase` decimal(10,0) NOT NULL,
  `urutan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_sales_order`
--

INSERT INTO `detail_sales_order` (`no_transaksi`, `kode_barang`, `keterangan`, `quantity`, `harga`, `diskon`, `diskon_persentase`, `urutan`) VALUES
('SO/CCTV/2307/0002', 'B000003', NULL, 1, 500, 10, 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_sales_order`
--
ALTER TABLE `detail_sales_order`
  ADD PRIMARY KEY (`no_transaksi`,`kode_barang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
