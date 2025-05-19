-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2025 at 03:05 PM
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

--
-- Dumping data for table `aadhar`
--

INSERT INTO `aadhar` (`id`, `user_id`, `aadhar_no`, `name`, `fName`, `house_no`, `locality`, `post_office`, `state`, `city`, `pin_code`, `dob`, `birth_address`, `gender`, `address`, `phone`, `image`, `language`, `name_local_language`, `gender_local`, `address_local_language`, `created_at`, `status`, `remark`, `certificate_file`) VALUES
(11, 2, '4587962365', 'RaHA', 'FAG', '45', 'iJA', 'DEoria', 'UP', 'Deopria', '274001', '26/07/1992', 'जन्म तीथी', 'Male', 'S/O : FAG, 45, iJA, DEoria, Deopria, UP, 274001', 2147483647, '1747649850bing_generated_qrcode.png', 'HI', 'राहा', '', 'एस/ओ: फाग, 45, आईजेए, डोरिया, ', '2025-05-19 10:57:10.664926', 'Rejected', '', '');

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
(4, 2, 6030.00, '2025-05-19 12:49:26');

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

--
-- Dumping data for table `birth_certificate`
--

INSERT INTO `birth_certificate` (`id`, `user_id`, `certificate`, `state`, `district`, `name`, `aadhar_number`, `phone`, `gender`, `dob`, `fName`, `fAadhar`, `mName`, `mAadhar`, `address`, `created_at`, `application_no`, `remark`, `status`, `certificate_file`) VALUES
(5, 2, 'birth certificate', 'RAJASTHAN', 'DAUSA', 'OLEG BARNETT', 652, 1, 'MALE', '05-05-2025', 'CYRUS KINNEY', 100, 'PATIENCE TALLEY', 96, 'RATIONE INCIDIDUNT A', '2025-05-19 10:11:47.267013', 'Birth_APP20250001', '', 'Pending', NULL);

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

--
-- Dumping data for table `licence`
--

INSERT INTO `licence` (`id`, `user_id`, `state`, `district`, `application_no`, `dob`, `phone`, `password`, `created_at`, `status`, `remark`, `certificate_file`) VALUES
(1, 2, 'NAGALAND', 'DIMAPUR', '558665323', '0000-00-00', 2015, '123456', '2025-05-19 12:26:02.412979', 'Rejected', 'rajan', '');

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

--
-- Dumping data for table `pan`
--

INSERT INTO `pan` (`id`, `user_id`, `card_type`, `pan_no`, `name`, `fName`, `dob`, `phone`, `gender`, `image`, `sign_image`, `created_at`, `status`, `remark`, `certificate_file`) VALUES
(6, 2, 'NSDL (FULL PAGE)', 'CTUGE1616I', 'RAJAN', 'FATHER', '06/07/2003', 2147483647, 'Male', '1747653339bing_gener', '1747653339imgnew.jpg', '2025-05-19 12:49:26.347411', 'Rejected', '', ''),
(7, 2, 'NSDL (FULL PAGE)', 'CTUGE1616I', 'RAJAN', 'FATHER', '06/07/2003', 2147483647, 'Male', '1747655512bing_gener', '1747655512imgnew.jpg', '2025-05-19 12:38:23.765869', 'Approved', '', '');

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

--
-- Dumping data for table `pm_kissan`
--

INSERT INTO `pm_kissan` (`id`, `user_id`, `state`, `district`, `reg_no`, `aadhar_no`, `name`, `phone`, `created_at`, `status`, `application_no`, `remark`, `certificate_file`) VALUES
(8, 2, 'UTTAR PRADESH', 'BALRAMPUR', 2147483647, 2147483647, 'Rajan Kushwaha', 2147483647, '2025-05-19 12:34:17.262648', 'Rejected', 'PM_APP20250001', 'wrong Detals', '');

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

--
-- Dumping data for table `ration`
--

INSERT INTO `ration` (`id`, `user_id`, `ration_number`, `applicant_name`, `phone`, `state`, `district`, `remark`, `certificate_file`, `created_at`, `status`) VALUES
(1, 2, '456987123', 'Haley Rosario', 1, 'UTTAR PRADESH', 'BALRAMPUR', '', '', '2025-05-19 12:11:28.291303', 'Rejected');

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
(5, 'pm_kissan_seeding', '500', '2025-05-19 12:32:48.137289'),
(6, 'aadhar', '5', '2025-05-13 08:13:28.758894'),
(7, 'Aadhar to PAN', '15', '2025-05-13 08:14:09.521249'),
(8, 'Pan', '5', '2025-05-13 08:14:53.662340'),
(9, 'membership_amount', '49', '2025-05-19 11:55:45.588435');

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
(7, 2, 1580.00, 'Rajan Kushwaha', '2025-05-19 12:49:26');

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
(1, 'admin', 'admin@gmail.com', '12345', '123456', '', '', 1, 0, '', '2025-05-12 06:31:20.235167'),
(2, 'Rajan Kushwaha', 'rajan25kushwaha@gmail.com', '12345', '8303293043', '', '', 0, 0, '', '2025-05-14 12:38:08.897568'),
(3, 'Rajan ', 'rajan@gmail.com', '123456', '', '', '', 0, 0, '', '2025-05-12 05:37:02.814564'),
(4, 'newError', 'user@gmail.com', '123456', '1234567890', '', '', 0, 0, '', '2025-05-12 05:37:51.561855'),
(7, 'Vansh', 'Vansh@gmail.com', '', '8299394347', 'Aydhoya', 'up', 0, 0, '', '2025-05-15 13:07:31.720119'),
(8, 'Melanie Garcia', 'fazu@mailinator.com', '', '+1 (926) 873-5952', 'Voluptatem Pariatur', 'Minima ut qui nostru', 0, 0, 'pay_QVVYoxZD7HKHPv', '2025-05-16 06:52:48.603300'),
(9, 'Vivien Morrison', 'ninupovo@mailinator.com', 'Pa$$w0rd!', '+1 (916) 523-1819', 'Nisi dolor elit lab', 'Anim sint facere nis', 0, 1, 'pay_QVVf0dLlNGbfT3', '2025-05-16 06:58:36.732786');

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `id` int(20) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `amount` int(20) NOT NULL,
  `payment_mode` varchar(40) NOT NULL,
  `user_id` int(20) NOT NULL,
  `email` varchar(201) DEFAULT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wallet`
--

INSERT INTO `wallet` (`id`, `transaction_id`, `amount`, `payment_mode`, `user_id`, `email`, `created_at`) VALUES
(16, ' nfvfvfbvbfvbvf', 1000, 'upi', 2, NULL, '2025-05-13 10:45:53.185268'),
(17, ' GFGGFGFG', 500, 'upi', 2, NULL, '2025-05-13 10:46:27.001948'),
(18, '1jqgqraj45ssd', 1000, 'upi', 2, NULL, '2025-05-13 11:00:53.644201'),
(19, 'rfdsg654gsdg', 100, 'upi', 2, NULL, '2025-05-14 08:18:42.627654'),
(20, '', 100, 'upi', 2, NULL, '2025-05-14 08:57:54.767989'),
(21, 'pay_QUotJ0XXYehvix', 1, 'upi', 2, 'rajan25kushwaha@gmail.com', '2025-05-14 13:08:15.469231'),
(22, 'pay_QUoxzkbacsBV10', 1, 'upi', 2, 'rajan25kushwaha@gmail.com', '2025-05-14 13:12:41.516090');

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
-- Dumping data for table `wallet_transaction_history`
--

INSERT INTO `wallet_transaction_history` (`id`, `user_id`, `amount`, `available_balance`, `purpose`, `type`, `status`, `created_at`) VALUES
(1, 2, 250.00, 750.00, 'Birth Certificate', 'debit', 'success', '2025-05-17 08:53:34'),
(2, 2, 250.00, 500.00, 'Birth Certificate', 'debit', '1', '2025-05-17 09:00:42'),
(3, 2, 5.00, 495.00, 'Aadhar', 'debit', '1', '2025-05-17 09:04:59'),
(4, 2, 60.00, 435.00, 'Ration Details', 'debit', '1', '2025-05-17 09:06:48'),
(5, 2, 60.00, 375.00, 'Ration Details', 'debit', '1', '2025-05-17 09:07:14'),
(6, 2, 250.00, 875.00, 'Refund: Birth Certificate', 'credit', '1', '2025-05-17 09:34:38'),
(7, 2, 250.00, 1125.00, 'Refund: Birth Certificate', 'credit', '1', '2025-05-19 09:01:59'),
(8, 2, 250.00, 1375.00, 'Refund: Birth Certificate', 'credit', '1', '2025-05-19 09:02:13'),
(9, 2, 250.00, 1625.00, 'Refund: Birth Certificate', 'credit', '1', '2025-05-19 09:05:15'),
(10, 2, 250.00, 1375.00, 'Birth Certificate', 'debit', '1', '2025-05-19 09:11:26'),
(11, 2, 250.00, 1625.00, 'Refund: Birth Certificate', 'credit', '1', '2025-05-19 09:11:49'),
(12, 2, 5.00, 1620.00, 'Aadhar', 'debit', '1', '2025-05-19 09:17:07'),
(13, 2, 5.00, 1615.00, 'Aadhar', 'debit', '1', '2025-05-19 09:26:03'),
(14, 2, 5.00, 1610.00, 'Aadhar', 'debit', '1', '2025-05-19 09:27:48'),
(15, 2, 5.00, 1605.00, 'Aadhar', 'debit', '1', '2025-05-19 09:31:40'),
(16, 2, 5.00, 1600.00, 'Aadhar', 'debit', '1', '2025-05-19 09:34:50'),
(17, 2, 5.00, 1595.00, 'Aadhar', 'debit', '1', '2025-05-19 09:35:27'),
(18, 2, 5.00, 1590.00, 'Aadhar', 'debit', '1', '2025-05-19 09:36:41'),
(19, 2, 5.00, 1585.00, 'Aadhar', 'debit', '1', '2025-05-19 09:38:50'),
(20, 2, 5.00, 1580.00, 'Aadhar', 'debit', '1', '2025-05-19 09:40:18'),
(21, 2, 250.00, 1330.00, 'Birth Certificate', 'debit', '1', '2025-05-19 09:40:50'),
(22, 2, 60.00, 1270.00, 'Ration Details', 'debit', '1', '2025-05-19 09:42:44'),
(23, 2, 250.00, 1020.00, 'Birth Certificate', 'debit', '1', '2025-05-19 10:04:28'),
(24, 2, 250.00, 770.00, 'Birth Certificate', 'debit', '1', '2025-05-19 10:08:00'),
(25, 2, 250.00, 520.00, 'Birth Certificate', 'debit', '1', '2025-05-19 10:11:47'),
(26, 2, 5.00, 515.00, 'Aadhar', 'debit', '1', '2025-05-19 10:14:57'),
(27, 2, 5.00, 510.00, 'Aadhar', 'debit', '1', '2025-05-19 10:17:30'),
(28, 2, 5.00, 515.00, 'Refund: Birth Certificate', 'credit', '1', '2025-05-19 10:27:32'),
(29, 2, 5.00, 520.00, 'Refund: Birth Certificate', 'credit', '1', '2025-05-19 10:30:29'),
(30, 2, 5.00, 525.00, 'Refund: Aadhar Apply', 'credit', '1', '2025-05-19 10:33:52'),
(31, 2, 5.00, 530.00, 'Refund: Aadhar Apply', 'credit', '1', '2025-05-19 10:37:00'),
(32, 2, 5.00, 535.00, 'Refund: Aadhar Apply', 'credit', '1', '2025-05-19 10:40:17'),
(33, 2, 5.00, 540.00, 'Refund: Aadhar Apply', 'credit', '1', '2025-05-19 10:40:43'),
(34, 2, 5.00, 545.00, 'Refund: Aadhar Apply', 'credit', '1', '2025-05-19 10:43:17'),
(35, 2, 5.00, 550.00, 'Refund: Aadhar Apply', 'credit', '1', '2025-05-19 10:44:30'),
(36, 2, 5.00, 555.00, 'Refund: Aadhar Apply', 'credit', '1', '2025-05-19 10:45:38'),
(37, 2, 5.00, 560.00, 'Refund: Aadhar Apply', 'credit', '1', '2025-05-19 10:54:56'),
(38, 2, 5.00, 565.00, 'Refund: Aadhar Apply', 'credit', '1', '2025-05-19 10:57:10'),
(39, 2, 5.00, 560.00, 'PAN Manual', 'debit', '1', '2025-05-19 11:15:39'),
(40, 2, 5.00, 555.00, 'PAN Manual', 'debit', '1', '2025-05-19 11:51:52'),
(41, 2, 60.00, 615.00, 'Refund: Aadhar Apply', 'credit', '1', '2025-05-19 12:09:58'),
(42, 2, 60.00, 675.00, 'Refund: Ration Apply', 'credit', '1', '2025-05-19 12:11:28'),
(43, 2, 100.00, 775.00, 'Refund: Learning Licenece Apply', 'credit', '1', '2025-05-19 12:26:02'),
(44, 2, 500.00, 1275.00, 'Refund: Pm Kissan Apply', 'credit', '1', '2025-05-19 12:34:17'),
(45, 2, 100.00, 1375.00, 'Refund: Learning Licenece Apply', 'credit', '1', '2025-05-19 12:45:00'),
(46, 2, 100.00, 1475.00, 'Refund: Learning Licenece Apply', 'credit', '1', '2025-05-19 12:45:22'),
(47, 2, 100.00, 1575.00, 'Refund: Learning Licenece Apply', 'credit', '1', '2025-05-19 12:47:13'),
(48, 2, 5.00, 1580.00, 'Refund: Pan Details Apply', 'credit', '1', '2025-05-19 12:49:26');

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
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `admin_wallet`
--
ALTER TABLE `admin_wallet`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `birth_certificate`
--
ALTER TABLE `birth_certificate`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `licence`
--
ALTER TABLE `licence`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pan`
--
ALTER TABLE `pan`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pm_kissan`
--
ALTER TABLE `pm_kissan`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ration`
--
ALTER TABLE `ration`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `wallet_transaction_history`
--
ALTER TABLE `wallet_transaction_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
