-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2024 at 07:22 AM
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
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `expense_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `deposit_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `expense_count` int(11) NOT NULL DEFAULT 0,
  `deposit_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dashboard`
--

INSERT INTO `dashboard` (`id`, `balance`, `expense_total`, `deposit_total`, `expense_count`, `deposit_count`) VALUES
(1, 0.00, 0.00, 0.00, 0, 0);

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
  `amount` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deposit`
--

INSERT INTO `deposit` (`id`, `user_id`, `created_at`, `updated_at`, `description`, `category`, `amount`, `date`) VALUES
(16, 2, '2024-10-23 12:34:31', '2024-10-23 12:36:18', 'qwertyuiop', '0', 977745.60, '2024-09-29'),
(17, 2, '2024-10-23 12:34:32', '2024-10-23 12:44:55', '1234', '0', 2345.60, '2024-10-03');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `security_q`
--

CREATE TABLE `security_q` (
  `id` int(10) NOT NULL,
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

INSERT INTO `security_q` (`id`, `q1`, `q1_answer`, `q2`, `q2_answer`, `q3`, `q3_answer`) VALUES
(1, 'qwertyuiop', 'qwerty', 'asdfghjkl', 'asdfgh', 'zxcvbnm', 'zxcvbn'),
(2, 'qwertyuiop', 'qwerty', 'asdfghjkl', 'asdfgh', 'zxcvbnm', 'zxcvbn');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) NOT NULL
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

INSERT INTO `user_accounts` (`id`, `fullname`, `username`, `email`, `password`, `created_at`, `updated_at`, `question_id`, `settings_id`, `dashboard_id`) VALUES
(2, 'John Paul Bongcales Cadavez', 'JpcTheDecoder', 'jpcyoyoyo123@gmail.com', '$2y$10$ZdAd1pZT4qZ.mwy2r1P75.nCaZ1uTDAeUWA8Q8/P/pilHWdOt76oG', '2024-10-23 01:16:17', '2024-10-23 03:29:12', 2, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dashboard`
--
ALTER TABLE `dashboard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_accounts` (`user_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `security_q`
--
ALTER TABLE `security_q`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deposit`
--
ALTER TABLE `deposit`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `security_q`
--
ALTER TABLE `security_q`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deposit`
--
ALTER TABLE `deposit`
  ADD CONSTRAINT `fk_user_accounts` FOREIGN KEY (`user_id`) REFERENCES `user_accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
