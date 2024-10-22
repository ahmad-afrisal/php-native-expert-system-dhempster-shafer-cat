-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 17, 2024 at 06:10 AM
-- Server version: 5.7.33
-- PHP Version: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pakar-penyakit-kucing`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gejala`
--

CREATE TABLE `tbl_gejala` (
  `kode_gejala` varchar(11) NOT NULL,
  `nama_gejala` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_gejala`
--

INSERT INTO `tbl_gejala` (`kode_gejala`, `nama_gejala`) VALUES
('G01', 'Gatal yang akut'),
('G02', 'Telinga keropeng'),
('G03', 'Kurang nafsu makan'),
('G04', 'Bulu kusam'),
('G05', 'Perilaku sering menggaruk'),
('G06', 'Demam'),
('G07', 'Muntah'),
('G08', 'Diare'),
('G09', 'Dehidrasi'),
('G10', 'Susah pipis'),
('G11', 'Susah BAB'),
('G12', 'Pipis berdarah'),
('G13', 'Sariawan'),
('G14', 'Air liur berlebih'),
('G15', 'Mata berair'),
('G16', 'Mata merah'),
('G17', 'Mata bengkak');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penyakit`
--

CREATE TABLE `tbl_penyakit` (
  `kode_penyakit` varchar(11) NOT NULL,
  `nama_penyakit` varchar(100) DEFAULT NULL,
  `keterangan` text NOT NULL,
  `pencegahan` text NOT NULL,
  `kode_gejala` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_penyakit`
--

INSERT INTO `tbl_penyakit` (`kode_penyakit`, `nama_penyakit`, `keterangan`, `pencegahan`, `kode_gejala`) VALUES
('P1', 'Scabies', 'Penyakit scabies atau kudis adalah penyakit kulit menular yang bisa dialami oleh manusia dan juga hewan, termasuk hewan berbulu seperti kucing. Scabies pada kucing disebabkan oleh infeksi tungau sarcoptes scabei dan Notoedres cati pada kucing penyakit ini menimbulkan rasa tidak nyaman, gatal-gatal, iritasi kulit, bahkan kulit berkerak.', '<p>Penanganan penyakit scabies pada kucing melibatkan langkah-langkah berikut :</p><p>1. Mandikan kucing secara teratur dan pastikan lingkungan bebas dari tungau.</p><p>2. Gunakan obat antiparasit, seperti spot-on/ shampo anti-tungau atau suntik scabies</p><p>3. Konsultasikan dengan dokter hewan untuk perawatan yang tepat sesuai kondisi kucing Anda.</p><p>4. Isolasi kucing terjangkit scabies.</p><p>5. Bersihkan kandang dan perlengkapan kucing.</p>', '[\"G01\", \"G02\", \"G03\", \"G04\"]'),
('P2', 'Virus Panleukopenia', 'Penyakit Virus Panleukopenia adalah penyakit menular yang disebabkan oleh parvovirus. Virus ini sangat rentan menyerang anak kucing dan tidak menginfeksi manusia. Panleukopenia menginfeksi kucing dengan cara membunuh sel-sel aktif membelah tulang sumsum, usus, dan janin yang sedang berkembang. ', '<p>Penanganan yang dapat dilakukan adalah transfusi darah untuk meningkatkan pansitopenia, infus cairan untuk menangani dehidrasi, dan pemberian vitamin/daya tahan tubuh, serta antibiotik untuk menangani infeksi sekunder</p>', '[\"G03\", \"G06\", \"G07\", \"G08\", \"G09\"]'),
('P3', 'FLUTD', 'FLUTD (Feline lower urinary tract diseases) adalah istilah yang digunakan untuk mengambarkan sekelompok gangguan yang mempengaruhi saluran kemih bagian bawah pada kucing.', '<p>Penanganan penyakit FLUTD pada kucing meliputi<br>1. &nbsp; &nbsp;Membawa kucing ke dokter hewan untuk pemeriksaan dan diagnosis.<br>2. &nbsp; &nbsp;Merawat kucing di rumah berdasarkan saran dari dokter hewan.<br>3. &nbsp; &nbsp;Mengatur pola makan kucing, terutama jika ada pembentukan kristal atau batu kandung kemih.<br>4. &nbsp; &nbsp;Pemasangan kateter untuk mengeluarkan urin dan terapi nutrisi.<br>5. &nbsp; &nbsp;Pada kasus berat, tindakan bedah mungkin diperlukan untuk mengangkat batu</p>', '[\"G03\", \"G07\", \"G10\", \"G11\", \"G12\"]'),
('P4', 'Calicivirus', 'Calicivirus adalah salah satu virus yang menyebabkan infeksi pernafasan ringan hingga parah pada kucing. Tanda yang paling umum yaitu gangguan saluran pernapasan atas. Namun, infeksi virus calici yang parah bisa menyebar keparu-paru, persendian, sampai organ lainnya.', '<p>Pengobatan calicivirus pada kucing</p>\r\n<ul type=\"disc\">\r\n<li>Obat pereda nyeri untuk meredakan ketidaknyamanan.</li>\r\n<li>Antibiotik untuk mengobati infeksi bakteri sekunder yang sering kali menyertai saat kucing terkena calicivirus.</li>\r\n<li>Obat antibiotik mata topikal untuk kucing yang mengalami infeksi mata.</li>\r\n<li>Obat antiinflamasi nonsteroid oral untuk mengurangi peradangan dan demam.</li>\r\n<li>Cairan intravena diberikan jika kucing mengalami dehidrasi dan membantu mengurangi demam.</li>\r\n</ul>', '[\"G03\", \"G06\", \"G09\", \"G13\", \"G14\"]'),
('P5', 'Radang mata', 'Radang Mata adalah salah satu penyebab mata kucing menjadi merah. Infeksi mata pada kucing biasanya disebabkan oleh virus atau bakteri.  ', '<p>Jika ada tanda-tanda ketidaknyamanan, bantulah untuk membersihkan mata sang&nbsp;kucing. Jika tidak kunjung membaik, segeralah berkunjung ke dokter hewan. Selain itu, pastikan untuk selalu memberikan makanan kucing bernutrisi tinggi agar dapat bantu mencegah&nbsp;sakit mata&nbsp;pada anabul kesayangan.</p>', '[\"G15\", \"G16\", \"G17\"]'),
('PO8', 'Asa', 'oko', '<p><strong><em>reststs</em></strong></p>', '[\"G01\", \"G02\", \"G03\", \"G04\"]');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `nama`, `username`, `password`) VALUES
(1, 'marwah', 'admin', 'admin123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_gejala`
--
ALTER TABLE `tbl_gejala`
  ADD PRIMARY KEY (`kode_gejala`);

--
-- Indexes for table `tbl_penyakit`
--
ALTER TABLE `tbl_penyakit`
  ADD PRIMARY KEY (`kode_penyakit`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
