-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 05:15 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appointment-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `feedback` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `feedback`, `created_at`) VALUES
(1, 2, 'I Like how The Email response it\'s so accurate thankyou ', '2024-05-23 02:33:49'),
(2, 2, 'sad', '2024-05-23 02:37:25');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`) VALUES
(4, 'Cake of Knowledge ', 'Easy to get, Hard to forget', '1.00', 'uploads/background.jpg'),
(6, 'Ube Cake Round', 'OHAHA', '7805.00', 'uploads/ube-cake-round.jpg'),
(7, 'Ube Cake', 'OHAHAHA', '8754.00', 'uploads/Ube-Cake.jpeg'),
(10, 'Heart of Mary', 'Makapuno Cake', '699.00', 'uploads/heart of mary.jpg'),
(11, 'Ube Cake Roll', 'The Hungry Pinner', '499.00', 'uploads/ube-cake-roll.jpg'),
(14, 'Ube Cake With White Chocolate', 'Woman Scribbles', '599.00', 'uploads/ube_coconut_cake_1-1-768x1024.webp');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `phone` varchar(15) DEFAULT NULL,
  `carrier` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `is_admin`, `phone`, `carrier`) VALUES
(1, 'Ayco', '$2y$10$5vm8UuhY/j2LogT1.lgeXeVVHbNSCR6eMiZre/MuqD0FuWG/mBloS', 'dakiesayco@gmail.com', 0, NULL, NULL),
(2, 'admin', '$2y$10$pZDMgocM/jEym4tx1nW07OzyogzrfzuHvbhu/AXOlqYd.2elcYFmq', 'emmaneulayco@gmail.com', 0, NULL, NULL),
(5, 'tatol', '$2y$10$D2pg86FJ2AWWcVuuSTcuGOfBXUSPhP4RQPFS1zzTJJvYek/zYLhAi', 'tatol@gmail.com', 127, NULL, NULL),
(7, 'ejayco123', '$2y$10$i1jRY7F4btjNlBWyS8c0G.Uirr8tLUlqrpruhSTP3DOSD3qM6ekaq', 'ejayco123@gmail.com', 0, '9750637725', 'globe'),
(8, 'jefferson', '$2y$10$XIt7PX7i/C8/mAE44sTpL.SGBFblfFl.tOxFbp14ZM1oIZC/VvW9.', 'jefferson@gmail.com', 0, '9750637725', 'globe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
