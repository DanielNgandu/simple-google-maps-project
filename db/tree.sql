-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2020 at 10:11 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

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

-- --------------------------------------------------------

--
-- Table structure for table `locations1`
--

CREATE TABLE `locations1` (
  `id` int(150) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `description` varchar(200) NOT NULL,
  `location_status` tinyint(1) DEFAULT 0,
  `img` varchar(500) NOT NULL,
  `created` timestamp(5) NOT NULL DEFAULT current_timestamp(5) ON UPDATE current_timestamp(5)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations1`
--

INSERT INTO `locations1` (`id`, `lat`, `lng`, `description`, `location_status`, `img`, `created`) VALUES
(1, -13.053837, 28.675991, 'Ndola Kafulafuta area was checked for deforestation activities', 1, 'hero.jpg', '2020-09-29 04:56:43.61136'),
(2, -13.192929, 28.192595, 'Tree planting was done here 23 rd september 2020', 1, 'hero.jpg', '2020-09-29 05:36:55.87831'),
(3, -12.206929, 27.335661, 'Lampant deforestation taking place here in chililabombwe', 0, 'hero.jpg', '2020-09-29 05:36:59.04245'),
(41, -12.924840, 24.717619, 'New Location', 1, 'zescounitsapp.jpg', '2020-09-30 07:57:08.92832');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `locations1`
--
ALTER TABLE `locations1`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `locations1`
--
ALTER TABLE `locations1`
  MODIFY `id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
