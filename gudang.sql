-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2024 at 02:39 AM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ternak_ayam`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE IF NOT EXISTS `barang` (
  `id_barang` char(7) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `stok`, `harga`, `satuan_id`) VALUES
('B000000', 'Kayu Utuh', 589, 1000000, 6),
('B000001', 'kayu', 0, 10000000, 6),
('P000000', 'Tripleks', 0, 25000, 6);

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE IF NOT EXISTS `barang_keluar` (
  `id_barang_keluar` char(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` char(7) NOT NULL,
  `jumlah_keluar` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `nama_pembeli` varchar(225) NOT NULL,
  `alamat_pembeli` varchar(1000) NOT NULL,
  `total_berat` text NOT NULL,
  `rata` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_barang_keluar`, `user_id`, `barang_id`, `jumlah_keluar`, `harga`, `tanggal_keluar`, `nama_pembeli`, `alamat_pembeli`, `total_berat`, `rata`) VALUES
('PA-00000', 1, 'P000000', 1000, 0, '2024-02-16', 'Nureda', 'Demak', '2473', '2,473'),
('PA-00001', 1, 'P000000', 290, 0, '2024-08-16', 'nuri', 'pati', '424', '1,46'),
('PA-00002', 1, 'P000000', 190, 0, '2024-10-16', 'Bari', 'Kudus', '3153', '1,59'),
('PA-00003', 1, 'P000000', 200, 0, '2023-10-16', 'Khoirul', 'Gebog', '520', '2,60'),
('PA-00005', 1, 'P000000', 5, 5000, '2024-06-05', 'pembeli', 'alamat', '10', '20');

--
-- Triggers `barang_keluar`
--
DELIMITER $$
CREATE TRIGGER `detele_stok_keluar` AFTER DELETE ON `barang_keluar`
 FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` + OLD.jumlah_keluar WHERE `barang`.`id_barang` = OLD.barang_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_stok_keluar` BEFORE INSERT ON `barang_keluar`
 FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` - NEW.jumlah_keluar WHERE `barang`.`id_barang` = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE IF NOT EXISTS `barang_masuk` (
  `id_barang_masuk` char(16) NOT NULL,
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

INSERT INTO `barang_masuk` (`id_barang_masuk`, `supplier_id`, `user_id`, `barang_id`, `jumlah_masuk`, `harga`, `tanggal_masuk`) VALUES
('PB-00000', 5, 1, 'P000000', 13000, 0, '2024-02-12'),
('PB-00001', 5, 1, 'B000000', 120, 0, '2024-08-02'),
('PB-00002', 5, 1, 'B000000', 70, 0, '2024-09-04'),
('PB-00003', 5, 1, 'B000000', 100, 0, '2023-10-09'),
('PB-00004', 5, 1, 'B000000', 90, 0, '2023-10-12'),
('PB-00005', 4, 1, 'B000000', 1, 1500, '2024-06-05'),
('PB-00006', 4, 1, 'B000000', 10, 1500, '2024-06-05'),
('PB-00007', 4, 1, 'B000000', 10, 1000000, '2024-06-06'),
('PB-00008', 4, 1, 'B000000', 1, 1000000, '2024-06-06');

--
-- Triggers `barang_masuk`
--
DELIMITER $$
CREATE TRIGGER `delete_stok_masuk` AFTER DELETE ON `barang_masuk`
 FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` - OLD.jumlah_masuk WHERE `barang`.`id_barang` = OLD.barang_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_stok_masuk` BEFORE INSERT ON `barang_masuk`
 FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` + NEW.jumlah_masuk WHERE `barang`.`id_barang` = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `hasil_produksi`
--

CREATE TABLE IF NOT EXISTS `hasil_produksi` (
  `id_hasil_produksi` char(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` varchar(255) NOT NULL,
  `jumlah_masuk` int(11) NOT NULL,
  `stok_k` text NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hasil_produksi`
--

INSERT INTO `hasil_produksi` (`id_hasil_produksi`, `user_id`, `barang_id`, `jumlah_masuk`, `stok_k`, `tanggal`, `keterangan`) VALUES
('HP-00001', 1, '0', 10, '', '2024-06-05', 'keterangan'),
('HP-00002', 1, 'P000000', 10, '', '2024-06-05', 'keterangan'),
('HP-00003', 1, 'P000000', 20, '', '2024-06-05', 'q');

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE IF NOT EXISTS `jenis` (
  `id_jenis` int(11) NOT NULL,
  `nama_jenis` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`id_jenis`, `nama_jenis`) VALUES
(8, 'Pedaging');

-- --------------------------------------------------------

--
-- Table structure for table `keluar_harian`
--

CREATE TABLE IF NOT EXISTS `keluar_harian` (
  `id_keluar_harian` char(16) NOT NULL,
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

INSERT INTO `keluar_harian` (`id_keluar_harian`, `user_id`, `barang_id`, `jumlah_keluar`, `stok_k`, `tanggal_keluar`, `keterangan`) VALUES
('KH-00001', 1, 'B000001', 48, '', '2023-10-18', 'pakan untuk minggu 1'),
('KH-00003', 1, 'B000001', 89, '', '2023-10-25', 'pakan untuk minggu 2'),
('KH-00005', 1, 'B000001', 160, '', '2023-11-02', 'pakan untuk minggu 3'),
('KH-00007', 1, 'B000000', 10, '', '2024-01-19', 'p'),
('KH-00008', 1, 'B000001', 10, '', '2024-01-19', 'ayam mati'),
('KH-00009', 1, 'B000000', 69, '10700', '2024-01-19', '-'),
('KH-00010', 1, 'B000000', 100, '10600', '2024-01-19', '--'),
('KH-00011', 1, 'B000001', 13, '160', '2024-01-19', '-'),
('KH-00012', 1, 'P000000', 10, '', '2024-06-05', 'asd');

--
-- Triggers `keluar_harian`
--
DELIMITER $$
CREATE TRIGGER `detele_stok_harian` AFTER DELETE ON `keluar_harian`
 FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` + OLD.jumlah_keluar WHERE `barang`.`id_barang` = OLD.barang_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_stok_keluarharian` BEFORE INSERT ON `keluar_harian`
 FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` - NEW.jumlah_keluar WHERE `barang`.`id_barang` = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `keuangan`
--

CREATE TABLE IF NOT EXISTS `keuangan` (
  `id_keuangan` int(11) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `tgl` date NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `nominal` double NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keuangan`
--

INSERT INTO `keuangan` (`id_keuangan`, `jenis`, `tgl`, `keterangan`, `nominal`) VALUES
(14, 'Modal', '2024-01-01', 'Modal Bulan 1', 100000),
(15, 'Pengeluaran', '2024-01-02', 'Upah pekerja', 20000),
(16, 'Pemasukan', '2024-01-03', 'Masuk pak eko', 15000),
(17, 'Pengeluaran', '2024-01-02', 'Ayam mati', 10000),
(18, 'Modal', '2024-02-01', 'Modal Bulan 2', 200000);

-- --------------------------------------------------------

--
-- Table structure for table `periode`
--

CREATE TABLE IF NOT EXISTS `periode` (
  `id` int(11) NOT NULL,
  `dari` date NOT NULL,
  `sampai` date NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `periode`
--

INSERT INTO `periode` (`id`, `dari`, `sampai`, `status`) VALUES
(2, '2024-02-01', '2024-02-29', '');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE IF NOT EXISTS `satuan` (
  `id_satuan` int(11) NOT NULL,
  `nama_satuan` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `role` enum('gudang','admin') NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `email`, `no_telp`, `role`, `password`, `created_at`, `is_active`) VALUES
(1, 'Admin', 'admin', 'admin@admin.com', '085747127210', 'admin', '$2a$12$48niKl.oVP73Xy4jrSgpWO6j6OBHUsEUe0wsrepr1uv2BxFjlYCdS', 1568689561, 1),
(2, 'Pegawai', 'pegawai', 'pegawai@gmail.com', '085747203316', 'gudang', '$2y$10$XZ8vo0GUorIIIS/SZFWFoOFgcJsFZDr8OCae.ycGG1RB2Xu0quFI2', 1704436483, 1),
(3, 'ternak ayam', 'pppp', 'ternak@gmail.com', '09865546898', 'gudang', '$2y$10$Lp.1vr3dylWAs3xjvtUEcO2WyvGivVEvngyv3Qb1FigR1QjjYmd9e', 1705661926, 0);

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
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`),
  ADD KEY `id_user` (`user_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `barang_id` (`barang_id`);

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
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `keuangan`
--
ALTER TABLE `keuangan`
  MODIFY `id_keuangan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
