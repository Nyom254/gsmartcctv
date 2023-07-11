-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 11, 2023 at 09:53 AM
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
-- Table structure for table `saldo_stok`
--

CREATE TABLE `saldo_stok` (
  `no_transaksi` varchar(40) NOT NULL,
  `tgl` date NOT NULL,
  `gudang` varchar(10) NOT NULL,
  `kode_barang` varchar(20) NOT NULL,
  `qty` int(11) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `harga` double NOT NULL,
  `status_stok` int(1) NOT NULL COMMENT 'status = 0 - utk barang Non Persediaan seperti kertas\r\nstatus = 1 - utk barang Persediaan, seperti : aksesoris cctv, komputer, barang xado (stok berasal dari Penerimaan Barang, Pembelian Barang dan Penjualan Barang)',
  `kode_departmen` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saldo_stok`
--

INSERT INTO `saldo_stok` (`no_transaksi`, `tgl`, `gudang`, `kode_barang`, `qty`, `satuan`, `harga`, `status_stok`, `kode_departmen`) VALUES
('PB/2307/0001', '2023-07-06', 'GD01', 'B000001', 1, 'Rim', 40000, 0, 'D000003'),
('PB/2307/0001', '2023-07-06', 'GD01', 'B000003', 1, 'TUBE', 500, 1, 'D000003'),
('PB/2307/0002', '2023-07-06', 'GD01', 'B000001', 1, 'Rim', 40000, 0, 'D000003'),
('PB/2307/0002', '2023-07-06', 'GD01', 'B000003', 1, 'TUBE', 500, 1, 'D000003');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `saldo_stok`
--
ALTER TABLE `saldo_stok`
  ADD PRIMARY KEY (`no_transaksi`,`kode_barang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
