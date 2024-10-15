-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2024 at 04:36 PM
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
-- Database: `car`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `title` varchar(222) DEFAULT NULL,
  `model_year` int(11) DEFAULT NULL,
  `KM` int(11) DEFAULT NULL,
  `color` int(11) DEFAULT NULL,
  `image` int(11) DEFAULT NULL,
  `description` varchar(222) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cars_admins`
--

CREATE TABLE `cars_admins` (
  `id` int(11) NOT NULL,
  `name` varchar(222) DEFAULT NULL,
  `email` varchar(222) DEFAULT NULL,
  `password` varchar(222) DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `image_name` varchar(200) DEFAULT NULL,
  `positions` int(11) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `rule_id` int(11) DEFAULT NULL,
  `role` int(1) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars_admins`
--

INSERT INTO `cars_admins` (`id`, `name`, `email`, `password`, `image`, `image_name`, `positions`, `phone`, `rule_id`, `role`) VALUES
(1, '‪ahmed elshaikh‬‏', 'elshaikh1932004@gmail.com', '$2y$10$GX9gCGVklS3uf3KlrQUBCeC6/Oz1fiy31vL4wnUYukhhlxGe15Goe', NULL, NULL, NULL, NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `cars_admin_data`
--

CREATE TABLE `cars_admin_data` (
  `id` int(11) NOT NULL,
  `name` varchar(222) DEFAULT NULL,
  `email` varchar(222) DEFAULT NULL,
  `password` varchar(222) DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `positions` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cars_brands`
--

CREATE TABLE `cars_brands` (
  `id` int(11) NOT NULL,
  `name` varchar(222) DEFAULT NULL,
  `country` varchar(222) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cars_customers`
--

CREATE TABLE `cars_customers` (
  `id` int(11) NOT NULL,
  `name` varchar(222) DEFAULT NULL,
  `email` varchar(222) DEFAULT NULL,
  `password` varchar(222) DEFAULT NULL,
  `status` varchar(212) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cars_messages`
--

CREATE TABLE `cars_messages` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `message` varchar(222) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cars_positions`
--

CREATE TABLE `cars_positions` (
  `id` int(11) NOT NULL,
  `name` varchar(222) DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cars_rules`
--

CREATE TABLE `cars_rules` (
  `id` int(11) NOT NULL,
  `title` varchar(222) DEFAULT NULL,
  `description` varchar(222) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `cars_admins`
--
ALTER TABLE `cars_admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rule_id` (`rule_id`);

--
-- Indexes for table `cars_admin_data`
--
ALTER TABLE `cars_admin_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cars_brands`
--
ALTER TABLE `cars_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cars_customers`
--
ALTER TABLE `cars_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cars_messages`
--
ALTER TABLE `cars_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `cars_positions`
--
ALTER TABLE `cars_positions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `cars_rules`
--
ALTER TABLE `cars_rules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cars_admins`
--
ALTER TABLE `cars_admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cars_admin_data`
--
ALTER TABLE `cars_admin_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cars_brands`
--
ALTER TABLE `cars_brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cars_customers`
--
ALTER TABLE `cars_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cars_messages`
--
ALTER TABLE `cars_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cars_positions`
--
ALTER TABLE `cars_positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cars_rules`
--
ALTER TABLE `cars_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `cars_brands` (`id`),
  ADD CONSTRAINT `cars_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `cars_customers` (`id`);

--
-- Constraints for table `cars_admins`
--
ALTER TABLE `cars_admins`
  ADD CONSTRAINT `cars_admins_ibfk_1` FOREIGN KEY (`rule_id`) REFERENCES `cars_rules` (`id`);

--
-- Constraints for table `cars_messages`
--
ALTER TABLE `cars_messages`
  ADD CONSTRAINT `cars_messages_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `cars_customers` (`id`),
  ADD CONSTRAINT `cars_messages_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `cars_customers` (`id`);

--
-- Constraints for table `cars_positions`
--
ALTER TABLE `cars_positions`
  ADD CONSTRAINT `cars_positions_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `cars_positions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
