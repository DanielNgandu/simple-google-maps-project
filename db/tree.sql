-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2020 at 09:41 PM
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
-- Table structure for table `description_type`
--

CREATE TABLE `description_type` (
  `id` int(11) NOT NULL,
  `type` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `description_type`
--

INSERT INTO `description_type` (`id`, `type`) VALUES
(1, 'Tree Planting'),
(2, 'Deforestation'),
(3, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `locations1`
--

CREATE TABLE `locations1` (
  `id` int(150) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `description` varchar(200) NOT NULL,
  `description_type_id` int(40) DEFAULT NULL,
  `location_status` tinyint(1) DEFAULT 0,
  `img` varchar(500) NOT NULL,
  `created` timestamp(5) NOT NULL DEFAULT current_timestamp(5) ON UPDATE current_timestamp(5)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations1`
--

INSERT INTO `locations1` (`id`, `lat`, `lng`, `description`, `description_type_id`, `location_status`, `img`, `created`) VALUES
(49, -11.850192, 25.530605, 'New tree planting site', 1, 0, 'Wed09.30.2020CEST06_50_49pm_treeplanting.jpg', '2020-09-30 16:50:49.71603'),
(3, -12.206929, 27.335661, 'Lampant deforestation taking place here in chililabombwe', 2, 1, 'deforestation.jpg', '2020-09-30 16:48:22.28958'),
(2, -13.192929, 28.192595, 'Tree planting was done here 23 rd september 2020', 1, 1, 'treeplanting.jpg', '2020-09-30 16:48:42.21894');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `description_type`
--
ALTER TABLE `description_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations1`
--
ALTER TABLE `locations1`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `description_type`
--
ALTER TABLE `description_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `locations1`
--
ALTER TABLE `locations1`
  MODIFY `id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
