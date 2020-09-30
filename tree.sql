-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 28, 2020 at 01:24 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tree`
--

 --------------------------------------------------------

--
-- Table structure for table `locations1`
--
DROP TABLE IF EXISTS `locations1`;
CREATE TABLE IF NOT EXISTS `locations1` (
  `id` int(150) NOT NULL AUTO_INCREMENT,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `description` varchar(200) NOT NULL,
  `location_status` tinyint(1) DEFAULT 0,
  `img` longblob NOT NULL,
  `created` timestamp(5) NOT NULL DEFAULT current_timestamp(5) ON UPDATE current_timestamp(5),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
-- Dumping data for table `locations1`
--

INSERT INTO `locations1` (`id`, `lat`, `lng`, `description`, `location_status`, `img`, `created`) VALUES
(1, -13.053837, 28.675991, 'Ndola Kafulafuta area was checked for deforestation activities', 1, 0x433a5c5c66616b65706174685c5c627573682e6a7067, '2020-09-23 09:51:14.15835'),
(2, -13.192929, 28.192595, 'Tree planting was done here 23 rd september 2020', 1, 0x433a5c5c66616b65706174685c5c686f772d746f2d706c616e742d612d747265652e6a7067, '2020-09-23 10:07:23.30971'),
(3, -12.206929, 27.335661, 'Lampant deforestation taking place here in chililabombwe', 0, 0x433a5c5c66616b65706174685c5c666f7265737472792e6a7067, '2020-09-25 09:16:35.82739');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
