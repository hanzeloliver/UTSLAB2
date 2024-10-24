-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2024 at 05:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `todos`
--

CREATE TABLE `todos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `todos`
--

INSERT INTO `todos` (`id`, `user_id`, `task`, `status`, `created_at`) VALUES
(1, 1, 'Complete project presentation', 1, '2024-01-01 03:30:00'),
(2, 1, 'Buy groceries', 0, '2024-01-01 04:00:00'),
(3, 1, 'Schedule dentist appointment', 0, '2024-01-01 05:00:00'),
(4, 1, 'Pay electricity bill', 1, '2024-01-02 02:00:00'),
(5, 1, 'Call mom', 0, '2024-01-02 07:00:00'),
(6, 2, 'Submit research paper', 1, '2024-01-02 05:00:00'),
(7, 2, 'Gym workout', 0, '2024-01-02 06:00:00'),
(8, 2, 'Team meeting at 3 PM', 1, '2024-01-03 02:00:00'),
(9, 2, 'Plan weekend trip', 0, '2024-01-03 03:00:00'),
(10, 2, 'Review code changes', 0, '2024-01-03 04:00:00'),
(11, 3, 'Fix bug in login system', 1, '2024-01-03 08:00:00'),
(12, 3, 'Update portfolio website', 0, '2024-01-03 09:00:00'),
(13, 3, 'Send invoice to client', 1, '2024-01-04 02:00:00'),
(14, 3, 'Prepare monthly report', 0, '2024-01-04 03:00:00'),
(15, 3, 'Backup database', 0, '2024-01-04 04:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todos`
--
ALTER TABLE `todos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todos`
--
ALTER TABLE `todos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `todos`
--
ALTER TABLE `todos`
  ADD CONSTRAINT `todos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
