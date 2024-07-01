-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2024 at 11:06 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gudang`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` char(7) NOT NULL,
  `kd_barang` char(32) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `jenis` int(11) DEFAULT NULL COMMENT '1 = bahan baku\r\n2 = barang produksi',
  `satuan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `kd_barang`, `nama_barang`, `stok`, `harga`, `jenis`, `satuan_id`) VALUES
('1', 'B000001', 'Kayu Jenis A', 46, 100000, 1, 6),
('2', 'B000002', 'Kayu Jenis B', 47, 110000, 1, 6),
('3', 'B000003', 'Kayu Jenis C', 49, 120000, 1, 6),
('4', 'P000004', 'Tripleks A', 2, 20000, 2, 6),
('5', 'P000005', 'Tripleks B', 2, 25000, 2, 6),
('6', 'P000006', 'Tripleks C', 1, 50000, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_barang_keluar` char(16) NOT NULL,
  `kd_barang_keluar` char(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` char(7) NOT NULL,
  `jumlah_keluar` int(11) NOT NULL,
  `harga` int(11) DEFAULT NULL,
  `tanggal_keluar` date NOT NULL,
  `nama_pembeli` varchar(225) NOT NULL,
  `alamat_pembeli` varchar(1000) NOT NULL,
  `total_berat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_barang_keluar`, `kd_barang_keluar`, `user_id`, `barang_id`, `jumlah_keluar`, `harga`, `tanggal_keluar`, `nama_pembeli`, `alamat_pembeli`, `total_berat`) VALUES
('1', 'PA-00001', 4, '4', 3, NULL, '2024-06-30', 'Arif', 'Tayu, Pati', NULL),
('2', 'PA-00002', 4, '5', 2, NULL, '2024-06-30', 'Wildan', 'Dukuhseti, Pati', NULL),
('3', 'PA-00003', 4, '6', 1, NULL, '2024-06-30', 'Konohamaru', 'Konoha, Konohagakure', NULL);

--
-- Triggers `barang_keluar`
--
DELIMITER $$
CREATE TRIGGER `detele_stok_keluar` AFTER DELETE ON `barang_keluar` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` + OLD.jumlah_keluar WHERE `barang`.`id_barang` = OLD.barang_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_stok_keluar` BEFORE INSERT ON `barang_keluar` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` - NEW.jumlah_keluar WHERE `barang`.`id_barang` = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_barang_masuk` char(16) NOT NULL,
  `kd_barang_masuk` char(32) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` char(7) NOT NULL,
  `jumlah_masuk` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_barang_masuk`, `kd_barang_masuk`, `supplier_id`, `user_id`, `barang_id`, `jumlah_masuk`, `harga`, `tanggal_masuk`) VALUES
('1', 'PB-00001', 4, 4, '1', 50, 100000, '2024-06-30'),
('2', 'PB-00002', 5, 4, '2', 50, 110000, '2024-06-30'),
('3', 'PB-00003', 4, 4, '3', 50, 120000, '2024-06-30');

--
-- Triggers `barang_masuk`
--
DELIMITER $$
CREATE TRIGGER `delete_stok_masuk` AFTER DELETE ON `barang_masuk` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` - OLD.jumlah_masuk WHERE `barang`.`id_barang` = OLD.barang_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_stok_masuk` BEFORE INSERT ON `barang_masuk` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` + NEW.jumlah_masuk WHERE `barang`.`id_barang` = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `hasil_produksi`
--

CREATE TABLE `hasil_produksi` (
  `id_hasil_produksi` char(16) NOT NULL,
  `kd_hasil_produksi` char(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` varchar(255) NOT NULL,
  `jumlah_masuk` int(11) NOT NULL,
  `stok_k` text NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hasil_produksi`
--

INSERT INTO `hasil_produksi` (`id_hasil_produksi`, `kd_hasil_produksi`, `user_id`, `barang_id`, `jumlah_masuk`, `stok_k`, `tanggal_masuk`, `keterangan`) VALUES
('1', 'HP-00001', 4, '4', 5, '5', '2024-06-30', 'Menggunakan 4 Kayu Jenis A'),
('2', 'HP-00002', 4, '5', 4, '4', '2024-06-30', 'Menggunakan 3 Kayu Jenis B'),
('3', 'HP-00003', 4, '6', 2, '2', '2024-06-30', 'Menggunakan 1 Kayu Jenis C');

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `id_jenis` int(11) NOT NULL,
  `nama_jenis` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `keluar_harian`
--

CREATE TABLE `keluar_harian` (
  `id_keluar_harian` char(16) NOT NULL,
  `kd_keluar_harian` char(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` char(7) NOT NULL,
  `jumlah_keluar` int(11) NOT NULL,
  `stok_k` text NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keluar_harian`
--

INSERT INTO `keluar_harian` (`id_keluar_harian`, `kd_keluar_harian`, `user_id`, `barang_id`, `jumlah_keluar`, `stok_k`, `tanggal_keluar`, `keterangan`) VALUES
('1', 'KH-00001', 4, '1', 4, '46', '2024-06-30', 'Pembuatan Tripleks A'),
('2', 'KH-00002', 4, '2', 3, '47', '2024-06-30', 'Pembuatan Tripleks B'),
('3', 'KH-00003', 4, '3', 1, '49', '2024-06-30', 'Pembuatan Tripleks C');

--
-- Triggers `keluar_harian`
--
DELIMITER $$
CREATE TRIGGER `detele_stok_harian` AFTER DELETE ON `keluar_harian` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` + OLD.jumlah_keluar WHERE `barang`.`id_barang` = OLD.barang_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_stok_keluarharian` BEFORE INSERT ON `keluar_harian` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` - NEW.jumlah_keluar WHERE `barang`.`id_barang` = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `keuangan`
--

CREATE TABLE `keuangan` (
  `id_keuangan` int(11) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `tgl` date NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `nominal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keuangan`
--

INSERT INTO `keuangan` (`id_keuangan`, `jenis`, `tgl`, `keterangan`, `nominal`) VALUES
(14, 'Modal', '2024-01-01', 'Modal Bulan 1', 100000),
(15, 'Pengeluaran', '2024-01-02', 'Upah pekerja', 20000),
(16, 'Pemasukan', '2024-01-03', 'Masuk pak eko', 15000),
(17, 'Pengeluaran', '2024-01-02', 'Ayam mati', 10000),
(18, 'Modal', '2024-02-01', 'Modal Bulan 2', 200000),
(19, 'Modal', '2024-06-29', 'test', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `periode`
--

CREATE TABLE `periode` (
  `id` int(11) NOT NULL,
  `dari` date NOT NULL,
  `sampai` date NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `periode`
--

INSERT INTO `periode` (`id`, `dari`, `sampai`, `status`) VALUES
(2, '2024-02-01', '2024-02-29', ''),
(3, '2024-02-01', '2024-02-29', ''),
(4, '2024-02-01', '2024-02-29', ''),
(5, '2024-02-01', '2024-02-29', ''),
(6, '2024-02-01', '2024-02-29', '');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` int(11) NOT NULL,
  `nama_satuan` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `nama_satuan`) VALUES
(5, 'Kg'),
(6, 'Pcs');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `no_telp`, `alamat`) VALUES
(4, 'PT Muria Jaya Raya', '081325763016', 'Gondang Manis Bae Kab. Kudus'),
(5, 'PT Tumbuh Optimal Prima', '085747203316', 'Gembong Kab. Pati');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `role` enum('gudang','admin') NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `email`, `no_telp`, `role`, `password`, `created_at`, `is_active`) VALUES
(1, 'Admin', 'admin', 'admin@admin.com', '085747127210', 'admin', '$2a$12$48niKl.oVP73Xy4jrSgpWO6j6OBHUsEUe0wsrepr1uv2BxFjlYCdS', 1568689561, 1),
(2, 'Pegawai', 'pegawai', 'pegawai@gmail.com', '085747203316', 'gudang', '$2y$10$XZ8vo0GUorIIIS/SZFWFoOFgcJsFZDr8OCae.ycGG1RB2Xu0quFI2', 1704436483, 1),
(3, 'ternak ayam', 'pppp', 'ternak@gmail.com', '09865546898', 'gudang', '$2y$10$Lp.1vr3dylWAs3xjvtUEcO2WyvGivVEvngyv3Qb1FigR1QjjYmd9e', 1705661926, 0),
(4, 'admin', 'admingudang01', 'gudang@admin.com', '085123123123', 'admin', '$2y$10$JZaPKf77m.Uo88f5sgnFQupJ5GRcG13DiuVVtEdTF8TM/cG/lrjFy', 1718035945, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `satuan_id` (`satuan_id`);

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_barang_keluar`),
  ADD KEY `id_user` (`user_id`),
  ADD KEY `id_barang` (`barang_id`) USING BTREE;

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`),
  ADD KEY `id_user` (`user_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `hasil_produksi`
--
ALTER TABLE `hasil_produksi`
  ADD PRIMARY KEY (`id_hasil_produksi`),
  ADD KEY `id_user` (`user_id`) USING BTREE,
  ADD KEY `barang_id` (`barang_id`) USING BTREE;

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `keluar_harian`
--
ALTER TABLE `keluar_harian`
  ADD PRIMARY KEY (`id_keluar_harian`),
  ADD KEY `id_user` (`user_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `keuangan`
--
ALTER TABLE `keuangan`
  ADD PRIMARY KEY (`id_keuangan`);

--
-- Indexes for table `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `keuangan`
--
ALTER TABLE `keuangan`
  MODIFY `id_keuangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`satuan_id`) REFERENCES `satuan` (`id_satuan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_keluar_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_3` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
