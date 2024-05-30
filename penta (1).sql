-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2024 at 03:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penta`
--

-- --------------------------------------------------------

--
-- Table structure for table `pentatech`
--

CREATE TABLE `pentatech` (
  `id` int(11) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` int(10) NOT NULL,
  `password` varchar(20) NOT NULL,
  `confirmpassword` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pentatech`
--

INSERT INTO `pentatech` (`id`, `fullname`, `username`, `email`, `telephone`, `password`, `confirmpassword`) VALUES
(1, 'John Ray', 'johnray', 'johnray@gmail.com', 1234567890, '81dc9bdb52d04dc20036', '81dc9bdb52d04dc20036'),
(2, 'Glitse Ray', 'glitseray', 'gray@gmail.com', 1234567890, '1234', '1234'),
(3, 'Amidu Samadu', 'amidusamadu', 'asamadu@gmail.com', 244822108, 'asamadu', 'asamadu'),
(4, 'Ali Dawin', 'alidawin', 'alidawin@gmail.com', 1234567890, 'alidawin', 'alidawin');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `file` varchar(100) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `job` varchar(30) NOT NULL,
  `department` varchar(30) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `file`, `firstname`, `lastname`, `job`, `department`, `description`) VALUES
(6, 'FB_IMG_1580818603188.jpg', 'Richard', 'Doe', 'Front-end Developer', 'Software', 'Building website user interface using various languages and frameworks.'),
(7, '64ab89e4eb27c6da0809fa6951f1eeaa.jpg159', 'Paul', 'Ray', 'Front-end Developer', 'Software', 'Building website user interface using various languages and frameworks.'),
(8, '5852a8dc918861e9089810d434c8c800.jpg591', 'Paul', 'Sam', 'Front-end Developer', 'Software', 'Building website user interface using various languages and frameworks.'),
(9, 'FB_IMG_1580857165033.jpg', 'Amidu', 'Samadu', 'Accountant', 'Finance', 'Managing the internal and external finances of the organization'),
(10, 'IMAG0601.jpg', 'Kyle', 'Kumar', 'Procument Officer', 'Finance', 'Managing the internal and external purchases of the organization'),
(11, 'IMG_20200110_074138_215.jpg', 'Joe', 'Peter', 'Front-end Developer', 'Software', 'Developing mobile and web user interfaces using various frameworks and libararies');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pentatech`
--
ALTER TABLE `pentatech`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pentatech`
--
ALTER TABLE `pentatech`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
