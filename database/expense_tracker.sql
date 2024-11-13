-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2024 at 05:53 AM
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
(1, 2, -10631862.20, 10882860.69, 250998.49, 11, 8),
(2, 4, 0.00, 0.00, 0.00, 0, 0),
(3, 5, -1000.00, 1000.00, 0.00, 1, 0);

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
(24, 2, '2024-11-06 17:54:14', '2024-11-06 17:54:14', 'minecraft inbu', 'Category 2', 876.00, '2024-11-06');

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
(10, 2, '2024-11-04 16:18:43', '2024-11-04 16:44:20', 'sinh sasmacnk', 'Category 1', 9872.00, '2023-01-02', 'sxkan, dskcn', 23),
(11, 2, '2024-11-06 09:20:42', '2024-11-06 09:20:42', 'jhj', 'Category 2', 43.00, '2024-11-19', 'jhjh', 2434),
(12, 2, '2024-11-06 09:28:43', '2024-11-06 09:28:43', 'GIS Training Snacks', 'Category 2', 500.00, '2024-11-06', 'Snacks', 34),
(25, 5, '2024-11-06 18:13:24', '2024-11-06 18:13:24', 'For GIS Training', 'Category 1', 1000.00, '2024-11-06', 'Snacks', 30),
(27, 2, '2024-11-06 18:14:26', '2024-11-06 18:14:26', 'noidcbijpac dk', 'Category 1', 234.00, '2024-10-30', 'wertyuio, cfvghnjm, oijhsgk, dkjhjk', 3984);

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
(4, 5, 'A', 'B', 'C', 'D', 'E', 'F');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `dashboard_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`id`, `fullname`, `username`, `email`, `profile_pic`, `password`, `created_at`, `updated_at`, `question_id`, `settings_id`, `dashboard_id`) VALUES
(2, 'John Paul Bongcales Cadavez', 'JpcTheDecoder', 'jpcyoyoyo123@gmail.com', 'profile_pic/671b5be74668f_1769829-plant_peashooter_thumb.jpg', '$2y$10$94pXEWx4Yc3JvgZHDRfSUepYsE9XHfaGlekzjbIOIwNWzqjETI65W', '2024-10-23 01:16:17', '2024-10-28 08:08:41', 2, NULL, 1),
(4, 'John Paul Cadavez', 'minecraft123', 'jpcyoyoyo@gmail.com', 'profile_pic/profile_default.svg', '$2y$10$syJVbXgdbeoWZKUFxHC.oem/jVOX/ScaMj1nwStiXmJWTkML/57Lm', '2024-10-28 08:49:33', '2024-10-28 08:49:44', 3, NULL, 2),
(5, 'Stefanie Relos', 'Steff', 'steffanierelos@gmail.com', 'profile_pic/profile_default.svg', '$2y$10$1MwoYUHEX9UUYu.EvqGe6uxx9SaJuH7uEHv7h4irtgPVaXDZ8e8iy', '2024-11-06 09:59:54', '2024-11-06 10:00:26', 4, NULL, 3);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dashboard`
--
ALTER TABLE `dashboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `deposit`
--
ALTER TABLE `deposit`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `security_q`
--
ALTER TABLE `security_q`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
