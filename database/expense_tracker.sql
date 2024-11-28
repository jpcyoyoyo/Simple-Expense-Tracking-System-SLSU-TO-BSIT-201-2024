-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2024 at 06:04 AM
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
-- Database: `expense_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `dashboard`
--

CREATE TABLE `dashboard` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `balance` decimal(20,2) NOT NULL DEFAULT 0.00,
  `expense_total` decimal(20,2) NOT NULL DEFAULT 0.00,
  `deposit_total` decimal(20,2) NOT NULL DEFAULT 0.00,
  `expense_count` int(11) NOT NULL DEFAULT 0,
  `deposit_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dashboard`
--

INSERT INTO `dashboard` (`id`, `user_id`, `balance`, `expense_total`, `deposit_total`, `expense_count`, `deposit_count`) VALUES
(1, 2, 319651420.89, 10874920.69, 330526341.58, 12, 19),
(2, 4, 0.00, 0.00, 0.00, 0, 0),
(3, 5, -1000.00, 1000.00, 0.00, 1, 0),
(4, NULL, 0.00, 0.00, 0.00, 0, 0),
(5, NULL, 0.00, 0.00, 0.00, 0, 0),
(6, NULL, 0.00, 0.00, 0.00, 0, 0),
(7, NULL, 0.00, 0.00, 0.00, 0, 0),
(8, NULL, 0.00, 0.00, 0.00, 0, 0),
(9, NULL, 0.00, 0.00, 0.00, 0, 0),
(11, NULL, 0.00, 0.00, 0.00, 0, 0),
(12, NULL, 0.00, 0.00, 0.00, 0, 0),
(13, NULL, 0.00, 0.00, 0.00, 0, 0),
(15, NULL, 0.00, 0.00, 0.00, 0, 0),
(16, 19, 0.00, 0.00, 0.00, 0, 0),
(17, 20, 0.00, 0.00, 0.00, 0, 0),
(18, 21, 0.00, 0.00, 0.00, 0, 0),
(19, 21, 0.00, 0.00, 0.00, 0, 0),
(20, 21, 0.00, 0.00, 0.00, 0, 0),
(21, 21, 0.00, 0.00, 0.00, 0, 0),
(22, 21, 0.00, 0.00, 0.00, 0, 0),
(23, 21, 0.00, 0.00, 0.00, 0, 0),
(24, 21, 0.00, 0.00, 0.00, 0, 0),
(25, 21, 0.00, 0.00, 0.00, 0, 0),
(26, 22, 0.00, 0.00, 0.00, 0, 0),
(27, 23, 0.00, 0.00, 0.00, 0, 0),
(28, 24, 0.00, 0.00, 0.00, 0, 0),
(29, 24, 0.00, 0.00, 0.00, 0, 0),
(30, 24, 0.00, 0.00, 0.00, 0, 0),
(31, 24, 0.00, 0.00, 0.00, 0, 0),
(32, 24, 0.00, 0.00, 0.00, 0, 0),
(33, 24, 0.00, 0.00, 0.00, 0, 0),
(34, 24, 0.00, 0.00, 0.00, 0, 0),
(35, 24, 0.00, 0.00, 0.00, 0, 0),
(36, 25, 0.00, 0.00, 0.00, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `deposit`
--

CREATE TABLE `deposit` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deposit`
--

INSERT INTO `deposit` (`id`, `user_id`, `created_at`, `updated_at`, `description`, `category`, `amount`, `date`) VALUES
(16, 2, '2024-10-23 12:34:31', '2024-11-04 13:34:22', 'qwertyui', 'Category 2', 234599.00, '2024-09-01'),
(17, 2, '2024-10-23 12:34:32', '2024-10-28 16:24:04', '1234', 'Category 1', 2345.60, '2024-10-03'),
(18, 2, '2024-10-27 22:54:47', '2024-10-27 22:54:47', 'minecraft inbu', 'Category 2', 234.00, '2024-09-29'),
(19, 2, '2024-11-04 13:34:45', '2024-11-04 13:34:45', 'minecraft inbu', 'Category 2', 2345.55, '2024-10-28'),
(20, 2, '2024-11-04 15:15:11', '2024-11-04 15:15:11', 'minecraft inbu', 'Category 2', 234.00, '2024-10-29'),
(21, 2, '2024-11-04 15:16:05', '2024-11-04 15:16:05', 'minecraft inbu', 'Category 2', 4567.00, '2024-10-31'),
(22, 2, '2024-11-04 15:17:18', '2024-11-04 15:17:18', 'samidcbin akcnspn', 'Category 1', 5797.34, '2024-10-11'),
(24, 2, '2024-11-06 17:54:14', '2024-11-06 17:54:14', 'minecraft inbu', 'Category 2', 876.00, '2024-11-06'),
(25, 15, '2024-11-26 11:32:33', '2024-11-26 11:32:33', 'Christmas Decorations', 'Category 1', 1500.00, '2024-11-25'),
(26, 15, '2024-11-26 11:32:38', '2024-11-26 11:32:38', 'Christmas Decorations', 'Category 1', 1500.00, '2024-11-25'),
(27, 2, '2024-11-26 15:20:09', '2024-11-26 15:20:09', 'asonibioc osbd cj', 'Category 2', 234.09, '2024-11-05'),
(28, 2, '2024-11-26 15:24:55', '2024-11-26 15:24:55', 'scadj nn aosidpjpds', 'Category 2', 348349.00, '2024-10-27'),
(30, 2, '2024-11-26 15:32:14', '2024-11-26 15:32:14', 'minecraft inbu', 'Category 2', 345657.00, '2024-11-05'),
(31, 2, '2024-11-26 15:35:05', '2024-11-26 15:35:05', 'minecraft inbu', 'Category 2', 32454.00, '2024-10-31'),
(32, 2, '2024-11-26 15:36:54', '2024-11-26 19:47:37', 'minecraft inbu', 'Category 2', 235.00, '2024-11-06'),
(33, 2, '2024-11-26 15:40:51', '2024-11-26 15:40:51', 'minecraft inbu', 'Category 1', 4567892.00, '2024-11-04'),
(34, 2, '2024-11-26 15:41:19', '2024-11-26 15:41:19', 'minecraft inbu', 'Category 1', 12345.00, '2024-10-29'),
(35, 2, '2024-11-26 15:46:20', '2024-11-26 15:46:20', 'minecraft inbu', 'Category 1', 35674.00, '2024-10-28'),
(36, 2, '2024-11-26 15:47:31', '2024-11-26 15:47:31', 'Ratione rerum aut ne', 'Category 2', 47.00, '1987-07-21'),
(37, 2, '2024-11-26 15:48:28', '2024-11-26 15:48:28', 'minecsdcmonon  ano', 'Category 2', 23456.00, '2024-10-31'),
(38, 2, '2024-11-26 15:49:03', '2024-11-26 19:53:07', 'minecraft inbu', 'Category 2', 324909000.00, '2024-11-04');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(10) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `item` varchar(500) DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`id`, `user_id`, `created_at`, `updated_at`, `description`, `category`, `amount`, `date`, `item`, `quantity`) VALUES
(2, 2, '2024-10-23 22:33:59', '2024-10-24 22:49:51', 'basccdsd', 'Category 1', 345677.71, '2024-09-01', '342, 5fd, sfd gd', 34),
(3, 2, '2024-10-23 22:34:39', '2024-10-23 22:34:39', 'asccdsd', 'Category 2', 123456.00, '2024-09-29', '12342, 5fd , sfd gd, s fs', 123),
(4, 2, '2024-10-24 18:19:52', '2024-10-24 18:19:52', 'noidcbijpac dk', 'Category 1', 9876123.00, '2024-09-29', 'wertyuio, cfvghnjm, oijhsgk, dkjhjk', 234),
(6, 2, '2024-10-24 18:25:45', '2024-11-04 16:54:33', 'minehj vsduva', 'Category 2', 432123.00, '2023-08-17', 'rtyuiw,, wertyuio, cfvghnjm, oijhsgk, dkjhjk', 23),
(7, 2, '2024-10-24 18:32:48', '2024-11-04 16:50:01', 'noidcbijpac dk', 'Category 1', 82637.00, '2023-01-18', 'rtyuiw, riouou, wertyuio, oijhsgk, dkjhjk', 345),
(8, 2, '2024-10-24 18:34:28', '2024-11-04 16:51:22', 'minecraft dsinh s', 'Category 1', 2318.00, '2023-01-12', 'yet, ndcis, fubc, dsijib, wedjnus', 8),
(9, 2, '2024-10-28 12:52:43', '2024-11-04 16:47:28', 'noidcbijpac dk', 'Category 2', 9876.98, '2023-01-27', 'wertyuio, cfvghnjm, oijhsgk', 567),
(10, 2, '2024-11-04 16:18:43', '2024-11-26 21:28:10', 'sinh sasmacnk', 'Category 1', 987.00, '2023-01-02', 'sxkan, dskcn', 23),
(12, 2, '2024-11-06 09:28:43', '2024-11-06 09:28:43', 'GIS Training Snacks', 'Category 2', 500.00, '2024-11-06', 'Snacks', 34),
(25, 5, '2024-11-06 18:13:24', '2024-11-06 18:13:24', 'For GIS Training', 'Category 1', 1000.00, '2024-11-06', 'Snacks', 30),
(27, 2, '2024-11-06 18:14:26', '2024-11-06 18:14:26', 'noidcbijpac dk', 'Category 1', 234.00, '2024-10-30', 'wertyuio, cfvghnjm, oijhsgk, dkjhjk', 3984),
(28, 2, '2024-11-26 20:05:31', '2024-11-26 21:23:27', 'noidcbijpac dk', 'Category 1', 949.00, '2024-11-06', 'wertyuio, cfvghnjm, oijhsgk, dkjhjk', 723),
(29, 2, '2024-11-26 20:06:24', '2024-11-26 20:06:24', 'noidcbijpac dk', 'Category 1', 39.00, '2024-11-04', 'yet, ndcis, fubc, dsijib, wedjnus', 30);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(10) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `created_at`, `status`, `description`) VALUES
(1, 2, '2024-11-25 10:46:59', 1, 'User JpcTheDecoder logged in successfully.'),
(2, 8, '2024-11-25 10:47:07', 1, 'User root logged in successfully.'),
(3, 2, '2024-11-25 11:00:38', 1, 'User JpcTheDecoder logged in successfully.'),
(4, 2, '2024-11-25 11:00:39', 1, 'Dashboard data fetched for dashboard ID: 1'),
(5, 8, '2024-11-25 11:00:44', 1, 'User root logged in successfully.'),
(6, 2, '2024-11-25 11:04:31', 1, 'User JpcTheDecoder logged in successfully.'),
(7, 2, '2024-11-25 11:04:31', 1, 'Dashboard data fetched for dashboard ID: 1'),
(8, 8, '2024-11-25 11:05:05', 1, 'User root logged in successfully.'),
(9, 8, '2024-11-25 14:06:25', 1, 'User logged out'),
(10, NULL, '2024-11-25 14:14:59', 0, 'Failed login attempt for username: JpcTheDecoder. Incorrect password.'),
(11, 2, '2024-11-25 14:15:08', 1, 'User JpcTheDecoder logged in successfully.'),
(12, 2, '2024-11-25 14:15:08', 1, 'Dashboard data fetched for dashboard ID: 1'),
(13, 2, '2024-11-25 14:15:12', 1, 'User logged out'),
(14, 2, '2024-11-25 14:34:14', 1, 'User JpcTheDecoder initiated a \'Forgot Password\' request.'),
(15, NULL, '2024-11-25 14:34:49', 0, 'Failed \'Forgot Password\' attempt for username: uhigyj. Username not found.'),
(16, 2, '2024-11-25 14:34:51', 1, 'User JpcTheDecoder initiated a \'Forgot Password\' request.'),
(17, 2, '2024-11-25 14:35:00', 1, 'User root successfully answered the security questions.'),
(18, 2, '2024-11-25 14:35:08', 0, 'User root failed to answer the security questions.'),
(19, 2, '2024-11-25 14:36:00', 1, 'User root successfully answered the security questions.'),
(20, 2, '2024-11-25 14:36:07', 0, 'Password change attempt failed: passwords do not match.'),
(21, 2, '2024-11-25 14:36:18', 1, 'Password changed successfully.'),
(22, 8, '2024-11-25 14:36:25', 1, 'User root logged in successfully.'),
(23, 8, '2024-11-25 14:37:47', 1, 'User logged out'),
(24, 8, '2024-11-25 14:37:56', 1, 'User root logged in successfully.'),
(25, 8, '2024-11-25 14:39:12', 1, 'User root logged out'),
(26, NULL, '2024-11-25 14:39:17', 0, 'Failed login attempt for username: JpcTheDecoder. Incorrect password.'),
(27, NULL, '2024-11-25 14:39:24', 0, 'Failed login attempt for username: JpcTheDecoder. Incorrect password.'),
(28, NULL, '2024-11-25 14:39:29', 0, 'Failed login attempt for username: JpcTheDecoder. Incorrect password.'),
(29, 2, '2024-11-25 14:39:34', 1, 'User JpcTheDecoder logged in successfully.'),
(30, 2, '2024-11-25 14:39:35', 1, 'Dashboard data fetched for dashboard ID: 1'),
(31, 2, '2024-11-25 14:39:38', 1, 'User JpcTheDecoder logged out'),
(32, 8, '2024-11-25 14:39:44', 1, 'User root logged in successfully.'),
(33, 2, '2024-11-25 15:40:56', 1, 'User JpcTheDecoder logged in successfully.'),
(34, 2, '2024-11-25 15:40:56', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(35, 2, '2024-11-25 15:43:23', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(36, 2, '2024-11-25 15:44:10', 1, 'User JpcTheDecoder logged out'),
(37, 2, '2024-11-25 15:44:17', 1, 'User JpcTheDecoder logged in successfully.'),
(38, 2, '2024-11-25 15:44:18', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(39, 2, '2024-11-25 15:44:27', 1, 'User JpcTheDecoder logged out'),
(40, 2, '2024-11-25 15:44:50', 1, 'User JpcTheDecoder logged in successfully.'),
(41, 2, '2024-11-25 15:44:51', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(42, 2, '2024-11-25 15:45:05', 1, 'User JpcTheDecoder logged out'),
(43, NULL, '2024-11-25 15:45:27', 0, 'Failed login attempt for username: Isnnama. User does not exist.'),
(44, 2, '2024-11-25 15:45:29', 1, 'User JpcTheDecoder logged in successfully.'),
(45, 2, '2024-11-25 15:45:29', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(46, 2, '2024-11-25 15:46:10', 1, 'User JpcTheDecoder logged out'),
(47, 2, '2024-11-25 15:46:25', 1, 'User JpcTheDecoder initiated a \'Forgot Password\' request.'),
(48, 2, '2024-11-25 15:47:12', 0, 'User root failed to answer the security questions.'),
(49, 2, '2024-11-25 15:49:22', 1, 'User JpcTheDecoder initiated a \'Forgot Password\' request.'),
(50, 2, '2024-11-25 15:49:35', 0, 'User JpcTheDecoder failed to answer the security questions.'),
(51, 2, '2024-11-25 15:49:52', 1, 'User JpcTheDecoder successfully answered the security questions.'),
(52, 2, '2024-11-25 15:50:12', 1, 'Password changed successfully.'),
(53, NULL, '2024-11-25 15:55:02', 0, 'Failed login attempt for username: JpcTheDecoder. Incorrect password.'),
(54, 2, '2024-11-25 15:55:14', 1, 'User JpcTheDecoder logged in successfully.'),
(55, 2, '2024-11-25 15:55:14', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(56, 2, '2024-11-25 15:56:00', 1, 'User JpcTheDecoder logged out'),
(57, 2, '2024-11-25 16:01:21', 1, 'User JpcTheDecoder logged in successfully.'),
(58, 2, '2024-11-25 16:01:21', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(59, 2, '2024-11-25 16:01:48', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(60, 2, '2024-11-25 16:03:44', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(61, 2, '2024-11-25 16:03:53', 1, 'User JpcTheDecoder logged out'),
(62, NULL, '2024-11-26 03:16:30', 0, 'Registration failed. Username: Stef or Email: steffanierelos@gmail.com already exists.'),
(63, 15, '2024-11-26 03:17:00', 1, 'User Stef registered successfully.'),
(64, NULL, '2024-11-26 03:18:14', 0, 'Registration failed. Username: Stef or Email: steffanierelos@gmail.com already exists.'),
(65, NULL, '2024-11-26 03:18:17', 0, 'Registration failed. Username: Stef or Email: steffanierelos@gmail.com already exists.'),
(66, 15, '2024-11-26 03:18:26', 1, 'User Stef logged in successfully.'),
(67, 15, '2024-11-26 03:22:17', 1, 'Default settings inserted successfully.'),
(68, NULL, '2024-11-26 03:22:17', 1, 'Default dashboard inserted successfully.'),
(69, 15, '2024-11-26 03:22:17', 1, 'User completed signup successfully.'),
(70, NULL, '2024-11-26 03:22:20', 0, 'User not authenticated'),
(71, 15, '2024-11-26 03:22:41', 1, 'Default settings inserted successfully.'),
(72, NULL, '2024-11-26 03:22:41', 1, 'Default dashboard inserted successfully.'),
(73, 15, '2024-11-26 03:22:41', 1, 'User completed signup successfully.'),
(74, NULL, '2024-11-26 03:22:41', 0, 'User not authenticated'),
(75, NULL, '2024-11-26 03:22:55', 0, 'User not authenticated'),
(76, 15, '2024-11-26 03:29:13', 1, 'User  logged out'),
(77, 15, '2024-11-26 03:29:23', 1, 'User Stef logged in successfully.'),
(78, 15, '2024-11-26 03:29:23', 1, 'Dashboard data fetched for Stef. Dashboard ID: 11'),
(79, 15, '2024-11-26 03:30:59', 1, 'Dashboard data fetched for Stef. Dashboard ID: 11'),
(80, 15, '2024-11-26 03:33:41', 1, 'User Stef logged out'),
(81, 15, '2024-11-26 03:34:23', 1, 'User Stef logged in successfully.'),
(82, 15, '2024-11-26 03:34:24', 1, 'Dashboard data fetched for Stef. Dashboard ID: 11'),
(83, 15, '2024-11-26 03:34:41', 1, 'User Stef logged out'),
(84, 16, '2024-11-26 05:29:21', 1, 'User Elise registered successfully.'),
(85, 16, '2024-11-26 05:29:43', 1, 'Default settings inserted successfully.'),
(86, NULL, '2024-11-26 05:29:43', 1, 'Default dashboard inserted successfully.'),
(87, 16, '2024-11-26 05:29:43', 1, 'User completed signup successfully.'),
(88, 16, '2024-11-26 05:30:18', 1, 'User Elise logged in successfully.'),
(89, 16, '2024-11-26 05:37:31', 1, 'User Elise logged out'),
(90, 17, '2024-11-26 05:38:04', 1, 'User Palero registered successfully.'),
(91, 17, '2024-11-26 05:38:17', 1, 'Default settings for  inserted successfully. Setting ID: 7'),
(92, NULL, '2024-11-26 05:38:17', 1, 'Default dashboard for user  inserted successfully. Dashboard ID: 13'),
(93, 17, '2024-11-26 05:38:17', 1, 'User  completed signup successfully.'),
(94, NULL, '2024-11-26 05:45:27', 0, 'Registration failed. Username: Elise or Email: lacubtanelisejane@gmail.com already exists.'),
(95, 18, '2024-11-26 05:46:28', 1, 'User Soph registered successfully.'),
(96, 18, '2024-11-26 05:46:44', 1, 'User  successfully completed security setup. Question ID: 15'),
(97, 18, '2024-11-26 05:46:44', 1, 'Default settings for  inserted successfully. Setting ID: 8'),
(98, 18, '2024-11-26 05:46:44', 1, 'User  successfully completed security setup. Question ID: 8'),
(99, NULL, '2024-11-26 05:46:44', 1, 'Default dashboard for user  inserted successfully. Dashboard ID: 14'),
(100, 18, '2024-11-26 05:46:44', 1, 'User  successfully completed security setup. Question ID: 14'),
(101, 18, '2024-11-26 05:46:44', 1, 'User  successfully completed security setup. Question ID: 1'),
(102, 18, '2024-11-26 05:50:15', 1, 'User  successfully completed security setup. Question ID: 16'),
(103, 18, '2024-11-26 05:50:15', 1, 'Default settings for  inserted successfully. Setting ID: 9'),
(104, 18, '2024-11-26 05:50:15', 1, 'User  successfully completed security setup. Question ID: 9'),
(105, NULL, '2024-11-26 05:50:15', 1, 'Default dashboard for user  inserted successfully. Dashboard ID: 15'),
(106, 18, '2024-11-26 05:50:15', 1, 'User  successfully completed security setup. Question ID: 15'),
(107, 18, '2024-11-26 05:50:15', 1, 'User  successfully completed security setup. Question ID: 1'),
(108, 19, '2024-11-26 05:59:06', 1, 'User Mel registered successfully.'),
(109, 19, '2024-11-26 05:59:22', 1, 'Security questions for user  inserted successfully. Question ID: 17'),
(110, 19, '2024-11-26 05:59:22', 1, 'Successfully inserted question_id with value 17 to User . '),
(111, 19, '2024-11-26 05:59:22', 1, 'Default settings for  inserted successfully. Setting ID: 10'),
(112, 19, '2024-11-26 05:59:22', 1, 'Successfully inserted settings_id with value 10 to User . '),
(113, 19, '2024-11-26 05:59:22', 1, 'Default dashboard for user  inserted successfully. Dashboard ID: 16'),
(114, 19, '2024-11-26 05:59:22', 1, 'Successfully inserted dashboard_id with value 16 to User . '),
(115, 19, '2024-11-26 05:59:22', 1, 'Successfully inserted is_login with value 1 to User . '),
(116, NULL, '2024-11-26 06:03:13', 0, 'Registration failed. Username: Stef or Email: stef@gmail.com already exists.'),
(117, 20, '2024-11-26 06:03:44', 1, 'User Kyle registered successfully.'),
(118, 20, '2024-11-26 06:04:05', 1, 'Security questions for user  inserted successfully. Question ID: 18'),
(119, 20, '2024-11-26 06:04:05', 1, 'Successfully inserted question_id with value 18 to User . '),
(120, 20, '2024-11-26 06:04:05', 1, 'Default settings for  inserted successfully. Setting ID: 11'),
(121, 20, '2024-11-26 06:04:05', 1, 'Successfully inserted settings_id with value 11 to User . '),
(122, 20, '2024-11-26 06:04:05', 1, 'Default dashboard for user  inserted successfully. Dashboard ID: 17'),
(123, 20, '2024-11-26 06:04:05', 1, 'Successfully inserted dashboard_id with value 17 to User . '),
(124, 20, '2024-11-26 06:04:05', 1, 'Successfully inserted is_login with value 1 to User . '),
(125, 8, '2024-11-26 06:07:05', 1, 'User root logged out'),
(126, 21, '2024-11-26 06:07:23', 1, 'User josotefok registered successfully.'),
(127, 21, '2024-11-26 06:07:26', 1, 'Security questions for user  inserted successfully. Question ID: 19'),
(128, 21, '2024-11-26 06:07:26', 1, 'Successfully inserted question_id with value 19 to User . '),
(129, 21, '2024-11-26 06:07:26', 1, 'Default settings for  inserted successfully. Setting ID: 12'),
(130, 21, '2024-11-26 06:07:26', 1, 'Successfully inserted settings_id with value 12 to User . '),
(131, 21, '2024-11-26 06:07:26', 1, 'Default dashboard for user  inserted successfully. Dashboard ID: 18'),
(132, 21, '2024-11-26 06:07:26', 1, 'Successfully inserted dashboard_id with value 18 to User . '),
(133, 21, '2024-11-26 06:07:26', 1, 'Successfully inserted is_login with value 1 to User . '),
(134, 21, '2024-11-26 06:09:32', 1, 'Security questions for user  inserted successfully. Question ID: 20'),
(135, 21, '2024-11-26 06:09:32', 1, 'Successfully inserted question_id with value 20 to User . '),
(136, 21, '2024-11-26 06:09:32', 1, 'Default settings for  inserted successfully. Setting ID: 13'),
(137, 21, '2024-11-26 06:09:32', 1, 'Successfully inserted settings_id with value 13 to User . '),
(138, 21, '2024-11-26 06:09:32', 1, 'Default dashboard for user  inserted successfully. Dashboard ID: 19'),
(139, 21, '2024-11-26 06:09:32', 1, 'Successfully inserted dashboard_id with value 19 to User . '),
(140, 21, '2024-11-26 06:09:32', 1, 'Successfully inserted is_login with value 1 to User . '),
(141, 21, '2024-11-26 06:10:03', 1, 'Security questions for user  inserted successfully. Question ID: 21'),
(142, 21, '2024-11-26 06:10:03', 1, 'Successfully inserted question_id with value 21 to User . '),
(143, 21, '2024-11-26 06:10:03', 1, 'Default settings for  inserted successfully. Setting ID: 14'),
(144, 21, '2024-11-26 06:10:03', 1, 'Successfully inserted settings_id with value 14 to User . '),
(145, 21, '2024-11-26 06:10:03', 1, 'Default dashboard for user  inserted successfully. Dashboard ID: 20'),
(146, 21, '2024-11-26 06:10:03', 1, 'Successfully inserted dashboard_id with value 20 to User . '),
(147, 21, '2024-11-26 06:10:03', 1, 'Successfully inserted is_login with value 1 to User . '),
(148, 21, '2024-11-26 06:10:08', 1, 'Security questions for user  inserted successfully. Question ID: 22'),
(149, 21, '2024-11-26 06:10:08', 1, 'Successfully inserted question_id with value 22 to User . '),
(150, 21, '2024-11-26 06:10:08', 1, 'Default settings for  inserted successfully. Setting ID: 15'),
(151, 21, '2024-11-26 06:10:08', 1, 'Successfully inserted settings_id with value 15 to User . '),
(152, 21, '2024-11-26 06:10:08', 1, 'Default dashboard for user  inserted successfully. Dashboard ID: 21'),
(153, 21, '2024-11-26 06:10:08', 1, 'Successfully inserted dashboard_id with value 21 to User . '),
(154, 21, '2024-11-26 06:10:08', 1, 'Successfully inserted is_login with value 1 to User . '),
(155, 21, '2024-11-26 06:10:16', 1, 'Security questions for user  inserted successfully. Question ID: 23'),
(156, 21, '2024-11-26 06:10:16', 1, 'Successfully inserted question_id with value 23 to User . '),
(157, 21, '2024-11-26 06:10:16', 1, 'Default settings for  inserted successfully. Setting ID: 16'),
(158, 21, '2024-11-26 06:10:16', 1, 'Successfully inserted settings_id with value 16 to User . '),
(159, 21, '2024-11-26 06:10:16', 1, 'Default dashboard for user  inserted successfully. Dashboard ID: 22'),
(160, 21, '2024-11-26 06:10:16', 1, 'Successfully inserted dashboard_id with value 22 to User . '),
(161, 21, '2024-11-26 06:10:16', 1, 'Successfully inserted is_login with value 1 to User . '),
(162, 21, '2024-11-26 06:10:20', 1, 'Security questions for user  inserted successfully. Question ID: 24'),
(163, 21, '2024-11-26 06:10:20', 1, 'Successfully inserted question_id with value 24 to User . '),
(164, 21, '2024-11-26 06:10:20', 1, 'Default settings for  inserted successfully. Setting ID: 17'),
(165, 21, '2024-11-26 06:10:20', 1, 'Successfully inserted settings_id with value 17 to User . '),
(166, 21, '2024-11-26 06:10:20', 1, 'Default dashboard for user  inserted successfully. Dashboard ID: 23'),
(167, 21, '2024-11-26 06:10:20', 1, 'Successfully inserted dashboard_id with value 23 to User . '),
(168, 21, '2024-11-26 06:10:20', 1, 'Successfully inserted is_login with value 1 to User . '),
(169, 21, '2024-11-26 06:10:20', 1, 'Security questions for user  inserted successfully. Question ID: 25'),
(170, 21, '2024-11-26 06:10:20', 1, 'Successfully inserted question_id with value 25 to User . '),
(171, 21, '2024-11-26 06:10:20', 1, 'Default settings for  inserted successfully. Setting ID: 18'),
(172, 21, '2024-11-26 06:10:20', 1, 'Successfully inserted settings_id with value 18 to User . '),
(173, 21, '2024-11-26 06:10:20', 1, 'Default dashboard for user  inserted successfully. Dashboard ID: 24'),
(174, 21, '2024-11-26 06:10:20', 1, 'Successfully inserted dashboard_id with value 24 to User . '),
(175, 21, '2024-11-26 06:10:20', 1, 'Successfully inserted is_login with value 1 to User . '),
(176, 21, '2024-11-26 06:10:21', 1, 'Security questions for user  inserted successfully. Question ID: 26'),
(177, 21, '2024-11-26 06:10:21', 1, 'Successfully inserted question_id with value 26 to User . '),
(178, 21, '2024-11-26 06:10:21', 1, 'Default settings for  inserted successfully. Setting ID: 19'),
(179, 21, '2024-11-26 06:10:21', 1, 'Successfully inserted settings_id with value 19 to User . '),
(180, 21, '2024-11-26 06:10:21', 1, 'Default dashboard for user  inserted successfully. Dashboard ID: 25'),
(181, 21, '2024-11-26 06:10:21', 1, 'Successfully inserted dashboard_id with value 25 to User . '),
(182, 21, '2024-11-26 06:10:21', 1, 'Successfully inserted is_login with value 1 to User . '),
(183, NULL, '2024-11-26 06:10:43', 0, 'Registration failed. Username: josotefok or Email: raxuw@mailinator.com already exists.'),
(184, 22, '2024-11-26 06:14:16', 1, 'User Nollan registered successfully.'),
(185, 22, '2024-11-26 06:14:34', 1, 'Security questions for user Nollan inserted successfully. Question ID: 27'),
(186, 22, '2024-11-26 06:14:34', 1, 'Successfully inserted question_id with value 27 to User Nollan. '),
(187, 22, '2024-11-26 06:14:34', 1, 'Default settings for Nollan inserted successfully. Setting ID: 20'),
(188, 22, '2024-11-26 06:14:34', 1, 'Successfully inserted settings_id with value 20 to User Nollan. '),
(189, 22, '2024-11-26 06:14:34', 1, 'Default dashboard for user Nollan inserted successfully. Dashboard ID: 26'),
(190, 22, '2024-11-26 06:14:34', 1, 'Successfully inserted dashboard_id with value 26 to User Nollan. '),
(191, 22, '2024-11-26 06:14:34', 1, 'Successfully inserted is_login with value 1 to User Nollan. '),
(192, 21, '2024-11-26 06:25:31', 1, 'User  logged out'),
(193, 8, '2024-11-26 06:25:38', 1, 'User root logged in successfully.'),
(194, 16, '2024-11-26 06:25:48', 1, 'User Elise logged in successfully.'),
(195, 16, '2024-11-26 06:25:55', 1, 'User Elise logged out'),
(196, 23, '2024-11-26 06:26:26', 1, 'User Jayr registered successfully.'),
(197, 23, '2024-11-26 06:26:41', 1, 'Security questions for user Jayr inserted successfully. Question ID: 28'),
(198, 23, '2024-11-26 06:26:41', 1, 'Successfully updated question_id with value 28 for user Jayr.'),
(199, 23, '2024-11-26 06:26:41', 1, 'Default settings for Jayr inserted successfully. Setting ID: 21'),
(200, 23, '2024-11-26 06:26:41', 1, 'Successfully updated settings_id with value 21 for user Jayr.'),
(201, 23, '2024-11-26 06:26:41', 1, 'Default dashboard for user Jayr inserted successfully. Dashboard ID: 27'),
(202, 23, '2024-11-26 06:26:41', 1, 'Successfully updated dashboard_id with value 27 for user Jayr.'),
(203, 24, '2024-11-26 06:29:24', 1, 'User kdijhusi registered successfully.'),
(204, 24, '2024-11-26 06:29:39', 1, 'Security questions for user kdijhusi inserted successfully. Question ID: 29'),
(205, 24, '2024-11-26 06:29:39', 1, 'Successfully updated question_id with value 29 for user kdijhusi.'),
(206, 24, '2024-11-26 06:29:39', 1, 'Default settings for kdijhusi inserted successfully. Setting ID: 22'),
(207, 24, '2024-11-26 06:29:39', 1, 'Successfully updated settings_id with value 22 for user kdijhusi.'),
(208, 24, '2024-11-26 06:29:39', 1, 'Default dashboard for user kdijhusi inserted successfully. Dashboard ID: 28'),
(209, 24, '2024-11-26 06:29:39', 1, 'Successfully updated dashboard_id with value 28 for user kdijhusi.'),
(210, 24, '2024-11-26 06:34:37', 1, 'Security questions for user kdijhusi inserted successfully. Question ID: 30'),
(211, 24, '2024-11-26 06:34:37', 1, 'Successfully updated question_id with value 30 for user kdijhusi.'),
(212, 24, '2024-11-26 06:34:37', 1, 'Default settings for kdijhusi inserted successfully. Setting ID: 23'),
(213, 24, '2024-11-26 06:34:37', 1, 'Successfully updated settings_id with value 23 for user kdijhusi.'),
(214, 24, '2024-11-26 06:34:37', 1, 'Default dashboard for user kdijhusi inserted successfully. Dashboard ID: 29'),
(215, 24, '2024-11-26 06:34:37', 1, 'Successfully updated dashboard_id with value 29 for user kdijhusi.'),
(216, 24, '2024-11-26 06:35:47', 1, 'Security questions for user kdijhusi inserted successfully. Question ID: 31'),
(217, 24, '2024-11-26 06:35:47', 1, 'Successfully updated question_id with value 31 for user kdijhusi.'),
(218, 24, '2024-11-26 06:35:47', 1, 'Default settings for kdijhusi inserted successfully. Setting ID: 24'),
(219, 24, '2024-11-26 06:35:47', 1, 'Successfully updated settings_id with value 24 for user kdijhusi.'),
(220, 24, '2024-11-26 06:35:47', 1, 'Default dashboard for user kdijhusi inserted successfully. Dashboard ID: 30'),
(221, 24, '2024-11-26 06:35:47', 1, 'Successfully updated dashboard_id with value 30 for user kdijhusi.'),
(222, 24, '2024-11-26 06:38:32', 1, 'Security questions for user kdijhusi inserted successfully. Question ID: 32'),
(223, 24, '2024-11-26 06:38:32', 1, 'Successfully updated question_id with value 32 for user kdijhusi.'),
(224, 24, '2024-11-26 06:38:32', 1, 'Default settings for kdijhusi inserted successfully. Setting ID: 25'),
(225, 24, '2024-11-26 06:38:32', 1, 'Successfully updated settings_id with value 25 for user kdijhusi.'),
(226, 24, '2024-11-26 06:38:32', 1, 'Default dashboard for user kdijhusi inserted successfully. Dashboard ID: 31'),
(227, 24, '2024-11-26 06:38:32', 1, 'Successfully updated dashboard_id with value 31 for user kdijhusi.'),
(228, 24, '2024-11-26 06:39:29', 1, 'Security questions for user kdijhusi inserted successfully. Question ID: 33'),
(229, 24, '2024-11-26 06:39:29', 1, 'Successfully updated question_id with value 33 for user kdijhusi.'),
(230, 24, '2024-11-26 06:39:29', 1, 'Default settings for kdijhusi inserted successfully. Setting ID: 26'),
(231, 24, '2024-11-26 06:39:29', 1, 'Successfully updated settings_id with value 26 for user kdijhusi.'),
(232, 24, '2024-11-26 06:39:29', 1, 'Default dashboard for user kdijhusi inserted successfully. Dashboard ID: 32'),
(233, 24, '2024-11-26 06:39:29', 1, 'Successfully updated dashboard_id with value 32 for user kdijhusi.'),
(234, 24, '2024-11-26 06:44:05', 1, 'Security questions for user kdijhusi inserted successfully. Question ID: 34'),
(235, 24, '2024-11-26 06:44:05', 1, 'Successfully updated question_id with value 34 for user kdijhusi.'),
(236, 24, '2024-11-26 06:44:05', 1, 'Default settings for kdijhusi inserted successfully. Setting ID: 27'),
(237, 24, '2024-11-26 06:44:05', 1, 'Successfully updated settings_id with value 27 for user kdijhusi.'),
(238, 24, '2024-11-26 06:44:05', 1, 'Default dashboard for user kdijhusi inserted successfully. Dashboard ID: 33'),
(239, 24, '2024-11-26 06:44:05', 1, 'Successfully updated dashboard_id with value 33 for user kdijhusi.'),
(240, 24, '2024-11-26 06:44:30', 1, 'Security questions for user kdijhusi inserted successfully. Question ID: 35'),
(241, 24, '2024-11-26 06:44:30', 1, 'Successfully updated question_id with value 35 for user kdijhusi.'),
(242, 24, '2024-11-26 06:44:30', 1, 'Default settings for kdijhusi inserted successfully. Setting ID: 28'),
(243, 24, '2024-11-26 06:44:30', 1, 'Successfully updated settings_id with value 28 for user kdijhusi.'),
(244, 24, '2024-11-26 06:44:30', 1, 'Default dashboard for user kdijhusi inserted successfully. Dashboard ID: 34'),
(245, 24, '2024-11-26 06:44:30', 1, 'Successfully updated dashboard_id with value 34 for user kdijhusi.'),
(246, 24, '2024-11-26 06:45:58', 1, 'Security questions for user kdijhusi inserted successfully. Question ID: 36'),
(247, 24, '2024-11-26 06:45:58', 1, 'Successfully updated question_id with value 36 for user kdijhusi.'),
(248, 24, '2024-11-26 06:45:58', 1, 'Default settings for kdijhusi inserted successfully. Setting ID: 29'),
(249, 24, '2024-11-26 06:45:58', 1, 'Successfully updated settings_id with value 29 for user kdijhusi.'),
(250, 24, '2024-11-26 06:45:58', 1, 'Default dashboard for user kdijhusi inserted successfully. Dashboard ID: 35'),
(251, 24, '2024-11-26 06:45:58', 1, 'Successfully updated dashboard_id with value 35 for user kdijhusi.'),
(252, 24, '2024-11-26 06:45:58', 1, 'User kdijhusi info fetched successfully.'),
(253, 24, '2024-11-26 06:46:10', 1, 'User kdijhusi logged out'),
(254, 8, '2024-11-26 06:46:27', 1, 'User root logged out'),
(255, 25, '2024-11-26 06:47:03', 1, 'User henowiqa registered successfully.'),
(256, 25, '2024-11-26 06:47:05', 1, 'Security questions for user henowiqa inserted successfully. Question ID: 37'),
(257, 25, '2024-11-26 06:47:05', 1, 'Successfully updated question_id with value 37 for user henowiqa.'),
(258, 25, '2024-11-26 06:47:05', 1, 'Default settings for henowiqa inserted successfully. Setting ID: 30'),
(259, 25, '2024-11-26 06:47:05', 1, 'Successfully updated settings_id with value 30 for user henowiqa.'),
(260, 25, '2024-11-26 06:47:05', 1, 'Default dashboard for user henowiqa inserted successfully. Dashboard ID: 36'),
(261, 25, '2024-11-26 06:47:05', 1, 'Successfully updated dashboard_id with value 36 for user henowiqa.'),
(262, 25, '2024-11-26 06:47:05', 1, 'User henowiqa info fetched successfully.'),
(263, 25, '2024-11-26 06:47:09', 1, 'User henowiqa logged out'),
(264, 25, '2024-11-26 06:47:13', 1, 'User henowiqa logged in successfully.'),
(265, 25, '2024-11-26 06:47:16', 1, 'User henowiqa logged out'),
(266, 8, '2024-11-26 06:47:27', 1, 'User root logged in successfully.'),
(267, 2, '2024-11-26 07:13:34', 1, 'User JpcTheDecoder logged in successfully.'),
(268, 2, '2024-11-26 07:15:26', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(269, 2, '2024-11-26 07:20:09', 1, 'Deposit added successfully for JpcTheDecoder. Deposit ID: 27'),
(270, 2, '2024-11-26 07:20:09', 1, 'Deposit details fetched successfully for JpcTheDecoder. Deposit ID: 27'),
(271, 2, '2024-11-26 07:24:55', 1, 'Deposit added successfully for JpcTheDecoder. Deposit ID: 28'),
(272, 2, '2024-11-26 07:24:55', 1, 'Deposit details fetched successfully for JpcTheDecoder. Deposit ID: 28'),
(273, 2, '2024-11-26 07:29:07', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(274, 2, '2024-11-26 07:29:14', 1, 'User JpcTheDecoder logged out'),
(275, 2, '2024-11-26 07:30:23', 1, 'User JpcTheDecoder logged in successfully.'),
(276, 2, '2024-11-26 07:30:23', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(277, 2, '2024-11-26 07:30:33', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(278, 2, '2024-11-26 07:31:36', 1, 'Deposit added successfully for JpcTheDecoder. Deposit ID: 29'),
(279, 2, '2024-11-26 07:31:36', 1, 'Deposit details fetched successfully for JpcTheDecoder. Deposit ID: 29'),
(280, 2, '2024-11-26 07:32:14', 1, 'Deposit added successfully for JpcTheDecoder. Deposit ID: 30'),
(281, 2, '2024-11-26 07:32:14', 1, 'Deposit details fetched successfully for JpcTheDecoder. Deposit ID: 30'),
(282, 2, '2024-11-26 07:35:05', 1, 'Deposit added successfully for JpcTheDecoder. Deposit ID: 31'),
(283, 2, '2024-11-26 07:35:05', 1, 'Deposit details fetched successfully for JpcTheDecoder. Deposit ID: 31'),
(284, 2, '2024-11-26 07:36:27', 1, 'User JpcTheDecoder logged in successfully.'),
(285, 2, '2024-11-26 07:36:27', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(286, 2, '2024-11-26 07:36:54', 1, 'Deposit added successfully for JpcTheDecoder. Deposit ID: 32'),
(287, 2, '2024-11-26 07:36:54', 1, 'Deposit details fetched successfully for JpcTheDecoder. Deposit ID: 32'),
(288, 8, '2024-11-26 07:39:45', 1, 'User root logged out'),
(289, 2, '2024-11-26 07:40:02', 1, 'User JpcTheDecoder logged out'),
(290, 2, '2024-11-26 07:40:26', 1, 'User JpcTheDecoder logged in successfully.'),
(291, 2, '2024-11-26 07:40:26', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(292, 2, '2024-11-26 07:40:51', 1, 'Deposit added successfully for JpcTheDecoder. Deposit ID: 33'),
(293, 2, '2024-11-26 07:40:51', 1, 'Deposit details fetched successfully for JpcTheDecoder. Deposit ID: 33'),
(294, 2, '2024-11-26 07:41:01', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(295, 2, '2024-11-26 07:41:19', 1, 'Deposit added successfully for JpcTheDecoder. Deposit ID: 34'),
(296, 2, '2024-11-26 07:41:19', 1, 'Deposit details fetched successfully for JpcTheDecoder. Deposit ID: 34'),
(297, 2, '2024-11-26 07:46:20', 1, 'Deposit added successfully for JpcTheDecoder. Deposit ID: 35'),
(298, 2, '2024-11-26 07:46:20', 1, 'Deposit details fetched successfully for JpcTheDecoder. Deposit ID: 35'),
(299, 2, '2024-11-26 07:47:31', 1, 'Deposit added successfully for JpcTheDecoder. Deposit ID: 36'),
(300, 2, '2024-11-26 07:47:31', 1, 'Deposit details fetched successfully for JpcTheDecoder. Deposit ID: 36'),
(301, 2, '2024-11-26 07:48:28', 1, 'Deposit added successfully for JpcTheDecoder. Deposit ID: 37'),
(302, 2, '2024-11-26 07:48:28', 1, 'Deposit details fetched successfully for JpcTheDecoder. Deposit ID: 37'),
(303, 2, '2024-11-26 07:49:03', 1, 'Deposit added successfully for JpcTheDecoder. Deposit ID: 38'),
(304, 2, '2024-11-26 07:49:03', 1, 'Deposit details fetched successfully for JpcTheDecoder. Deposit ID: 38'),
(305, 2, '2024-11-26 07:49:08', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(306, 2, '2024-11-26 07:49:19', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(307, 8, '2024-11-26 07:52:27', 1, 'User root logged in successfully.'),
(308, 2, '2024-11-26 08:00:28', 1, 'Deposit deleted successfully for JpcTheDecoder. Deposit ID 29'),
(309, 2, '2024-11-26 08:08:45', 1, 'Deposit record updated successfully for JpcTheDecoder. Deposit ID: 32 '),
(310, 2, '2024-11-26 08:08:45', 1, 'Updated deposit data retrieved successfully for JpcTheDecoder. Deposit ID: 32.'),
(311, 2, '2024-11-26 08:12:25', 1, 'Fetched deposits successfully.'),
(312, 2, '2024-11-26 08:12:25', 1, 'Fetched distinct categories successfully.'),
(313, 2, '2024-11-26 08:12:25', 1, 'Fetched distinct years successfully.'),
(314, 2, '2024-11-26 08:13:49', 1, 'Fetched deposits successfully for JpcTheDecoder.'),
(315, 2, '2024-11-26 08:13:49', 1, 'Fetched distinct categories successfully for JpcTheDecoder.'),
(316, 2, '2024-11-26 08:13:49', 1, 'Fetched distinct years successfully for JpcTheDecoder.'),
(317, 2, '2024-11-26 08:13:56', 1, 'Fetched deposits successfully for JpcTheDecoder.'),
(318, 2, '2024-11-26 08:13:56', 1, 'Fetched distinct categories successfully for JpcTheDecoder.'),
(319, 2, '2024-11-26 08:13:56', 1, 'Fetched distinct years successfully for JpcTheDecoder.'),
(320, 2, '2024-11-26 08:14:19', 1, 'Deposit added successfully for JpcTheDecoder. Deposit ID: 39'),
(321, 2, '2024-11-26 08:14:19', 1, 'Deposit details fetched successfully for JpcTheDecoder. Deposit ID: 39'),
(322, 2, '2024-11-26 08:14:27', 1, 'Deposit deleted successfully for JpcTheDecoder. Deposit ID 39'),
(323, 2, '2024-11-26 08:15:15', 1, 'Deposit record updated successfully for JpcTheDecoder. Deposit ID: 32 '),
(324, 2, '2024-11-26 08:15:15', 1, 'Updated deposit data retrieved successfully for JpcTheDecoder. Deposit ID: 32.'),
(325, 2, '2024-11-26 08:18:25', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(326, 2, '2024-11-26 08:18:28', 1, 'User JpcTheDecoder logged out'),
(327, 2, '2024-11-26 08:18:43', 1, 'User JpcTheDecoder logged in successfully.'),
(328, 2, '2024-11-26 08:18:43', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(329, 2, '2024-11-26 08:21:51', 1, 'Fetched deposits successfully for JpcTheDecoder.'),
(330, 2, '2024-11-26 08:21:51', 1, 'Fetched distinct categories successfully for JpcTheDecoder.'),
(331, 2, '2024-11-26 08:21:51', 1, 'Fetched distinct years successfully for JpcTheDecoder.'),
(332, 2, '2024-11-26 08:22:57', 1, 'Fetched deposits successfully for JpcTheDecoder.'),
(333, 2, '2024-11-26 08:22:57', 1, 'Fetched distinct categories successfully for JpcTheDecoder.'),
(334, 2, '2024-11-26 08:22:57', 1, 'Fetched distinct years successfully for JpcTheDecoder.'),
(335, 2, '2024-11-26 08:23:19', 1, 'User JpcTheDecoder logged out'),
(336, 8, '2024-11-26 08:23:24', 1, 'User root logged in successfully.'),
(337, 8, '2024-11-26 08:34:27', 1, 'User root logged out'),
(338, 2, '2024-11-26 08:34:43', 1, 'User JpcTheDecoder logged in successfully.'),
(339, 2, '2024-11-26 08:34:43', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(340, 2, '2024-11-26 08:34:57', 1, 'Fetched deposits successfully for JpcTheDecoder.'),
(341, 2, '2024-11-26 08:34:57', 1, 'Fetched distinct categories successfully for JpcTheDecoder.'),
(342, 2, '2024-11-26 08:34:57', 1, 'Fetched distinct years successfully for JpcTheDecoder.'),
(343, 2, '2024-11-26 08:36:29', 1, 'Fetched deposits successfully for JpcTheDecoder.'),
(344, 2, '2024-11-26 08:36:29', 1, 'Fetched distinct categories successfully for JpcTheDecoder.'),
(345, 2, '2024-11-26 08:36:29', 1, 'Fetched distinct years successfully for JpcTheDecoder.'),
(346, 2, '2024-11-26 08:36:55', 1, 'Fetched deposits successfully for JpcTheDecoder.'),
(347, 2, '2024-11-26 08:36:55', 1, 'Fetched distinct categories successfully for JpcTheDecoder.'),
(348, 2, '2024-11-26 08:36:55', 1, 'Fetched distinct years successfully for JpcTheDecoder.'),
(349, 2, '2024-11-26 08:38:35', 1, 'Fetched deposits successfully for JpcTheDecoder.'),
(350, 2, '2024-11-26 08:38:35', 1, 'Fetched distinct categories successfully for JpcTheDecoder.'),
(351, 2, '2024-11-26 08:38:35', 1, 'Fetched distinct years successfully for JpcTheDecoder.'),
(352, 2, '2024-11-26 11:42:32', 1, 'Fetched deposits successfully for JpcTheDecoder.'),
(353, 2, '2024-11-26 11:42:32', 1, 'Fetched distinct categories for filters successfully for JpcTheDecoder.'),
(354, 2, '2024-11-26 11:42:32', 1, 'Fetched distinct years for filters successfully for JpcTheDecoder.'),
(355, 2, '2024-11-26 11:47:18', 1, 'Fetched deposits successfully for JpcTheDecoder.'),
(356, 2, '2024-11-26 11:47:18', 1, 'Fetched distinct categories for filters successfully for JpcTheDecoder.'),
(357, 2, '2024-11-26 11:47:18', 1, 'Fetched distinct years for filters successfully for JpcTheDecoder.'),
(358, 2, '2024-11-26 11:47:37', 1, 'Deposit record updated successfully for JpcTheDecoder. Deposit ID: 32 '),
(359, 2, '2024-11-26 11:47:37', 1, 'Updated deposit data retrieved successfully for JpcTheDecoder. Deposit ID: 32.'),
(360, NULL, '2024-11-26 11:47:37', 1, 'Expense total retrieved successfully for JpcTheDecoder. Dashboard ID: 1'),
(361, 2, '2024-11-26 11:47:37', 1, 'Fetched deposits successfully for JpcTheDecoder.'),
(362, 2, '2024-11-26 11:47:37', 1, 'Fetched distinct categories for filters successfully for JpcTheDecoder.'),
(363, 2, '2024-11-26 11:47:37', 1, 'Fetched distinct years for filters successfully for JpcTheDecoder.'),
(364, 2, '2024-11-26 11:52:17', 1, 'Fetched deposits successfully for JpcTheDecoder.'),
(365, 2, '2024-11-26 11:52:17', 1, 'Fetched distinct categories for filters successfully for JpcTheDecoder.'),
(366, 2, '2024-11-26 11:52:17', 1, 'Fetched distinct years for filters successfully for JpcTheDecoder.'),
(367, 2, '2024-11-26 11:53:07', 1, 'Deposit record updated successfully for JpcTheDecoder. Deposit ID: 38 '),
(368, 2, '2024-11-26 11:53:07', 1, 'Updated deposit data retrieved successfully for JpcTheDecoder. Deposit ID: 38.'),
(369, NULL, '2024-11-26 11:53:07', 1, 'Expense total retrieved successfully for JpcTheDecoder. Dashboard ID: 1'),
(370, 2, '2024-11-26 11:53:07', 1, 'Dashboard updated successfully for JpcTheDecoder. Dashboard ID: 1'),
(371, 2, '2024-11-26 11:53:20', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(372, 2, '2024-11-26 11:53:56', 1, 'Fetched deposits successfully for JpcTheDecoder.'),
(373, 2, '2024-11-26 11:53:56', 1, 'Fetched distinct categories for filters successfully for JpcTheDecoder.'),
(374, 2, '2024-11-26 11:53:56', 1, 'Fetched distinct years for filters successfully for JpcTheDecoder.'),
(375, 2, '2024-11-26 12:01:36', 1, 'Fetched deposits successfully for JpcTheDecoder.'),
(376, 2, '2024-11-26 12:01:36', 1, 'Fetched distinct categories for filters successfully for JpcTheDecoder.'),
(377, 2, '2024-11-26 12:01:36', 1, 'Fetched distinct years for filters successfully for JpcTheDecoder.'),
(378, 2, '2024-11-26 12:05:31', 1, 'Expense added successfully for JpcTheDecoder. Expense ID: 28'),
(379, 2, '2024-11-26 12:05:31', 1, 'Expense details fetched successfully for JpcTheDecoder. Expense ID: 28'),
(380, 2, '2024-11-26 12:06:24', 1, 'Expense added successfully for JpcTheDecoder. Expense ID: 29'),
(381, 2, '2024-11-26 12:06:24', 1, 'Expense details fetched successfully for JpcTheDecoder. Expense ID: 29'),
(382, 2, '2024-11-26 12:11:28', 1, 'Expense deleted successfully for JpcTheDecoder. Expense ID 11'),
(383, 2, '2024-11-26 12:46:30', 1, 'Expense record updated successfully for JpcTheDecoder. Expense ID: 28 '),
(384, 2, '2024-11-26 12:46:30', 1, 'Updated expense data retrieved successfully for JpcTheDecoder. Expense ID: 28.'),
(385, 2, '2024-11-26 12:58:41', 1, 'Fetched expenses successfully for JpcTheDecoder.'),
(386, 2, '2024-11-26 12:58:41', 1, 'Fetched distinct categories for filters successfully for JpcTheDecoder.'),
(387, 2, '2024-11-26 12:58:41', 1, 'Fetched distinct years for filters successfully for JpcTheDecoder.'),
(388, 2, '2024-11-26 13:04:29', 1, 'Fetched expenses successfully for JpcTheDecoder.'),
(389, 2, '2024-11-26 13:04:29', 1, 'Fetched distinct categories for filters successfully for JpcTheDecoder.'),
(390, 2, '2024-11-26 13:04:29', 1, 'Fetched distinct years for filters successfully for JpcTheDecoder.'),
(391, 2, '2024-11-26 13:04:32', 1, 'Fetched expenses successfully for JpcTheDecoder.'),
(392, 2, '2024-11-26 13:04:32', 1, 'Fetched distinct categories for filters successfully for JpcTheDecoder.'),
(393, 2, '2024-11-26 13:04:32', 1, 'Fetched distinct years for filters successfully for JpcTheDecoder.'),
(394, 2, '2024-11-26 13:07:11', 1, 'Fetched expenses successfully for JpcTheDecoder.'),
(395, 2, '2024-11-26 13:07:11', 1, 'Fetched distinct categories for filters successfully for JpcTheDecoder.'),
(396, 2, '2024-11-26 13:07:11', 1, 'Fetched distinct years for filters successfully for JpcTheDecoder.'),
(397, 2, '2024-11-26 13:22:50', 1, 'Fetched expenses successfully for JpcTheDecoder.'),
(398, 2, '2024-11-26 13:22:50', 1, 'Fetched distinct categories for filters successfully for JpcTheDecoder.'),
(399, 2, '2024-11-26 13:22:50', 1, 'Fetched distinct years for filters successfully for JpcTheDecoder.'),
(400, 2, '2024-11-26 13:23:14', 1, 'Fetched expenses successfully for JpcTheDecoder.'),
(401, 2, '2024-11-26 13:23:14', 1, 'Fetched distinct categories for filters successfully for JpcTheDecoder.'),
(402, 2, '2024-11-26 13:23:14', 1, 'Fetched distinct years for filters successfully for JpcTheDecoder.'),
(403, 2, '2024-11-26 13:23:27', 1, 'Expense record updated successfully for JpcTheDecoder. Expense ID: 28 '),
(404, 2, '2024-11-26 13:23:27', 1, 'Updated expense data retrieved successfully for JpcTheDecoder. Expense ID: 28.'),
(405, 2, '2024-11-26 13:23:27', 1, 'Deposit total retrieved successfully for JpcTheDecoder. Dashboard ID: 1'),
(406, 2, '2024-11-26 13:27:57', 1, 'Fetched expenses successfully for JpcTheDecoder.'),
(407, 2, '2024-11-26 13:27:57', 1, 'Fetched distinct categories for filters successfully for JpcTheDecoder.'),
(408, 2, '2024-11-26 13:27:57', 1, 'Fetched distinct years for filters successfully for JpcTheDecoder.'),
(409, 2, '2024-11-26 13:28:10', 1, 'Expense record updated successfully for JpcTheDecoder. Expense ID: 10 '),
(410, 2, '2024-11-26 13:28:10', 1, 'Updated expense data retrieved successfully for JpcTheDecoder. Expense ID: 10.'),
(411, 2, '2024-11-26 13:28:10', 1, 'Deposit total retrieved successfully for JpcTheDecoder. Dashboard ID: 1'),
(412, 2, '2024-11-26 13:28:10', 1, 'Dashboard updated successfully for JpcTheDecoder. Dashboard ID: 1'),
(413, 2, '2024-11-26 13:30:32', 1, 'Fetched expenses successfully for JpcTheDecoder.'),
(414, 2, '2024-11-26 13:30:32', 1, 'Fetched distinct categories for filters successfully for JpcTheDecoder.'),
(415, 2, '2024-11-26 13:30:32', 1, 'Fetched distinct years for filters successfully for JpcTheDecoder.'),
(416, 2, '2024-11-26 13:32:10', 1, 'Fetched expenses successfully for JpcTheDecoder.'),
(417, 2, '2024-11-26 13:32:10', 1, 'Fetched distinct categories for filters successfully for JpcTheDecoder.'),
(418, 2, '2024-11-26 13:32:10', 1, 'Fetched distinct years for filters successfully for JpcTheDecoder.'),
(419, 2, '2024-11-26 13:32:18', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(420, 2, '2024-11-26 13:32:18', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(421, 2, '2024-11-26 13:32:18', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(422, 2, '2024-11-26 13:32:18', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(423, 2, '2024-11-26 13:32:18', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(424, 2, '2024-11-26 13:32:18', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(425, 2, '2024-11-26 13:33:34', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(426, 2, '2024-11-26 13:33:34', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(427, 2, '2024-11-26 13:33:34', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(428, 2, '2024-11-26 13:33:34', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(429, 2, '2024-11-26 13:33:34', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(430, 2, '2024-11-26 13:33:34', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(431, 2, '2024-11-26 13:34:00', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(432, 2, '2024-11-26 13:34:00', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(433, 2, '2024-11-26 13:34:00', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(434, 2, '2024-11-26 13:34:00', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(435, 2, '2024-11-26 13:34:00', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(436, 2, '2024-11-26 13:34:00', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(437, 2, '2024-11-26 13:34:58', 1, 'Fetched deposits for deposit table successfully for JpcTheDecoder.'),
(438, 2, '2024-11-26 13:34:58', 1, 'Fetched distinct categories for deposit filters successfully for JpcTheDecoder.'),
(439, 2, '2024-11-26 13:34:58', 1, 'Fetched distinct years for deposit filters successfully for JpcTheDecoder.'),
(440, 2, '2024-11-26 13:34:59', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(441, 2, '2024-11-26 13:35:04', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(442, 2, '2024-11-26 13:35:04', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(443, 2, '2024-11-26 13:35:04', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(444, 2, '2024-11-26 13:35:04', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(445, 2, '2024-11-26 13:35:04', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(446, 2, '2024-11-26 13:35:04', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(447, 2, '2024-11-26 13:35:07', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(448, 2, '2024-11-26 13:35:07', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(449, 2, '2024-11-26 13:35:07', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(450, 2, '2024-11-26 13:35:36', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(451, 2, '2024-11-26 13:35:36', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(452, 2, '2024-11-26 13:35:36', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(453, 2, '2024-11-26 13:35:36', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(454, 2, '2024-11-26 13:35:36', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(455, 2, '2024-11-26 13:35:36', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(456, 2, '2024-11-26 13:38:32', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(457, 2, '2024-11-26 13:38:32', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(458, 2, '2024-11-26 13:38:32', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(459, 2, '2024-11-26 13:38:32', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(460, 2, '2024-11-26 13:38:32', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(461, 2, '2024-11-26 13:38:32', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(462, 2, '2024-11-26 13:41:17', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(463, 2, '2024-11-26 13:41:17', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(464, 2, '2024-11-26 13:41:17', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(465, 2, '2024-11-26 13:41:17', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(466, 2, '2024-11-26 13:41:17', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(467, 2, '2024-11-26 13:41:17', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(468, 2, '2024-11-26 13:55:52', 1, 'Profile updated successfully for user JpcTheDecoder. Old username: JpcTheDecoder.'),
(469, 2, '2024-11-26 13:56:20', 1, 'Profile updated successfully for user JpcTheDecoder. Old username: JpcTheDecoder.'),
(470, 2, '2024-11-26 13:58:55', 1, 'Profile updated successfully for user JpcTheDecoder. Old username: JpcTheDecoder.'),
(471, 2, '2024-11-26 13:59:53', 1, 'Profile updated successfully for user JpcTheDecoder.'),
(472, 2, '2024-11-26 13:59:53', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(473, 2, '2024-11-26 14:00:05', 1, 'Username updated from JpcTheDecoder to JpcTheDecodere. Profile updated successfully.'),
(474, 2, '2024-11-26 14:00:05', 1, 'Dashboard data fetched for JpcTheDecodere. Dashboard ID: 1'),
(475, 2, '2024-11-26 14:00:22', 1, 'Username updated from JpcTheDecodere to JpcTheDecoder. Profile updated successfully.'),
(476, 2, '2024-11-26 14:00:22', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(477, 2, '2024-11-26 14:01:38', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(478, 2, '2024-11-26 14:01:52', 1, 'Fetched deposits for deposit table successfully for JpcTheDecoder.'),
(479, 2, '2024-11-26 14:01:52', 1, 'Fetched distinct categories for deposit filters successfully for JpcTheDecoder.'),
(480, 2, '2024-11-26 14:01:52', 1, 'Fetched distinct years for deposit filters successfully for JpcTheDecoder.'),
(481, 2, '2024-11-26 14:05:39', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(482, 2, '2024-11-26 14:05:39', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(483, 2, '2024-11-26 14:05:39', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(484, 2, '2024-11-26 14:05:39', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(485, 2, '2024-11-26 14:05:39', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(486, 2, '2024-11-26 14:05:39', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(487, 2, '2024-11-26 14:17:27', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(488, 2, '2024-11-26 14:17:27', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(489, 2, '2024-11-26 14:17:27', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(490, 2, '2024-11-26 14:17:27', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(491, 2, '2024-11-26 14:17:27', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(492, 2, '2024-11-26 14:17:27', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(493, 8, '2024-11-26 14:17:42', 1, 'User root logged out'),
(494, 8, '2024-11-26 14:18:02', 1, 'User root logged in successfully.'),
(495, 2, '2024-11-26 14:19:45', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(496, 2, '2024-11-26 14:22:49', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(497, 8, '2024-11-26 14:23:14', 1, 'User root logged in successfully.'),
(498, 8, '2024-11-26 14:27:42', 1, 'User root logged out'),
(499, 2, '2024-11-26 14:31:49', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(500, 8, '2024-11-26 14:32:18', 1, 'User root logged in successfully.'),
(501, 2, '2024-11-26 14:34:11', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(502, 8, '2024-11-26 14:34:17', 1, 'User root logged out'),
(503, 8, '2024-11-26 14:34:36', 1, 'User root logged in successfully.'),
(504, 2, '2024-11-26 14:36:21', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(505, 8, '2024-11-26 14:36:27', 1, 'User root logged out'),
(506, 8, '2024-11-26 14:36:43', 1, 'User root logged in successfully.'),
(507, 2, '2024-11-26 14:38:52', 1, 'User JpcTheDecoder logged out'),
(508, 8, '2024-11-26 14:38:56', 1, 'User root logged in successfully.'),
(509, 8, '2024-11-26 14:48:23', 1, 'User root logged out'),
(510, 2, '2024-11-26 14:48:33', 1, 'User JpcTheDecoder logged in successfully.'),
(511, 2, '2024-11-26 14:48:33', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(512, 8, '2024-11-26 14:48:43', 1, 'User root logged in successfully.'),
(513, 2, '2024-11-26 14:50:01', 1, 'Fetched deposits for deposit table successfully for JpcTheDecoder.'),
(514, 2, '2024-11-26 14:50:01', 1, 'Fetched distinct categories for deposit filters successfully for JpcTheDecoder.'),
(515, 2, '2024-11-26 14:50:01', 1, 'Fetched distinct years for deposit filters successfully for JpcTheDecoder.'),
(516, 2, '2024-11-26 14:50:04', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(517, 2, '2024-11-26 14:50:04', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(518, 2, '2024-11-26 14:50:04', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(519, 2, '2024-11-26 14:50:07', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.');
INSERT INTO `logs` (`id`, `user_id`, `created_at`, `status`, `description`) VALUES
(520, 2, '2024-11-26 14:50:07', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(521, 2, '2024-11-26 14:50:07', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(522, 2, '2024-11-26 14:50:07', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(523, 2, '2024-11-26 14:50:07', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(524, 2, '2024-11-26 14:50:07', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(525, 2, '2024-11-26 14:50:14', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(526, 2, '2024-11-26 14:50:14', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(527, 2, '2024-11-26 14:50:14', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(528, 2, '2024-11-26 14:50:21', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(529, 2, '2024-11-26 14:51:37', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(530, 8, '2024-11-26 14:51:44', 1, 'User root logged out'),
(531, 8, '2024-11-26 14:52:07', 1, 'User root logged in successfully.'),
(532, 8, '2024-11-26 14:53:06', 1, 'User root logged out'),
(533, 2, '2024-11-26 14:57:07', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(534, 2, '2024-11-26 14:57:37', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(535, 8, '2024-11-26 14:57:45', 1, 'User root logged in successfully.'),
(536, 8, '2024-11-26 14:58:26', 1, 'User root logged in successfully.'),
(537, 2, '2024-11-26 14:59:11', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(538, 8, '2024-11-26 14:59:24', 1, 'User root logged in successfully.'),
(539, 2, '2024-11-26 15:02:14', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(540, 2, '2024-11-26 15:03:14', 1, 'User JpcTheDecoder logged out'),
(541, 8, '2024-11-26 15:03:18', 1, 'User root logged in successfully.'),
(542, 8, '2024-11-26 15:17:42', 1, 'User root logged out'),
(543, 8, '2024-11-26 15:19:07', 1, 'User root logged in successfully.'),
(544, 2, '2024-11-26 15:19:14', 1, 'User JpcTheDecoder logged in successfully.'),
(545, 2, '2024-11-26 15:19:14', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(546, 2, '2024-11-26 15:19:29', 1, 'Fetched deposits for deposit table successfully for JpcTheDecoder.'),
(547, 2, '2024-11-26 15:19:29', 1, 'Fetched distinct categories for deposit filters successfully for JpcTheDecoder.'),
(548, 2, '2024-11-26 15:19:29', 1, 'Fetched distinct years for deposit filters successfully for JpcTheDecoder.'),
(549, 2, '2024-11-26 15:19:45', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(550, 2, '2024-11-26 15:20:06', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(551, 2, '2024-11-26 15:20:08', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(552, 2, '2024-11-26 15:23:49', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(553, 8, '2024-11-26 15:24:17', 1, 'User root logged in successfully.'),
(554, 2, '2024-11-26 15:24:20', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(555, 2, '2024-11-26 15:24:26', 1, 'Fetched deposits for deposit table successfully for JpcTheDecoder.'),
(556, 2, '2024-11-26 15:24:26', 1, 'Fetched distinct categories for deposit filters successfully for JpcTheDecoder.'),
(557, 2, '2024-11-26 15:24:26', 1, 'Fetched distinct years for deposit filters successfully for JpcTheDecoder.'),
(558, 2, '2024-11-27 01:02:41', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(559, 2, '2024-11-27 01:02:46', 1, 'Fetched deposits for deposit table successfully for JpcTheDecoder.'),
(560, 2, '2024-11-27 01:02:46', 1, 'Fetched distinct categories for deposit filters successfully for JpcTheDecoder.'),
(561, 2, '2024-11-27 01:02:46', 1, 'Fetched distinct years for deposit filters successfully for JpcTheDecoder.'),
(562, 2, '2024-11-27 01:10:47', 1, 'Fetched deposits for deposit table successfully for JpcTheDecoder.'),
(563, 2, '2024-11-27 01:10:47', 1, 'Fetched distinct categories for deposit filters successfully for JpcTheDecoder.'),
(564, 2, '2024-11-27 01:10:47', 1, 'Fetched distinct years for deposit filters successfully for JpcTheDecoder.'),
(565, 2, '2024-11-27 01:23:42', 1, 'Fetched deposits for deposit table successfully for JpcTheDecoder.'),
(566, 2, '2024-11-27 01:23:42', 1, 'Fetched distinct categories for deposit filters successfully for JpcTheDecoder.'),
(567, 2, '2024-11-27 01:23:42', 1, 'Fetched distinct years for deposit filters successfully for JpcTheDecoder.'),
(568, 8, '2024-11-27 02:26:26', 1, 'User root logged out'),
(569, 2, '2024-11-27 02:26:28', 1, 'User JpcTheDecoder logged out'),
(570, 8, '2024-11-27 02:27:01', 1, 'User root logged in successfully.'),
(571, 8, '2024-11-27 02:28:22', 1, 'User root logged out'),
(572, 8, '2024-11-27 02:28:26', 1, 'User root logged in successfully.'),
(573, 8, '2024-11-27 02:35:46', 1, 'User root logged out'),
(574, 8, '2024-11-27 02:36:16', 1, 'User root logged in successfully.'),
(575, 2, '2024-11-27 02:36:24', 1, 'User JpcTheDecoder logged in successfully.'),
(576, 2, '2024-11-27 02:36:24', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(577, 2, '2024-11-27 02:36:29', 1, 'Fetched deposits for deposit table successfully for JpcTheDecoder.'),
(578, 2, '2024-11-27 02:36:29', 1, 'Fetched distinct categories for deposit filters successfully for JpcTheDecoder.'),
(579, 2, '2024-11-27 02:36:29', 1, 'Fetched distinct years for deposit filters successfully for JpcTheDecoder.'),
(580, 2, '2024-11-27 02:36:33', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(581, 2, '2024-11-27 02:36:33', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(582, 2, '2024-11-27 02:36:33', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(583, 2, '2024-11-27 02:41:32', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(584, 2, '2024-11-27 02:41:32', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(585, 2, '2024-11-27 02:41:32', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(586, 2, '2024-11-27 02:42:03', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(587, 2, '2024-11-27 02:42:30', 1, 'Fetched deposits for deposit table successfully for JpcTheDecoder.'),
(588, 2, '2024-11-27 02:42:30', 1, 'Fetched distinct categories for deposit filters successfully for JpcTheDecoder.'),
(589, 2, '2024-11-27 02:42:30', 1, 'Fetched distinct years for deposit filters successfully for JpcTheDecoder.'),
(590, 2, '2024-11-27 02:42:31', 1, 'Fetched deposits for deposit table successfully for JpcTheDecoder.'),
(591, 2, '2024-11-27 02:42:31', 1, 'Fetched distinct categories for deposit filters successfully for JpcTheDecoder.'),
(592, 2, '2024-11-27 02:42:31', 1, 'Fetched distinct years for deposit filters successfully for JpcTheDecoder.'),
(593, 2, '2024-11-27 02:42:33', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(594, 2, '2024-11-27 02:42:33', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(595, 2, '2024-11-27 02:42:33', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(596, 2, '2024-11-27 02:48:53', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(597, 2, '2024-11-27 02:48:53', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(598, 2, '2024-11-27 02:48:53', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(599, 8, '2024-11-27 02:48:59', 1, 'User root logged out'),
(600, 8, '2024-11-27 02:49:22', 1, 'User root logged in successfully.'),
(601, 2, '2024-11-27 02:50:01', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(602, 2, '2024-11-27 02:50:01', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(603, 2, '2024-11-27 02:50:01', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(604, 8, '2024-11-27 02:50:19', 1, 'User root logged in successfully.'),
(605, 2, '2024-11-27 02:53:33', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(606, 2, '2024-11-27 02:53:33', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(607, 2, '2024-11-27 02:53:33', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(608, 2, '2024-11-27 02:56:05', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(609, 2, '2024-11-27 02:56:05', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(610, 2, '2024-11-27 02:56:05', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(611, 2, '2024-11-27 02:59:35', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(612, 2, '2024-11-27 02:59:35', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(613, 2, '2024-11-27 02:59:35', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(614, 2, '2024-11-27 03:00:46', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(615, 2, '2024-11-27 03:00:46', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(616, 2, '2024-11-27 03:00:46', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(617, 2, '2024-11-27 03:01:02', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(618, 2, '2024-11-27 03:01:02', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(619, 2, '2024-11-27 03:01:02', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(620, 8, '2024-11-27 03:01:28', 1, 'User root logged in successfully.'),
(621, 2, '2024-11-27 03:03:29', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(622, 2, '2024-11-27 03:03:29', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(623, 2, '2024-11-27 03:03:29', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(624, 2, '2024-11-27 03:09:56', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(625, 2, '2024-11-27 03:09:56', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(626, 2, '2024-11-27 03:09:56', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(627, 8, '2024-11-27 03:10:15', 1, 'User root logged in successfully.'),
(628, 2, '2024-11-27 03:20:05', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(629, 2, '2024-11-27 03:20:05', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(630, 2, '2024-11-27 03:20:05', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(631, 8, '2024-11-27 03:20:47', 1, 'User root logged in successfully.'),
(632, 2, '2024-11-27 03:32:08', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(633, 2, '2024-11-27 03:32:08', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(634, 2, '2024-11-27 03:32:08', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(635, 2, '2024-11-27 03:33:29', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(636, 2, '2024-11-27 03:33:29', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(637, 2, '2024-11-27 03:33:29', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(638, 8, '2024-11-27 03:33:43', 1, 'User root logged out'),
(639, 8, '2024-11-27 03:33:55', 1, 'User root logged in successfully.'),
(640, 2, '2024-11-27 03:36:12', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(641, 2, '2024-11-27 03:36:12', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(642, 2, '2024-11-27 03:36:12', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(643, 8, '2024-11-27 03:36:16', 1, 'User root logged out'),
(644, 2, '2024-11-27 03:36:22', 1, 'User JpcTheDecoder logged out'),
(645, 8, '2024-11-27 03:36:26', 1, 'User root logged in successfully.'),
(646, 8, '2024-11-27 04:15:01', 1, 'User root logged out'),
(647, 2, '2024-11-27 04:15:24', 1, 'User JpcTheDecoder logged in successfully.'),
(648, 2, '2024-11-27 04:15:25', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(649, 2, '2024-11-27 04:34:26', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(650, 2, '2024-11-27 04:34:26', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(651, 2, '2024-11-27 04:34:26', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(652, 2, '2024-11-27 04:34:26', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(653, 2, '2024-11-27 04:34:26', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(654, 2, '2024-11-27 04:34:26', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(655, 2, '2024-11-27 04:34:55', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(656, 2, '2024-11-27 04:34:55', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(657, 2, '2024-11-27 04:34:55', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(658, 2, '2024-11-27 04:34:55', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(659, 2, '2024-11-27 04:34:55', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(660, 2, '2024-11-27 04:34:55', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(661, 2, '2024-11-27 04:34:57', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(662, 2, '2024-11-27 04:34:57', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(663, 2, '2024-11-27 04:34:57', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(664, 2, '2024-11-27 04:34:58', 1, 'Fetched deposits for deposit table successfully for JpcTheDecoder.'),
(665, 2, '2024-11-27 04:34:58', 1, 'Fetched distinct categories for deposit filters successfully for JpcTheDecoder.'),
(666, 2, '2024-11-27 04:34:58', 1, 'Fetched distinct years for deposit filters successfully for JpcTheDecoder.'),
(667, 2, '2024-11-27 04:35:09', 1, 'User JpcTheDecoder logged out'),
(668, 8, '2024-11-27 04:35:18', 1, 'User root logged in successfully.'),
(669, 8, '2024-11-27 04:38:36', 1, 'User root logged out'),
(670, 2, '2024-11-27 04:38:43', 1, 'User JpcTheDecoder logged in successfully.'),
(671, 2, '2024-11-27 04:38:43', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(672, 2, '2024-11-27 04:38:47', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(673, 2, '2024-11-27 04:38:47', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(674, 2, '2024-11-27 04:38:47', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(675, 2, '2024-11-27 04:38:47', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(676, 2, '2024-11-27 04:38:47', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(677, 2, '2024-11-27 04:38:47', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(678, 2, '2024-11-27 04:38:52', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(679, 2, '2024-11-27 04:38:52', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(680, 2, '2024-11-27 04:38:52', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(681, 2, '2024-11-27 04:38:52', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(682, 2, '2024-11-27 04:38:52', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(683, 2, '2024-11-27 04:38:52', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(684, 2, '2024-11-27 04:39:31', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(685, 2, '2024-11-27 04:39:31', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(686, 2, '2024-11-27 04:39:31', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(687, 2, '2024-11-27 04:39:31', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(688, 2, '2024-11-27 04:39:31', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(689, 2, '2024-11-27 04:39:31', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(690, 2, '2024-11-27 04:40:06', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(691, 2, '2024-11-27 04:40:06', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(692, 2, '2024-11-27 04:40:06', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(693, 2, '2024-11-27 04:40:06', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(694, 2, '2024-11-27 04:40:06', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(695, 2, '2024-11-27 04:40:06', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(696, 2, '2024-11-27 04:40:56', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(697, 2, '2024-11-27 04:40:56', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(698, 2, '2024-11-27 04:40:56', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(699, 2, '2024-11-27 04:40:56', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(700, 2, '2024-11-27 04:40:56', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(701, 2, '2024-11-27 04:40:56', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(702, 2, '2024-11-27 04:41:31', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(703, 2, '2024-11-27 04:41:31', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(704, 2, '2024-11-27 04:41:31', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(705, 2, '2024-11-27 04:41:31', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(706, 2, '2024-11-27 04:41:31', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(707, 2, '2024-11-27 04:41:31', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(708, 2, '2024-11-27 04:41:36', 1, 'User JpcTheDecoder logged out'),
(709, 8, '2024-11-27 04:41:44', 1, 'User root logged in successfully.'),
(710, 8, '2024-11-27 04:42:28', 1, 'User root logged out'),
(711, 2, '2024-11-27 04:43:08', 1, 'User JpcTheDecoder logged in successfully.'),
(712, 2, '2024-11-27 04:43:08', 1, 'Dashboard data fetched for JpcTheDecoder. Dashboard ID: 1'),
(713, 2, '2024-11-27 04:43:10', 1, 'Fetched deposits for deposit table successfully for JpcTheDecoder.'),
(714, 2, '2024-11-27 04:43:10', 1, 'Fetched distinct categories for deposit filters successfully for JpcTheDecoder.'),
(715, 2, '2024-11-27 04:43:10', 1, 'Fetched distinct years for deposit filters successfully for JpcTheDecoder.'),
(716, 2, '2024-11-27 04:43:11', 1, 'Fetched expenses for expense table successfully for JpcTheDecoder.'),
(717, 2, '2024-11-27 04:43:11', 1, 'Fetched distinct categories for expense filters successfully for JpcTheDecoder.'),
(718, 2, '2024-11-27 04:43:11', 1, 'Fetched distinct years for expense filters successfully for JpcTheDecoder.'),
(719, 2, '2024-11-27 04:43:12', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(720, 2, '2024-11-27 04:43:12', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(721, 2, '2024-11-27 04:43:12', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(722, 2, '2024-11-27 04:43:12', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(723, 2, '2024-11-27 04:43:12', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(724, 2, '2024-11-27 04:43:12', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(725, 2, '2024-11-27 04:43:16', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(726, 2, '2024-11-27 04:43:16', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(727, 2, '2024-11-27 04:43:16', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(728, 2, '2024-11-27 04:43:16', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(729, 2, '2024-11-27 04:43:16', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(730, 2, '2024-11-27 04:43:16', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(731, 2, '2024-11-27 04:45:18', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(732, 2, '2024-11-27 04:45:18', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(733, 2, '2024-11-27 04:45:18', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(734, 2, '2024-11-27 04:45:18', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(735, 2, '2024-11-27 04:45:18', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(736, 2, '2024-11-27 04:45:18', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(737, 2, '2024-11-27 04:46:44', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(738, 2, '2024-11-27 04:46:44', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(739, 2, '2024-11-27 04:46:44', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(740, 2, '2024-11-27 04:46:44', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(741, 2, '2024-11-27 04:46:44', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(742, 2, '2024-11-27 04:46:44', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(743, 2, '2024-11-27 04:47:44', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(744, 2, '2024-11-27 04:47:44', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(745, 2, '2024-11-27 04:47:44', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(746, 2, '2024-11-27 04:47:44', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(747, 2, '2024-11-27 04:47:44', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(748, 2, '2024-11-27 04:47:44', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(749, 2, '2024-11-27 04:47:53', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(750, 2, '2024-11-27 04:47:53', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(751, 2, '2024-11-27 04:47:53', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(752, 2, '2024-11-27 04:47:53', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(753, 2, '2024-11-27 04:47:53', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(754, 2, '2024-11-27 04:47:53', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(755, 2, '2024-11-27 04:48:06', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(756, 2, '2024-11-27 04:48:06', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(757, 2, '2024-11-27 04:48:06', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(758, 2, '2024-11-27 04:48:06', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(759, 2, '2024-11-27 04:48:06', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(760, 2, '2024-11-27 04:48:06', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(761, 2, '2024-11-27 04:48:30', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(762, 2, '2024-11-27 04:48:30', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(763, 2, '2024-11-27 04:48:30', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(764, 2, '2024-11-27 04:48:30', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(765, 2, '2024-11-27 04:48:30', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(766, 2, '2024-11-27 04:48:30', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(767, 2, '2024-11-27 04:48:40', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(768, 2, '2024-11-27 04:48:40', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(769, 2, '2024-11-27 04:48:40', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(770, 2, '2024-11-27 04:48:40', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(771, 2, '2024-11-27 04:48:40', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(772, 2, '2024-11-27 04:48:40', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(773, 2, '2024-11-27 04:48:46', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(774, 2, '2024-11-27 04:48:46', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(775, 2, '2024-11-27 04:48:46', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(776, 2, '2024-11-27 04:48:46', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(777, 2, '2024-11-27 04:48:46', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(778, 2, '2024-11-27 04:48:46', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(779, 2, '2024-11-27 04:48:57', 1, 'Fetched deposits for report table successfully for JpcTheDecoder.'),
(780, 2, '2024-11-27 04:48:57', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(781, 2, '2024-11-27 04:48:57', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.'),
(782, 2, '2024-11-27 04:48:57', 1, 'Fetched expenses for report table successfully for JpcTheDecoder.'),
(783, 2, '2024-11-27 04:48:57', 1, 'Fetched distinct categories for report filters successfully for JpcTheDecoder.'),
(784, 2, '2024-11-27 04:48:57', 1, 'Fetched distinct years for report filters successfully for JpcTheDecoder.');

-- --------------------------------------------------------

--
-- Table structure for table `security_q`
--

CREATE TABLE `security_q` (
  `id` int(10) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `q1` varchar(1000) NOT NULL,
  `q1_answer` varchar(1000) NOT NULL,
  `q2` varchar(1000) NOT NULL,
  `q2_answer` varchar(1000) NOT NULL,
  `q3` varchar(1000) NOT NULL,
  `q3_answer` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `security_q`
--

INSERT INTO `security_q` (`id`, `user_id`, `q1`, `q1_answer`, `q2`, `q2_answer`, `q3`, `q3_answer`) VALUES
(2, 2, 'qwertyuiop', 'qwerty', 'asdfghjkl', 'asdfgh', 'zxcvbnm', 'zxcvbn'),
(3, 4, 'qwertyuiop', 'qwerty', 'asdfghjkl', 'asdfgh', 'zxcvbnm', 'zxcvbn'),
(4, 5, 'A', 'B', 'C', 'D', 'E', 'F'),
(5, 7, 'Nisi Nam aliquip ut', 'Veniam aut aut tota', 'Possimus in amet r', 'Quidem autem maxime', 'Autem vitae eum fugi', 'Minim ex consectetur'),
(6, 8, 'Amet eaque ea nisi', 'Dolorum in sed excep', 'Cupidatat et atque s', 'Dolorem ut molestiae', 'Ea nesciunt deserun', 'At dolorum labore vo'),
(7, 9, 'Qui aliqua Deserunt', 'Voluptas optio dolo', 'Neque aut pariatur', 'Tenetur id totam qu', 'Modi id iusto quia', 'Rem nulla vel sit a'),
(8, 10, 'Repellendus Et labo', 'Sint inventore sit', 'Odit perferendis asp', 'Omnis ipsum lorem au', 'Exercitationem earum', 'A labore dolore ut e'),
(9, 11, 'Aut error reiciendis', 'Quam a sunt exercita', 'Voluptatem quam vel', 'Et porro adipisicing', 'Omnis inventore accu', 'Facere ullamco rerum'),
(10, 12, 'Illum quam consecte', 'Itaque debitis est', 'Eos repudiandae reic', 'Iure qui deleniti ex', 'Aut voluptatibus sap', 'Quia veritatis quia'),
(11, 15, 'a', 'b', 'c', 'd', 'e', 'f'),
(12, 15, 'a', 'b', 'c', 'd', 'e', 'f'),
(13, 16, 'Urjdjff', 'Rjfjjf', 'Jffjfjfj', 'Jfjfjfjf', 'Jdjdjfjf', 'Jdjdjdjd'),
(14, 17, '1', 'W', '1', '1', 'W', '1'),
(15, 18, 'E', 'E', 'E', 'E', 'Ee', 'E'),
(16, 18, 'Ujyhre', 'Ggbjj', 'Hhjko', 'Hjj', 'Hhhkik', 'Hhjji'),
(17, 19, 'Fkfkfkf', 'Fkfkrkr', 'Fkfkddk', 'Dkrkfkf', 'Dkffkkf', 'Rkdkgkbk'),
(18, 20, 'Roogohkb', 'Kvlfkgovoc', 'Oggovovkv', 'Ogovovkv', 'Oflvkvkv', 'Ogovov'),
(26, 21, 'Dolor magni eos ea', 'Nesciunt fugiat la', 'Voluptatem Beatae d', 'Dolorum expedita con', 'Velit fuga Rem pari', 'Consectetur voluptat'),
(27, 22, 'Lhfovlv', 'Kfkffkfkkf', 'Kfkfkckc', 'Jckckckc', 'Kckckfld', 'Kckckdlsls'),
(28, 23, 'Krkvkg', 'Jvcjckkv', 'Jgjfjfjv', 'Jcjfkkc', 'Kckckvkv', 'Kdocldlwl'),
(29, 24, 'qwertyuiop', 'qwerty', 'asdfghjkl', 'asdfgh', 'zxcvbnm', 'zxcvbn'),
(30, 24, 'qwertyuiop', 'qwerty', 'asdfghjkl', 'asdfgh', 'zxcvbnm', 'zxcvbn'),
(31, 24, 'qwertyuiop', 'qwerty', 'asdfghjkl', 'asdfgh', 'zxcvbnm', 'zxcvbn'),
(32, 24, 'qwertyuiop', 'qwerty', 'asdfghjkl', 'asdfgh', 'zxcvbnm', 'zxcvbn'),
(33, 24, 'qwertyuiop', 'qwerty', 'asdfghjkl', 'asdfgh', 'zxcvbnm', 'zxcvbn'),
(34, 24, 'qwertyuiop', 'qwerty', 'asdfghjkl', 'asdfgh', 'zxcvbnm', 'zxcvbn'),
(35, 24, 'qwertyuiop', 'qwerty', 'asdfghjkl', 'asdfgh', 'zxcvbnm', 'zxcvbn'),
(36, 24, 'qwertyuiop', 'qwerty', 'asdfghjkl', 'asdfgh', 'zxcvbnm', 'zxcvbn'),
(37, 25, 'Est ex deleniti omni', 'Aliquip cupidatat qu', 'Cupidatat elit null', 'Ut exercitationem ni', 'Quod aperiam ullamco', 'Autem et ea neque in');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `theme` varchar(255) NOT NULL,
  `font_size` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `user_id`, `theme`, `font_size`) VALUES
(1, 10, 'default', 'medium'),
(2, 11, 'default', 'medium'),
(3, 12, 'default', 'medium'),
(4, 15, 'default', 'medium'),
(5, 15, 'default', 'medium'),
(6, 16, 'default', 'medium'),
(7, 17, 'default', 'medium'),
(8, 18, 'default', 'medium'),
(9, 18, 'default', 'medium'),
(10, 19, 'default', 'medium'),
(11, 20, 'default', 'medium'),
(19, 21, 'default', 'medium'),
(20, 22, 'default', 'medium'),
(21, 23, 'default', 'medium'),
(25, 24, 'default', 'medium'),
(26, 24, 'default', 'medium'),
(27, 24, 'default', 'medium'),
(28, 24, 'default', 'medium'),
(29, 24, 'default', 'medium'),
(30, 25, 'default', 'medium');

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `question_id` int(11) DEFAULT NULL,
  `settings_id` int(11) DEFAULT NULL,
  `dashboard_id` int(11) DEFAULT NULL,
  `is_admin` int(1) NOT NULL,
  `is_login` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`id`, `fullname`, `username`, `email`, `profile_pic`, `password`, `created_at`, `updated_at`, `question_id`, `settings_id`, `dashboard_id`, `is_admin`, `is_login`) VALUES
(2, 'John Paul Bongcales Cadavez', 'JpcTheDecoder', 'jpcyoyoyo123@gmail.com', 'profile_pic/671b5be74668f_1769829-plant_peashooter_thumb.jpg', '$2y$10$A1IrsJ7PEuMy7ywofCQFCeZWwouKnvbJnC.TbZqY1lEiS5aTQJX/C', '2024-10-23 01:16:17', '2024-11-27 04:43:08', 2, NULL, 1, 0, 1),
(4, 'John Paul Cadavez', 'minecraft123', 'jpcyoyoyo@gmail.com', 'profile_pic/profile_default.svg', '$2y$10$syJVbXgdbeoWZKUFxHC.oem/jVOX/ScaMj1nwStiXmJWTkML/57Lm', '2024-10-28 08:49:33', '2024-10-28 08:49:44', 3, NULL, 2, 0, 0),
(5, 'Stefanie Relos', 'Steff', 'steffanierelos@gmail.com', 'profile_pic/profile_default.svg', '$2y$10$1MwoYUHEX9UUYu.EvqGe6uxx9SaJuH7uEHv7h4irtgPVaXDZ8e8iy', '2024-11-06 09:59:54', '2024-11-06 10:00:26', 4, NULL, 3, 0, 0),
(7, 'Ariana Dixon', 'nicemici', 'woqyg@mailinator.com', 'profile_pic/profile_default.svg', '$2y$10$xFj2K3MjAKy2ycQdRhmlXu3DnGqpy7La7ZWClvvvV/7cVz0NtYH5a', '2024-11-24 13:08:51', '2024-11-24 13:11:50', 5, NULL, 4, 0, 0),
(8, 'Brenda Hickman', 'root', 'qyxogepufo@mailinator.com', 'profile_pic/profile_default.svg', '$2y$10$WXFK5QNn2arqGPLR4/cq4.duRy9AQdNS3JWKgDlG9c8mB/HcQgqYi', '2024-11-24 13:11:22', '2024-11-27 04:42:28', 7, NULL, 6, 1, 0),
(9, 'Vivien Lloyd', 'vekyhunasu', 'vevew@mailinator.com', 'profile_pic/profile_default.svg', '$2y$10$81zatNMMSCc4AkKy1rmTP.9E3V84SWs4Qlqe9/RN9t297BL7ZECsO', '2024-11-24 13:41:21', '2024-11-24 13:41:21', NULL, NULL, NULL, 0, 0),
(10, 'Bradley Wagner', 'sifaruhab', 'ruluhu@mailinator.com', 'profile_pic/profile_default.svg', '$2y$10$IESDDGyf.f1X/imqOOdBWOrZ20Nf44609L/gmWQPr/o/yN9cC2PtC', '2024-11-24 14:06:29', '2024-11-24 14:27:45', 8, 1, 7, 0, 0),
(11, 'Fiona Allison', 'hasuwasow', 'vygygetas@mailinator.com', 'profile_pic/profile_default.svg', '$2y$10$f02CtXUw86xvL4AEv6TZseqhAbe87DExLDucxfh/SkdgdPrqB0SLG', '2024-11-24 14:17:15', '2024-11-24 14:27:49', 9, 2, 8, 0, 0),
(12, 'Arthur Crosby', 'qipygifo', 'rosesug@mailinator.com', 'profile_pic/profile_default.svg', '$2y$10$x/Cw8oYeWOVm8wB/F7lJG.ZnEZ575s8dlzSYccPjXHQEfpMqRdUB2', '2024-11-25 09:44:12', '2024-11-25 09:45:30', 10, 3, 9, 0, 0),
(15, 'Stefanie', 'Stef', 'relos@gmail.com', 'profile_pic/ 674540f48fe87_1730473385754.jpg', '$2y$10$6xcR6dg/OKSaBJuOrBh9WuwIuO4HstG9W7iNaDXzV3heR1ficaske', '2024-11-26 03:17:00', '2024-11-26 03:34:41', 12, 5, 11, 0, 0),
(16, 'Elise Jane Lacubtan', 'Elise', 'lacubtanelisejane@gmail.com', 'profile_pic/profile_default.svg', '$2y$10$MOtySxoMGf0a412BWZtjk.aD7PLcJsaOGQJ75JmEp40EMoqNr2Pqe', '2024-11-26 05:29:21', '2024-11-26 06:25:55', 13, 6, 12, 0, 0),
(17, 'Realene Palero', 'Palero', 'palero@gmail.com', 'profile_pic/profile_default.svg', '$2y$10$jyGxWZS/96OBsGoiJmlWeuxfdWymfDc4tYvMqhdy.E/lywOFMIl7u', '2024-11-26 05:38:04', '2024-11-26 06:11:07', 14, 7, 13, 0, 0),
(18, 'Sophy Mecasio', 'Soph', 'sophy@gmail.com', 'profile_pic/profile_default.svg', '$2y$10$foToSw4Gv6V/twXofuGX9uVSmgxRvG0uV6omJU8ftHjYJ9DM9T.cC', '2024-11-26 05:46:28', '2024-11-26 06:11:09', 16, 9, 15, 0, 0),
(19, 'Romel Miro', 'Mel', 'romel@gmail.com', 'profile_pic/profile_default.svg', '$2y$10$DdhGxm6Bn1i8MOr2MB/mnenAMI/m5JXU/PnqvGOoUY0mYzSv9p2H2', '2024-11-26 05:59:06', '2024-11-26 06:11:14', 17, 10, 16, 0, 0),
(20, 'Kyle Hoag', 'Kyle', 'kyle@gmail.com', 'profile_pic/profile_default.svg', '$2y$10$BrD0GndP.tSQFy2ieJ4iaugIrtzx8dquOgVeDpEaILV4zZPU/THAG', '2024-11-26 06:03:44', '2024-11-26 06:11:17', 18, 11, 17, 0, 0),
(21, 'Madison Weeks', 'josotefok', 'raxuw@mailinator.com', 'profile_pic/profile_default.svg', '$2y$10$aPAfiQZhGeMQEsrbCLLQDefmDH5NnibeFtXyTu4e3Nw/cHjlP14x2', '2024-11-26 06:07:23', '2024-11-26 06:11:21', 26, 19, 25, 0, 0),
(22, 'Nollan Paleor', 'Nollan', 'nollan@gmail.com', 'profile_pic/profile_default.svg', '$2y$10$8j40ows9jGe5T5sZmzKArO373sFVQ2//jZyc.OsbxbEiGmVe8amdK', '2024-11-26 06:14:16', '2024-11-26 06:48:34', 27, 20, 26, 0, 0),
(23, 'Jay r Sala', 'Jayr', 'jayr@gmail.com', 'profile_pic/profile_default.svg', '$2y$10$hQIVwpb0szVYiNpsgSGiPeyaQszquRTr7pPvjcwIMjtH1fttLGXdu', '2024-11-26 06:26:26', '2024-11-26 06:26:41', 28, 21, 27, 0, 0),
(24, 'John Paul Bongcales Cadavez', 'kdijhusi', 'dsocniu@sadimon.com', 'profile_pic/profile_default.svg', '$2y$10$0a21RYHY7HeBrf4nnyMpqeAgviLyKOS61t3wxRywpynyqK7Bkgj7G', '2024-11-26 06:29:24', '2024-11-26 06:45:58', 36, 29, 35, 0, 0),
(25, 'Sybill Graves', 'henowiqa', 'jucy@mailinator.com', 'profile_pic/profile_default.svg', '$2y$10$FNTHgvPOKayWXltG/P8iSu81RPGJTHpfrWBTk3axLIGrl4xdt8qIu', '2024-11-26 06:47:03', '2024-11-26 06:47:16', 37, 30, 36, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(10) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dashboard`
--
ALTER TABLE `dashboard`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_accounts_dashboard` (`user_id`) USING BTREE;

--
-- Indexes for table `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_accounts_deposit` (`user_id`) USING BTREE;

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_accounts_expense` (`user_id`) USING BTREE;

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_accounts_logs` (`user_id`) USING BTREE;

--
-- Indexes for table `security_q`
--
ALTER TABLE `security_q`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_accounts_security_q` (`user_id`) USING BTREE;

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_accounts_settings` (`user_id`) USING BTREE;

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_question` (`question_id`),
  ADD KEY `fk_settings` (`settings_id`),
  ADD KEY `fk_dashboard` (`dashboard_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_accounts_category` (`user_id`) USING BTREE;


--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dashboard`
--
ALTER TABLE `dashboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `deposit`
--
ALTER TABLE `deposit`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=785;

--
-- AUTO_INCREMENT for table `security_q`
--
ALTER TABLE `security_q`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dashboard`
--
ALTER TABLE `dashboard`
  ADD CONSTRAINT `fk_user_accounts_dashboard` FOREIGN KEY (`user_id`) REFERENCES `user_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `deposit`
--
ALTER TABLE `deposit`
  ADD CONSTRAINT `fk_user_accounts` FOREIGN KEY (`user_id`) REFERENCES `user_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `expense`
--
ALTER TABLE `expense`
  ADD CONSTRAINT `fk_user_accounts_expense` FOREIGN KEY (`user_id`) REFERENCES `user_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `fk_user_accounts_logs` FOREIGN KEY (`user_id`) REFERENCES `user_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `security_q`
--
ALTER TABLE `security_q`
  ADD CONSTRAINT `fk_user_accounts_security_q` FOREIGN KEY (`user_id`) REFERENCES `user_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `fk_user_accounts_settings` FOREIGN KEY (`user_id`) REFERENCES `user_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD CONSTRAINT `fk_dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`),
  ADD CONSTRAINT `fk_question` FOREIGN KEY (`question_id`) REFERENCES `security_q` (`id`),
  ADD CONSTRAINT `fk_settings` FOREIGN KEY (`settings_id`) REFERENCES `settings` (`id`);

--
-- Constraints for table `settings`
--
ALTER TABLE `category`
  ADD CONSTRAINT `fk_user_accounts_category` FOREIGN KEY (`user_id`) REFERENCES `user_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
