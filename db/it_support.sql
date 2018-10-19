-- phpMyAdmin SQL Dump
-- version 4.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 19, 2018 at 08:57 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.10RC1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `it_support`
--

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE IF NOT EXISTS `karyawan` (
  `id` int(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `alamat` text,
  `id_user_level` int(11) NOT NULL DEFAULT '100'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `nama`, `username`, `password`, `no_telp`, `alamat`, `id_user_level`) VALUES
(2, 'Oky', 'oky', 'a01fc1889227c327b3fff1af435f7273', '081219939135', NULL, 10),
(3, 'Dwi', 'dwi', 'babb9834d96c27f00b718469e0fba0bf', '081219939135', NULL, 100),
(5, 'Hartanto', 'hartanto', '165bb904df330836eafc751e197f9345', '081219939135', NULL, 100);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_support`
--

CREATE TABLE IF NOT EXISTS `ticket_support` (
  `id` bigint(50) NOT NULL,
  `id_karyawan` bigint(50) DEFAULT NULL,
  `judul` varchar(100) NOT NULL,
  `kendala` text NOT NULL,
  `status_progress` varchar(50) DEFAULT NULL,
  `date_create_at` datetime DEFAULT NULL,
  `id_karyawan_pemroses` bigint(50) DEFAULT NULL,
  `keterangan` text,
  `date_diproses` datetime DEFAULT NULL,
  `na` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticket_support`
--

INSERT INTO `ticket_support` (`id`, `id_karyawan`, `judul`, `kendala`, `status_progress`, `date_create_at`, `id_karyawan_pemroses`, `keterangan`, `date_diproses`, `na`) VALUES
(2, 5, 'Judul h', 'kendala h', 'Menunggu Antrian', '2018-10-19 07:25:32', NULL, NULL, NULL, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `userlevelpermissions`
--

CREATE TABLE IF NOT EXISTS `userlevelpermissions` (
  `userlevelid` int(11) NOT NULL,
  `tablename` varchar(255) NOT NULL DEFAULT '',
  `permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userlevelpermissions`
--

INSERT INTO `userlevelpermissions` (`userlevelid`, `tablename`, `permission`) VALUES
(-2, '{2D23B2F1-9107-4245-BBC7-F6E2C1DB634A}karyawan', 0),
(-2, '{2D23B2F1-9107-4245-BBC7-F6E2C1DB634A}ticket_support', 0),
(-2, '{2D23B2F1-9107-4245-BBC7-F6E2C1DB634A}userlevelpermissions', 0),
(-2, '{2D23B2F1-9107-4245-BBC7-F6E2C1DB634A}userlevels', 0),
(10, '{2D23B2F1-9107-4245-BBC7-F6E2C1DB634A}karyawan', 111),
(10, '{2D23B2F1-9107-4245-BBC7-F6E2C1DB634A}ticket_support', 110),
(10, '{2D23B2F1-9107-4245-BBC7-F6E2C1DB634A}userlevelpermissions', 111),
(10, '{2D23B2F1-9107-4245-BBC7-F6E2C1DB634A}userlevels', 111),
(100, '{2D23B2F1-9107-4245-BBC7-F6E2C1DB634A}karyawan', 108),
(100, '{2D23B2F1-9107-4245-BBC7-F6E2C1DB634A}ticket_support', 109),
(100, '{2D23B2F1-9107-4245-BBC7-F6E2C1DB634A}userlevelpermissions', 96),
(100, '{2D23B2F1-9107-4245-BBC7-F6E2C1DB634A}userlevels', 96);

-- --------------------------------------------------------

--
-- Table structure for table `userlevels`
--

CREATE TABLE IF NOT EXISTS `userlevels` (
  `userlevelid` int(11) NOT NULL,
  `userlevelname` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userlevels`
--

INSERT INTO `userlevels` (`userlevelid`, `userlevelname`) VALUES
(-2, 'Anonymous'),
(-1, 'Administrator'),
(0, 'Default'),
(10, 'Administrasi IT Support'),
(100, 'Karyawan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `ticket_support`
--
ALTER TABLE `ticket_support`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userlevelpermissions`
--
ALTER TABLE `userlevelpermissions`
  ADD PRIMARY KEY (`userlevelid`,`tablename`);

--
-- Indexes for table `userlevels`
--
ALTER TABLE `userlevels`
  ADD PRIMARY KEY (`userlevelid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ticket_support`
--
ALTER TABLE `ticket_support`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
