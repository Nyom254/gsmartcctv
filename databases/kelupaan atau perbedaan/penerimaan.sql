-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 11, 2023 at 09:47 AM
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
-- Table structure for table `penerimaan`
--

CREATE TABLE `penerimaan` (
  `no_penerimaan` varchar(30) NOT NULL,
  `tgl` date NOT NULL,
  `no_po` varchar(30) NOT NULL,
  `kode_supplier` varchar(20) NOT NULL,
  `keterangan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penerimaan`
--

INSERT INTO `penerimaan` (`no_penerimaan`, `tgl`, `no_po`, `kode_supplier`, `keterangan`) VALUES
('PB/2306/0001', '2023-06-21', 'PO/MIJY/2306/0003', 'S000001', ''),
('PB/2306/0002', '2023-06-21', 'PO/CCTV/2306/0001', 'S000001', ''),
('PB/2307/0001', '2023-07-06', 'PO/CCTV/2307/0001', 'S000001', ''),
('PB/2307/0002', '2023-07-06', 'PO/CCTV/2307/0001', 'S000001', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `penerimaan`
--
ALTER TABLE `penerimaan`
  ADD PRIMARY KEY (`no_penerimaan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
