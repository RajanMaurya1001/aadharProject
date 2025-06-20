-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2025 at 12:14 PM
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
-- Database: `psprint`
--

-- --------------------------------------------------------

--
-- Table structure for table `aadhar`
--

CREATE TABLE `aadhar` (
  `id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `aadhar_no` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `fName` varchar(40) NOT NULL,
  `house_no` varchar(20) NOT NULL,
  `locality` varchar(40) NOT NULL,
  `post_office` varchar(30) NOT NULL,
  `state` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `pin_code` varchar(20) NOT NULL,
  `dob` text NOT NULL,
  `birth_address` varchar(40) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `phone` int(20) NOT NULL,
  `image` varchar(100) NOT NULL,
  `language` varchar(20) NOT NULL,
  `name_local_language` varchar(20) NOT NULL,
  `gender_local` varchar(40) NOT NULL,
  `address_local_language` varchar(30) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `status` enum('Pending','Process','Approved','Rejected') DEFAULT 'Pending',
  `remark` varchar(255) NOT NULL,
  `certificate_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_wallet`
--

CREATE TABLE `admin_wallet` (
  `id` int(20) NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT 1,
  `amount` decimal(20,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_wallet`
--

INSERT INTO `admin_wallet` (`id`, `user_id`, `amount`, `created_at`) VALUES
(4, 2, 0.00, '2025-05-20 09:50:42');

-- --------------------------------------------------------

--
-- Table structure for table `birth_certificate`
--

CREATE TABLE `birth_certificate` (
  `id` int(10) NOT NULL,
  `user_id` int(40) NOT NULL,
  `certificate` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `district` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `aadhar_number` int(50) NOT NULL,
  `phone` int(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` varchar(20) NOT NULL,
  `fName` varchar(50) NOT NULL,
  `fAadhar` int(50) NOT NULL,
  `mName` varchar(50) NOT NULL,
  `mAadhar` int(50) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `application_no` varchar(20) DEFAULT NULL,
  `remark` varchar(255) NOT NULL,
  `status` enum('Pending','Process','Approved','Rejected') DEFAULT 'Pending',
  `certificate_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `licence`
--

CREATE TABLE `licence` (
  `id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `state` varchar(50) NOT NULL,
  `district` varchar(50) NOT NULL,
  `application_no` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `phone` int(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `status` enum('Pending','Process','Approved','Rejected') DEFAULT 'Pending',
  `remark` varchar(255) NOT NULL,
  `certificate_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pan`
--

CREATE TABLE `pan` (
  `id` int(10) NOT NULL,
  `user_id` int(20) NOT NULL,
  `card_type` varchar(20) NOT NULL,
  `pan_no` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `fName` varchar(50) NOT NULL,
  `dob` varchar(30) NOT NULL,
  `phone` int(40) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `image` varchar(20) NOT NULL,
  `sign_image` varchar(20) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `status` enum('Pending','Process','Approved','Rejected') DEFAULT 'Pending',
  `remark` varchar(255) NOT NULL,
  `certificate_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pm_kissan`
--

CREATE TABLE `pm_kissan` (
  `id` int(10) NOT NULL,
  `user_id` int(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `district` varchar(20) NOT NULL,
  `reg_no` int(20) NOT NULL,
  `aadhar_no` int(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` int(20) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `status` enum('Pending','Process','Approved','Rejected') DEFAULT 'Pending',
  `application_no` varchar(20) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `certificate_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ration`
--

CREATE TABLE `ration` (
  `id` int(10) NOT NULL,
  `user_id` int(20) NOT NULL,
  `ration_number` varchar(50) NOT NULL,
  `applicant_name` varchar(40) NOT NULL,
  `phone` int(20) NOT NULL,
  `state` varchar(40) NOT NULL,
  `district` varchar(40) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `certificate_file` varchar(255) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `status` enum('Pending','Process','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(20) NOT NULL,
  `service_name` varchar(50) NOT NULL,
  `service_charge` varchar(50) NOT NULL,
  `created` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_name`, `service_charge`, `created`) VALUES
(2, 'Birth_certificate', '250', '2025-05-13 08:11:20.842615'),
(3, 'Learning_ licence', '100', '2025-05-19 12:15:43.805426'),
(4, 'ration_to_aadhar', '60', '2025-05-19 11:56:50.814624'),
(5, 'pm_kissan_seeding', '300', '2025-05-20 07:40:46.763931'),
(6, 'aadhar', '10', '2025-05-20 07:40:20.521603'),
(7, 'Aadhar to PAN', '15', '2025-05-13 08:14:09.521249'),
(8, 'Pan', '10', '2025-05-20 07:40:13.687450'),
(9, 'membership_amount', '49', '2025-05-20 09:53:02.417086');

-- --------------------------------------------------------

--
-- Table structure for table `total_wallet_balence`
--

CREATE TABLE `total_wallet_balence` (
  `id` int(20) NOT NULL,
  `user_id` bigint(50) NOT NULL,
  `wallet_balence` decimal(20,2) NOT NULL DEFAULT 0.00,
  `name` varchar(240) NOT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `total_wallet_balence`
--

INSERT INTO `total_wallet_balence` (`id`, `user_id`, `wallet_balence`, `name`, `Created_At`) VALUES
(7, 2, 0.00, 'Rajan Kushwaha', '2025-05-20 09:53:12');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `district` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 0,
  `membership_amount` bigint(50) DEFAULT NULL,
  `transaction_id` varchar(40) NOT NULL,
  `created_At` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `phone`, `district`, `state`, `role`, `membership_amount`, `transaction_id`, `created_At`) VALUES
(1, 'admin', 'admin@gmail.com', '12345', '123456', '', '', 1, 0, '', '2025-05-12 06:31:20.235167');

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `id` int(20) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `name` varchar(245) DEFAULT NULL,
  `amount` int(20) NOT NULL,
  `payment_mode` varchar(40) NOT NULL,
  `user_id` int(20) NOT NULL,
  `email` varchar(201) DEFAULT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transaction_history`
--

CREATE TABLE `wallet_transaction_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `available_balance` decimal(10,2) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `type` enum('debit','credit') NOT NULL,
  `status` varchar(50) DEFAULT 'success',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aadhar`
--
ALTER TABLE `aadhar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_wallet`
--
ALTER TABLE `admin_wallet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `birth_certificate`
--
ALTER TABLE `birth_certificate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `licence`
--
ALTER TABLE `licence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pan`
--
ALTER TABLE `pan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pm_kissan`
--
ALTER TABLE `pm_kissan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ration`
--
ALTER TABLE `ration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `total_wallet_balence`
--
ALTER TABLE `total_wallet_balence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet_transaction_history`
--
ALTER TABLE `wallet_transaction_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aadhar`
--
ALTER TABLE `aadhar`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_wallet`
--
ALTER TABLE `admin_wallet`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `birth_certificate`
--
ALTER TABLE `birth_certificate`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `licence`
--
ALTER TABLE `licence`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pan`
--
ALTER TABLE `pan`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pm_kissan`
--
ALTER TABLE `pm_kissan`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ration`
--
ALTER TABLE `ration`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `total_wallet_balence`
--
ALTER TABLE `total_wallet_balence`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallet_transaction_history`
--
ALTER TABLE `wallet_transaction_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
