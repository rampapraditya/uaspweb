-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2026 at 09:37 AM
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
-- Table structure for table `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `id` int(11) NOT NULL,
  `kode_pembelian` varchar(36) DEFAULT NULL,
  `kode_barang` varchar(6) DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `kode_pembelian` varchar(36) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `idsupplier` varchar(6) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `grand_total` int(11) DEFAULT NULL,
  `bayar` int(11) DEFAULT NULL,
  `kembalian` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `idpenjualan` varchar(36) NOT NULL,
  `tanggal` date NOT NULL,
  `konsumen` varchar(50) DEFAULT NULL,
  `hp` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`idpenjualan`, `tanggal`, `konsumen`, `hp`) VALUES
('33ec9eb6-45cd-4095-b685-63a158607f36', '2026-07-01', 'Alvin', '0928349'),
('552bf4a2-3ace-4e54-b619-fc4b51a0cf0d', '2026-06-30', 'Tulus', '0587'),
('9fa67866-6b7d-4ee0-9f7a-7d66620a546f', '2026-06-30', 'Tulus', '216446615'),
('b933dd14-19f4-4c9c-80f1-7ab017003bba', '2026-06-30', 'Tulus', '084');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_detil`
--

CREATE TABLE `penjualan_detil` (
  `idpenjualan_detil` int(11) NOT NULL,
  `idpenjualan` varchar(36) NOT NULL,
  `idproduk` varchar(6) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(11, '9fa67866-6b7d-4ee0-9f7a-7d66620a546f', 'P0005', 235),
(12, '33ec9eb6-45cd-4095-b685-63a158607f36', 'P0004', 2),
(13, '33ec9eb6-45cd-4095-b685-63a158607f36', 'P0005', 1);

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
-- Indexes for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_pembelian` (`kode_pembelian`,`kode_barang`),
  ADD KEY `kode_barang` (`kode_barang`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`kode_pembelian`),
  ADD KEY `idsupplier` (`idsupplier`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`idpenjualan`);

--
-- Indexes for table `penjualan_detil`
--
ALTER TABLE `penjualan_detil`
  ADD PRIMARY KEY (`idpenjualan_detil`),
  ADD KEY `idproduk` (`idproduk`),
  ADD KEY `idpenjualan` (`idpenjualan`);

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

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penjualan_detil`
--
ALTER TABLE `penjualan_detil`
  MODIFY `idpenjualan_detil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD CONSTRAINT `detail_pembelian_ibfk_1` FOREIGN KEY (`kode_barang`) REFERENCES `produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_pembelian_ibfk_2` FOREIGN KEY (`kode_pembelian`) REFERENCES `pembelian` (`kode_pembelian`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`idsupplier`) REFERENCES `supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
