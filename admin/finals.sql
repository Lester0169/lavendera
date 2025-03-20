-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 01:07 PM
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
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `ID` int(11) NOT NULL,
  `Full_Name` varchar(100) NOT NULL,
  `Full_Address` text DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Type_of_Service` varchar(100) DEFAULT NULL,
  `Phone_Number` varchar(20) DEFAULT NULL,
  `Bill` decimal(10,2) DEFAULT NULL,
  `Status` varchar(50) DEFAULT 'Scheduled for Pickup',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'John Doe', '123 Main St, Cityville', 'Dry Wash', '+63 912 345 678', 100.50, 'Scheduled for Pickup', '2025-03-19', '2025-03-20 08:03:07'),
(2, 'Jane Smith', '456 Oak Rd, Townsville', 'Dry', '+63 905 567 890', 150.75, 'Drop Off', '2025-03-19', '2025-03-19 15:23:52'),
(3, 'Robert Brown', '789 Pine Ln, Villagewood', 'Dry Wash', '+63 917 876 543', 200.00, 'Self Pick Up', '2025-03-19', '2025-03-19 15:23:52'),
(4, 'Alice Johnson', '321 Maple Ave, Suburbia', 'Dry', '+63 908 432 109', 120.40, 'Drop Off', '2025-03-19', '2025-03-19 15:23:52'),
(5, 'Michael White', '654 Birch Blvd, Uptown', 'Dry Wash', '+63 922 678 901', 180.25, 'Self Pick Up', '2025-03-19', '2025-03-19 15:23:52');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_type` varchar(50) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `pickup_date` date DEFAULT NULL,
  `dropoff_date` date DEFAULT NULL,
  `delivery_option` varchar(50) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `service_type`, `total_price`, `pickup_date`, `dropoff_date`, `delivery_option`, `payment_method_id`, `created_at`, `status`) VALUES
(8, 4, 'pickup', 0.00, '2025-03-28', '0000-00-00', 'delivery', 1, '2025-03-19 18:10:10', 'Pending'),
(9, 4, 'pickup', 0.00, '2025-03-28', '0000-00-00', 'delivery', 1, '2025-03-19 18:11:50', 'Pending'),
(10, 4, 'pickup', 0.00, '2025-03-28', '2025-03-27', 'delivery', 1, '2025-03-19 18:12:24', 'Pending'),
(11, 4, 'pickup', 0.00, '2025-03-28', '2025-03-27', 'delivery', 1, '2025-03-19 18:13:06', 'Pending'),
(12, 4, 'dropoff', 90.00, '0000-00-00', '2025-03-27', 'selfPickup', 1, '2025-03-19 18:23:18', 'Pending'),
(13, 4, 'pickup', 155.00, '2025-03-26', '2025-03-27', 'delivery', 1, '2025-03-19 18:23:40', 'Pending'),
(14, 4, 'dropoff', 115.00, '0000-00-00', '2025-03-27', 'selfPickup', 1, '2025-03-20 05:08:44', 'Pending'),
(15, 4, 'pickup', 150.00, '2025-03-25', '0000-00-00', 'selfPickup', 1, '2025-03-20 05:09:37', 'Pending'),
(16, 4, 'pickup', 145.00, '0000-00-00', '0000-00-00', 'delivery', 1, '2025-03-20 06:23:38', 'Pending'),
(17, 4, 'pickup', 145.00, '2025-03-27', '0000-00-00', 'selfPickup', 1, '2025-03-20 06:57:39', 'Pending'),
(18, 4, 'pickup', 160.00, '2025-03-27', '0000-00-00', 'selfPickup', 1, '2025-03-20 07:41:56', 'Pending'),
(19, 4, 'pickup', 95.00, '2025-03-27', '0000-00-00', 'selfPickup', 1, '2025-03-20 08:34:11', 'Pending'),
(20, 4, 'dropoff', 115.00, '2025-03-27', '2025-03-27', 'delivery', 1, '2025-03-20 09:14:15', 'Pending'),
(21, 4, 'pickup', 145.00, '2025-03-20', '0000-00-00', 'delivery', 1, '2025-03-20 09:16:53', 'Pending'),
(22, 4, 'pickup', 145.00, '2025-03-20', '0000-00-00', 'delivery', 1, '2025-03-20 09:43:34', 'Pending'),
(23, 4, 'dropoff', 65.00, '0000-00-00', '2025-03-20', 'selfPickup', 1, '2025-03-20 09:59:37', 'Pending'),
(24, 4, 'dropoff', 40.00, '0000-00-00', '2025-03-27', 'selfPickup', 1, '2025-03-20 10:13:02', 'Pending'),
(25, 4, 'dropoff', 115.00, '0000-00-00', '2025-03-27', 'delivery', 1, '2025-03-20 10:20:45', 'Pending'),
(26, 4, 'pickup', 145.00, '2025-03-26', '0000-00-00', 'delivery', 1, '2025-03-20 11:04:39', 'Pending'),
(27, 4, 'pickup', 145.00, '2025-03-27', '0000-00-00', 'delivery', 1, '2025-03-20 11:05:13', 'Pending'),
(28, 4, 'pickup', 145.00, '2025-03-27', '0000-00-00', 'delivery', 1, '2025-03-20 11:05:13', 'Pending'),
(29, 4, 'pickup', 145.00, '2025-03-27', '0000-00-00', 'delivery', 1, '2025-03-20 11:05:13', 'Pending'),
(30, 4, 'pickup', 145.00, '2025-03-27', '0000-00-00', 'delivery', 1, '2025-03-20 11:05:14', 'Pending'),
(31, 4, 'pickup', 145.00, '2025-03-26', '0000-00-00', 'delivery', 1, '2025-03-20 11:05:24', 'Pending'),
(32, 4, 'dropoff', 65.00, '0000-00-00', '2025-03-27', 'selfPickup', 1, '2025-03-20 11:11:18', 'Pending'),
(33, 4, 'pickup', 145.00, '0000-00-00', '0000-00-00', 'delivery', 1, '2025-03-20 11:23:40', 'Pending'),
(34, 4, 'pickup', 145.00, '2025-03-27', '0000-00-00', 'delivery', 1, '2025-03-20 11:26:08', 'Pending'),
(35, 4, 'dropoff', 65.00, '0000-00-00', '2025-03-26', 'selfPickup', 1, '2025-03-20 11:42:16', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_delivery`
--

CREATE TABLE `order_delivery` (
  `delivery_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `delivery_option` varchar(50) NOT NULL,
  `delivery_fee` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_delivery`
--

INSERT INTO `order_delivery` (`delivery_id`, `order_id`, `delivery_option`, `delivery_fee`) VALUES
(8, 8, 'delivery', 50.00),
(9, 9, 'delivery', 50.00),
(10, 10, 'delivery', 50.00),
(11, 11, 'delivery', 50.00),
(12, 12, 'selfPickup', 0.00),
(13, 13, 'delivery', 50.00),
(14, 14, 'selfPickup', 0.00),
(15, 15, 'selfPickup', 0.00),
(16, 16, 'delivery', 50.00),
(17, 17, 'selfPickup', 0.00),
(18, 18, 'selfPickup', 0.00),
(19, 19, 'selfPickup', 0.00),
(20, 20, 'delivery', 50.00),
(21, 21, 'delivery', 50.00),
(22, 22, 'delivery', 50.00),
(23, 23, 'selfPickup', 0.00),
(24, 24, 'selfPickup', 0.00),
(25, 25, 'delivery', 50.00),
(26, 31, 'delivery', 50.00),
(27, 32, 'selfPickup', 0.00),
(28, 33, 'delivery', 50.00),
(29, 34, 'delivery', 50.00),
(30, 35, 'selfPickup', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_services`
--

CREATE TABLE `order_services` (
  `order_service_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pickup_locations`
--

CREATE TABLE `pickup_locations` (
  `id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `instructions` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pickup_locations`
--

INSERT INTO `pickup_locations` (`id`, `address`, `instructions`, `created_at`) VALUES
(1, 'dsadadsa', 'dsadsadsad', '2025-03-20 07:40:25'),
(2, 'Blk 36 Lot 21 Rosalina Village 3 Baliok Davao City', 'SADSADSADASDASDS', '2025-03-20 07:43:01'),
(3, 'Blk 36 Lot 21 Rosalina Village 3 Baliok Davao City', 'sdsadsadadasdsad', '2025-03-20 07:46:54'),
(4, 'asdsad', 'asdasdasdad', '2025-03-20 08:33:59'),
(5, 'Blk 36 Lot 21 Rosalina Village 3 Baliok Davao City', 'asdsadasdasd', '2025-03-20 09:13:59'),
(6, 'blk 36', 'asdsadsad', '2025-03-20 09:16:40'),
(7, 'blk 36', 'asdsadsadsadsad', '2025-03-20 09:43:26'),
(8, 'asdsad', 'asdasdasdsa', '2025-03-20 09:59:24'),
(9, 'sadsadsadsa', 'dasdsadasdadsad', '2025-03-20 10:12:52'),
(10, 'Blk 36 Lot 21 Rosalina Village 3 Baliok Davao City', 'dsadasdasd', '2025-03-20 10:20:38'),
(11, 'sadsad', 'asdasdasd', '2025-03-20 11:04:26'),
(12, 'blk 36', 'dasdsadsad', '2025-03-20 11:42:07');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `service_price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` enum('Pending','Paid','Failed') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `phoneNumber` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `dateOfBirth`, `phoneNumber`, `password`, `photo`, `created_at`) VALUES
(4, 'les', 'Lester Jhon Andico', '2025-03-18', '09518410074', '$2y$10$w6MvsRY0ulSwky1BJ2Ieb.ZWqR.OXZjsNrarsJi.4eplr6hJIdccu', NULL, '2025-03-18 11:09:12'),
(5, 'dangrey', 'Dangrey cutie masyado', '2025-03-20', '09518410074', '$2y$10$QLZgX7XdogxoJNfNaHRotOP3n5DtxuuyJEr/MnHS5/fBx.3u7npN6', NULL, '2025-03-19 16:06:50');

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
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`Status`);

--
-- Indexes for table `customer_management`
--
ALTER TABLE `customer_management`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `order_delivery`
--
ALTER TABLE `order_delivery`
  ADD PRIMARY KEY (`delivery_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_services`
--
ALTER TABLE `order_services`
  ADD PRIMARY KEY (`order_service_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `pickup_locations`
--
ALTER TABLE `pickup_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_management`
--
ALTER TABLE `customer_management`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `order_delivery`
--
ALTER TABLE `order_delivery`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `order_services`
--
ALTER TABLE `order_services`
  MODIFY `order_service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `pickup_locations`
--
ALTER TABLE `pickup_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_delivery`
--
ALTER TABLE `order_delivery`
  ADD CONSTRAINT `order_delivery_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `order_services`
--
ALTER TABLE `order_services`
  ADD CONSTRAINT `order_services_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
