-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2024 at 10:44 AM
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
-- Database: `gudang`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `asset_tagging` int(11) NOT NULL,
  `jenis_aset` varchar(200) DEFAULT NULL,
  `merk` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `serial_number` varchar(255) NOT NULL,
  `nama` int(11) DEFAULT NULL,
  `mapping` varchar(255) DEFAULT NULL,
  `o365` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `kondisi` varchar(200) DEFAULT NULL,
  `approval_status` varchar(200) DEFAULT NULL,
  `aksi` varchar(50) NOT NULL,
  `documentation` varchar(255) DEFAULT NULL,
  `previous_customer_name` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `asset_tagging`, `jenis_aset`, `merk`, `type`, `serial_number`, `nama`, `mapping`, `o365`, `lokasi`, `status`, `kondisi`, `approval_status`, `aksi`, `documentation`, `previous_customer_name`, `created_at`, `updated_at`, `latitude`, `longitude`, `keterangan`) VALUES
(427, 108, 'Laptop', 11, 'Windows 10 OHS i7-8324', '23131412re', 39, 'isuhad', 'Partner License', 'PT. PAMAPERSADA NUSANTARA, 9, Cakung, East Jakarta, Special capital Region of Jakarta, Java, Indonesia', 'Operation', 'New', 'Approved', 'Handover', 'uploads/documentation/1727857630_pikaso_embed-removebg.png', '39', '2024-09-30 15:22:51', '2024-10-02 01:27:11', -6.1978480, 106.9155301, NULL),
(428, 107, 'Laptop', 11, 'Windows 10 OHS i7-8324', 'siadad', 39, 'isuhad', 'Partner License', 'PT UNITED TRACTOR, Cakung, East Jakarta, Special capital Region of Jakarta, Java, Indonesia', 'Operation', 'New', 'Approved', 'Handover', 'uploads/documentation/1727857801_pikaso_embed.jpeg', '39', '2024-10-02 01:29:40', '2024-10-02 01:30:01', -6.1857115, 106.9309578, NULL);

--
-- Triggers `assets`
--
DELIMITER $$
CREATE TRIGGER `after_asset_create` AFTER INSERT ON `assets` FOR EACH ROW BEGIN
    INSERT INTO asset_history (
        asset_tagging_old, 
        merk_old, 
        nama_old, 
        jenis_aset_old, 
        changed_at,
        action
    )
    VALUES (
        NEW.asset_tagging, 
        NEW.merk, 
        NEW.nama, 
        NEW.jenis_aset,
        NOW(), 
        'CREATE'
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_asset_delete` AFTER DELETE ON `assets` FOR EACH ROW BEGIN
    INSERT INTO asset_history (
        asset_tagging_old, 
        merk_old, 
        nama_old, 
        jenis_aset_old, 
        changed_at,
        keterangan,
        action
    )
    VALUES (
        OLD.asset_tagging, 
        OLD.merk, 
        OLD.nama, 
        OLD.jenis_aset, 
        NOW(),
        OLD.keterangan,
        'DELETE'
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_asset_update` AFTER UPDATE ON `assets` FOR EACH ROW BEGIN
    INSERT INTO asset_history (
        asset_tagging_old, 
        merk_old, 
        nama_old, 
        jenis_aset_old, 
        changed_at, 
        action,
        nama_new
    )
    VALUES (
        OLD.asset_tagging, 
        OLD.merk, 
        OLD.nama, 
        OLD.jenis_aset, 
        NOW(), 
        'UPDATE',
        NEW.nama
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_assets_delete_status` AFTER DELETE ON `assets` FOR EACH ROW BEGIN
    UPDATE inventory SET status = 'Inventory' WHERE id = OLD.asset_tagging;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_assets_insert_status` AFTER INSERT ON `assets` FOR EACH ROW BEGIN
    UPDATE inventory SET status = 'Operation' WHERE id = NEW.asset_tagging;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_asset_delete` BEFORE DELETE ON `assets` FOR EACH ROW BEGIN
    INSERT INTO asset_history (
        asset_id, asset_tagging_old, asset_tagging_new,
        jenis_aset_old, jenis_aset_new,
        merk_old, merk_new,
        type_old, type_new,
        serial_number_old, serial_number_new,
        nama_old, nama_new,
        mapping_old, mapping_new,
        o365_old, o365_new,
        lokasi_old, lokasi_new,
        status_old, status_new,
        kondisi_old, kondisi_new,
        documentation_old, documentation_new,
        action
    )
    VALUES (
        OLD.id, OLD.asset_tagging, NULL,
        OLD.jenis_aset, NULL,
        OLD.merk, NULL,
        OLD.type, NULL,
        OLD.serial_number, NULL,
        OLD.nama, NULL,
        OLD.mapping, NULL,
        OLD.o365, NULL,
        OLD.lokasi, NULL,
        OLD.status, NULL,
        OLD.kondisi, NULL,
        OLD.documentation, NULL,
        'DELETE'
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_asset_update` BEFORE UPDATE ON `assets` FOR EACH ROW BEGIN
    INSERT INTO asset_history (
        asset_id, asset_tagging_old, asset_tagging_new,
        jenis_aset_old, jenis_aset_new,
        merk_old, merk_new,
        type_old, type_new,
        serial_number_old, serial_number_new,
        nama_old, nama_new,
        mapping_old, mapping_new,
        o365_old, o365_new,
        lokasi_old, lokasi_new,
        status_old, status_new,
        kondisi_old, kondisi_new,
        documentation_old, documentation_new,
        action
    )
    VALUES (
        OLD.id, OLD.asset_tagging, NEW.asset_tagging,
        OLD.jenis_aset, NEW.jenis_aset,
        OLD.merk, NEW.merk,
        OLD.type, NEW.type,
        OLD.serial_number, NEW.serial_number,
        OLD.nama, NEW.nama,
        OLD.mapping, NEW.mapping,
        OLD.o365, NEW.o365,
        OLD.lokasi, NEW.lokasi,
        OLD.status, NEW.status,
        OLD.kondisi, NEW.kondisi,
        OLD.documentation, NEW.documentation,
        'UPDATE'
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `triger_lokasi_taggalditerima_delete` AFTER DELETE ON `assets` FOR EACH ROW BEGIN
    -- Update lokasi and tanggal_diterima in inventory when an asset is deleted
    UPDATE inventory
    SET 
        lokasi = 'in inventory',
        tanggal_diterima = '-'
    WHERE id = OLD.asset_tagging;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `triger_lokasi_taggalditerima_insert` AFTER INSERT ON `assets` FOR EACH ROW BEGIN
    -- Update lokasi and tanggal_diterima in inventory based on asset_tagging
    UPDATE inventory
    SET 
        lokasi = NEW.lokasi,
        tanggal_diterima = NEW.updated_at
    WHERE id = NEW.asset_tagging;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `triger_lokasi_taggalditerima_update` AFTER UPDATE ON `assets` FOR EACH ROW BEGIN    
    -- Update lokasi and tanggal_diterima in inventory based on assets' lokasi and updated_at
    UPDATE inventory
    SET lokasi = NEW.lokasi,
        tanggal_diterima = NEW.updated_at
    WHERE id = NEW.asset_tagging;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `asset_history`
--

CREATE TABLE `asset_history` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `asset_tagging_old` int(11) DEFAULT NULL,
  `asset_tagging_new` int(11) DEFAULT NULL,
  `jenis_aset_old` varchar(200) DEFAULT NULL,
  `jenis_aset_new` varchar(200) DEFAULT NULL,
  `merk_old` int(11) DEFAULT NULL,
  `merk_new` int(11) DEFAULT NULL,
  `type_old` varchar(255) DEFAULT NULL,
  `type_new` varchar(255) DEFAULT NULL,
  `serial_number_old` varchar(255) DEFAULT NULL,
  `serial_number_new` varchar(255) DEFAULT NULL,
  `nama_old` int(11) DEFAULT NULL,
  `nama_new` int(11) DEFAULT NULL,
  `mapping_old` varchar(255) DEFAULT NULL,
  `mapping_new` varchar(255) DEFAULT NULL,
  `o365_old` varchar(255) DEFAULT NULL,
  `o365_new` varchar(255) DEFAULT NULL,
  `lokasi_old` varchar(255) DEFAULT NULL,
  `lokasi_new` varchar(255) DEFAULT NULL,
  `status_old` varchar(50) DEFAULT NULL,
  `status_new` varchar(50) DEFAULT NULL,
  `kondisi_old` enum('Good','Exception','Bad','New') DEFAULT NULL,
  `kondisi_new` enum('Good','Exception','Bad','New') DEFAULT NULL,
  `documentation_old` varchar(255) DEFAULT NULL,
  `documentation_new` varchar(255) DEFAULT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `action` enum('CREATE','UPDATE','DELETE') DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asset_history`
--

INSERT INTO `asset_history` (`id`, `asset_id`, `asset_tagging_old`, `asset_tagging_new`, `jenis_aset_old`, `jenis_aset_new`, `merk_old`, `merk_new`, `type_old`, `type_new`, `serial_number_old`, `serial_number_new`, `nama_old`, `nama_new`, `mapping_old`, `mapping_new`, `o365_old`, `o365_new`, `lokasi_old`, `lokasi_new`, `status_old`, `status_new`, `kondisi_old`, `kondisi_new`, `documentation_old`, `documentation_new`, `changed_at`, `action`, `keterangan`) VALUES
(1324, NULL, 107, NULL, 'Laptop', NULL, 11, NULL, NULL, NULL, NULL, NULL, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-30 06:44:45', 'CREATE', NULL),
(1325, 425, 107, 107, 'Laptop', 'Laptop', 11, 11, 'Windows 10 OHS i7-8324', 'Windows 10 OHS i7-8324', 'siadad', 'siadad', 39, 39, 'isuhad', 'isuhad', 'Partner License', 'Partner License', 'PT UNITED TRACTOR, Cakung, East Jakarta, Special capital Region of Jakarta, Java, Indonesia', 'PT UNITED TRACTOR, Cakung, East Jakarta, Special capital Region of Jakarta, Java, Indonesia', 'Operation', 'Operation', 'New', 'New', NULL, 'uploads/documentation/1727678753_handoverA.jpg', '2024-09-30 06:45:54', 'UPDATE', NULL),
(1326, NULL, 107, NULL, 'Laptop', NULL, 11, NULL, NULL, NULL, NULL, NULL, 39, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-30 06:45:54', 'UPDATE', NULL),
(1327, 425, 107, 107, 'Laptop', 'Laptop', 11, 11, 'Windows 10 OHS i7-8324', 'Windows 10 OHS i7-8324', 'siadad', 'siadad', 39, 39, 'isuhad', 'isuhad', 'Partner License', 'Partner License', 'PT UNITED TRACTOR, Cakung, East Jakarta, Special capital Region of Jakarta, Java, Indonesia', 'PT UNITED TRACTOR, Cakung, East Jakarta, Special capital Region of Jakarta, Java, Indonesia', 'Operation', 'Operation', 'New', 'New', 'uploads/documentation/1727678753_handoverA.jpg', 'uploads/documentation/1727678753_handoverA.jpg', '2024-09-30 06:48:11', 'UPDATE', NULL),
(1328, NULL, 107, NULL, 'Laptop', NULL, 11, NULL, NULL, NULL, NULL, NULL, 39, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-30 06:48:11', 'UPDATE', NULL),
(1329, 425, 107, NULL, 'Laptop', NULL, 11, NULL, 'Windows 10 OHS i7-8324', NULL, 'siadad', NULL, 39, NULL, 'isuhad', NULL, 'Partner License', NULL, 'PT UNITED TRACTOR, Cakung, East Jakarta, Special capital Region of Jakarta, Java, Indonesia', NULL, 'Operation', NULL, 'New', NULL, 'uploads/documentation/1727678753_handoverA.jpg', NULL, '2024-09-30 06:48:51', 'DELETE', NULL),
(1330, NULL, 107, NULL, 'Laptop', NULL, 11, NULL, NULL, NULL, NULL, NULL, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-30 06:48:51', 'DELETE', 'Damaged'),
(1331, NULL, 107, NULL, 'Laptop', NULL, 11, NULL, NULL, NULL, NULL, NULL, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-30 06:50:03', 'CREATE', NULL),
(1332, 426, 107, 107, 'Laptop', 'Laptop', 11, 11, 'Windows 10 OHS i7-8324', 'Windows 10 OHS i7-8324', 'siadad', 'siadad', 39, 39, 'isuhad', 'isuhad', 'Partner License', 'Partner License', 'PT UNITED TRACTOR, Cakung, East Jakarta, Special capital Region of Jakarta, Java, Indonesia', 'PT UNITED TRACTOR, Cakung, East Jakarta, Special capital Region of Jakarta, Java, Indonesia', 'Operation', 'Operation', 'New', 'New', NULL, 'uploads/documentation/1727679036_handoverB.jpg', '2024-09-30 06:50:36', 'UPDATE', NULL),
(1333, NULL, 107, NULL, 'Laptop', NULL, 11, NULL, NULL, NULL, NULL, NULL, 39, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-30 06:50:36', 'UPDATE', NULL),
(1334, NULL, 108, NULL, 'Laptop', NULL, 11, NULL, NULL, NULL, NULL, NULL, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-30 22:22:51', 'CREATE', NULL),
(1335, 426, 107, 107, 'Laptop', 'Laptop', 11, 11, 'Windows 10 OHS i7-8324', 'Windows 10 OHS i7-8324', 'siadad', 'siadad', 39, 39, 'isuhad', 'isuhad', 'Partner License', 'Partner License', 'PT UNITED TRACTOR, Cakung, East Jakarta, Special capital Region of Jakarta, Java, Indonesia', 'PT UNITED TRACTOR, Cakung, East Jakarta, Special capital Region of Jakarta, Java, Indonesia', 'Operation', 'Operation', 'New', 'New', 'uploads/documentation/1727679036_handoverB.jpg', 'uploads/documentation/1727679036_handoverB.jpg', '2024-10-02 08:26:20', 'UPDATE', NULL),
(1336, NULL, 107, NULL, 'Laptop', NULL, 11, NULL, NULL, NULL, NULL, NULL, 39, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-02 08:26:20', 'UPDATE', NULL),
(1337, 427, 108, 108, 'Laptop', 'Laptop', 11, 11, 'Windows 10 OHS i7-8324', 'Windows 10 OHS i7-8324', '23131412re', '23131412re', 39, 39, 'isuhad', 'isuhad', 'Partner License', 'Partner License', 'PT. PAMAPERSADA NUSANTARA, 9, Cakung, East Jakarta, Special capital Region of Jakarta, Java, Indonesia', 'PT. PAMAPERSADA NUSANTARA, 9, Cakung, East Jakarta, Special capital Region of Jakarta, Java, Indonesia', 'Operation', 'Operation', 'New', 'New', NULL, 'uploads/documentation/1727857630_pikaso_embed-removebg.png', '2024-10-02 08:27:11', 'UPDATE', NULL),
(1338, NULL, 108, NULL, 'Laptop', NULL, 11, NULL, NULL, NULL, NULL, NULL, 39, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-02 08:27:11', 'UPDATE', NULL),
(1339, 426, 107, NULL, 'Laptop', NULL, 11, NULL, 'Windows 10 OHS i7-8324', NULL, 'siadad', NULL, 39, NULL, 'isuhad', NULL, 'Partner License', NULL, 'PT UNITED TRACTOR, Cakung, East Jakarta, Special capital Region of Jakarta, Java, Indonesia', NULL, 'Operation', NULL, 'New', NULL, 'uploads/documentation/1727679036_handoverB.jpg', NULL, '2024-10-02 08:27:23', 'DELETE', NULL),
(1340, NULL, 107, NULL, 'Laptop', NULL, 11, NULL, NULL, NULL, NULL, NULL, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-02 08:27:23', 'DELETE', 'Damaged'),
(1341, NULL, 107, NULL, 'Laptop', NULL, 11, NULL, NULL, NULL, NULL, NULL, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-02 08:29:40', 'CREATE', NULL),
(1342, 428, 107, 107, 'Laptop', 'Laptop', 11, 11, 'Windows 10 OHS i7-8324', 'Windows 10 OHS i7-8324', 'siadad', 'siadad', 39, 39, 'isuhad', 'isuhad', 'Partner License', 'Partner License', 'PT UNITED TRACTOR, Cakung, East Jakarta, Special capital Region of Jakarta, Java, Indonesia', 'PT UNITED TRACTOR, Cakung, East Jakarta, Special capital Region of Jakarta, Java, Indonesia', 'Operation', 'Operation', 'New', 'New', NULL, 'uploads/documentation/1727857801_pikaso_embed.jpeg', '2024-10-02 08:30:01', 'UPDATE', NULL),
(1343, NULL, 107, NULL, 'Laptop', NULL, 11, NULL, NULL, NULL, NULL, NULL, 39, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-02 08:30:01', 'UPDATE', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `role` varchar(50) NOT NULL,
  `nrp` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `mapping` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `username`, `password`, `role`, `nrp`, `name`, `mapping`) VALUES
(13, 'chairudin@gmail.com', 'admin', 'admin', '12345', 'ADMIN', 'IT SUPPORT'),
(29, 'bagas@gmail.com', 'admin', 'admin', '1234', 'Dimas', 'DAD'),
(34, 'admin@gmail.com', 'admin', 'admin', '666', 'Fattan Malva', 'IT SUPPORT'),
(39, 'umar@gmail.com', '123', 'user', '9o86', 'UMAR', 'isuhad'),
(40, 'amin@gmail.com', '123', 'user', '76231936-', 'AMIN', 'IT Infrastructure'),
(41, 'budi@gmail.com', '123', 'user', '238648248h287y', 'BUDI', 'IT SUPPORT'),
(42, 'sales@gmail.com', '123', 'sales', '8888', 'A\'a Sales', 'sales'),
(43, 'cobalogin@gmail.com', '1234', 'user', 'sijdlfds', 'TEST REGISTER PAGE', 'lkcdf'),
(44, 'akufattan@gmail.com', '123', 'user', '124810912', 'Fattan Malva', 'IT Infrastructure');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `tagging` varchar(50) NOT NULL,
  `asets` varchar(200) NOT NULL,
  `merk` int(11) NOT NULL,
  `seri` varchar(50) NOT NULL,
  `tanggalmasuk` varchar(200) NOT NULL,
  `type` varchar(50) NOT NULL,
  `kondisi` varchar(200) NOT NULL,
  `status` enum('Operation','Inventory') NOT NULL DEFAULT 'Inventory',
  `lokasi` varchar(255) DEFAULT NULL,
  `tanggal_diterima` datetime DEFAULT NULL,
  `maintenance` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `tagging`, `asets`, `merk`, `seri`, `tanggalmasuk`, `type`, `kondisi`, `status`, `lokasi`, `tanggal_diterima`, `maintenance`) VALUES
(107, 'LAP-001', 'Laptop', 11, 'siadad', '27-09-2024', 'Windows 10 OHS i7-8324', 'Good', 'Operation', 'PT UNITED TRACTOR, Cakung, East Jakarta, Special capital Region of Jakarta, Java, Indonesia', '2024-10-02 08:30:01', '2024-09-30'),
(108, 'LAP-002', 'Laptop', 11, '23131412re', '27-09-2024', 'Windows 10 OHS i7-8324', 'New', 'Operation', 'PT. PAMAPERSADA NUSANTARA, 9, Cakung, East Jakarta, Special capital Region of Jakarta, Java, Indonesia', '2024-10-02 08:27:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_history`
--

CREATE TABLE `inventory_history` (
  `id` int(11) NOT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `action` enum('INSERT','DELETE') NOT NULL,
  `tagging` varchar(50) DEFAULT NULL,
  `asets` varchar(200) DEFAULT NULL,
  `merk` int(11) DEFAULT NULL,
  `seri` varchar(50) DEFAULT NULL,
  `tanggalmasuk` varchar(200) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `kondisi` varchar(200) DEFAULT NULL,
  `status` enum('Operation','Inventory') DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `tanggal_diterima` datetime DEFAULT NULL,
  `action_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `documentation` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_history`
--

INSERT INTO `inventory_history` (`id`, `inventory_id`, `action`, `tagging`, `asets`, `merk`, `seri`, `tanggalmasuk`, `type`, `kondisi`, `status`, `lokasi`, `tanggal_diterima`, `action_time`, `documentation`) VALUES
(54, 118, 'INSERT', 'coba entry dan scrap', 'Laptop', 11, '1213464567', '2024-10-01', 'Windows 10 OHS i7-8324', 'New', NULL, NULL, NULL, '2024-10-01 02:02:24', 'documentation/1727748144_Screenshot (250).png'),
(55, 118, 'DELETE', 'coba entry dan scrap', 'Laptop', 11, '1213464567', '2024-10-01', 'Windows 10 OHS i7-8324', 'New', 'Inventory', NULL, NULL, '2024-10-01 02:02:44', 'documentation/1727748164_Screenshot (253).png'),
(56, 119, 'INSERT', 'COBA', 'Laptop', 11, '124325252', '2024-10-25', 'Windows 10 OHS i7-8324', 'New', NULL, NULL, NULL, '2024-10-01 02:07:04', 'documentation/1727748424_Screenshot (253).png'),
(57, 120, 'INSERT', 'kiufgwev', 'Laptop', 11, '231432', '2024-10-01', 'Windows 10 OHS i7-8324', 'New', NULL, NULL, NULL, '2024-10-01 02:07:31', 'documentation/1727748450_Screenshot (251).png'),
(58, 119, 'DELETE', 'COBA', 'Laptop', 11, '124325252', '2024-10-25', 'Windows 10 OHS i7-8324', 'New', 'Inventory', NULL, NULL, '2024-10-01 02:07:56', 'documentation/1727748476_Screenshot (248).png'),
(59, 120, 'DELETE', 'kiufgwev', 'Laptop', 11, '231432', '2024-10-01', 'Windows 10 OHS i7-8324', 'New', 'Inventory', NULL, NULL, '2024-10-01 02:07:56', 'documentation/1727748476_Screenshot (248).png');

-- --------------------------------------------------------

--
-- Table structure for table `merk`
--

CREATE TABLE `merk` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merk`
--

INSERT INTO `merk` (`id`, `name`) VALUES
(11, 'Dell'),
(13, 'Avanza'),
(14, 'HP');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `asset_name` varchar(255) DEFAULT NULL,
  `merk_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `total_quantity` int(11) DEFAULT NULL,
  `operation` int(11) DEFAULT NULL,
  `inventory` int(11) DEFAULT NULL,
  `good` int(11) DEFAULT NULL,
  `exception` int(11) DEFAULT NULL,
  `bad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`id`, `asset_name`, `merk_name`, `location`, `total_quantity`, `operation`, `inventory`, `good`, `exception`, `bad`) VALUES
(27, NULL, 'Samsung', 'HO', 0, 4, -4, 4, 0, 0),
(28, NULL, 'Lenovo', 'HO', 0, 4, -4, 4, 0, 0),
(29, NULL, 'Macbook', 'HO', 0, 4, -4, 4, 0, 0),
(30, NULL, 'Macbook', NULL, 0, 1, -1, 0, 1, 0),
(31, NULL, 'Macbook', 'kjqgciq', 0, 2, -2, 0, 2, 0),
(32, NULL, 'HP', 'liugiuf', 0, 1, -1, 0, 1, 0),
(33, NULL, 'DELL', 'oiphp', 0, 1, -1, 1, 0, 0),
(34, NULL, 'DELL', 'oigpi', 0, 1, -1, 1, 0, 0),
(35, NULL, 'DELL', 'iugui', 0, 2, -2, 2, 0, 0),
(36, NULL, 'Samsung', '/lkdhs;ch', 0, 1, -1, 1, 0, 0),
(37, NULL, 'DELL', 'PAMA', 0, 1, -1, 1, 0, 0),
(38, NULL, 'HP', 'HO', 0, 1, -1, 1, 0, 0),
(39, NULL, 'Samsung', 'HO', 0, 1, -1, 1, 0, 0),
(40, NULL, 'Lenovo', 'HO', 0, 1, -1, 1, 0, 0),
(41, NULL, 'Macbook', 'PAMA', 0, 1, -1, 1, 0, 0),
(42, NULL, 'DELL', 'HO', 0, 2, -2, 2, 0, 0),
(43, NULL, 'HP', 'HO', 0, 2, -2, 2, 0, 0),
(44, NULL, 'Samsung', 'HO', 0, 2, -2, 2, 0, 0),
(45, NULL, 'Lenovo', 'PAMA', 0, 2, -2, 2, 0, 0),
(46, NULL, 'Macbook', 'HO', 0, 2, -2, 2, 0, 0),
(47, NULL, 'DELL', 'HO', 0, 3, -3, 3, 0, 0),
(48, NULL, 'HP', 'HO', 0, 3, -3, 3, 0, 0),
(49, NULL, 'Samsung', 'PAMA', 0, 3, -3, 3, 0, 0),
(50, NULL, 'Lenovo', 'HO', 0, 3, -3, 3, 0, 0),
(51, NULL, 'Macbook', 'HO', 0, 3, -3, 3, 0, 0),
(52, NULL, 'DELL', 'HO', 0, 4, -4, 4, 0, 0),
(53, NULL, 'HP', 'PAMA', 0, 4, -4, 4, 0, 0),
(54, NULL, 'Samsung', 'HO', 0, 4, -4, 4, 0, 0),
(55, NULL, 'Lenovo', 'HO', 0, 4, -4, 4, 0, 0),
(56, NULL, 'Macbook', 'HO', 0, 4, -4, 4, 0, 0),
(57, NULL, 'DELL', 'PAMA', 0, 5, -5, 5, 0, 0),
(58, NULL, 'DELL', 'PAMA', 0, 6, -6, 6, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `departement` varchar(200) NOT NULL,
  `lokasi` varchar(200) NOT NULL,
  `nama_asset` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `nama`, `departement`, `lokasi`, `nama_asset`, `status`, `description`, `created_at`) VALUES
(40, 'A\'a Sales', 'sales', 'PT PAMA PERSADA', 'Laptop', 'Pending', 'minta yang paling bagus', '2024-09-19 00:54:11'),
(41, 'A\'a Sales', 'sales', 'PT PAMA PERSADA', 'Laptop', 'Pending', 'minta yang paling bagus', '2024-09-19 00:56:02');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nohp` varchar(12) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `nrp` varchar(50) NOT NULL,
  `mapping` varchar(50) NOT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `after_user_insert` AFTER INSERT ON `user` FOR EACH ROW BEGIN
    -- Menambahkan data customer
    INSERT INTO customer (nrp, name, mapping)
    VALUES (NEW.nrp, NEW.nama, NEW.mapping);
    
    -- Mengupdate customer_id di tabel user dengan ID customer yang baru dibuat
    SET @customer_id = LAST_INSERT_ID();
    
    UPDATE user
    SET customer_id = @customer_id
    WHERE id = NEW.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL,
  `plat_nomor` varchar(200) NOT NULL,
  `nama` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `plat_nomor`, `nama`) VALUES
(2, 'AG 3252 EF', 'PAJERO');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_lending`
--

CREATE TABLE `vehicle_lending` (
  `id` int(11) NOT NULL,
  `id_nama_peminjam` int(11) NOT NULL,
  `id_plat_nomor` int(11) NOT NULL,
  `tanggal_berangkat` varchar(200) NOT NULL,
  `tanggal_pulang` varchar(200) NOT NULL,
  `waktu_berangkat` varchar(200) NOT NULL,
  `waktu_pulang` varchar(200) NOT NULL,
  `tujuan` varchar(200) NOT NULL,
  `keperluan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_lending`
--

INSERT INTO `vehicle_lending` (`id`, `id_nama_peminjam`, `id_plat_nomor`, `tanggal_berangkat`, `tanggal_pulang`, `waktu_berangkat`, `waktu_pulang`, `tujuan`, `keperluan`) VALUES
(1, 39, 2, 'sdcl', 'asc', '9023', '2032', 'cakung', 'beli idea hub');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_tagging` (`asset_tagging`),
  ADD KEY `merk` (`merk`),
  ADD KEY `nama` (`nama`);

--
-- Indexes for table `asset_history`
--
ALTER TABLE `asset_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merk` (`merk`);

--
-- Indexes for table `inventory_history`
--
ALTER TABLE `inventory_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `merk`
--
ALTER TABLE `merk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer` (`customer_id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_lending`
--
ALTER TABLE `vehicle_lending`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer_mobil` (`id_nama_peminjam`),
  ADD KEY `fk_mobil` (`id_plat_nomor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=429;

--
-- AUTO_INCREMENT for table `asset_history`
--
ALTER TABLE `asset_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1344;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `inventory_history`
--
ALTER TABLE `inventory_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `merk`
--
ALTER TABLE `merk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vehicle_lending`
--
ALTER TABLE `vehicle_lending`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_ibfk_1` FOREIGN KEY (`asset_tagging`) REFERENCES `inventory` (`id`),
  ADD CONSTRAINT `assets_ibfk_2` FOREIGN KEY (`merk`) REFERENCES `merk` (`id`),
  ADD CONSTRAINT `assets_ibfk_3` FOREIGN KEY (`nama`) REFERENCES `customer` (`id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`merk`) REFERENCES `merk` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);

--
-- Constraints for table `vehicle_lending`
--
ALTER TABLE `vehicle_lending`
  ADD CONSTRAINT `fk_customer_mobil` FOREIGN KEY (`id_nama_peminjam`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `fk_mobil` FOREIGN KEY (`id_plat_nomor`) REFERENCES `vehicle` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
