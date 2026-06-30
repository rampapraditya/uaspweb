-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 30, 2026 at 06:32 AM
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
  `idpenjualan` varchar(6) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `idsupplier` varchar(6) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idpenjualan`),
  KEY `idsupplier` (`idsupplier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_detil`
--

DROP TABLE IF EXISTS `penjualan_detil`;
CREATE TABLE IF NOT EXISTS `penjualan_detil` (
  `idpenjualan_detil` int NOT NULL AUTO_INCREMENT,
  `idpenjualan` varchar(6) COLLATE utf8mb4_general_ci NOT NULL,
  `idproduk` varchar(6) COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` int NOT NULL,
  PRIMARY KEY (`idpenjualan_detil`),
  KEY `idpenjualan` (`idpenjualan`),
  KEY `idproduk` (`idproduk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`idsupplier`) REFERENCES `supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
