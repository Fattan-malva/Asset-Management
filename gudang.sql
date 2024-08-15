-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Agu 2024 pada 09.27
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `assets`
--

INSERT INTO `assets` (`id`, `asset_tagging`, `jenis_aset`, `merk`, `type`, `serial_number`, `nama`, `mapping`, `o365`, `lokasi`, `status`, `kondisi`, `approval_status`, `aksi`, `documentation`, `created_at`, `updated_at`) VALUES
(115, 43, 'Laptop', 8, '-', '1234', 34, 'IT SUPPORT', 'Partner License', 'GSI', 'Operation', 'Good', 'Approved', '', 'uploads/documentation/1723701828.JPG', '2024-08-14 01:44:43', '2024-08-14 23:03:48'),
(116, 44, 'Laptop', 8, '-', '12345677', 35, '-', 'Partner License', 'DAD', 'Operation', 'Good', 'Approved', 'Mutasi', 'uploads/documentation/1723705999.jpg', '2024-08-14 23:21:37', '2024-08-15 00:13:19'),
(117, 46, 'Laptop', 9, '-', 'siadad', 35, '-', 'Partner License', 'DAD', 'Operation', 'Good', 'Approved', 'Handover', 'uploads/documentation/1723706009.jpg', '2024-08-15 00:12:27', '2024-08-15 00:13:29');

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
(431, 115, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'edit', 'cobaaa nih', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1723695713.png', 'uploads/documentation/1723698850.png', '2024-08-15 05:14:10', 'UPDATE'),
(432, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-15 05:14:10', 'UPDATE'),
(433, 115, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'cobaaa nih', 'cobaaa nih', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1723698850.png', 'uploads/documentation/1723698880.png', '2024-08-15 05:14:40', 'UPDATE'),
(434, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-15 05:14:40', 'UPDATE'),
(435, 115, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 29, 34, 'DAD', 'IT SUPPORT', 'Partner License', 'Partner License', 'cobaaa nih', 'GSI', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1723698880.png', 'uploads/documentation/1723698880.png', '2024-08-15 06:02:06', 'UPDATE'),
(436, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-15 06:02:06', 'UPDATE'),
(437, 115, 43, 43, 'Laptop', 'Laptop', 8, 8, '-', '-', '1234', '1234', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'GSI', 'GSI', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1723698880.png', 'uploads/documentation/1723701828.JPG', '2024-08-15 06:03:48', 'UPDATE'),
(438, NULL, 43, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-15 06:03:48', 'UPDATE'),
(439, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-15 06:21:37', ''),
(440, 116, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 34, 34, 'IT SUPPORT', 'IT SUPPORT', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1723703040.JPG', '2024-08-15 06:24:00', 'UPDATE'),
(441, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-15 06:24:00', 'UPDATE'),
(442, 116, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 34, 29, 'IT SUPPORT', 'DAD', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1723703040.JPG', 'uploads/documentation/1723703040.JPG', '2024-08-15 06:26:42', 'UPDATE'),
(443, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 34, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-15 06:26:42', 'UPDATE'),
(444, 116, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 29, 29, 'DAD', 'DAD', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1723703040.JPG', 'uploads/documentation/1723703326.png', '2024-08-15 06:28:46', 'UPDATE'),
(445, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-15 06:28:46', 'UPDATE'),
(446, NULL, 46, NULL, 'Laptop', NULL, 9, NULL, NULL, NULL, NULL, NULL, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-15 07:12:27', ''),
(447, 116, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 29, 35, 'DAD', '-', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1723703326.png', 'uploads/documentation/1723703326.png', '2024-08-15 07:12:43', 'UPDATE'),
(448, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 29, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-15 07:12:43', 'UPDATE'),
(449, 116, 44, 44, 'Laptop', 'Laptop', 8, 8, '-', '-', '12345677', '12345677', 35, 35, '-', '-', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', 'uploads/documentation/1723703326.png', 'uploads/documentation/1723705999.jpg', '2024-08-15 07:13:19', 'UPDATE'),
(450, NULL, 44, NULL, 'Laptop', NULL, 8, NULL, NULL, NULL, NULL, NULL, 35, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-15 07:13:19', 'UPDATE'),
(451, 117, 46, 46, 'Laptop', 'Laptop', 9, 9, '-', '-', 'siadad', 'siadad', 35, 35, '-', '-', 'Partner License', 'Partner License', 'DAD', 'DAD', 'Operation', 'Operation', 'Good', 'Good', NULL, 'uploads/documentation/1723706009.jpg', '2024-08-15 07:13:29', 'UPDATE'),
(452, NULL, 46, NULL, 'Laptop', NULL, 9, NULL, NULL, NULL, NULL, NULL, 35, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-15 07:13:29', 'UPDATE');

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
(44, 'LAP-002', 'Laptop', 8, '12345677', '-', 'Bad', 'Operation'),
(46, 'COBA MD', 'Laptop', 9, 'siadad', '-', 'Bad', 'Operation'),
(47, 'jlhdfcsk', 'opfjsd', 8, 'fd;khcd', 'dfoqih', 'Good', 'Inventory');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT untuk tabel `asset_history`
--
ALTER TABLE `asset_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=453;

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
