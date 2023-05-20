-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Bulan Mei 2023 pada 19.53
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
-- Database: `skripsi_tajik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `confusion_matrix`
--

CREATE TABLE `confusion_matrix` (
  `col_1` varchar(30) DEFAULT NULL,
  `col_2` varchar(4) DEFAULT NULL,
  `col_3` varchar(6) DEFAULT NULL,
  `col_4` varchar(8) DEFAULT NULL,
  `col_5` varchar(6) DEFAULT NULL,
  `col_6` varchar(6) DEFAULT NULL,
  `col_7` varchar(6) DEFAULT NULL,
  `col_8` varchar(7) DEFAULT NULL,
  `col_9` varchar(8) DEFAULT NULL,
  `col_10` varchar(6) DEFAULT NULL,
  `col_11` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `confusion_matrix`
--

INSERT INTO `confusion_matrix` (`col_1`, `col_2`, `col_3`, `col_4`, `col_5`, `col_6`, `col_7`, `col_8`, `col_9`, `col_10`, `col_11`) VALUES
('nama ', 'aer ', 'besae ', 'caparuni', 'lante ', 'ngana ', 'ambil ', 'kucing ', 'penakut ', 'hujan ', 'cabai '),
('iqbal anggai', 'air', 'jelek', 'kotor', 'lantai', 'kamu', 'ambe', 'tusa', 'panako', 'ujang', 'rica'),
('widya rompas ', 'air', 'jelek', 'jorok', 'lantai', 'kamu', 'ambe', 'tusa', 'panako', 'ujang', 'rica'),
('jendry immanuel kalampung ', 'air', 'jelek', 'kotor', 'lantai', 'kamu', 'ambe', 'tusa', 'panako', 'ujang', 'rica'),
('rizki andika mahmud', 'air', 'jelek', 'jorok', 'lantai', 'kamu', 'ambe', 'tusa', 'panako', 'ujang', 'rica'),
('ghaizka masloman', 'air', 'jelek', 'jorok', 'lantai', 'kamu', 'ambe', 'tusa', 'panako', 'ujang', 'rica'),
('gratcia bernadette', 'air', 'jelek', 'jorok', 'lantai', 'kamu', 'ambe', 'tusa', 'panako', 'ujang', 'rica'),
('jeremia andreas waani', 'air', 'jelek', 'jorok', 'lantai', 'kamu', 'ambe', 'tusa', 'panako', 'ujang', 'rica'),
('solagratia angelita fiera maga', 'air', 'jelek', 'jorok', 'lantai', 'kamu', 'ambe', 'tusa', 'panako', 'ujang', 'rica'),
('gilbert cefryo palentein', 'air', 'jelek', 'kotor', 'lantai', 'kamu', 'ambe', 'tusa', 'panako', 'ujang', 'rica'),
('anisa tumbel', 'air', 'jelek', 'jorok', 'lantai', 'kamu', 'ambe', 'tusa', 'panako', 'ujang', 'rica');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
