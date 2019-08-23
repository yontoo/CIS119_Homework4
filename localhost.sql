-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 23, 2019 at 12:03 PM
-- Server version: 5.6.37
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(255) NOT NULL,
  `leagueName` varchar(16) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `leagueName`) VALUES
(4, 'gerbilstore', '$2y$10$bWNRVLhazxhdVQKBb1qlP.KoqvPa3Q0U5nZER4fuoABDllO17FTc2', ''),
(5, 'kazimelo', '$2y$10$SaEmTS8sOtcp7C/GnndrzOgXMLHAKIhu1fvOblNobDbg1AvHBn.VC', 'kazimelo'),
(6, 'badboys', '$2y$10$/Brg4cV1jntUZN2D/lVMOOOVvzLeqql8QUfJVjYsw/G5r9fcyS8wK', ''),
(7, 'shanharris', '$2y$10$zaG6JHJQhI3lB2mTwq//YeognD5FPUrOn/Qleag9KNIGv89OGpS1.', 'wickedcoven');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

GRANT USAGE ON *.* TO 'tray'@'localhost' IDENTIFIED BY PASSWORD '*42E5155315C1575AFE2F19ED56B357A657761BF8';
GRANT ALL PRIVILEGES ON `projectdb`.* TO 'tray'@'localhost';
