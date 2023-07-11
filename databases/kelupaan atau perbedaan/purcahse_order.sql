-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 11, 2023 at 10:08 AM
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
-- Table structure for table `purcahse_order`
--

CREATE TABLE `purcahse_order` (
  `NO_TRANSAKSI` varchar(30) NOT NULL,
  `TANGGAL` date NOT NULL,
  `NO_REF` varchar(30) NOT NULL,
  `KODE_SUPPLIER` varchar(10) NOT NULL,
  `KETERANGAN` varchar(100) NOT NULL,
  `JATUH_TEMPO` date NOT NULL COMMENT 'rumus tgl jatuh tempo = tanggal + termin',
  `DISKON` double NOT NULL DEFAULT 0,
  `DPP` double NOT NULL DEFAULT 0,
  `PPN` double NOT NULL DEFAULT 0,
  `JENIS_PPN` varchar(20) NOT NULL COMMENT 'Non PKP / PKP / Include',
  `SUBTOTAL` double NOT NULL DEFAULT 0,
  `PPN_PERSENTASE` float NOT NULL COMMENT '11%',
  `BATAL` bit(1) NOT NULL,
  `TERM` int(11) NOT NULL DEFAULT 0,
  `PENGAMBIL` varchar(20) DEFAULT NULL,
  `CRUSER` varchar(20) DEFAULT NULL,
  `CRTIME` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kode_departemen` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `purcahse_order`
--

INSERT INTO `purcahse_order` (`NO_TRANSAKSI`, `TANGGAL`, `NO_REF`, `KODE_SUPPLIER`, `KETERANGAN`, `JATUH_TEMPO`, `DISKON`, `DPP`, `PPN`, `JENIS_PPN`, `SUBTOTAL`, `PPN_PERSENTASE`, `BATAL`, `TERM`, `PENGAMBIL`, `CRUSER`, `CRTIME`, `kode_departemen`) VALUES
('PO/CCTV/2307/0001', '2023-07-05', 'ddd', 'S000001', '', '2023-07-07', 0, 73455, 8080.05, 'PKP', 73455, 11, b'0', 2, 'Fandi', 'admin1', '2023-07-05 07:12:48', 'D000001');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `purcahse_order`
--
ALTER TABLE `purcahse_order`
  ADD PRIMARY KEY (`NO_TRANSAKSI`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
