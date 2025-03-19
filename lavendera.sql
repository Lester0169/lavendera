-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2025 at 07:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'Lester', '123');

-- --------------------------------------------------------

--
-- Table structure for table `laundrywoman`
--

CREATE TABLE `laundrywoman` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `barangay` varchar(100) DEFAULT NULL,
  `phoneNumber` varchar(255) DEFAULT NULL,
  `valid_id` varchar(50) DEFAULT NULL,
  `years_of_experience` int(11) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `educational_background` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laundrywoman`
--

INSERT INTO `laundrywoman` (`id`, `name`, `date_of_birth`, `age`, `gender`, `barangay`, `phoneNumber`, `valid_id`, `years_of_experience`, `skills`, `educational_background`) VALUES
(45, 'Dangrey Laundromat', '2024-08-28', 21, 'male', 'Baliok', '09518410074', 'uploads/valid id.jpeg', 8, 'sadasdsa', 'asdsadsadasd'),
(46, 'Aiah Arceta', '2024-08-28', 21, 'female', 'Baliok', '09518410074', 'uploads/Aiah Arceta 🤍 (1).jpeg', 8, 'cddsad', 'asdsadasdasd');

-- --------------------------------------------------------

--
-- Table structure for table `manage`
--

CREATE TABLE `manage` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `phoneNumber` varchar(255) DEFAULT NULL,
  `valid_id` varchar(255) NOT NULL,
  `years_of_experience` int(11) DEFAULT NULL,
  `skills` text NOT NULL,
  `educational_background` text DEFAULT NULL,
  `application_status` varchar(50) DEFAULT 'pending',
  `application_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manage`
--

INSERT INTO `manage` (`id`, `name`, `date_of_birth`, `age`, `gender`, `barangay`, `phoneNumber`, `valid_id`, `years_of_experience`, `skills`, `educational_background`, `application_status`, `application_date`) VALUES
(39, 'Dangrey Laundromat', '2024-08-28', 21, 'male', 'Baliok', '09518410074', 'uploads/valid id.jpeg', 8, 'sadasdsa', 'asdsadsadasd', 'approved', '2024-08-27 16:55:52'),
(40, 'Aiah Arceta', '2024-08-28', 21, 'female', 'Baliok', '09518410074', 'uploads/Aiah Arceta 🤍 (1).jpeg', 8, 'cddsad', 'asdsadasdasd', 'approved', '2024-08-28 03:11:51');

-- --------------------------------------------------------

--
-- Table structure for table `personal_info`
--

CREATE TABLE `personal_info` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `availability` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `experience` text NOT NULL,
  `ratings` varchar(50) DEFAULT '5 stars',
  `phone_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal_info`
--

INSERT INTO `personal_info` (`id`, `name`, `image`, `availability`, `barangay`, `experience`, `ratings`, `phone_number`) VALUES
(23, 'Dangrey Laundromat', 'uploads/images.jpeg', 'Monday to Friday 8:00 am to 5:00 pm', 'Baliok', '11', '0 stars', '09518410074'),
(24, 'Aiah Arceta', 'uploads/Aiah Arceta 🤍 (1).jpeg', 'Monday to Friday 8:00 am to 5:00 pm', 'Baliok', '8', '0 stars', '09518410074');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_name`, `service_price`) VALUES
(26, 'Wash and Fold', '₱35 per kilogram');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `phoneNumber` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(20) DEFAULT 'user',
  `photo` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `barangay`, `dateOfBirth`, `phoneNumber`, `password`, `usertype`, `photo`) VALUES
(84, 'dangrey', 'Dangrey Laundromat', 'Baliok', '2024-08-28', '09518410074', '123', 'laundrywoman', ''),
(85, 'les', 'Lester Jhon Andico', 'Baliok', '2024-08-28', '09518410074', '123', 'user', 0x75706c6f6164732f363663653935663064656235332d64616e677265792063757469652e6a7067),
(86, 'aiah', 'Aiah Arceta', 'Baliok', '2024-08-28', '09518410074', '123', 'laundrywoman', 0x75706c6f6164732f363665636531316238306139632d416961682041726365746120f09fa48d202831292e6a706567),
(87, 'rendel123', 'Rendel Gerongco', 'Ma-a', '2025-03-01', '09518410074', '123', 'user', 0x75706c6f6164732f363763326131383361326630302d53756e67206a696e20776f6f2e6a706567);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `laundrywoman`
--
ALTER TABLE `laundrywoman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manage`
--
ALTER TABLE `manage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_info`
--
ALTER TABLE `personal_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `laundrywoman`
--
ALTER TABLE `laundrywoman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `manage`
--
ALTER TABLE `manage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `personal_info`
--
ALTER TABLE `personal_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
