-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Agu 2024 pada 05.30
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
(162, 43, 'Laptop', 8, '-', '1234', 29, '-', 'Partner License', 'HO', 'Operation', 'Good', 'Rejected', 'Return', 'uploads/documentation/1724123958.png', NULL, '2024-08-19 20:16:55', '2024-08-19 20:23:20');

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
(741, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-19 09:30:32', ''),
(742, 144, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'sa', 'sa', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724059853.jpg', '2024-08-19 09:30:53', 'UPDATE'),
(743, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-19 09:30:53', 'UPDATE'),
(744, 144, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 34, 29, 'IT SUPPORT', 'DAD', 'Partner License', 'Partner License', 'sa', 'sa', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724059853.jpg', 'uploads/documentation/1724059853.jpg', '2024-08-19 09:31:44', 'UPDATE'),
(745, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-19 09:31:44', 'UPDATE'),
(746, 144, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'sa', 'sa', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724059853.jpg', 'uploads/documentation/1724059941.jpg', '2024-08-19 09:32:21', 'UPDATE'),
(747, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-19 09:32:21', 'UPDATE'),
(748, 143, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'kasjdh', 'kasjdh', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724059611.jpg', 'uploads/documentation/1724059611.jpg', '2024-08-19 09:36:41', 'UPDATE'),
(749, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-19 09:36:41', 'UPDATE'),
(750, 144, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'sa', 'sa', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724059941.jpg', 'uploads/documentation/1724059941.jpg', '2024-08-19 09:36:49', 'UPDATE'),
(751, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-19 09:36:49', 'UPDATE'),
(752, 144, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'sa', 'sa', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724059941.jpg', 'uploads/documentation/1724059941.jpg', '2024-08-19 09:37:09', 'UPDATE'),
(753, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-19 09:37:09', 'UPDATE'),
(754, 144, 44, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '12345677', NULL, 29, NULL, 'DAD', NULL, 'Partner License', NULL, 'sa', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724059941.jpg', NULL, '2024-08-19 09:37:24', 'DELETE'),
(755, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-19 09:37:24', 'DELETE'),
(756, 143, 43, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1234', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'kasjdh', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724059611.jpg', NULL, '2024-08-19 09:38:01', 'DELETE'),
(757, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-19 09:38:01', 'DELETE'),
(758, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-19 09:38:26', ''),
(759, 145, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-19 09:38:58', 'UPDATE'),
(760, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-19 09:38:58', 'UPDATE'),
(761, 145, 43, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1234', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'DAD', NULL, 'Operation', NULL, 'Good', NULL, NULL, NULL, '2024-08-19 09:39:43', 'DELETE'),
(762, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-19 09:39:43', 'DELETE'),
(763, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-19 09:42:49', ''),
(764, 146, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'ho', 'ho', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-19 09:43:01', 'UPDATE'),
(765, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-19 09:43:01', 'UPDATE'),
(766, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-19 09:44:36', ''),
(767, 146, 43, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1234', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'ho', NULL, 'Operation', NULL, 'Good', NULL, NULL, NULL, '2024-08-19 09:49:33', 'DELETE'),
(768, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-19 09:49:33', 'DELETE'),
(769, 147, 44, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '12345677', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'asds', NULL, 'Operation', NULL, 'Good', NULL, NULL, NULL, '2024-08-19 09:50:41', 'DELETE'),
(770, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-19 09:50:41', 'DELETE'),
(771, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-19 09:56:22', ''),
(772, 148, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'kuydsa', 'kuydsa', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 00:34:49', 'UPDATE'),
(773, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 00:34:49', 'UPDATE'),
(774, 148, 43, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1234', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'kuydsa', NULL, 'Operation', NULL, 'Good', NULL, NULL, NULL, '2024-08-20 00:35:01', 'DELETE'),
(775, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 00:35:01', 'DELETE'),
(776, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 00:39:57', ''),
(777, 149, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724114425.jpg', '2024-08-20 00:40:25', 'UPDATE'),
(778, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 00:40:25', 'UPDATE'),
(779, 149, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 29, 'IT SUPPORT', 'DAD', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724114425.jpg', 'uploads/documentation/1724114425.jpg', '2024-08-20 00:40:51', 'UPDATE'),
(780, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 00:40:51', 'UPDATE'),
(781, 149, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724114425.jpg', 'uploads/documentation/1724114425.jpg', '2024-08-20 00:41:46', 'UPDATE'),
(782, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 00:41:46', 'UPDATE'),
(783, 149, 43, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1234', NULL, 29, NULL, 'DAD', NULL, 'Partner License', NULL, 'DAD', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724114425.jpg', NULL, '2024-08-20 00:57:11', 'DELETE'),
(784, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 00:57:11', 'DELETE'),
(785, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 00:59:25', ''),
(786, 150, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'Fattan', 'Fattan', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724115608.jpg', '2024-08-20 01:00:08', 'UPDATE'),
(787, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:00:08', 'UPDATE'),
(788, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:11:21', ''),
(789, 151, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'coba', 'coba', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724116303.jpg', '2024-08-20 01:11:43', 'UPDATE'),
(790, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:11:43', 'UPDATE'),
(791, 150, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 29, 'IT SUPPORT', 'DAD', 'Partner License', 'Partner License', 'Fattan', 'Fattan', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724115608.jpg', 'uploads/documentation/1724115608.jpg', '2024-08-20 01:12:58', 'UPDATE'),
(792, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:12:58', 'UPDATE'),
(793, 150, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'Fattan', 'Fattan', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724115608.jpg', 'uploads/documentation/1724116566.jpg', '2024-08-20 01:16:06', 'UPDATE'),
(794, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:16:06', 'UPDATE'),
(795, 150, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 34, 'DAD', 'IT SUPPORT', 'Partner License', 'Partner License', 'Fattan', 'Fattan', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724116566.jpg', 'uploads/documentation/1724116566.jpg', '2024-08-20 01:27:30', 'UPDATE'),
(796, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:27:30', 'UPDATE'),
(797, 150, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'Fattan', 'Fattan', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724116566.jpg', 'uploads/documentation/1724116566.jpg', '2024-08-20 01:28:14', 'UPDATE'),
(798, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:28:14', 'UPDATE'),
(799, 150, 43, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1234', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'Fattan', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724116566.jpg', NULL, '2024-08-20 01:28:38', 'DELETE'),
(800, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:28:38', 'DELETE'),
(801, 151, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 34, 29, 'IT SUPPORT', 'DAD', 'Partner License', 'Partner License', 'coba', 'coba', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724116303.jpg', 'uploads/documentation/1724116303.jpg', '2024-08-20 01:29:38', 'UPDATE'),
(802, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:29:38', 'UPDATE'),
(803, 151, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'coba', 'coba', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724116303.jpg', 'uploads/documentation/1724117600.jpg', '2024-08-20 01:33:20', 'UPDATE'),
(804, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:33:20', 'UPDATE'),
(805, 151, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 29, 34, 'DAD', 'DAD', 'Partner License', 'Partner License', 'coba', 'coba', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724117600.jpg', 'uploads/documentation/1724117600.jpg', '2024-08-20 01:33:47', 'UPDATE'),
(806, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:33:47', 'UPDATE'),
(807, 151, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 34, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'coba', 'coba', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724117600.jpg', 'uploads/documentation/1724117600.jpg', '2024-08-20 01:37:51', 'UPDATE'),
(808, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:37:51', 'UPDATE'),
(809, 151, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'coba', 'coba', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724117600.jpg', 'uploads/documentation/1724117600.jpg', '2024-08-20 01:48:41', 'UPDATE'),
(810, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:48:41', 'UPDATE'),
(811, 151, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 29, 34, 'DAD', 'DAD', 'Partner License', 'Partner License', 'coba', 'coba', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724117600.jpg', 'uploads/documentation/1724117600.jpg', '2024-08-20 01:52:27', 'UPDATE'),
(812, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:52:27', 'UPDATE'),
(813, 151, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 34, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'coba', 'coba', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724117600.jpg', 'uploads/documentation/1724117600.jpg', '2024-08-20 01:52:56', 'UPDATE'),
(814, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:52:56', 'UPDATE'),
(815, 151, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'coba', 'coba', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724117600.jpg', 'uploads/documentation/1724117600.jpg', '2024-08-20 01:53:06', 'UPDATE'),
(816, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:53:06', 'UPDATE'),
(817, 151, 44, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '12345677', NULL, 29, NULL, 'DAD', NULL, 'Partner License', NULL, 'coba', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724117600.jpg', NULL, '2024-08-20 01:53:35', 'DELETE'),
(818, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:53:35', 'DELETE'),
(819, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:53:47', ''),
(820, 152, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 01:54:04', 'UPDATE'),
(821, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:54:04', 'UPDATE'),
(822, 152, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, '1724118866_wallpaperflare.com_wallpaper.jpg', '2024-08-20 01:54:26', 'UPDATE'),
(823, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:54:26', 'UPDATE'),
(824, 152, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', '1724118866_wallpaperflare.com_wallpaper.jpg', '1724118866_wallpaperflare.com_wallpaper.jpg', '2024-08-20 01:54:34', 'UPDATE'),
(825, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:54:34', 'UPDATE'),
(826, 152, 43, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1234', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'DAD', NULL, 'Operation', NULL, 'Good', NULL, '1724118866_wallpaperflare.com_wallpaper.jpg', NULL, '2024-08-20 01:56:46', 'DELETE'),
(827, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:56:46', 'DELETE'),
(828, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:56:56', ''),
(829, 153, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 01:57:09', 'UPDATE'),
(830, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:57:09', 'UPDATE'),
(831, 153, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 29, 'IT SUPPORT', 'DAD', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 01:58:27', 'UPDATE'),
(832, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:58:27', 'UPDATE'),
(833, 153, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 01:58:45', 'UPDATE'),
(834, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:58:45', 'UPDATE'),
(835, 153, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 34, 'DAD', 'DAD', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 01:58:54', 'UPDATE'),
(836, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:58:54', 'UPDATE'),
(837, 153, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'DAD', 'DAD', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 01:59:31', 'UPDATE'),
(838, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:59:31', 'UPDATE'),
(839, 153, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'DAD', 'DAD', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 01:59:37', 'UPDATE'),
(840, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 01:59:37', 'UPDATE'),
(841, 153, 43, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1234', NULL, 34, NULL, 'DAD', NULL, 'Partner License', NULL, 'DAD', NULL, 'Operation', NULL, 'Good', NULL, NULL, NULL, '2024-08-20 02:07:26', 'DELETE'),
(842, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:07:26', 'DELETE'),
(843, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:07:38', ''),
(844, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:07:50', ''),
(845, 154, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 02:08:05', 'UPDATE'),
(846, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:08:05', 'UPDATE'),
(847, 155, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 02:08:14', 'UPDATE'),
(848, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:08:14', 'UPDATE'),
(849, 155, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 02:08:34', 'UPDATE'),
(850, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:08:34', 'UPDATE'),
(851, 155, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 02:08:41', 'UPDATE'),
(852, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:08:41', 'UPDATE'),
(853, 154, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 29, 'IT SUPPORT', 'DAD', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 02:11:51', 'UPDATE'),
(854, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:11:51', 'UPDATE'),
(855, 154, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 02:12:08', 'UPDATE'),
(856, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:12:08', 'UPDATE'),
(857, 154, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 02:12:17', 'UPDATE'),
(858, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:12:17', 'UPDATE'),
(859, 154, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 34, 'DAD', 'IT SUPPORT', 'Partner License', 'Partner License', 'dad', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 02:13:03', 'UPDATE'),
(860, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:13:03', 'UPDATE'),
(861, 154, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 02:13:18', 'UPDATE'),
(862, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:13:18', 'UPDATE'),
(863, 154, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 29, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 02:13:28', 'UPDATE'),
(864, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:13:28', 'UPDATE'),
(865, 155, 44, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '12345677', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'dad', NULL, 'Operation', NULL, 'Good', NULL, NULL, NULL, '2024-08-20 02:20:10', 'DELETE'),
(866, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:20:10', 'DELETE'),
(867, 154, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 02:20:26', 'UPDATE'),
(868, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:20:26', 'UPDATE'),
(869, 154, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 02:21:51', 'UPDATE'),
(870, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:21:51', 'UPDATE'),
(871, 154, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 02:23:27', 'UPDATE'),
(872, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:23:27', 'UPDATE'),
(873, 154, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 02:23:35', 'UPDATE'),
(874, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:23:35', 'UPDATE'),
(875, 154, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 29, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 02:23:43', 'UPDATE'),
(876, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:23:43', 'UPDATE'),
(877, 154, 43, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1234', NULL, 29, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'HO', NULL, 'Operation', NULL, 'Good', NULL, NULL, NULL, '2024-08-20 02:24:06', 'DELETE'),
(878, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:24:06', 'DELETE'),
(879, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:24:27', ''),
(880, 156, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724120775.jpg', '2024-08-20 02:26:15', 'UPDATE'),
(881, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:26:15', 'UPDATE'),
(882, 156, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724120775.jpg', 'uploads/documentation/1724120775.jpg', '2024-08-20 02:26:51', 'UPDATE'),
(883, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:26:51', 'UPDATE'),
(884, 156, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724120775.jpg', 'uploads/documentation/1724120775.jpg', '2024-08-20 02:26:59', 'UPDATE'),
(885, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:26:59', 'UPDATE'),
(886, 156, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724120775.jpg', 'uploads/documentation/1724120775.jpg', '2024-08-20 02:27:14', 'UPDATE'),
(887, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:27:14', 'UPDATE'),
(888, 156, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 29, 'IT SUPPORT', 'DAD', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724120775.jpg', 'uploads/documentation/1724120775.jpg', '2024-08-20 02:28:03', 'UPDATE'),
(889, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:28:03', 'UPDATE'),
(890, 156, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724120775.jpg', 'uploads/documentation/1724120904.jpg', '2024-08-20 02:28:24', 'UPDATE'),
(891, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:28:24', 'UPDATE'),
(892, 156, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 35, 'DAD', '-', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724120904.jpg', 'uploads/documentation/1724120904.jpg', '2024-08-20 02:30:49', 'UPDATE'),
(893, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:30:49', 'UPDATE'),
(894, 156, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 35, 35, '-', '-', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724120904.jpg', 'uploads/documentation/1724121076.jpg', '2024-08-20 02:31:16', 'UPDATE'),
(895, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 35, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:31:16', 'UPDATE'),
(896, 156, 43, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1234', NULL, 35, NULL, '-', NULL, 'Partner License', NULL, 'DAD', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724121076.jpg', NULL, '2024-08-20 02:36:38', 'DELETE'),
(897, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:36:38', 'DELETE'),
(898, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:37:12', ''),
(899, 157, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724121472.jpg', '2024-08-20 02:37:52', 'UPDATE'),
(900, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:37:52', 'UPDATE'),
(901, 157, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 29, 'IT SUPPORT', 'DAD', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724121472.jpg', 'uploads/documentation/1724121472.jpg', '2024-08-20 02:39:11', 'UPDATE'),
(902, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:39:11', 'UPDATE'),
(903, 157, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724121472.jpg', 'uploads/documentation/1724121575.jpg', '2024-08-20 02:39:35', 'UPDATE'),
(904, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:39:35', 'UPDATE'),
(905, 157, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 34, 'DAD', 'IT SUPPORT', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724121575.jpg', 'uploads/documentation/1724121575.jpg', '2024-08-20 02:40:28', 'UPDATE'),
(906, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:40:28', 'UPDATE'),
(907, 157, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724121575.jpg', 'uploads/documentation/1724121575.jpg', '2024-08-20 02:40:44', 'UPDATE'),
(908, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:40:44', 'UPDATE'),
(909, 157, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724121575.jpg', 'uploads/documentation/1724121575.jpg', '2024-08-20 02:40:58', 'UPDATE'),
(910, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:40:58', 'UPDATE'),
(911, 157, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 29, 'IT SUPPORT', 'DAD', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724121575.jpg', 'uploads/documentation/1724121575.jpg', '2024-08-20 02:42:22', 'UPDATE'),
(912, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:42:22', 'UPDATE'),
(913, 157, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724121575.jpg', 'uploads/documentation/1724121575.jpg', '2024-08-20 02:42:34', 'UPDATE'),
(914, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:42:34', 'UPDATE'),
(915, 157, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 34, 'DAD', 'DAD', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724121575.jpg', 'uploads/documentation/1724121575.jpg', '2024-08-20 02:42:45', 'UPDATE'),
(916, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:42:45', 'UPDATE'),
(917, 157, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 35, 'DAD', '-', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724121575.jpg', 'uploads/documentation/1724121575.jpg', '2024-08-20 02:43:06', 'UPDATE'),
(918, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:43:06', 'UPDATE'),
(919, 157, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 35, 35, '-', '-', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724121575.jpg', 'uploads/documentation/1724121811.jpg', '2024-08-20 02:43:31', 'UPDATE'),
(920, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 35, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:43:31', 'UPDATE'),
(921, 157, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 35, 34, '-', 'IT SUPPORT', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724121811.jpg', 'uploads/documentation/1724121811.jpg', '2024-08-20 02:43:53', 'UPDATE'),
(922, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 35, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:43:53', 'UPDATE'),
(923, 157, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724121811.jpg', 'uploads/documentation/1724121811.jpg', '2024-08-20 02:44:06', 'UPDATE'),
(924, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:44:06', 'UPDATE'),
(925, 157, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724121811.jpg', 'uploads/documentation/1724121811.jpg', '2024-08-20 02:44:14', 'UPDATE'),
(926, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:44:14', 'UPDATE'),
(927, 157, 43, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1234', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'dad', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724121811.jpg', NULL, '2024-08-20 02:45:06', 'DELETE'),
(928, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:45:06', 'DELETE'),
(929, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:49:28', ''),
(930, 158, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'dad', 'dad', 'Operation', 'Operation', 'Good', 'Good', NULL, NULL, '2024-08-20 02:50:05', 'UPDATE'),
(931, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:50:05', 'UPDATE'),
(932, 158, 43, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1234', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'dad', NULL, 'Operation', NULL, 'Good', NULL, NULL, NULL, '2024-08-20 02:50:22', 'DELETE'),
(933, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:50:22', 'DELETE'),
(934, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:50:44', ''),
(935, 159, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'PAMA', 'PAMA', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724122264.jpg', '2024-08-20 02:51:04', 'UPDATE'),
(936, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:51:04', 'UPDATE'),
(937, 159, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 35, 'IT SUPPORT', '-', 'Partner License', 'Partner License', 'PAMA', 'PAMA', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724122264.jpg', 'uploads/documentation/1724122264.jpg', '2024-08-20 02:52:36', 'UPDATE'),
(938, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:52:36', 'UPDATE'),
(939, 159, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 35, 35, '-', '-', 'Partner License', 'Partner License', 'PAMA', 'PAMA', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724122264.jpg', 'uploads/documentation/1724122372.jpg', '2024-08-20 02:52:52', 'UPDATE'),
(940, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 35, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:52:52', 'UPDATE'),
(941, 159, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 35, 29, '-', 'DAD', 'Partner License', 'Partner License', 'PAMA', 'PAMA', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724122372.jpg', 'uploads/documentation/1724122372.jpg', '2024-08-20 02:53:37', 'UPDATE'),
(942, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 35, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:53:37', 'UPDATE'),
(943, 159, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'PAMA', 'PAMA', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724122372.jpg', 'uploads/documentation/1724122372.jpg', '2024-08-20 02:53:52', 'UPDATE'),
(944, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:53:52', 'UPDATE'),
(945, 159, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 34, 'DAD', 'DAD', 'Partner License', 'Partner License', 'PAMA', 'PAMA', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724122372.jpg', 'uploads/documentation/1724122372.jpg', '2024-08-20 02:54:06', 'UPDATE'),
(946, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:54:06', 'UPDATE'),
(947, 159, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'PAMA', 'PAMA', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724122372.jpg', 'uploads/documentation/1724122372.jpg', '2024-08-20 02:56:13', 'UPDATE'),
(948, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:56:13', 'UPDATE'),
(949, 159, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'PAMA', 'PAMA', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724122372.jpg', 'uploads/documentation/1724122602.jpg', '2024-08-20 02:56:42', 'UPDATE'),
(950, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:56:42', 'UPDATE'),
(951, 159, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'PAMA', 'PAMA', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724122602.jpg', 'uploads/documentation/1724122603.jpg', '2024-08-20 02:56:43', 'UPDATE'),
(952, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:56:43', 'UPDATE'),
(953, 159, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 34, 'DAD', 'IT SUPPORT', 'Partner License', 'Partner License', 'PAMA', 'PAMA', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724122603.jpg', 'uploads/documentation/1724122603.jpg', '2024-08-20 02:57:19', 'UPDATE'),
(954, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:57:19', 'UPDATE'),
(955, 159, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'PAMA', 'PAMA', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724122603.jpg', 'uploads/documentation/1724122603.jpg', '2024-08-20 02:57:47', 'UPDATE'),
(956, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:57:47', 'UPDATE'),
(957, 159, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'PAMA', 'PAMA', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724122603.jpg', 'uploads/documentation/1724122603.jpg', '2024-08-20 02:57:57', 'UPDATE'),
(958, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:57:57', 'UPDATE'),
(959, 159, 43, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1234', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'PAMA', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724122603.jpg', NULL, '2024-08-20 02:58:11', 'DELETE');
INSERT INTO `asset_history` (`id`, `asset_id`, `asset_tagging_old`, `asset_tagging_new`, `jenis_aset_old`, `jenis_aset_new`, `merk_old`, `merk_new`, `type_old`, `type_new`, `serial_number_old`, `serial_number_new`, `nama_old`, `nama_new`, `mapping_old`, `mapping_new`, `o365_old`, `o365_new`, `lokasi_old`, `lokasi_new`, `status_old`, `status_new`, `kondisi_old`, `kondisi_new`, `documentation_old`, `documentation_new`, `changed_at`, `action`) VALUES
(960, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:58:11', 'DELETE'),
(961, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:59:22', ''),
(962, 160, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724122783.jpg', '2024-08-20 02:59:43', 'UPDATE'),
(963, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 02:59:43', 'UPDATE'),
(964, 160, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 29, 'IT SUPPORT', 'DAD', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724122783.jpg', 'uploads/documentation/1724122783.jpg', '2024-08-20 03:00:05', 'UPDATE'),
(965, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:00:05', 'UPDATE'),
(966, 160, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724122783.jpg', 'uploads/documentation/1724122825.png', '2024-08-20 03:00:25', 'UPDATE'),
(967, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:00:25', 'UPDATE'),
(968, 160, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 34, 'DAD', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724122825.png', 'uploads/documentation/1724122825.png', '2024-08-20 03:00:44', 'UPDATE'),
(969, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:00:44', 'UPDATE'),
(970, 160, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724122825.png', 'uploads/documentation/1724122825.png', '2024-08-20 03:00:54', 'UPDATE'),
(971, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:00:54', 'UPDATE'),
(972, 160, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724122825.png', 'uploads/documentation/1724122825.png', '2024-08-20 03:01:02', 'UPDATE'),
(973, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:01:02', 'UPDATE'),
(974, 160, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724122825.png', 'uploads/documentation/1724122825.png', '2024-08-20 03:07:42', 'UPDATE'),
(975, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:07:42', 'UPDATE'),
(976, 160, 43, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1234', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'DAD', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724122825.png', NULL, '2024-08-20 03:07:58', 'DELETE'),
(977, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:07:58', 'DELETE'),
(978, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:08:18', ''),
(979, 161, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724123324.jpg', '2024-08-20 03:08:44', 'UPDATE'),
(980, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:08:44', 'UPDATE'),
(981, 161, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 29, 'IT SUPPORT', 'DAD', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123324.jpg', 'uploads/documentation/1724123324.jpg', '2024-08-20 03:09:11', 'UPDATE'),
(982, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:09:11', 'UPDATE'),
(983, 161, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123324.jpg', 'uploads/documentation/1724123324.jpg', '2024-08-20 03:09:19', 'UPDATE'),
(984, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:09:19', 'UPDATE'),
(985, 161, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 34, 'DAD', 'DAD', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123324.jpg', 'uploads/documentation/1724123324.jpg', '2024-08-20 03:09:31', 'UPDATE'),
(986, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:09:31', 'UPDATE'),
(987, 161, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 35, 'DAD', '-', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123324.jpg', 'uploads/documentation/1724123324.jpg', '2024-08-20 03:10:01', 'UPDATE'),
(988, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:10:01', 'UPDATE'),
(989, 161, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 35, 35, '-', '-', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123324.jpg', 'uploads/documentation/1724123324.jpg', '2024-08-20 03:10:32', 'UPDATE'),
(990, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 35, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:10:32', 'UPDATE'),
(991, 161, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 35, 34, '-', '-', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123324.jpg', 'uploads/documentation/1724123324.jpg', '2024-08-20 03:10:40', 'UPDATE'),
(992, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 35, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:10:40', 'UPDATE'),
(993, 161, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 29, '-', 'DAD', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123324.jpg', 'uploads/documentation/1724123324.jpg', '2024-08-20 03:11:00', 'UPDATE'),
(994, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:11:00', 'UPDATE'),
(995, 161, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123324.jpg', 'uploads/documentation/1724123497.png', '2024-08-20 03:11:37', 'UPDATE'),
(996, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:11:37', 'UPDATE'),
(997, 161, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 34, 'DAD', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123497.png', 'uploads/documentation/1724123497.png', '2024-08-20 03:11:55', 'UPDATE'),
(998, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:11:55', 'UPDATE'),
(999, 161, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123497.png', 'uploads/documentation/1724123497.png', '2024-08-20 03:12:03', 'UPDATE'),
(1000, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:12:03', 'UPDATE'),
(1001, 161, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123497.png', 'uploads/documentation/1724123497.png', '2024-08-20 03:12:10', 'UPDATE'),
(1002, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:12:10', 'UPDATE'),
(1003, 161, 43, NULL, 'Laptop', NULL, 8, NULL, '-', NULL, '1234', NULL, 34, NULL, 'IT SUPPORT', NULL, 'Partner License', NULL, 'DAD', NULL, 'Operation', NULL, 'Good', NULL, 'uploads/documentation/1724123497.png', NULL, '2024-08-20 03:16:37', 'DELETE'),
(1004, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:16:37', 'DELETE'),
(1005, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:16:55', ''),
(1006, 162, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1724123838.jpg', '2024-08-20 03:17:18', 'UPDATE'),
(1007, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:17:18', 'UPDATE'),
(1008, 162, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 29, 'IT SUPPORT', 'DAD', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123838.jpg', 'uploads/documentation/1724123838.jpg', '2024-08-20 03:18:13', 'UPDATE'),
(1009, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:18:13', 'UPDATE'),
(1010, 162, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123838.jpg', 'uploads/documentation/1724123838.jpg', '2024-08-20 03:18:33', 'UPDATE'),
(1011, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:18:33', 'UPDATE'),
(1012, 162, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 34, 'DAD', 'DAD', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123838.jpg', 'uploads/documentation/1724123838.jpg', '2024-08-20 03:18:40', 'UPDATE'),
(1013, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:18:40', 'UPDATE'),
(1014, 162, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123838.jpg', 'uploads/documentation/1724123838.jpg', '2024-08-20 03:18:57', 'UPDATE'),
(1015, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:18:57', 'UPDATE'),
(1016, 162, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123838.jpg', 'uploads/documentation/1724123958.png', '2024-08-20 03:19:18', 'UPDATE'),
(1017, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:19:18', 'UPDATE'),
(1018, 162, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 35, 'DAD', '-', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123958.png', 'uploads/documentation/1724123958.png', '2024-08-20 03:19:41', 'UPDATE'),
(1019, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:19:41', 'UPDATE'),
(1020, 162, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 35, 35, '-', '-', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123958.png', 'uploads/documentation/1724123958.png', '2024-08-20 03:20:17', 'UPDATE'),
(1021, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 35, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:20:17', 'UPDATE'),
(1022, 162, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 35, 29, '-', '-', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123958.png', 'uploads/documentation/1724123958.png', '2024-08-20 03:20:25', 'UPDATE'),
(1023, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 35, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:20:25', 'UPDATE'),
(1024, 162, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, '-', '-', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123958.png', 'uploads/documentation/1724123958.png', '2024-08-20 03:22:55', 'UPDATE'),
(1025, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:22:55', 'UPDATE'),
(1026, 162, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, '-', '-', 'Partner License', 'Partner License', 'HO', 'HO', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1724123958.png', 'uploads/documentation/1724123958.png', '2024-08-20 03:23:20', 'UPDATE'),
(1027, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 03:23:20', 'UPDATE');

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
(34, 'fattan@gmail.com', 'fattan', 'user', '666', 'Fattan Malva', 'IT SUPPORT'),
(35, 'coba@gmail.com', 'coba', 'user', '1234', 'coba', '-');

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
(43, 'LAP-001', 'Laptop', 8, '1234', '-', 'Exception', 'Operation'),
(44, 'LAP-002', 'Laptop', 8, '12345677', '-', 'Bad', 'Inventory');

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
(8, 'Dell'),
(9, 'COBA MD'),
(10, 'coba');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT untuk tabel `asset_history`
--
ALTER TABLE `asset_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1028;

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

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
