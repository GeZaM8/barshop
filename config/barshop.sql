-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               11.4.2-MariaDB-log - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for barshop
CREATE DATABASE IF NOT EXISTS `barshop` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `barshop`;

-- Dumping structure for table barshop.barang
CREATE TABLE IF NOT EXISTS `barang` (
  `kode` int(5) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) NOT NULL,
  `jenis` varchar(15) NOT NULL,
  `satuan` varchar(15) NOT NULL DEFAULT 'pcs',
  `harga_beli` int(15) NOT NULL,
  `harga_jual` int(15) DEFAULT NULL,
  `jumlah` int(5) NOT NULL DEFAULT 0,
  PRIMARY KEY (`kode`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table barshop.barang: ~3 rows (approximately)
INSERT INTO `barang` (`kode`, `nama`, `jenis`, `satuan`, `harga_beli`, `harga_jual`, `jumlah`) VALUES
	(1, 'Pulpen', 'Alat Tulis', 'pcs', 1500, 2000, 0),
	(2, 'Buku', 'Alat Tulis', 'pcs', 3000, 5000, 20),
	(3, 'Tipe-X', 'Alat Tulis', 'pcs', 3000, 5000, 5);

-- Dumping structure for table barshop.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `id_cart` int(5) NOT NULL AUTO_INCREMENT,
  `kode_pelanggan` int(5) NOT NULL,
  `id_account` int(5) NOT NULL,
  `kode_barang` int(5) NOT NULL,
  `jumlah_barang` int(5) NOT NULL,
  PRIMARY KEY (`id_cart`,`id_account`),
  KEY `FK_cart_pelanggan` (`kode_pelanggan`),
  KEY `FK_cart_user` (`id_account`),
  KEY `FK_cart_barang` (`kode_barang`),
  CONSTRAINT `FK_cart_barang` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`kode`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_cart_pelanggan` FOREIGN KEY (`kode_pelanggan`) REFERENCES `pelanggan` (`kode`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_cart_user` FOREIGN KEY (`id_account`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table barshop.cart: ~0 rows (approximately)

-- Dumping structure for table barshop.detail_transaksi
CREATE TABLE IF NOT EXISTS `detail_transaksi` (
  `nomor_detail` int(5) NOT NULL AUTO_INCREMENT,
  `nomor_order` int(5) DEFAULT NULL,
  `kode_barang` int(5) DEFAULT NULL,
  `jumlah_barang` int(5) DEFAULT NULL,
  PRIMARY KEY (`nomor_detail`),
  KEY `FK_detail_transaksi_barang` (`kode_barang`),
  KEY `FK_detail_transaksi_transaksi` (`nomor_order`),
  CONSTRAINT `FK_detail_transaksi_barang` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`kode`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_detail_transaksi_transaksi` FOREIGN KEY (`nomor_order`) REFERENCES `transaksi` (`nomor_order`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table barshop.detail_transaksi: ~6 rows (approximately)
INSERT INTO `detail_transaksi` (`nomor_detail`, `nomor_order`, `kode_barang`, `jumlah_barang`) VALUES
	(13, 12, 1, 125),
	(14, 13, 1, 5),
	(15, 13, 2, 5),
	(16, 14, 3, 5),
	(17, 15, 3, 10),
	(18, 17, 1, 70);

-- Dumping structure for view barshop.detail_transaksiview
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `detail_transaksiview` (
	`nomor_order` INT(5) NULL,
	`nomor_detail` INT(5) NOT NULL,
	`kode_barang` INT(5) NOT NULL,
	`nama_barang` VARCHAR(30) NOT NULL COLLATE 'utf8mb4_general_ci',
	`jenis_barang` VARCHAR(15) NOT NULL COLLATE 'utf8mb4_general_ci',
	`jumlah_barang` INT(5) NULL,
	`total_harga` BIGINT(25) NULL
) ENGINE=MyISAM;

-- Dumping structure for table barshop.pelanggan
CREATE TABLE IF NOT EXISTS `pelanggan` (
  `kode` int(5) NOT NULL AUTO_INCREMENT,
  `id_account` int(5) DEFAULT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` varchar(30) NOT NULL,
  `no_telp` varchar(14) NOT NULL,
  PRIMARY KEY (`kode`) USING BTREE,
  UNIQUE KEY `id_account` (`id_account`),
  CONSTRAINT `FK_pelanggan_account` FOREIGN KEY (`id_account`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table barshop.pelanggan: ~7 rows (approximately)
INSERT INTO `pelanggan` (`kode`, `id_account`, `nama`, `alamat`, `no_telp`) VALUES
	(1, 2, 'Serge', 'Jakarta', '081238912311'),
	(7, 8, 'aaaaa', 'Jakarta', '0829292929'),
	(8, 9, 'q', 'q', 'qa'),
	(9, 11, 'sadasd', 'asas', 'asasas'),
	(12, 13, 'aaaa', 'aaaaa', '0812382111a'),
	(13, 14, 'aaaa', 'a', '0812'),
	(17, 16, 'Jean Arby Putra', 'Ceger', '0812309281'),
	(18, 17, 'apa', 'a', '0983323');

-- Dumping structure for table barshop.pemasok
CREATE TABLE IF NOT EXISTS `pemasok` (
  `kode` int(5) NOT NULL AUTO_INCREMENT,
  `id_account` int(5) DEFAULT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` varchar(30) NOT NULL,
  `no_telp` varchar(12) NOT NULL,
  `email` varchar(30) NOT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL DEFAULT 'Tidak Aktif',
  PRIMARY KEY (`kode`) USING BTREE,
  KEY `FK_pemasok_account` (`id_account`),
  CONSTRAINT `FK_pemasok_account` FOREIGN KEY (`id_account`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table barshop.pemasok: ~3 rows (approximately)
INSERT INTO `pemasok` (`kode`, `id_account`, `nama`, `alamat`, `no_telp`, `email`, `status`) VALUES
	(1, 4, 'Alat Tulis', 'Jakarta', '08123987123', 'pemasok1@gmail.com', 'Tidak Aktif'),
	(2, 12, 'aa', 'a', '01', 'a@a', 'Aktif');

-- Dumping structure for table barshop.pesanan
CREATE TABLE IF NOT EXISTS `pesanan` (
  `nomor_po` int(15) NOT NULL AUTO_INCREMENT,
  `tanggal_po` date NOT NULL DEFAULT current_timestamp(),
  `kode_supplier` int(5) NOT NULL,
  `kode_barang` int(5) NOT NULL,
  `jumlah_barang` int(5) DEFAULT NULL,
  `status` enum('Pending','Accepted','Rejected','Paid') NOT NULL DEFAULT 'Pending',
  `deleted_at` date DEFAULT NULL,
  PRIMARY KEY (`nomor_po`),
  KEY `FK_purchase_orders_pemasok` (`kode_supplier`),
  KEY `FK_purchase_orders_barang` (`kode_barang`),
  CONSTRAINT `FK_purchase_orders_barang` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`kode`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_purchase_orders_pemasok` FOREIGN KEY (`kode_supplier`) REFERENCES `pemasok` (`kode`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table barshop.pesanan: ~6 rows (approximately)
INSERT INTO `pesanan` (`nomor_po`, `tanggal_po`, `kode_supplier`, `kode_barang`, `jumlah_barang`, `status`, `deleted_at`) VALUES
	(11, '2024-12-02', 1, 3, 5, 'Paid', '2024-12-02'),
	(12, '2024-12-02', 1, 3, 100, 'Paid', '2024-12-02'),
	(13, '2024-12-02', 2, 1, 95, 'Paid', '2024-12-02'),
	(14, '2024-12-02', 2, 2, 95, 'Paid', '2024-12-02'),
	(15, '2024-12-02', 1, 3, 95, 'Paid', '2024-12-02'),
	(16, '2024-12-02', 1, 1, 55, 'Paid', '2024-12-02'),
	(17, '2024-12-02', 1, 2, 55, 'Paid', '2024-12-02');

-- Dumping structure for view barshop.pesananview
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `pesananview` (
	`nomor_po` INT(15) NOT NULL,
	`tanggal_po` DATE NOT NULL,
	`kode_pemasok` INT(5) NOT NULL,
	`nama_pemasok` VARCHAR(30) NOT NULL COLLATE 'utf8mb4_general_ci',
	`kode_barang` INT(5) NOT NULL,
	`nama_barang` VARCHAR(30) NOT NULL COLLATE 'utf8mb4_general_ci',
	`jenis_barang` VARCHAR(15) NOT NULL COLLATE 'utf8mb4_general_ci',
	`jumlah_barang` INT(5) NULL,
	`harga` BIGINT(25) NULL,
	`status` ENUM('Pending','Accepted','Rejected','Paid') NOT NULL COLLATE 'utf8mb4_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for table barshop.transaksi
CREATE TABLE IF NOT EXISTS `transaksi` (
  `nomor_order` int(5) NOT NULL AUTO_INCREMENT,
  `tanggal_order` date NOT NULL DEFAULT current_timestamp(),
  `kode_pelanggan` int(5) NOT NULL,
  `kode_barang` int(5) DEFAULT NULL,
  `jumlah_barang` int(3) DEFAULT NULL,
  `status` enum('Pending','Paid','Cancelled') NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`nomor_order`) USING BTREE,
  KEY `FK_transaksi_barang` (`kode_barang`) USING BTREE,
  KEY `FK_transaksi_pelanggan` (`kode_pelanggan`) USING BTREE,
  CONSTRAINT `FK_transaksi_barang` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`kode`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_transaksi_pelanggan` FOREIGN KEY (`kode_pelanggan`) REFERENCES `pelanggan` (`kode`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table barshop.transaksi: ~5 rows (approximately)
INSERT INTO `transaksi` (`nomor_order`, `tanggal_order`, `kode_pelanggan`, `kode_barang`, `jumlah_barang`, `status`) VALUES
	(12, '2024-11-26', 12, NULL, NULL, 'Pending'),
	(13, '2024-12-02', 12, NULL, NULL, 'Pending'),
	(14, '2024-12-02', 12, NULL, NULL, 'Pending'),
	(15, '2024-12-02', 12, NULL, NULL, 'Pending'),
	(17, '2024-12-02', 12, NULL, NULL, 'Pending');

-- Dumping structure for view barshop.transaksiview
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `transaksiview` (
	`nomor_order` INT(5) NOT NULL,
	`tanggal_order` DATE NOT NULL,
	`kode_pelanggan` INT(5) NOT NULL,
	`nama_pelanggan` VARCHAR(30) NOT NULL COLLATE 'utf8mb4_general_ci',
	`status` ENUM('Pending','Paid','Cancelled') NOT NULL COLLATE 'utf8mb4_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for table barshop.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(15) NOT NULL,
  `level` enum('Admin','Pelanggan','Pemasok','Manager') NOT NULL DEFAULT 'Pelanggan',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table barshop.user: ~15 rows (approximately)
INSERT INTO `user` (`id`, `username`, `password`, `level`) VALUES
	(1, 'Admin', 'admin', 'Admin'),
	(2, 'aa', 'aa', 'Pelanggan'),
	(4, 'pemasok', 'pemasok', 'Pemasok'),
	(5, 'Restu', 'master', 'Admin'),
	(6, 'Rifqi', '2222', 'Admin'),
	(7, 'Manager', 'manager', 'Manager'),
	(8, 's', 's', 'Pelanggan'),
	(9, 'q', 'q', 'Pelanggan'),
	(11, 'as', 's', 'Pelanggan'),
	(12, 'tes', 'a', 'Pemasok'),
	(13, 'pelanggan', 'pelanggan', 'Pelanggan'),
	(14, 'tes dulu', 'a', 'Pelanggan'),
	(15, 'apa', 'apa', 'Pelanggan'),
	(16, 'Jean', '1', 'Pelanggan'),
	(17, 'Tesss', 'te', 'Pelanggan');

-- Dumping structure for view barshop.detail_transaksiview
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `detail_transaksiview`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `detail_transaksiview` AS SELECT d.nomor_order, d.nomor_detail,
		b.kode AS kode_barang, b.nama AS nama_barang, b.jenis AS jenis_barang, 
		d.jumlah_barang, (d.jumlah_barang * b.harga_jual) AS total_harga 
FROM detail_transaksi d, barang b
WHERE d.kode_barang = b.kode ;

-- Dumping structure for view barshop.pesananview
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `pesananview`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `pesananview` AS SELECT pe.nomor_po, pe.tanggal_po,
		p.kode AS kode_pemasok, p.nama AS nama_pemasok,
		b.kode AS kode_barang, b.nama AS nama_barang, b.jenis AS jenis_barang,
		pe.jumlah_barang, (pe.jumlah_barang * b.harga_jual) AS harga, pe.status
FROM pesanan pe, barang b, pemasok p
WHERE pe.kode_barang = b.kode AND
		pe.kode_supplier = p.kode ;

-- Dumping structure for view barshop.transaksiview
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `transaksiview`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `transaksiview` AS SELECT t.nomor_order, t.tanggal_order,
		p.kode AS kode_pelanggan, p.nama AS nama_pelanggan,
		t.status
FROM transaksi t, pelanggan p
WHERE t.kode_pelanggan = p.kode ;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
