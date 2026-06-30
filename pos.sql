-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 30, 2026 at 09:09 AM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

DROP TABLE IF EXISTS `penjualan`;
CREATE TABLE IF NOT EXISTS `penjualan` (
  `idpenjualan` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `konsumen` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hp` varchar(35) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`idpenjualan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`idpenjualan`, `tanggal`, `konsumen`, `hp`) VALUES
('552bf4a2-3ace-4e54-b619-fc4b51a0cf0d', '2026-06-30', 'Tulus', '0587'),
('9fa67866-6b7d-4ee0-9f7a-7d66620a546f', '2026-06-30', 'Tulus', '216446615'),
('b933dd14-19f4-4c9c-80f1-7ab017003bba', '2026-06-30', 'Tulus', '084');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_detil`
--

DROP TABLE IF EXISTS `penjualan_detil`;
CREATE TABLE IF NOT EXISTS `penjualan_detil` (
  `idpenjualan_detil` int NOT NULL AUTO_INCREMENT,
  `idpenjualan` varchar(36) COLLATE utf8mb4_general_ci NOT NULL,
  `idproduk` varchar(6) COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` int NOT NULL,
  PRIMARY KEY (`idpenjualan_detil`),
  KEY `idproduk` (`idproduk`),
  KEY `idpenjualan` (`idpenjualan`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan_detil`
--

INSERT INTO `penjualan_detil` (`idpenjualan_detil`, `idpenjualan`, `idproduk`, `jumlah`) VALUES
(5, 'b933dd14-19f4-4c9c-80f1-7ab017003bba', 'P0001', 1),
(6, 'b933dd14-19f4-4c9c-80f1-7ab017003bba', 'P0003', 1),
(7, 'b933dd14-19f4-4c9c-80f1-7ab017003bba', 'P0005', 2),
(8, '552bf4a2-3ace-4e54-b619-fc4b51a0cf0d', 'P0002', 12),
(9, '552bf4a2-3ace-4e54-b619-fc4b51a0cf0d', 'P0003', 6),
(10, '9fa67866-6b7d-4ee0-9f7a-7d66620a546f', 'P0001', 5),
(11, '9fa67866-6b7d-4ee0-9f7a-7d66620a546f', 'P0005', 235);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

DROP TABLE IF EXISTS `produk`;
CREATE TABLE IF NOT EXISTS `produk` (
  `id` varchar(6) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `satuan` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `hargabeli` double NOT NULL,
  `hargajual` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama`, `satuan`, `hargabeli`, `hargajual`) VALUES
('P0001', 'Beras Premium 5kg', 'Pcs', 65000, 75000),
('P0002', 'Minyak Goreng 2L', 'Pouch', 28000, 34000),
('P0003', 'Gula Pasir 1kg', 'Pcs', 13500, 16000),
('P0004', 'Mie Instan Soto', 'Dus', 110000, 125000),
('P0005', 'Teh Celup Kotak', 'Pack', 6000, 8500);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `id` varchar(6) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `kota` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `hp` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `alamat`, `kota`, `hp`) VALUES
('SP01', 'PT Megah Abadi', 'Jl. Merdeka No. 45', 'Jakarta', '081123456789'),
('SP02', 'CV Sumber Makmur', 'Jl. Asia Afrika No. 12', 'Bandung', '081234567890'),
('SP03', 'UD Jaya Sentosa', 'Jl. Basuki Rahmat No. 88', 'Surabaya', '081345678901'),
('SP04', 'PT Elektronik Maju', 'Jl. Gajah Mada No. 10', 'Semarang', '081556789012'),
('SP05', 'CV Prima Nusantara', 'Jl. Sudirman No. 201', 'Medan', '081667890123');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `penjualan_detil`
--
ALTER TABLE `penjualan_detil`
  ADD CONSTRAINT `penjualan_detil_ibfk_1` FOREIGN KEY (`idproduk`) REFERENCES `produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penjualan_detil_ibfk_2` FOREIGN KEY (`idpenjualan`) REFERENCES `penjualan` (`idpenjualan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
