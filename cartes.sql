-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: database
-- Generation Time: Aug 27, 2024 at 11:06 PM
-- Server version: 8.4.2
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cartes`
--
CREATE DATABASE IF NOT EXISTS `cartes` DEFAULT CHARACTER SET utf8mb4 ;
USE `cartes`;

-- --------------------------------------------------------

--
-- Table structure for table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE `administrateur` (
  `id` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

--
-- Truncate table before insert `administrateur`
--

TRUNCATE TABLE `administrateur`;
--
-- Dumping data for table `administrateur`
--

INSERT INTO `administrateur` (`id`, `email`, `password`) VALUES
(1, 'root@root.com', 'password');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `postnom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `profession` varchar(100) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sexe` enum('M','F') NOT NULL,
  `province` varchar(100) NOT NULL,
  `commune` varchar(100) NOT NULL,
  `quartier` varchar(100) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `qrcode` varchar(255) NOT NULL, 
  `cree_le` datetime default now()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

--
-- Truncate table before insert `clients`
--

TRUNCATE TABLE `clients`;
--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
