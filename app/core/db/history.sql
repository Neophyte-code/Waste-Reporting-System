-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2025 at 06:02 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `waste_reporting_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `redemption_id` int(11) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `points_change` decimal(10,2) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `user_id`, `redemption_id`, `type`, `title`, `message`, `points_change`, `status`, `created_at`) VALUES
(1, 1, 1, 'redemption_request', 'Redemption Request Submitted', 'Your redemption request has been submitted and is pending review.', -75.00, 'pending', '2025-08-10 10:00:35'),
(2, 9, 2, 'redemption_request', 'Redemption Request Submitted', 'Your redemption request has been submitted and is pending review.', -25.00, 'pending', '2025-08-12 04:04:42'),
(3, 9, 3, 'redemption_request', 'Redemption Request Submitted', 'Your redemption request has been submitted and is pending review.', -25.00, 'pending', '2025-08-12 04:41:28'),
(4, 9, 4, 'redemption_request', 'Redemption Request Submitted', 'Your redemption request has been submitted and is pending review.', -25.00, 'pending', '2025-08-12 05:01:50'),
(5, 8, 5, 'redemption_request', 'Redemption Request Submitted', 'Your redemption request has been submitted and is pending review.', -100.00, 'pending', '2025-08-13 03:13:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `redemption_id` (`redemption_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
