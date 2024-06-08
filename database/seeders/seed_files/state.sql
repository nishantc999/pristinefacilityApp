-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2024 at 04:59 PM
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
-- Database: `nccf_cpanel`
--

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `id` int(11) NOT NULL,
  `state_title` varchar(100) NOT NULL,
  `state_description` text NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `state_title`, `state_description`, `status`) VALUES
(1, 'Andaman & Nicobar Islands', '', 'Active'),
(2, 'Andhra Pradesh', '', 'Active'),
(3, 'Arunachal Pradesh', '', 'Active'),
(4, 'Assam', '', 'Active'),
(5, 'Bihar', '', 'Active'),
(6, 'Chandigarh', '', 'Active'),
(7, 'Chhattisgarh', '', 'Active'),
(8, 'Dadra & Nagar Haveli', '', 'Active'),
(9, 'Daman & Diu', '', 'Active'),
(10, 'Delhi', '', 'Active'),
(11, 'Goa', '', 'Active'),
(12, 'Gujarat', '', 'Active'),
(13, 'Haryana', '', 'Active'),
(14, 'Himachal Pradesh', '', 'Active'),
(15, 'Jammu & Kashmir', '', 'Active'),
(16, 'Jharkhand', '', 'Active'),
(17, 'Karnataka', '', 'Active'),
(18, 'Kerala', '', 'Active'),
(19, 'Lakshadweep', '', 'Active'),
(20, 'Madhya Pradesh', '', 'Active'),
(21, 'Maharashtra', '', 'Active'),
(22, 'Manipur', '', 'Active'),
(23, 'Meghalaya', '', 'Active'),
(24, 'Mizoram', '', 'Active'),
(25, 'Nagaland', '', 'Active'),
(26, 'Odisha', '', 'Active'),
(27, 'Puducherry', '', 'Active'),
(28, 'Punjab', '', 'Active'),
(29, 'Rajasthan', '', 'Active'),
(30, 'Sikkim', '', 'Active'),
(31, 'Tamil Nadu', '', 'Active'),
(32, 'Tripura', '', 'Active'),
(33, 'Uttar Pradesh', '', 'Active'),
(34, 'Uttarakhand', '', 'Active'),
(35, 'West Bengal', '', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6600;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
