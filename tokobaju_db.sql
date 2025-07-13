-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Jul 2025 pada 01.56
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tokobaju_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `status` enum('Menunggu','Selesai') DEFAULT 'Menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id`, `username`, `alamat`, `metode_pembayaran`, `total`, `tanggal`, `status`) VALUES
(1, 'user', 'bnb', 'E-Wallet', 12000, '2025-07-13 06:08:21', 'Selesai'),
(2, 'user', 'buta jia', 'COD', 12000, '2025-07-13 06:20:18', 'Menunggu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan_item`
--

CREATE TABLE `pesanan_item` (
  `id` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `nama_produk` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan_item`
--

INSERT INTO `pesanan_item` (`id`, `id_pesanan`, `nama_produk`, `harga`, `jumlah`) VALUES
(1, 1, 'ayam', 12000, 1),
(2, 2, 'ayam', 12000, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `deskripsi`, `harga`, `gambar`) VALUES
(2, 'Kemeja Putih - Rainbow', 'Kemeja putih dari brand rainbow sangat halus.', 90000, 'uploads/Flux_Dev_A_vibrant_photograph_featuring_a_crisp_bright_white_s_3.jpg'),
(3, 'Jaket Bomber Van Gogh', 'jaket bomber bertemakan pelukis legendaris van gogh', 155000, 'uploads/06932f17-b27d-4496-8c7d-330e5fadef2c.jpeg'),
(4, 'Jaket Sailor', 'jaket untuk para pelaut.', 210000, 'uploads/Gemini_Generated_Image_b55hv6b55hv6b55h.png'),
(5, 'Jaket anime', 'jaket dengan tema anime.', 90000, 'uploads/Gemini_Generated_Image_eawmuzeawmuzeawm.png'),
(6, 'Cardigan - Cream', 'cardigan dengan style korea berwarna cream.', 85000, 'uploads/Flux_Dev_Generate_me_highresolution_photographs_of_a_cardigan__2.jpg'),
(7, 'Celana y2k wanita', 'celana model y2k untuk wanita.', 72000, 'uploads/Gemini_Generated_Image_91sx0b91sx0b91sx.png'),
(8, 'Celana y2k pria', 'celana model y2k untuk pria.', 89000, 'uploads/Gemini_Generated_Image_th78q0th78q0th78.png'),
(9, 'Jaket denim sailor', 'jaket denim dengan tema laut.', 190000, 'uploads/Flux_Dev_A_highly_detailed_crisp_and_vibrant_photograph_of_a_w_0.jpg'),
(10, 'Jaket sukajan naga merah', 'jaket sukajan dengan model naga berwarna merah, cocok untuk yang ingin tampil berani.', 300000, 'uploads/Gemini_Generated_Image_3vgoaa3vgoaa3vgo.png'),
(11, 'Celana kargo unisex', 'celana kargo bisa dipakai semua gender.', 94000, 'uploads/Gemini_Generated_Image_fjcoccfjcoccfjco.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2a$12$qeswVGafN4Izm0QQhxrktudfXS0hrC3dmksYcGra99AiDWFZlWDHu'),
(2, 'user', '$2y$10$VG3Pn2d/NbALZoz66Q8WwOSsbgvHLhwe0r/leC9EQ4S6lQYspfmAK');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pesanan_item`
--
ALTER TABLE `pesanan_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pesanan_item`
--
ALTER TABLE `pesanan_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pesanan_item`
--
ALTER TABLE `pesanan_item`
  ADD CONSTRAINT `pesanan_item_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
