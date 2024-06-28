-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Des 2023 pada 03.04
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
-- Database: `edas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int(10) UNSIGNED NOT NULL,
  `id_ahp_alternatif` int(11) NOT NULL,
  `alternatif_C` varchar(5) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `j_sp` float NOT NULL,
  `j_sn` float NOT NULL,
  `nsp` float NOT NULL,
  `nsn` float NOT NULL,
  `q` float NOT NULL,
  `ranking` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `id_ahp_alternatif`, `alternatif_C`, `nama`, `j_sp`, `j_sn`, `nsp`, `nsn`, `q`, `ranking`) VALUES
(1, 11, 'C1', 'Kondisi Membahayakan Manusia', 0.119719, 0.0059869, 1, 0.953861, 0.976931, 1),
(2, 12, 'C2', 'Bencana pada tahap tanggap darurat', 0.01367, 0.0801382, 0.114184, 0.382403, 0.248294, 3),
(3, 13, 'C3', 'Kecelakaan dengan Penanganan Khusus', 0.111591, 0.0597688, 0.932111, 0.539383, 0.735747, 2),
(4, 14, 'C4', 'Kecelakaan Penerbangan dan Pelayaran', 0.0306725, 0.129758, 0.256205, 0, 0.128102, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ir`
--

CREATE TABLE `ir` (
  `jumlah` int(11) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ir`
--

INSERT INTO `ir` (`jumlah`, `nilai`) VALUES
(1, 0),
(2, 0),
(3, 0.58),
(4, 0.9),
(5, 1.12),
(6, 1.24),
(7, 1.32),
(8, 1.41),
(9, 1.45),
(10, 1.49),
(11, 1.51),
(12, 1.48),
(13, 1.56),
(14, 1.57),
(15, 1.59);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria_edas`
--

CREATE TABLE `kriteria_edas` (
  `id_kriteria` int(11) UNSIGNED NOT NULL,
  `id_ahp_kriteria` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `bobot` float NOT NULL,
  `atribut` set('benefit','cost') DEFAULT NULL,
  `av` float NOT NULL,
  `pvektor` float NOT NULL,
  `ei` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kriteria_edas`
--

INSERT INTO `kriteria_edas` (`id_kriteria`, `id_ahp_kriteria`, `nama`, `bobot`, `atribut`, `av`, `pvektor`, `ei`) VALUES
(1, 31, 'Jumlah Kasus', 0.224066, 'benefit', 3.5, 2.24066, 0.952278),
(2, 32, 'Jarak', 0.0373596, 'cost', 2.025, 0.373596, 0.971349),
(3, 33, 'Siap', 0.090964, 'benefit', 4.1, 0.90964, 1.21285),
(4, 34, 'Waktu Tempuh', 0.0503215, 'benefit', 3.075, 0.503215, 1.0232),
(5, 35, 'Korban', 0.0579321, 'benefit', 4.55, 0.579321, 1.09106),
(6, 36, 'Kecepatan Tanggap', 0.168636, 'benefit', 3.3, 1.68636, 1.33504),
(7, 37, 'Peralatan', 0.108048, 'cost', 2.675, 1.08048, 0.972431),
(8, 38, 'Ketersediaan Informasi', 0.0667996, 'benefit', 2.575, 0.667996, 1.15786),
(9, 39, 'Jumlah Personil', 0.0750159, 'benefit', 2.45, 0.750159, 1.18775),
(10, 40, 'Instansi', 0.120858, 'cost', 2.275, 1.20858, 1.04743);

-- --------------------------------------------------------

--
-- Struktur dari tabel `matriks`
--

CREATE TABLE `matriks` (
  `id_alternatif` int(10) UNSIGNED NOT NULL,
  `id_kriteria` int(10) UNSIGNED NOT NULL,
  `value` float NOT NULL,
  `av` float NOT NULL,
  `pda` float NOT NULL,
  `nda` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `matriks`
--

INSERT INTO `matriks` (`id_alternatif`, `id_kriteria`, `value`, `av`, `pda`, `nda`) VALUES
(1, 1, 5, 3.5, 0.428571, 0),
(1, 2, 2.2, 2.025, 0, 0.0864198),
(1, 3, 4.1, 4.1, 0, 0),
(1, 4, 3, 3.075, 0, 0.0243902),
(1, 5, 5, 4.55, 0.0989011, 0),
(1, 6, 3.4, 3.3, 0.030303, 0),
(1, 7, 2.6, 2.675, 0.0280374, 0),
(1, 8, 2.8, 2.575, 0.0873786, 0),
(1, 9, 2.4, 2.45, 0, 0.0204082),
(1, 10, 2.2, 2.275, 0.032967, 0),
(2, 1, 3, 3.5, 0, 0.142857),
(2, 2, 1.8, 2.025, 0.111111, 0),
(2, 3, 3.8, 4.1, 0, 0.0731707),
(2, 4, 3.3, 3.075, 0.0731707, 0),
(2, 5, 3.6, 4.55, 0, 0.208791),
(2, 6, 3.3, 3.3, 0, 0),
(2, 7, 3.2, 2.675, 0, 0.196262),
(2, 8, 2.8, 2.575, 0.0873786, 0),
(2, 9, 2.4, 2.45, 0, 0.0204082),
(2, 10, 2.4, 2.275, 0, 0.0549451),
(3, 1, 3, 3.5, 0, 0.142857),
(3, 2, 1.9, 2.025, 0.0617284, 0),
(3, 3, 4.5, 4.1, 0.097561, 0),
(3, 4, 4.1, 3.075, 0.333333, 0),
(3, 5, 4.7, 4.55, 0.032967, 0),
(3, 6, 4.5, 3.3, 0.363636, 0),
(3, 7, 2.4, 2.675, 0.102804, 0),
(3, 8, 1.8, 2.575, 0, 0.300971),
(3, 9, 2.2, 2.45, 0, 0.102041),
(3, 10, 2.1, 2.275, 0.0769231, 0),
(4, 1, 3, 3.5, 0, 0.142857),
(4, 2, 2.2, 2.025, 0, 0.0864198),
(4, 3, 4, 4.1, 0, 0.0243902),
(4, 4, 1.9, 3.075, 0, 0.382114),
(4, 5, 4.9, 4.55, 0.0769231, 0),
(4, 6, 2, 3.3, 0, 0.393939),
(4, 7, 2.5, 2.675, 0.0654206, 0),
(4, 8, 2.9, 2.575, 0.126214, 0),
(4, 9, 2.8, 2.45, 0.142857, 0),
(4, 10, 2.4, 2.275, 0, 0.0549451);

-- --------------------------------------------------------

--
-- Struktur dari tabel `perbandingan_kriteria`
--

CREATE TABLE `perbandingan_kriteria` (
  `id` int(11) NOT NULL,
  `kriteria1` int(11) NOT NULL,
  `kriteria2` int(11) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `perbandingan_kriteria`
--

INSERT INTO `perbandingan_kriteria` (`id`, `kriteria1`, `kriteria2`, `nilai`) VALUES
(0, 31, 31, 3),
(1, 31, 32, 3),
(2, 31, 33, 2),
(3, 31, 34, 4),
(4, 31, 35, 3),
(5, 31, 36, 4),
(6, 31, 37, 2),
(7, 31, 38, 3),
(8, 31, 39, 4),
(9, 31, 40, 2),
(10, 32, 33, 0.5),
(11, 32, 34, 0.333333),
(12, 32, 35, 0.333333),
(13, 32, 36, 0.25),
(14, 32, 37, 0.5),
(15, 32, 38, 0.333333),
(16, 32, 39, 0.333333),
(17, 32, 40, 0.5),
(18, 33, 34, 2),
(19, 33, 35, 2),
(20, 33, 36, 0.333333),
(21, 33, 37, 0.5),
(22, 33, 38, 3),
(23, 33, 39, 2),
(24, 33, 40, 0.333333),
(25, 34, 35, 0.5),
(26, 34, 36, 0.333333),
(27, 34, 37, 0.5),
(28, 34, 38, 0.5),
(29, 34, 39, 0.5),
(30, 34, 40, 0.5),
(31, 35, 36, 0.333333),
(32, 35, 37, 0.5),
(33, 35, 38, 0.5),
(34, 35, 39, 0.5),
(35, 35, 40, 0.333333),
(36, 36, 37, 2),
(37, 36, 38, 3),
(38, 36, 39, 3),
(39, 36, 40, 2),
(40, 37, 38, 2),
(41, 37, 39, 2),
(42, 37, 40, 1),
(43, 38, 39, 0.5),
(44, 38, 40, 0.5),
(45, 39, 40, 0.5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pv_kriteria`
--

CREATE TABLE `pv_kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pv_kriteria`
--

INSERT INTO `pv_kriteria` (`id_kriteria`, `nilai`) VALUES
(31, 0.224066),
(32, 0.0373596),
(33, 0.090964),
(34, 0.0503215),
(35, 0.0579321),
(36, 0.168636),
(37, 0.108048),
(38, 0.0667996),
(39, 0.0750159),
(40, 0.120858);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indeks untuk tabel `ir`
--
ALTER TABLE `ir`
  ADD PRIMARY KEY (`jumlah`);

--
-- Indeks untuk tabel `kriteria_edas`
--
ALTER TABLE `kriteria_edas`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `matriks`
--
ALTER TABLE `matriks`
  ADD PRIMARY KEY (`id_alternatif`,`id_kriteria`);

--
-- Indeks untuk tabel `perbandingan_kriteria`
--
ALTER TABLE `perbandingan_kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pv_kriteria`
--
ALTER TABLE `pv_kriteria`
  ADD PRIMARY KEY (`id_kriteria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
