-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Bulan Mei 2023 pada 17.15
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_barang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` char(7) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga_barang` int(25) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `jenis_id` int(11) NOT NULL,
  `gudang_id` int(11) NOT NULL,
  `image` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `stok`, `harga_barang`, `satuan_id`, `jenis_id`, `gudang_id`, `image`) VALUES
('B000001', 'Botol', 450, 150000, 1, 14, 5, 'item-230511-ed6459d4f2.jpg'),
('B000002', 'Selimut', 534, 500, 3, 11, 6, 'item-230511-3450c59cb1.png'),
('B000003', 'Payung', 234, 2000, 1, 14, 3, 'item-230511-9a56fb7b8f.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_hilang`
--

CREATE TABLE `barang_hilang` (
  `id_barang_hilang` char(16) CHARACTER SET utf8 NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` char(7) CHARACTER SET utf8 NOT NULL,
  `jumlah_hilang` int(50) NOT NULL,
  `tanggal_hilang` date NOT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang_hilang`
--

INSERT INTO `barang_hilang` (`id_barang_hilang`, `user_id`, `barang_id`, `jumlah_hilang`, `tanggal_hilang`, `lokasi`) VALUES
('T-BH-23051100002', 19, 'B000002', 2, '2023-04-13', 'Lokasi'),
('T-BH-23051100003', 19, 'B000003', 2, '2023-05-08', '');

--
-- Trigger `barang_hilang`
--
DELIMITER $$
CREATE TRIGGER `update_stok_hilang` BEFORE INSERT ON `barang_hilang` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` - NEW.jumlah_hilang WHERE `barang`.`id_barang` = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_barang_keluar` char(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` char(7) NOT NULL,
  `jumlah_keluar` int(11) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `lokasi` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_barang_keluar`, `user_id`, `barang_id`, `jumlah_keluar`, `tanggal_keluar`, `lokasi`) VALUES
('T-BK-23051100001', 19, 'B000001', 50, '2023-04-06', 'Jalan'),
('T-BK-23051100002', 19, 'B000003', 5, '2023-05-11', 'London');

--
-- Trigger `barang_keluar`
--
DELIMITER $$
CREATE TRIGGER `update_stok_keluar` BEFORE INSERT ON `barang_keluar` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` - NEW.jumlah_keluar WHERE `barang`.`id_barang` = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_barang_masuk` char(16) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` char(7) NOT NULL,
  `jumlah_masuk` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_barang_masuk`, `supplier_id`, `user_id`, `barang_id`, `jumlah_masuk`, `tanggal_masuk`) VALUES
('T-BM-23051100001', 3, 19, 'B000001', 500, '2023-04-01'),
('T-BM-23051100002', 3, 19, 'B000002', 500, '2023-04-02'),
('T-BM-23051100003', 21, 19, 'B000003', 250, '2023-05-03'),
('T-BM-23051100004', 21, 19, 'B000002', 50, '2023-05-05');

--
-- Trigger `barang_masuk`
--
DELIMITER $$
CREATE TRIGGER `update_stok_masuk` BEFORE INSERT ON `barang_masuk` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` + NEW.jumlah_masuk WHERE `barang`.`id_barang` = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_rusak`
--

CREATE TABLE `barang_rusak` (
  `id_barang_rusak` char(16) CHARACTER SET utf8 NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` char(7) CHARACTER SET utf8 NOT NULL,
  `jumlah_rusak` int(11) NOT NULL,
  `tanggal_rusak` date NOT NULL,
  `lokasi` varchar(225) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang_rusak`
--

INSERT INTO `barang_rusak` (`id_barang_rusak`, `user_id`, `barang_id`, `jumlah_rusak`, `tanggal_rusak`, `lokasi`) VALUES
('T-BR-23051100001', 19, 'B000002', 6, '2023-04-27', 'lokasi'),
('T-BR-23051100002', 19, 'B000003', 3, '2023-05-10', 'Lokasi'),
('T-BR-23051100003', 19, 'B000003', 6, '2023-05-11', ''),
('T-BR-23051100004', 19, 'B000002', 4, '2023-04-20', '');

--
-- Trigger `barang_rusak`
--
DELIMITER $$
CREATE TRIGGER `update_stok_rusak` BEFORE INSERT ON `barang_rusak` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` - NEW.jumlah_rusak WHERE `barang`.`id_barang` = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gudang`
--

CREATE TABLE `gudang` (
  `id_gudang` int(11) NOT NULL,
  `nama_gudang` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `gudang`
--

INSERT INTO `gudang` (`id_gudang`, `nama_gudang`) VALUES
(1, 'Gudang Makanan'),
(2, 'Gudang Elektronik'),
(3, 'Gudang Bahan Bangunan'),
(5, 'Gudang Logistik & Sembako'),
(6, 'Gudang Barang Kecantikan & Kesehatan'),
(7, 'Gudang Barang Transportasi & Otomotif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis`
--

CREATE TABLE `jenis` (
  `id_jenis` int(11) NOT NULL,
  `nama_jenis` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `jenis`
--

INSERT INTO `jenis` (`id_jenis`, `nama_jenis`) VALUES
(1, 'Makanan Ringan'),
(2, 'Minuman'),
(7, 'Perangkat Komputer'),
(9, 'Elektronik'),
(10, 'Alat Bangunan'),
(11, 'Alat Kesehatan'),
(12, 'Transportasi'),
(13, 'Sembako'),
(14, 'Perkakas & Alat Berat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `report`
--

CREATE TABLE `report` (
  `id_report` varchar(11) NOT NULL,
  `month` int(2) NOT NULL,
  `year` int(4) NOT NULL,
  `category` varchar(25) NOT NULL,
  `additional_info` varchar(100) NOT NULL,
  `rejected_note` varchar(100) NOT NULL,
  `is_verified` int(1) DEFAULT NULL,
  `verified_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `report`
--

INSERT INTO `report` (`id_report`, `month`, `year`, `category`, `additional_info`, `rejected_note`, `is_verified`, `verified_at`, `created_by`, `created_at`) VALUES
('T-LB-202304', 4, 2023, '', '', '', 1, 1683817271, 19, 2147483647),
('T-LB-202305', 5, 2023, '', '', '', 0, NULL, 19, 2147483647);

-- --------------------------------------------------------

--
-- Struktur dari tabel `report_detail`
--

CREATE TABLE `report_detail` (
  `id_report_detail` int(11) NOT NULL,
  `id_report` varchar(15) NOT NULL,
  `id_barang` varchar(15) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `stok_awal` int(11) NOT NULL,
  `stok_masuk` int(11) NOT NULL,
  `stok_keluar` int(11) NOT NULL,
  `stok_rusak` int(11) NOT NULL,
  `stok_hilang` int(11) NOT NULL,
  `stok_akhir` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `report_detail`
--

INSERT INTO `report_detail` (`id_report_detail`, `id_report`, `id_barang`, `nama_barang`, `stok_awal`, `stok_masuk`, `stok_keluar`, `stok_rusak`, `stok_hilang`, `stok_akhir`) VALUES
(42, 'T-LB-202305', 'B000001', 'Botol', 0, 0, 0, 0, 0, 450),
(43, 'T-LB-202305', 'B000002', 'Selimut', 0, 50, 0, 0, 0, 538),
(44, 'T-LB-202305', 'B000003', 'Payung', 0, 250, 5, 3, 2, 240),
(45, 'T-LB-202304', 'B000001', 'Botol', 0, 500, 50, 0, 0, 450),
(46, 'T-LB-202304', 'B000002', 'Selimut', 0, 500, 0, 10, 2, 534),
(47, 'T-LB-202304', 'B000003', 'Payung', 0, 0, 0, 0, 0, 234);

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` int(11) NOT NULL,
  `nama_satuan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `nama_satuan`) VALUES
(1, 'Unit'),
(2, 'Pack'),
(3, 'Botol'),
(5, 'Pcs'),
(6, 'Liter'),
(7, 'Lusin'),
(8, 'Kardus'),
(9, 'Kg'),
(10, 'Kodi'),
(11, 'Buah'),
(12, 'Rim'),
(13, 'Ton'),
(14, 'Kwintal'),
(15, 'Ons'),
(16, 'Karung'),
(17, 'Box');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `supplier` varchar(50) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `supplier`, `nama_supplier`, `no_telp`, `alamat`, `foto`) VALUES
(3, 'PT Gudang Cabang Korea', 'Madnae Jin', '02221888820', 'Seol Korea', 'item-210712-c50b5cea88.jpg'),
(21, 'PT Angkasa  2 Jakarta', 'Agus Nanda', '083590843222', 'Pasa Senen Jakarta Pusat', 'item-210712-add9e3595d.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `role` enum('spv','admin','ehk') NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  `foto` text NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `email`, `no_telp`, `role`, `password`, `created_at`, `foto`, `is_active`) VALUES
(19, 'Aulia', 'admin', 'fawwazmudzakir30@gmail.com', '+6285281751644', 'admin', '$2y$10$Y55kZmQXou7FDI6vh8VDnOPbMVmCqnFoCYT9YBpGdbnnfevXpEVoq', 1681916873, 'user.png', 1),
(20, 'spv', 'spv', 'gudang@gmail.com', '0897654321', 'spv', '$2y$10$/ueciv3hRUmsDGa1AMk/OO0mnGW1jtbvZf/S9.2S0TUiGEqhEOUFu', 1681917005, 'user.png', 1),
(22, 'ehk', 'ehk', 'ehk@tes.tes', '01234', 'ehk', '$2y$10$T9HbYAOmTFHvDHbePtiIXOsCxMGeYu0eVu.8yo1L15ruCdj8GEcrK', 1683392052, 'user.png', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `satuan_id` (`satuan_id`),
  ADD KEY `kategori_id` (`jenis_id`),
  ADD KEY `gudang_id` (`gudang_id`);

--
-- Indeks untuk tabel `barang_hilang`
--
ALTER TABLE `barang_hilang`
  ADD PRIMARY KEY (`id_barang_hilang`),
  ADD KEY `barang_id` (`barang_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- Indeks untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_barang_keluar`),
  ADD KEY `id_user` (`user_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indeks untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`),
  ADD KEY `id_user` (`user_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indeks untuk tabel `barang_rusak`
--
ALTER TABLE `barang_rusak`
  ADD PRIMARY KEY (`id_barang_rusak`),
  ADD KEY `barang_id` (`barang_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- Indeks untuk tabel `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id_gudang`);

--
-- Indeks untuk tabel `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indeks untuk tabel `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id_report`);

--
-- Indeks untuk tabel `report_detail`
--
ALTER TABLE `report_detail`
  ADD PRIMARY KEY (`id_report_detail`);

--
-- Indeks untuk tabel `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `gudang`
--
ALTER TABLE `gudang`
  MODIFY `id_gudang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `report_detail`
--
ALTER TABLE `report_detail`
  MODIFY `id_report_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT untuk tabel `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`satuan_id`) REFERENCES `satuan` (`id_satuan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`jenis_id`) REFERENCES `jenis` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_keluar_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_3` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
