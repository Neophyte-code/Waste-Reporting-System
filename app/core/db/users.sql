-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2025 at 08:41 AM
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
-- Database: `waste_reporting_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `role` enum('user','admin','superadmin') NOT NULL DEFAULT 'user'
) ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `barangay_id`, `email`, `password`, `created_at`, `profile_picture`, `points`, `role`) VALUES
(1, 'Jerwin', 'Noval', 1, 'jerwinnoval645@gmail.com', '$2y$10$fZcHB6UVHv4.S0CxYFROy.TgT017Vrt7ajZAZU8Rb99HrxxqhHMZq', '2025-06-13 08:15:27', 'images/uploads/68a41bffd2b95-491197203_9603661269713196_2713955384735654909_n.jpg', 965, 'user'),
(9, 'ella', 'pasohil', 2, 'ellapasohil@gmail.com', '$2y$10$H2F8A7wj9osqa7tY93Ty2OotOCibn93ozNqbUOpf1z.C7jw4EtFZG', '2025-06-25 03:40:40', 'images/uploads/68a54fd7a49cc-janice.jpg', 110, 'user'),
(11, 'Mary Grace', 'Rosell', 3, 'marygracerosell@gmail.com', '$2y$10$ns35rjGIiDWXvZmHLpxBMuabf1BHrWEPQMx0EhtncVZ/cqma2pPb.', '2025-08-20 04:37:24', 'images/uploads/68a5534d72d25-Screenshot 2025-08-20 124626.png', 0, 'user'),
(12, 'Tristan', 'Vasquez', 1, 'tristanvasquez@gmail.com', '$2y$10$C0Nex1717HrDQEKqicN4P.9qhnwZhnFrbF3GT2ppIWLKslxPRYJxS', '2025-08-23 03:11:18', 'images/uploads/68c37ca54a5c7-profile.jpg', 40, 'user'),
(13, 'Barangay', 'Tapilon', 1, 'barangaytapilon@gmail.com', '$2y$10$RSOc/KbynA5xo.cIcLB4AeTUInO28x2YwB.m8WMvV0yFDqa4oVnAG', '2025-08-23 05:49:58', NULL, 0, 'admin'),
(20, 'Barangay', 'Maya', 2, 'barangaymaya@gmail.com', '$2y$10$RSOc/KbynA5xo.cIcLB4AeTUInO28x2YwB.m8WMvV0yFDqa4oVnAG', '2025-08-23 05:49:58', NULL, 0, 'admin'),
(21, 'Barangay', 'Poblacion', 3, 'barangaypoblacion@gmail.com', '$2y$10$RSOc/KbynA5xo.cIcLB4AeTUInO28x2YwB.m8WMvV0yFDqa4oVnAG', '2025-08-23 05:49:58', NULL, 0, 'admin'),
(22, 'Roselyn', 'Arenas', 3, 'roselynarenas@gmail.com', '$2y$10$I0o0x2kwBXpIB2u6vFlWPuxuXACyU9WMF2c96V7cQ4m8JUEZ3soja', '2025-09-18 10:13:30', 'images/uploads/68cbdd79bb1ab-Screenshot 2025-08-20 124626.png', 10, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
