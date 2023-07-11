-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 11, 2023 at 10:02 AM
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
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('0','1') NOT NULL,
  `status_aktif` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `level`, `status_aktif`) VALUES
(23, 'Fandi', 'fandi', '$2y$10$mZzgU0/Z/fzPigP9tvoLtOBq3/LeFF2hBcpbIxWv2Al.hVno0/m2O', '1', b'1'),
(48, 'Diyah', 'diyah', '$2y$10$kYtaDvTSOaPda15iZZa23.UiMXLtsa9t9vP69ZX9pAkI4lsc/gP02', '1', b'1'),
(49, 'Bayu', 'bayu', '$2y$10$U7OZqybSaxXzOw2SKUKtkuiP3EH8/.wJtZezWssGDR9ucA6779Ut.', '1', b'1'),
(50, 'Aldy', 'aldy', '$2y$10$6bKk7ZLK2PrYYvw9HOWQWeq6a4t66ttHqEcfxEGppQ2IriDf8LmJ6', '1', b'1'),
(51, 'Aditya', 'aditya', '$2y$10$/7nYJycMjbfdqf8hivP9f.WWVaw6qeCI6ksES1chP4jrpjVJnrqkK', '1', b'1'),
(52, 'Alex', 'alex', '$2y$10$MbBrq.e0zNKDikrLOkrK9udQdxVNDoVzu4AA4ua8Ols4o5QjKv5he', '1', b'1'),
(53, 'admin1', 'admin1', '$2y$10$d6XdZ5w0a4RwyPRX10et9ef/TpmXQGeRsrowde60hZLNN1zZCPtWq', '1', b'1'),
(54, 'user1', 'user1', '$2y$10$KJzO6T6RVcMlVAfqdrcVG.b1PqaxymlWuiiEQxkN5Dr71c238wOAS', '0', b'1'),
(58, 'tes', 'tes', '$2y$10$oqb3DvsrACJJ9iMmCFRkS.rZcwbnkcXNfHjjggNTBTRayPvV5eIei', '0', b'1'),
(59, 'tes2', 'tes2', '$2y$10$JCi/64DSOx5l5u1fl1lN/OAu3JEw8J.IqqUKPQBSA3sBdkS7AI6e2', '1', b'1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
