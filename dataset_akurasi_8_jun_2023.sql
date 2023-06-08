-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 08 Jun 2023 pada 19.26
-- Versi server: 10.4.20-MariaDB
-- Versi PHP: 8.0.8

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
-- Struktur dari tabel `dataset_akurasi_8_jun_2023`
--

CREATE TABLE `dataset_akurasi_8_jun_2023` (
  `no` int(11) NOT NULL,
  `predict_target_translations` varchar(27) DEFAULT NULL,
  `predict_source_translations` varchar(27) DEFAULT NULL,
  `actual_translations` varchar(19) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `dataset_akurasi_8_jun_2023`
--

INSERT INTO `dataset_akurasi_8_jun_2023` (`no`, `predict_target_translations`, `predict_source_translations`, `actual_translations`) VALUES
(2, 'Abu', 'Aub', 'Debu'),
(3, 'Aer', 'Arr', 'Air'),
(4, 'Ampat', 'Ampt', 'Empat'),
(5, 'Amper', 'Ampr', 'Dekat'),
(6, 'Anyor', 'Anyr', 'Hanyut'),
(7, 'Angus', 'Anngs', 'Hangus'),
(8, 'Avonturir', 'Avntrir', 'Tidak Lazim '),
(9, 'Balak', 'Blk', 'Kayu Potong'),
(10, 'Balakama', 'Blakma', 'Kemangi'),
(11, 'Bangong', 'Bgong', 'Bangun'),
(12, 'Banjer', 'Bnjre', 'Banjir'),
(13, 'Banoda', 'Bnda', 'Bernoda'),
(14, 'Bapete', 'Bpte', 'Memetik'),
(15, 'Bapici', 'Bapci', 'Menghitung Uang'),
(16, 'Baplaka', 'Bplka', 'Tengkurap'),
(17, 'Barol', 'Brl', 'Jagoan (Film)'),
(18, 'Baron', 'Brn', 'Berputar '),
(19, 'Baruba', 'Brba', 'Berubah'),
(20, 'Bas', 'Baas', 'Tukang Bangunan'),
(21, 'Basar', 'Bsr', 'Besar'),
(22, 'Basei', 'Bseii', 'Menghindar'),
(23, 'Basmengken', 'Bsmngkn', 'Memakai Lipstick'),
(24, 'Basosapu', 'Basspuu', 'Menyapu'),
(25, 'Basosere', 'Basser', 'Menghina'),
(26, 'Baspik', 'Bspk', 'Nyontek'),
(27, 'Boboca', 'Bobc', 'Gurita'),
(28, 'Bobou', 'Bobu', 'Bau'),
(29, 'Bok', 'Bk', 'Tikungan'),
(30, 'Boke', 'Bkee', 'Babi'),
(31, 'Bolotu', 'Blotu', 'Pelit'),
(32, 'Boto-Boto', 'Bot-Bto', 'Belalang'),
(33, 'Boton', 'Btonn', 'Tidak Lazim '),
(34, 'Bramakusu', 'Brmkus', 'Serai'),
(35, 'Brenebon', 'Brenbn', 'Kacang Merah'),
(36, 'Brenti', 'Brnti', 'Berhenti'),
(37, 'Brur', 'Brr', 'Seusia'),
(38, 'Budo', 'Bdo', 'Hampir Albino'),
(39, 'Budo Makao', 'Bdo mkao', 'Albino'),
(40, 'Bulu', 'Bull', 'Bambu'),
(41, 'Cabiu', 'Cabuu', 'Kotoran Telinga'),
(42, 'Cabu', 'Cbu', 'Cabut'),
(43, 'Cao', 'Coo', 'Bolos'),
(44, 'Cari Slak', 'Cri Sla', 'Cari Cara'),
(45, 'Carlota', 'Crlta', 'Cerewet'),
(46, 'Ceke', 'Cke', 'Makan'),
(47, 'Cere', 'Cee', 'Cerai'),
(48, 'Cewe', 'Cee', 'Cewek'),
(49, 'Cica', 'Ccaa', 'Cecak'),
(50, 'Cica Binkarong', 'Cica Bnkng', 'Kadal Kecil'),
(51, 'Cico', 'Ccoo', 'Centil'),
(52, 'Ciong', 'Cong', 'Cium'),
(53, 'Ciri', 'Cri', 'Jatuh'),
(54, 'Colo', 'Clo', 'Celup'),
(55, 'Dromulen', 'Romuln', 'Pasar Malam'),
(56, 'Dudu', 'Udu', 'Duduk'),
(57, 'Dusu', 'Duss', 'Kejar'),
(58, 'Enter', 'Entr', 'Kata Perbandingan'),
(59, 'Enteru', 'Entru', 'Utuh'),
(60, 'Fastiu', 'Fatiu', 'Bosan'),
(61, 'Forat', 'Frat', 'Simpanan'),
(62, 'Foya', 'Fya', 'Lama'),
(63, 'Gantong', 'Gntng', 'Gantung'),
(64, 'Gara', ' Gra', 'Ejek'),
(65, 'Garfu', 'Grfuu', 'Garpu'),
(66, 'Gartak', 'Grtakkk', 'Gertak'),
(67, 'Golojo', 'Glijo', 'Rakus'),
(68, 'Gomu', 'Gomoo', 'Lebam'),
(69, 'Gora', 'Gorrr', 'Jambu Air'),
(70, 'Goraka', 'Gorka', 'Jahe'),
(71, 'Goro', 'Gorr', 'Karet Gelang'),
(72, 'Goso', 'Goss', 'Gosok'),
(73, 'Grap', 'Grpp', 'Lucu'),
(74, 'Grendel', 'Grdel', 'Kunci'),
(75, 'Gros', 'Grss', 'Besar'),
(76, 'Haga', 'Hga', 'Tatap'),
(77, 'Hamis', 'Hmis', 'Basi'),
(78, 'Hela', 'Hla', 'Tarik'),
(79, 'Hidop', 'Hidp', 'Hidup'),
(80, 'Hoba', 'Hoa', 'Intip'),
(81, 'Idong', 'Idng', 'Hidung'),
(82, 'Ijo', 'Ijj', 'Hijau'),
(83, 'Ika', 'Ikk', 'Ikat'),
(84, 'Ikang', 'Ikng', 'Ikan'),
(85, 'Iko', 'Ikoi', 'Ikut'),
(86, 'Ilang', 'Ilng', 'Hilang'),
(87, 'Inga', 'Iga', 'Ingat'),
(88, 'Injang', 'Injg', 'Injak'),
(89, 'Jaga Blengko', 'Jga Blegk', 'Jaga Tempat'),
(90, 'Jaha', 'Jha', 'Jahat'),
(91, 'Jalang', 'Jlang', 'Jalan'),
(92, 'Jongko', 'Jongko', 'Jongkok'),
(93, 'Jumir', 'Jmirr', 'Tumit'),
(94, 'Kadera', 'Kadra', 'Kursi'),
(95, 'Temba', 'Tmba', 'Tembak'),
(96, 'Ujang', 'Ujng', 'Hujan'),
(97, 'Utang', 'Utng', 'Hutang'),
(98, 'Vol', 'Vool', 'Penuh'),
(99, 'Vor', 'Voor', 'Untuk'),
(100, 'Vruk', 'Vrkk', 'Lebih Cepat'),
(101, 'Yaki', 'Ykki', 'Monyet');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dataset_akurasi_8_jun_2023`
--
ALTER TABLE `dataset_akurasi_8_jun_2023`
  ADD PRIMARY KEY (`no`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `dataset_akurasi_8_jun_2023`
--
ALTER TABLE `dataset_akurasi_8_jun_2023`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
