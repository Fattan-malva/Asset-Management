-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Agu 2024 pada 06.46
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

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
-- Struktur dari tabel `assets`
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `assets`
--

INSERT INTO `assets` (`id`, `asset_tagging`, `jenis_aset`, `merk`, `type`, `serial_number`, `nama`, `mapping`, `o365`, `lokasi`, `status`, `kondisi`, `approval_status`, `aksi`, `documentation`, `previous_customer_name`, `created_at`, `updated_at`) VALUES
(179, 59, 'Tablet', 8, '-', '987654321', 34, 'IT SUPPORT', 'Partner License', 'HO', 'Operation', 'Good', 'Approved', 'Rollback', 'uploads/documentation/1724656312.png', NULL, '2024-08-26 00:11:03', '2024-08-26 19:17:34'),
(185, 54, 'PC', 8, '-', '9137409832', 34, 'IT SUPPORT', 'Partner License', 'HO', 'Operation', 'Good', 'Approved', 'Rollback', 'uploads/documentation/1724722917.png', NULL, '2024-08-26 18:04:38', '2024-08-26 19:17:41'),
(187, 52, 'Tablet', 8, '-', '97321731', 34, 'IT SUPPORT', 'Partner License', 'HO', 'Operation', 'Good', 'Approved', 'Rollback', 'uploads/documentation/1724724306.png', NULL, '2024-08-26 19:00:30', '2024-08-26 19:17:46');

--
-- Trigger `assets`
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
        action
    )
    VALUES (
        OLD.asset_tagging, 
        OLD.merk, 
        OLD.nama, 
        OLD.jenis_aset, 
        NOW(), 
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `asset_history`
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
  `kondisi_old` enum('Good','Exception','Bad') DEFAULT NULL,
  `kondisi_new` enum('Good','Exception','Bad') DEFAULT NULL,
  `documentation_old` varchar(255) DEFAULT NULL,
  `documentation_new` varchar(255) DEFAULT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `action` enum('INSERT','UPDATE','DELETE') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `asset_history`
--

INSERT INTO `asset_history` (`id`, `asset_id`, `asset_tagging_old`, `asset_tagging_new`, `jenis_aset_old`, `jenis_aset_new`, `merk_old`, `merk_new`, `type_old`, `type_new`, `serial_number_old`, `serial_number_new`, `nama_old`, `nama_new`, `mapping_old`, `mapping_new`, `o365_old`, `o365_new`, `lokasi_old`, `lokasi_new`, `status_old`, `status_new`, `kondisi_old`, `kondisi_new`, `documentation_old`, `documentation_new`, `changed_at`, `action`) VALUES
(1044, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-22 08:29:39', ''),
(1045, 165, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'PAMA MILIK FATTAN', 'PAMA MILIK FATTAN', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724315412.png', '2024-08-22 08:30:12', 'UPDATE'),
(1046, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-22 08:30:12', 'UPDATE'),
(1047, 165, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 34, 'DAD', 'IT SUPPORT', 'Partner License', 'Partner License', 'PAMA MILIK FATTAN', 'PAMA MILIK FATTAN', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724315412.png', 'uploads/documentation/1724315412.png', '2024-08-22 08:30:57', 'UPDATE'),
(1048, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-22 08:30:57', 'UPDATE'),
(1049, 165, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'PAMA MILIK FATTAN', 'PAMA MILIK FATTAN', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724315412.png', 'uploads/documentation/1724315521.png', '2024-08-22 08:32:01', 'UPDATE'),
(1050, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-22 08:32:01', 'UPDATE'),
(1051, 165, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'PAMA MILIK FATTAN', 'PAMA MILIK FATTAN', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724315521.png', 'uploads/documentation/1724315521.png', '2024-08-22 08:32:34', 'UPDATE'),
(1052, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-22 08:32:34', 'UPDATE'),
(1053, 165, 43, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1234', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'PAMA MILIK FATTAN', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724315521.png', NULL, '2024-08-22 08:32:59', 'DELETE'),
(1054, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-22 08:32:59', 'DELETE'),
(1055, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-23 12:19:11', ''),
(1056, 166, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724415602.png', '2024-08-23 12:20:03', 'UPDATE'),
(1057, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-23 12:20:03', 'UPDATE'),
(1058, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-23 12:20:27', ''),
(1059, NULL, 49, NULL, '-', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-24 18:50:44', ''),
(1060, 168, 49, 49, '-', '-', 8, 8, 'dqwojqwoc', 'dqwojqwoc', '09900', '09900', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724525694.png', '2024-08-24 18:54:54', 'UPDATE'),
(1061, NULL, 49, NULL, '-', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-24 18:54:54', 'UPDATE'),
(1062, 167, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724526035.png', '2024-08-24 19:00:35', 'UPDATE'),
(1063, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-24 19:00:35', 'UPDATE'),
(1064, 168, 49, 49, '-', '-', 8, 8, 'dqwojqwoc', 'dqwojqwoc', '09900', '09900', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724525694.png', 'uploads/documentation/1724525694.png', '2024-08-24 19:28:12', 'UPDATE'),
(1065, NULL, 49, NULL, '-', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-24 19:28:12', 'UPDATE'),
(1066, 168, 49, 49, '-', '-', 8, 8, 'dqwojqwoc', 'dqwojqwoc', '09900', '09900', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724525694.png', 'uploads/documentation/1724525694.png', '2024-08-24 19:36:18', 'UPDATE'),
(1067, NULL, 49, NULL, '-', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-24 19:36:18', 'UPDATE'),
(1068, 168, 49, 49, '-', '-', 8, 8, 'dqwojqwoc', 'dqwojqwoc', '09900', '09900', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724525694.png', 'uploads/documentation/1724525694.png', '2024-08-24 19:36:34', 'UPDATE'),
(1069, NULL, 49, NULL, '-', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-24 19:36:34', 'UPDATE'),
(1070, 168, 49, 49, '-', '-', 8, 8, 'dqwojqwoc', 'dqwojqwoc', '09900', '09900', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724525694.png', 'documents/1724635633_Screenshot (250).png', '2024-08-26 01:27:13', 'UPDATE'),
(1071, NULL, 49, NULL, '-', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 01:27:13', 'UPDATE'),
(1072, 168, 49, NULL, '-', NULL, 8, NULL, 'dqwojqwoc', NULL, '09900', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'HO', NULL, 'Operation', NULL, 'Good', NULL, 'documents/1724635633_Screenshot (250).png', NULL, '2024-08-26 01:46:38', 'DELETE'),
(1073, NULL, 49, NULL, '-', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 01:46:38', 'DELETE'),
(1074, 166, 43, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1234', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'HO', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724415602.png', NULL, '2024-08-26 01:51:19', 'DELETE'),
(1075, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 01:51:19', 'DELETE'),
(1076, 167, 44, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '12345677', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'HO', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724526035.png', NULL, '2024-08-26 01:51:19', 'DELETE'),
(1077, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 01:51:19', 'DELETE'),
(1078, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 01:52:47', ''),
(1079, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 01:52:59', ''),
(1080, NULL, 49, NULL, '-', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 01:53:19', ''),
(1081, 170, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724637380.png', '2024-08-26 01:56:21', 'UPDATE'),
(1082, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 01:56:21', 'UPDATE'),
(1083, 170, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724637380.png', 'uploads/documentation/1724637380.png', '2024-08-26 01:57:23', 'UPDATE'),
(1084, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 01:57:23', 'UPDATE'),
(1085, 171, 49, 49, '-', '-', 8, 8, 'dqwojqwoc', 'dqwojqwoc', '09900', '09900', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'PAMA', 'PAMA', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724637465.png', '2024-08-26 01:57:45', 'UPDATE'),
(1086, NULL, 49, NULL, '-', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 01:57:45', 'UPDATE'),
(1087, 171, 49, 49, '-', '-', 8, 8, 'dqwojqwoc', 'dqwojqwoc', '09900', '09900', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'PAMA', 'PAMA', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724637465.png', 'documents/1724637493_Screenshot (249).png', '2024-08-26 01:58:13', 'UPDATE'),
(1088, NULL, 49, NULL, '-', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 01:58:13', 'UPDATE'),
(1089, NULL, 50, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 02:18:56', ''),
(1090, NULL, 51, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 02:19:07', ''),
(1091, 172, 50, 50, 'Laptop', 'Laptop', 8, 8, '-', '-', '93240274', '93240274', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724638765.png', '2024-08-26 02:19:25', 'UPDATE'),
(1092, NULL, 50, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 02:19:25', 'UPDATE'),
(1093, 173, 51, 51, 'Laptop', 'Laptop', 8, 8, '-', '-', '1842696', '1842696', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724638776.png', '2024-08-26 02:19:36', 'UPDATE'),
(1094, NULL, 51, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 02:19:36', 'UPDATE'),
(1095, 169, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724643149.png', '2024-08-26 03:32:29', 'UPDATE'),
(1096, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 03:32:29', 'UPDATE'),
(1097, 169, 43, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1234', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'DAD', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724643149.png', NULL, '2024-08-26 04:01:37', 'DELETE'),
(1098, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 04:01:37', 'DELETE'),
(1099, 170, 44, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '12345677', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'HO', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724637380.png', NULL, '2024-08-26 04:01:37', 'DELETE'),
(1100, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 04:01:37', 'DELETE'),
(1101, 171, 49, NULL, '-', NULL, 8, NULL, 'dqwojqwoc', NULL, '09900', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'PAMA', NULL, 'Operation', NULL, 'Good', NULL, 'documents/1724637493_Screenshot (249).png', NULL, '2024-08-26 04:01:37', 'DELETE'),
(1102, NULL, 49, NULL, '-', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 04:01:37', 'DELETE'),
(1103, 172, 50, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '93240274', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'DAD', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724638765.png', NULL, '2024-08-26 04:01:37', 'DELETE'),
(1104, NULL, 50, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 04:01:37', 'DELETE'),
(1105, 173, 51, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1842696', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'HO', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724638776.png', NULL, '2024-08-26 04:01:37', 'DELETE'),
(1106, NULL, 51, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 04:01:37', 'DELETE'),
(1107, NULL, 52, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 04:03:31', ''),
(1108, 174, 52, 52, 'Tablet', 'Tablet', 8, 8, '-', '-', '97321731', '97321731', 13, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-26 04:04:07', 'UPDATE'),
(1109, NULL, 52, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 13, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 04:04:07', 'UPDATE'),
(1110, 174, 52, 52, 'Tablet', 'Tablet', 8, 8, '-', '-', '97321731', '97321731', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724645059.png', '2024-08-26 04:04:19', 'UPDATE'),
(1111, NULL, 52, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 04:04:19', 'UPDATE'),
(1112, NULL, 53, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 04:06:25', ''),
(1113, NULL, 54, NULL, 'PC', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 04:06:46', ''),
(1114, 175, 53, 53, 'Laptop', 'Laptop', 8, 8, '-', '-', '8932604', '8932604', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724645221.png', '2024-08-26 04:07:01', 'UPDATE'),
(1115, NULL, 53, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 04:07:01', 'UPDATE'),
(1116, 176, 54, 54, 'PC', 'PC', 8, 8, '-', '-', '9137409832', '9137409832', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724645230.png', '2024-08-26 04:07:10', 'UPDATE'),
(1117, NULL, 54, NULL, 'PC', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 04:07:10', 'UPDATE'),
(1118, NULL, 55, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 04:27:09', ''),
(1119, 177, 55, 55, 'Laptop', 'Laptop', 8, 8, '-', '-', '9283743027', '9283743027', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724646743.png', '2024-08-26 04:32:23', 'UPDATE'),
(1120, NULL, 55, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 04:32:23', 'UPDATE'),
(1121, NULL, 56, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 06:12:44', ''),
(1122, 178, 56, 56, 'Laptop', 'Laptop', 8, 8, '-', '-', '725214619', '725214619', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724653411.png', '2024-08-26 06:23:31', 'UPDATE'),
(1123, NULL, 56, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 06:23:31', 'UPDATE'),
(1124, 174, 52, NULL, 'Tablet', NULL, 8, NULL, '-', NULL, '97321731', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'HO', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724645059.png', NULL, '2024-08-26 06:50:15', 'DELETE'),
(1125, NULL, 52, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 06:50:15', 'DELETE'),
(1126, 175, 53, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '8932604', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'HO', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724645221.png', NULL, '2024-08-26 06:50:15', 'DELETE'),
(1127, NULL, 53, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 06:50:15', 'DELETE'),
(1128, 176, 54, NULL, 'PC', NULL, 8, NULL, '-', NULL, '9137409832', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'HO', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724645230.png', NULL, '2024-08-26 06:50:15', 'DELETE'),
(1129, NULL, 54, NULL, 'PC', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 06:50:15', 'DELETE'),
(1130, 177, 55, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '9283743027', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'HO', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724646743.png', NULL, '2024-08-26 06:50:15', 'DELETE'),
(1131, NULL, 55, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 06:50:15', 'DELETE'),
(1132, 178, 56, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '725214619', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'DAD', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724653411.png', NULL, '2024-08-26 06:50:15', 'DELETE'),
(1133, NULL, 56, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 06:50:15', 'DELETE'),
(1134, NULL, 59, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 07:11:03', ''),
(1135, 179, 59, 59, 'Tablet', 'Tablet', 8, 8, '-', '-', '987654321', '987654321', 13, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-26 07:11:39', 'UPDATE'),
(1136, NULL, 59, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 13, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 07:11:39', 'UPDATE'),
(1137, 179, 59, 59, 'Tablet', 'Tablet', 8, 8, '-', '-', '987654321', '987654321', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724656312.png', '2024-08-26 07:11:52', 'UPDATE'),
(1138, NULL, 59, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 07:11:52', 'UPDATE'),
(1139, NULL, 52, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 07:57:57', ''),
(1140, 180, 52, 52, 'Tablet', 'Tablet', 8, 8, '-', '-', '97321731', '97321731', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724659089.png', '2024-08-26 07:58:09', 'UPDATE'),
(1141, NULL, 52, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 07:58:09', 'UPDATE'),
(1142, 180, 52, 52, 'Tablet', 'Tablet', 8, 8, '-', '-', '97321731', '97321731', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724659089.png', 'uploads/documentation/1724659089.png', '2024-08-26 08:37:08', 'UPDATE'),
(1143, NULL, 52, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 08:37:08', 'UPDATE'),
(1144, 179, 59, 59, 'Tablet', 'Tablet', 8, 8, '-', '-', '987654321', '987654321', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724656312.png', 'uploads/documentation/1724656312.png', '2024-08-26 08:38:02', 'UPDATE'),
(1145, NULL, 59, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 08:38:02', 'UPDATE'),
(1146, 179, 59, 59, 'Tablet', 'Tablet', 8, 8, '-', '-', '987654321', '987654321', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724656312.png', 'uploads/documentation/1724656312.png', '2024-08-26 08:38:39', 'UPDATE'),
(1147, NULL, 59, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 08:38:39', 'UPDATE'),
(1148, 180, 52, NULL, 'Tablet', NULL, 8, NULL, '-', NULL, '97321731', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'HO', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724659089.png', NULL, '2024-08-26 08:38:51', 'DELETE'),
(1149, NULL, 52, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 08:38:51', 'DELETE'),
(1150, 179, 59, 59, 'Tablet', 'Tablet', 8, 8, '-', '-', '987654321', '987654321', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724656312.png', 'uploads/documentation/1724656312.png', '2024-08-26 08:39:00', 'UPDATE'),
(1151, NULL, 59, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 08:39:00', 'UPDATE'),
(1152, NULL, 52, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 08:42:53', ''),
(1153, NULL, 53, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 09:12:33', ''),
(1154, NULL, 54, NULL, 'PC', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 09:21:39', ''),
(1155, 183, 54, 54, 'PC', 'PC', 8, 8, '-', '-', '9137409832', '9137409832', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-26 09:23:07', 'UPDATE'),
(1156, NULL, 54, NULL, 'PC', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 09:23:07', 'UPDATE'),
(1157, 182, 53, 53, 'Laptop', 'Laptop', 8, 8, '-', '-', '8932604', '8932604', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Business', 'Business', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-26 09:23:10', 'UPDATE'),
(1158, NULL, 53, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 09:23:10', 'UPDATE'),
(1159, 182, 53, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '8932604', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Business', NULL, 'HO', NULL, 'Operation', NULL, 'Good', NULL, NULL, NULL, '2024-08-26 09:23:18', 'DELETE'),
(1160, NULL, 53, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 09:23:18', 'DELETE'),
(1161, 183, 54, NULL, 'PC', NULL, 8, NULL, '-', NULL, '9137409832', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'HO', NULL, 'Operation', NULL, 'Good', NULL, NULL, NULL, '2024-08-26 09:23:23', 'DELETE'),
(1162, NULL, 54, NULL, 'PC', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 09:23:23', 'DELETE'),
(1163, NULL, 53, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 09:27:45', ''),
(1164, NULL, 54, NULL, 'PC', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 01:04:38', ''),
(1165, 185, 54, 54, 'PC', 'PC', 8, 8, '-', '-', '9137409832', '9137409832', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724722917.png', '2024-08-27 01:41:58', 'UPDATE'),
(1166, NULL, 54, NULL, 'PC', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 01:41:58', 'UPDATE'),
(1167, NULL, 55, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 01:42:59', ''),
(1168, 186, 55, 55, 'Laptop', 'Laptop', 8, 8, '-', '-', '9283743027', '9283743027', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-27 01:59:27', 'UPDATE'),
(1169, NULL, 55, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 01:59:27', 'UPDATE'),
(1170, 184, 53, 53, 'Laptop', 'Laptop', 8, 8, '-', '-', '8932604', '8932604', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-27 01:59:32', 'UPDATE'),
(1171, NULL, 53, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 01:59:32', 'UPDATE'),
(1172, 181, 52, 52, 'Tablet', 'Tablet', 8, 8, '-', '-', '97321731', '97321731', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-27 01:59:36', 'UPDATE'),
(1173, NULL, 52, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 01:59:36', 'UPDATE'),
(1174, 186, 55, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '9283743027', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'DAD', NULL, 'Operation', NULL, 'Good', NULL, NULL, NULL, '2024-08-27 02:00:08', 'DELETE'),
(1175, NULL, 55, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:00:08', 'DELETE'),
(1176, 184, 53, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '8932604', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'DAD', NULL, 'Operation', NULL, 'Good', NULL, NULL, NULL, '2024-08-27 02:00:13', 'DELETE'),
(1177, NULL, 53, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:00:13', 'DELETE'),
(1178, 181, 52, NULL, 'Tablet', NULL, 8, NULL, '-', NULL, '97321731', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'HO', NULL, 'Operation', NULL, 'Good', NULL, NULL, NULL, '2024-08-27 02:00:17', 'DELETE'),
(1179, NULL, 52, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:00:17', 'DELETE'),
(1180, NULL, 52, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:00:30', ''),
(1181, NULL, 53, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:01:41', ''),
(1182, 188, 53, 53, 'Laptop', 'Laptop', 8, 8, '-', '-', '8932604', '8932604', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724724249.png', '2024-08-27 02:04:09', 'UPDATE'),
(1183, NULL, 53, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:04:09', 'UPDATE'),
(1184, 188, 53, 53, 'Laptop', 'Laptop', 8, 8, '-', '-', '8932604', '8932604', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724724249.png', 'uploads/documentation/1724724253.png', '2024-08-27 02:04:13', 'UPDATE'),
(1185, NULL, 53, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:04:13', 'UPDATE'),
(1186, 187, 52, 52, 'Tablet', 'Tablet', 8, 8, '-', '-', '97321731', '97321731', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724724306.png', '2024-08-27 02:05:06', 'UPDATE'),
(1187, NULL, 52, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:05:06', 'UPDATE'),
(1188, 188, 53, 53, 'Laptop', 'Laptop', 8, 8, '-', '-', '8932604', '8932604', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724724253.png', 'uploads/documentation/1724724253.png', '2024-08-27 02:12:18', 'UPDATE'),
(1189, NULL, 53, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:12:18', 'UPDATE'),
(1190, 188, 53, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '8932604', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'DAD', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724724253.png', NULL, '2024-08-27 02:12:38', 'DELETE'),
(1191, NULL, 53, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:12:38', 'DELETE'),
(1192, 187, 52, 52, 'Tablet', 'Tablet', 8, 8, '-', '-', '97321731', '97321731', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724724306.png', 'uploads/documentation/1724724306.png', '2024-08-27 02:13:28', 'UPDATE'),
(1193, NULL, 52, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:13:28', 'UPDATE'),
(1194, 185, 54, 54, 'PC', 'PC', 8, 8, '-', '-', '9137409832', '9137409832', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724722917.png', 'uploads/documentation/1724722917.png', '2024-08-27 02:16:02', 'UPDATE'),
(1195, NULL, 54, NULL, 'PC', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:16:02', 'UPDATE'),
(1196, 179, 59, 59, 'Tablet', 'Tablet', 8, 8, '-', '-', '987654321', '987654321', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724656312.png', 'uploads/documentation/1724656312.png', '2024-08-27 02:16:16', 'UPDATE'),
(1197, NULL, 59, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:16:16', 'UPDATE'),
(1198, 187, 52, 52, 'Tablet', 'Tablet', 8, 8, '-', '-', '97321731', '97321731', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724724306.png', 'uploads/documentation/1724724306.png', '2024-08-27 02:16:36', 'UPDATE'),
(1199, NULL, 52, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:16:36', 'UPDATE'),
(1200, 185, 54, 54, 'PC', 'PC', 8, 8, '-', '-', '9137409832', '9137409832', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724722917.png', 'uploads/documentation/1724722917.png', '2024-08-27 02:16:41', 'UPDATE'),
(1201, NULL, 54, NULL, 'PC', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:16:41', 'UPDATE'),
(1202, 179, 59, 59, 'Tablet', 'Tablet', 8, 8, '-', '-', '987654321', '987654321', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724656312.png', 'uploads/documentation/1724656312.png', '2024-08-27 02:16:46', 'UPDATE'),
(1203, NULL, 59, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:16:46', 'UPDATE'),
(1204, 179, 59, 59, 'Tablet', 'Tablet', 8, 8, '-', '-', '987654321', '987654321', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724656312.png', 'uploads/documentation/1724656312.png', '2024-08-27 02:17:34', 'UPDATE'),
(1205, NULL, 59, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:17:34', 'UPDATE'),
(1206, 185, 54, 54, 'PC', 'PC', 8, 8, '-', '-', '9137409832', '9137409832', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724722917.png', 'uploads/documentation/1724722917.png', '2024-08-27 02:17:41', 'UPDATE'),
(1207, NULL, 54, NULL, 'PC', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:17:41', 'UPDATE'),
(1208, 187, 52, 52, 'Tablet', 'Tablet', 8, 8, '-', '-', '97321731', '97321731', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724724306.png', 'uploads/documentation/1724724306.png', '2024-08-27 02:17:46', 'UPDATE'),
(1209, NULL, 52, NULL, 'Tablet', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 02:17:46', 'UPDATE');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
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
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id`, `username`, `password`, `role`, `nrp`, `name`, `mapping`) VALUES
(13, 'admin@gmail.com', 'admin', 'admin', '12345', 'ADMIN', 'IT SUPPORT'),
(29, 'Dimas@gmail.com', '123', 'user', '1234', 'Dimas', 'DAD'),
(34, 'fattan@gmail.com', 'fattan', 'user', '666', 'Fattan Malva', 'IT SUPPORT');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `tagging` varchar(50) NOT NULL,
  `asets` varchar(200) NOT NULL,
  `merk` int(11) NOT NULL,
  `seri` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `kondisi` varchar(200) NOT NULL,
  `status` enum('Operation','Inventory') NOT NULL DEFAULT 'Inventory'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `inventory`
--

INSERT INTO `inventory` (`id`, `tagging`, `asets`, `merk`, `seri`, `type`, `kondisi`, `status`) VALUES
(52, 'TAB-0001', 'Tablet', 8, '97321731', '-', 'Good', 'Operation'),
(53, 'LAP-0001', 'Laptop', 8, '8932604', '-', 'Good', 'Inventory'),
(54, 'PC-0001', 'PC', 8, '9137409832', '-', 'Good', 'Operation'),
(55, 'LAP-0002', 'Laptop', 8, '9283743027', '-', 'Good', 'Inventory'),
(56, 'LAP-0003', 'Laptop', 8, '725214619', '-', 'Good', 'Inventory'),
(57, 'LAP-0004', 'Laptop', 8, '987', '-', 'Good', 'Inventory'),
(58, 'LAP-0005', 'Laptop', 8, '123456789', '-', 'Good', 'Inventory'),
(59, 'TAB-0002', 'Tablet', 8, '987654321', '-', 'Good', 'Operation'),
(60, 'PC-0002', 'PC', 8, '1122334455', '-', 'Good', 'Inventory'),
(61, 'LAP-0006', 'Laptop', 8, '5566778899', '-', 'Good', 'Inventory');

-- --------------------------------------------------------

--
-- Struktur dari tabel `merk`
--

CREATE TABLE `merk` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `merk`
--

INSERT INTO `merk` (`id`, `name`) VALUES
(8, 'Dell');

-- --------------------------------------------------------

--
-- Struktur dari tabel `report`
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
-- Dumping data untuk tabel `report`
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
-- Struktur dari tabel `user`
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
-- Trigger `user`
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

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_tagging` (`asset_tagging`),
  ADD KEY `merk` (`merk`),
  ADD KEY `nama` (`nama`);

--
-- Indeks untuk tabel `asset_history`
--
ALTER TABLE `asset_history`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merk` (`merk`);

--
-- Indeks untuk tabel `merk`
--
ALTER TABLE `merk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer` (`customer_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT untuk tabel `asset_history`
--
ALTER TABLE `asset_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1210;

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT untuk tabel `merk`
--
ALTER TABLE `merk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_ibfk_1` FOREIGN KEY (`asset_tagging`) REFERENCES `inventory` (`id`),
  ADD CONSTRAINT `assets_ibfk_2` FOREIGN KEY (`merk`) REFERENCES `merk` (`id`),
  ADD CONSTRAINT `assets_ibfk_3` FOREIGN KEY (`nama`) REFERENCES `customer` (`id`);

--
-- Ketidakleluasaan untuk tabel `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`merk`) REFERENCES `merk` (`id`);

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
