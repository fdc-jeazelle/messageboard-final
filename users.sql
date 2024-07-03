-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 03, 2024 at 03:27 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `messageboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `last_logged_in` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `date_added`, `last_logged_in`) VALUES
(30, 'Johnny', 'White', 'johndoe@gmail.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-06-24 11:24:06', '2024-07-02 08:24:59'),
(31, 'Angelina', 'Jolie', 'ajolie@gmail.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-06-26 08:07:15', '2024-07-03 03:26:52'),
(32, 'Timothy', 'Chalamet', 'tim@gmail.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-06-27 04:26:48', '2024-07-01 10:34:51'),
(33, 'Jane', 'Doe', 'janedoe@gmail.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-01 10:50:57', '2024-07-01 10:50:57'),
(34, 'Ryan', 'Park', 'ryanpark@gmail.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-01 10:51:43', '2024-07-01 10:51:43'),
(50, 'John', 'Smith', 'john.smith@example.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-02 10:49:39', '2024-07-02 10:49:39'),
(51, 'Emily', 'Johnson', 'emily.johnson@example.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-02 10:52:42', '2024-07-02 10:52:42'),
(52, 'Michael', 'Williams', 'michael.williams@example.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-02 10:53:49', '2024-07-02 11:06:08'),
(53, 'Sarah', 'Brown', 'sarah.brown@example.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-02 10:57:35', '2024-07-02 10:57:35'),
(54, 'David', 'Davis', 'david.davis@example.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-02 10:59:04', '2024-07-02 10:59:04'),
(55, 'Jessica', 'Miller', 'jessica.miller@example.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-02 11:00:54', '2024-07-02 11:00:54'),
(56, 'Matthew', 'Wilson', 'matthew.wilson@example.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-02 11:01:15', '2024-07-02 11:01:15'),
(57, 'Olivia', 'Moore', 'olivia.moore@example.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-02 11:05:40', '2024-07-02 11:05:40'),
(58, 'Ethan', 'Taylor', 'ethan.taylor@example.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-02 11:05:59', '2024-07-02 11:05:59'),
(59, 'test', 'test', 'test@gmail.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-02 11:44:12', '2024-07-02 11:44:12'),
(60, 'sfsdf', 'sdfsdf', 'uuuere@gmail.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-02 11:44:41', '2024-07-02 11:44:41'),
(61, 'sfsdf', 'sdfsdf', 'uuuerexxxx@gmail.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-02 11:45:20', '2024-07-02 11:45:20'),
(62, 'sfsdf', 'sdfsdf', 'uuuerddexxxx@gmail.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-02 11:45:51', '2024-07-02 11:45:51'),
(63, 'sfsdf', 'sdfsdf', 'uuuerddexxxxtt@gmail.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-02 11:46:39', '2024-07-02 11:46:39'),
(64, 'newname', 'cxvxcv', 'as@gmail.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-02 11:47:04', '2024-07-02 11:47:04'),
(65, 'sdfsdf', 'sdfsdf', 'dasda@gmail.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-02 11:48:24', '2024-07-02 11:48:24'),
(66, 'sfdsd', 'sdfsf', 'jjjj@gmail.com', '5750c4a12a4ea5d9e2b3ff5f7ec57a22d7518278', '2024-07-02 11:49:22', '2024-07-02 11:49:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
