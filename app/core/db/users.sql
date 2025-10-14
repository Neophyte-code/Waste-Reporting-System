-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2025 at 01:15 PM
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
  `id_front` varchar(255) DEFAULT NULL,
  `id_back` varchar(255) DEFAULT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `role` enum('user','admin','superadmin') NOT NULL DEFAULT 'user',
  `status` enum('active','banned') NOT NULL DEFAULT 'active',
  `is_verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `barangay_id`, `email`, `password`, `created_at`, `profile_picture`, `id_front`, `id_back`, `points`, `role`, `status`, `is_verified`) VALUES
(1, 'Jerwin', 'Noval', 1, 'jerwinnoval645@gmail.com', '$2y$10$fZcHB6UVHv4.S0CxYFROy.TgT017Vrt7ajZAZU8Rb99HrxxqhHMZq', '2025-06-13 08:15:27', 'images/uploads/68a41bffd2b95-491197203_9603661269713196_2713955384735654909_n.jpg', NULL, NULL, 965, 'user', 'banned', 1),
(9, 'ella', 'pasohil', 2, 'ellapasohil@gmail.com', '$2y$10$H2F8A7wj9osqa7tY93Ty2OotOCibn93ozNqbUOpf1z.C7jw4EtFZG', '2025-06-25 03:40:40', 'images/uploads/68a54fd7a49cc-janice.jpg', NULL, NULL, 110, 'user', 'active', 1),
(11, 'Mary Grace', 'Rosell', 3, 'marygracerosell@gmail.com', '$2y$10$ns35rjGIiDWXvZmHLpxBMuabf1BHrWEPQMx0EhtncVZ/cqma2pPb.', '2025-08-20 04:37:24', 'images/uploads/68a5534d72d25-Screenshot 2025-08-20 124626.png', NULL, NULL, 0, 'user', 'active', 1),
(12, 'Tristan', 'Vasquez', 1, 'tristanvasquez@gmail.com', '$2y$10$C0Nex1717HrDQEKqicN4P.9qhnwZhnFrbF3GT2ppIWLKslxPRYJxS', '2025-08-23 03:11:18', 'images/uploads/68c37ca54a5c7-profile.jpg', NULL, NULL, 40, 'user', 'active', 1),
(13, 'Barangay', 'Tapilon', 1, 'barangaytapilon@gmail.com', '$2y$10$RSOc/KbynA5xo.cIcLB4AeTUInO28x2YwB.m8WMvV0yFDqa4oVnAG', '2025-08-23 05:49:58', NULL, NULL, NULL, 0, 'admin', 'active', 1),
(20, 'Barangay', 'Maya', 2, 'barangaymaya@gmail.com', '$2y$10$RSOc/KbynA5xo.cIcLB4AeTUInO28x2YwB.m8WMvV0yFDqa4oVnAG', '2025-08-23 05:49:58', NULL, NULL, NULL, 0, 'admin', 'active', 1),
(21, 'Barangay', 'Poblacion', 3, 'barangaypoblacion@gmail.com', '$2y$10$RSOc/KbynA5xo.cIcLB4AeTUInO28x2YwB.m8WMvV0yFDqa4oVnAG', '2025-08-23 05:49:58', NULL, NULL, NULL, 0, 'admin', 'active', 1),
(22, 'Roselyn', 'Arenas', 3, 'roselynarenas@gmail.com', '$2y$10$I0o0x2kwBXpIB2u6vFlWPuxuXACyU9WMF2c96V7cQ4m8JUEZ3soja', '2025-09-18 10:13:30', 'images/uploads/68cbdd79bb1ab-Screenshot 2025-08-20 124626.png', NULL, NULL, 10, 'user', 'active', 1),
(25, 'Super', 'Admin', 4, 'superadmin@gmail.com', '$2y$10$uqMAhVfhHFDVTp7YaJ96heMKgfmz45IMhCsEzwwJ//plKbsFW2jLm', '2025-09-20 07:26:46', NULL, NULL, NULL, 0, 'superadmin', 'active', 1),
(62, 'Neophyte', 'Novadev', 1, 'neophytedeveloper944@gmail.com', '$2y$10$gDamuGgzOdu7RhLv5yzOSuMxFpRwi/4CrXyEFOqyrlSA5axDz3TAW', '2025-10-11 11:14:26', NULL, NULL, NULL, 0, 'user', 'active', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

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
