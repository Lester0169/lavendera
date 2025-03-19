-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2025 at 04:51 PM
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
-- Database: `lavendera`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_management`
--

CREATE TABLE `customer_management` (
  `ID` int(11) NOT NULL,
  `Full_Name` varchar(255) DEFAULT NULL,
  `Full_Address` varchar(255) DEFAULT NULL,
  `Type_of_Service` varchar(255) DEFAULT NULL,
  `Phone_Number` varchar(15) DEFAULT NULL,
  `Bill` decimal(10,2) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_management`
--

INSERT INTO `customer_management` (`ID`, `Full_Name`, `Full_Address`, `Type_of_Service`, `Phone_Number`, `Bill`, `Status`, `Date`, `created_at`) VALUES
(1, 'John Doe', '123 Main St, Cityville', 'Dry Wash', '+63 912 345 678', 100.50, 'Self Pick Up', '2025-03-19', '2025-03-19 15:23:52'),
(2, 'Jane Smith', '456 Oak Rd, Townsville', 'Dry', '+63 905 567 890', 150.75, 'Drop Off', '2025-03-19', '2025-03-19 15:23:52'),
(3, 'Robert Brown', '789 Pine Ln, Villagewood', 'Dry Wash', '+63 917 876 543', 200.00, 'Self Pick Up', '2025-03-19', '2025-03-19 15:23:52'),
(4, 'Alice Johnson', '321 Maple Ave, Suburbia', 'Dry', '+63 908 432 109', 120.40, 'Drop Off', '2025-03-19', '2025-03-19 15:23:52'),
(5, 'Michael White', '654 Birch Blvd, Uptown', 'Dry Wash', '+63 922 678 901', 180.25, 'Self Pick Up', '2025-03-19', '2025-03-19 15:23:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_management`
--
ALTER TABLE `customer_management`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_management`
--
ALTER TABLE `customer_management`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
