-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2026 at 06:48 AM
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
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` varchar(6) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `hargabeli` double NOT NULL,
  `hargajual` double NOT NULL
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

CREATE TABLE `supplier` (
  `id` varchar(6) NOT NULL,
  `nama` varchar(60) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `kota` varchar(50) NOT NULL,
  `hp` varchar(30) NOT NULL
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
-- Indexes for dumped tables
--

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
