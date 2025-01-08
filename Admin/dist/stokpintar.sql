-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2024 at 04:46 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stokpintar`
--

-- --------------------------------------------------------

--
-- Table structure for table `bahan_baku`
--

CREATE TABLE `bahan_baku` (
  `id` int(11) NOT NULL,
  `nama_bahan` varchar(255) DEFAULT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `tanggal_kadaluarsa` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bahan_baku`
--

INSERT INTO `bahan_baku` (`id`, `nama_bahan`, `kategori_id`, `stok`, `satuan`, `harga`, `tanggal_kadaluarsa`) VALUES
(1, 'Kerupuk Kuning', 1, 100, 'kg', 15000.00, '2025-12-01'),
(2, 'Kerupuk Aci', 1, 120, 'kg', 12000.00, '2025-12-01'),
(3, 'Kerupuk Bawang', 1, 80, 'kg', 13000.00, '2025-12-01'),
(4, 'Mie Instan', 1, 200, 'bungkus', 5000.00, '2026-01-01'),
(5, 'Mie Kering', 1, 150, 'kg', 15000.00, '2026-01-01'),
(6, 'Kwetiau', 1, 50, 'kg', 20000.00, '2025-11-01'),
(7, 'Makaroni Kering', 1, 100, 'kg', 25000.00, '2026-02-01'),
(8, 'Makroni Basah', 1, 60, 'kg', 22000.00, '2026-02-01'),
(9, 'Bihun', 1, 90, 'kg', 8000.00, '2026-01-01'),
(10, 'Soun', 1, 70, 'kg', 7500.00, '2026-01-01'),
(11, 'Bawang Merah', 2, 50, 'kg', 20000.00, '2024-11-01'),
(12, 'Bawang Putih', 2, 40, 'kg', 25000.00, '2024-11-05'),
(13, 'Cabai Merah Besar', 2, 60, 'kg', 30000.00, '2024-10-20'),
(14, 'Cabai Rawit', 2, 30, 'kg', 30000.00, '2024-10-20'),
(15, 'Kencur', 2, 50, 'kg', 15000.00, '2025-01-01'),
(16, 'Saus Sambal', 3, 200, 'botol', 15000.00, '2025-06-01'),
(17, 'Saus Tomat', 3, 150, 'botol', 12000.00, '2025-06-01'),
(18, 'Kecap Manis', 3, 100, 'botol', 18000.00, '2025-07-01'),
(19, 'Merica Bubuk', 3, 20, 'kg', 25000.00, '2025-02-01'),
(20, 'Garam', 3, 100, 'kg', 5000.00, '2025-11-01'),
(21, 'Gula Pasir', 3, 120, 'kg', 7000.00, '2025-11-01'),
(22, 'Penyedap Rasa', 3, 50, 'pak', 15000.00, '2025-12-01'),
(23, 'Bakso Sapi', 4, 120, 'kg', 60000.00, '2025-01-01'),
(24, 'Sosis Ayam', 4, 100, 'bungkus', 25000.00, '2025-06-01'),
(25, 'Telur', 4, 200, 'butir', 3000.00, '2025-05-01'),
(26, 'Ayam Suwir', 4, 80, 'kg', 40000.00, '2025-04-01'),
(27, 'Ceker Ayam', 4, 70, 'kg', 35000.00, '2025-04-01'),
(28, 'Sawi Hijau', 4, 150, 'kg', 8000.00, '2025-12-01'),
(29, 'Kol', 4, 90, 'kg', 7000.00, '2025-11-01'),
(30, 'Brokoli', 4, 50, 'kg', 25000.00, '2025-12-01'),
(31, 'Wortel', 4, 100, 'kg', 10000.00, '2025-11-01'),
(32, 'Toge', 4, 80, 'kg', 5000.00, '2025-11-01'),
(33, 'Kikil Sapi', 4, 40, 'kg', 40000.00, '2025-03-01'),
(34, 'Jamur Tiram', 4, 60, 'kg', 20000.00, '2025-01-01'),
(35, 'Crab Stick', 4, 50, 'bungkus', 35000.00, '2025-02-01'),
(36, 'Keju Parut', 4, 30, 'kg', 80000.00, '2025-04-01'),
(37, 'Santan', 5, 100, 'liter', 25000.00, '2025-12-01'),
(38, 'Susu Cair', 5, 120, 'liter', 30000.00, '2025-06-01'),
(39, 'Kerupuk Pangsit', 5, 200, 'bungkus', 10000.00, '2025-11-01'),
(40, 'Kerupuk Udang', 5, 150, 'bungkus', 12000.00, '2025-10-01'),
(41, 'Minyak Goreng', 6, 200, 'liter', 18000.00, '2025-12-01'),
(42, 'Margarin', 6, 100, 'kg', 35000.00, '2025-06-01'),
(43, 'Air Kaldu Ayam', 7, 50, 'liter', 10000.00, '2025-01-01'),
(44, 'Air Kaldu Sapi', 7, 50, 'liter', 12000.00, '2025-01-01'),
(45, 'Cup Plastik', 8, 500, 'pcs', 1000.00, '2025-12-01'),
(46, 'Mangkuk Plastik', 8, 300, 'pcs', 1200.00, '2025-12-01'),
(47, 'Sendok Plastik', 8, 1000, 'pcs', 500.00, '2025-12-01'),
(48, 'Garpu Plastik', 8, 1000, 'pcs', 500.00, '2025-12-01');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(1, 'Bahan Dasar'),
(2, 'Bumbu Dasar Seblak'),
(3, 'Bumbu Penyedap'),
(4, 'Bahan Topping'),
(5, 'Bahan Pelengkap'),
(6, 'Minyak dan Penggorengan'),
(7, 'Air Kaldu'),
(8, 'Penyajian dan Kemasan');

-- --------------------------------------------------------

--
-- Table structure for table `pengadaan`
--

CREATE TABLE `pengadaan` (
  `id` int(11) NOT NULL,
  `bahan_baku_id` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tanggal_pesanan` date DEFAULT NULL,
  `total_biaya` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `nama_bahan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengadaan`
--

INSERT INTO `pengadaan` (`id`, `bahan_baku_id`, `jumlah`, `tanggal_pesanan`, `total_biaya`, `status`, `nama_bahan`) VALUES
(1, 1, 50, '2024-11-01', 750000.00, 'Dipesan', 'Kerupuk Kuning'),
(2, 2, 100, '2024-11-05', 500000.00, 'Diterima', 'Kerupuk Aci'),
(3, 3, 20, '2024-10-25', 400000.00, 'Dibatalkan', 'Kerupuk Bawang');

-- --------------------------------------------------------

--
-- Table structure for table `penggunaan`
--

CREATE TABLE `penggunaan` (
  `id` int(11) NOT NULL,
  `bahan_baku_id` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tanggal_penggunaan` date DEFAULT NULL,
  `nama_bahan` varchar(255) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penggunaan`
--

INSERT INTO `penggunaan` (`id`, `bahan_baku_id`, `jumlah`, `tanggal_penggunaan`, `nama_bahan`, `satuan`) VALUES
(1, 1, 10, '2024-11-01', 'Kerupuk Kuning', 'kg'),
(2, 2, 50, '2024-11-02', 'Kerupuk Aci', 'kg'),
(3, 5, 30, '2024-11-03', 'Mie Kering', 'kg');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama_supplier` varchar(255) DEFAULT NULL,
  `kontak` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama_supplier`, `kontak`, `alamat`) VALUES
(1, 'Supplier A', '08123456789', 'Jl. Contoh 1, Bandung'),
(2, 'Supplier B', '08234567890', 'Jl. Contoh 2, Jakarta');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengadaan`
--
ALTER TABLE `pengadaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bahan_baku_id` (`bahan_baku_id`);

--
-- Indexes for table `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bahan_baku_id` (`bahan_baku_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pengadaan`
--
ALTER TABLE `pengadaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `penggunaan`
--
ALTER TABLE `penggunaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  ADD CONSTRAINT `bahan_baku_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`);

--
-- Constraints for table `pengadaan`
--
ALTER TABLE `pengadaan`
  ADD CONSTRAINT `pengadaan_ibfk_1` FOREIGN KEY (`bahan_baku_id`) REFERENCES `bahan_baku` (`id`);

--
-- Constraints for table `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD CONSTRAINT `penggunaan_ibfk_1` FOREIGN KEY (`bahan_baku_id`) REFERENCES `bahan_baku` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
