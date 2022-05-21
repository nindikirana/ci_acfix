-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Apr 2022 pada 17.25
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 5.6.39

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sp_acfix`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `gejala`
--

CREATE TABLE `gejala` (
  `Id_Gejala` char(5) NOT NULL,
  `Nama_Gejala` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `gejala`
--

INSERT INTO `gejala` (`Id_Gejala`, `Nama_Gejala`) VALUES
('G0001', 'AC mati total'),
('G0002', 'MCB Trip'),
('G0003', 'LED indicator unit indoor berkedip-kedip'),
('G0004', 'Kerusakan pada fuse atau sekering'),
('G0005', 'Sensor rusak'),
('G0006', 'IC program rusak'),
('G0007', 'Pin konektor dan jalur PCB rusak'),
('G0008', 'Tidak ada hembusan udara yang keluar dari blower AC'),
('G0009', 'Blower tidak bekerja sama sekali'),
('G0010', 'Lilitan motor blower putus atau terbakar'),
('G0011', 'AC menjadi kurang dingin'),
('G0012', 'Mesin kompresor menjadi berisik'),
('G0013', 'Kompresor menjadi cepat panas'),
('G0014', 'Ampere kompresor terlalu tinggi'),
('G0015', 'Mesin kompresor mendengung'),
('G0016', 'Kompresor berkarat'),
('G0017', 'Klep atau katup rusak'),
('G0018', 'AC tidak kunjung menyala'),
('G0019', 'Kipas AC tidak bergerak'),
('G0020', 'Badan kapasitor mengalami kembung'),
('G0021', 'AC mengeluarkan bunyi yang berisik'),
('G0022', 'Suara kipas outdoor berisik'),
('G0023', 'Putaran kipas outdoor tidak lancar'),
('G0024', 'Terdapat pembekuan pada pipa kecil'),
('G0025', 'Munculnya bunga es pada pipa instalasi'),
('G0026', 'Tidak ada suhu panas yang keluar di bagian unit outdoor'),
('G0027', 'Keluar air pada AC'),
('G0028', 'Biaya listrik membengkak'),
('G0029', 'Udara yang dihasilkan AC terasa panas'),
('G0030', 'Hembusan blower terhambat dan tidak merata'),
('G0031', 'Sirip-sirip evaporator tersumbat'),
('G0032', 'Coil kondensor terasa sangat panas'),
('G0033', 'Sirip-sirip kondensor tersumbat'),
('G0034', 'Kompresor tidak bekerja');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kerusakan`
--

CREATE TABLE `kerusakan` (
  `kode_kerusakan` char(5) NOT NULL,
  `nama_kerusakan` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kerusakan`
--

INSERT INTO `kerusakan` (`kode_kerusakan`, `nama_kerusakan`) VALUES
('K0001', 'Spark pada terminal utama atau kompresor rusak'),
('K0002', 'PCB Control Error'),
('K0003', 'Kebocoran refrigerant pada sambungan pipa'),
('K0004', 'Motor Blower rusak'),
('K0005', 'Kompresor rusak '),
('K0006', 'Kapasitor rusak'),
('K0007', 'Bearing kipas outdoor rusak'),
('K0008', 'Sirip-sirip evaporator kotor'),
('K0009', 'Sirip-sirip kondensor kotor');

-- --------------------------------------------------------

--
-- Struktur dari tabel `solusi`
--

CREATE TABLE `solusi` (
  `kode_solusi` char(5) NOT NULL,
  `solusi_penanganan` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `solusi`
--

INSERT INTO `solusi` (`kode_solusi`, `solusi_penanganan`) VALUES
('S0001', '1.	Mengganti konektor dan kabel yang terbakar\r\n2.	Kencangkan sambungan terminal dan konektor\r\n3.	Periksa kekuatan setiap sambungan\r\n'),
('S0002', '1.	Membersihkan PCB control menggunakan contact cleaner\r\n2.	Reset aliran listrik utama pada MCB dengan cara mematikan aliran listrik, lalu sekitar 2-3 menit kemudian, nyalakan kembali.\r\n'),
('S0003', '1.	Periksa setiap sambungan pipa menggunakan air sabun atau leakage detector.\r\n2.	Perbaiki kebocoran pipa dengan cara pengelasan\r\n3.	Kencangkan setiap sambungan pipa yang terkoneksi dengan nipple\r\n4.	Tambahkan refrigerant untuk menggantikan refrigerant yang hilang akibat kebocoran.\r\n'),
('S0004', 'Ganti motor blower dengan yang baru'),
('S0005', 'Ganti kompresor dengan yang baru'),
('S0006', 'Ganti kompresor baru sesuai ukurannya'),
('S0007', '1.	Bersihkan bearing menggunakan pelumas khusus\r\n2.	Jika rusak, ganti bearing dengan yang baru\r\n'),
('S0008', 'Membersihkan sirip-sirip evaporator menggunakan air yang dicampur dengan cairan pembersih khusus, semprotkan menggunakan pompa steam.'),
('S0009', 'Membersihkan sirip-sirip kondensor menggunakan air yang dicampur dengan cairan pembersih khusus, semprotkan menggunakan pompa steam.');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`Id_Gejala`);

--
-- Indeks untuk tabel `kerusakan`
--
ALTER TABLE `kerusakan`
  ADD PRIMARY KEY (`kode_kerusakan`);

--
-- Indeks untuk tabel `solusi`
--
ALTER TABLE `solusi`
  ADD PRIMARY KEY (`kode_solusi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
