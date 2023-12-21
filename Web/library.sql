-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2023 at 02:31 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(9) NOT NULL,
  `student_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `attendance` int(11) NOT NULL,
  `attendance_date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `exam_id`, `attendance`, `attendance_date_time`) VALUES
(2, 1, 1, 1, '2023-11-26 23:50:08'),
(3, 2, 1, 1, '2023-11-26 23:50:08'),
(4, 1, 2, 1, '2023-11-26 23:52:28'),
(5, 3, 1, 0, NULL),
(6, 3, 2, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `local_id` varchar(99) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fingerprint` tinyint(1) NOT NULL,
  `type_user` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `local_id`, `password`, `name`, `email`, `fingerprint`, `type_user`) VALUES
(1, 'Admin', '123', 'Test Admin', 'admin@test.com', 0, 'Admin'),
(2, 'ST0128385', 'Pa$$w0rd!', 'Kitra Vazquez', 'jyqozaju@mailinator.com', 0, 'Lecturer'),
(3, 'ST01283812', 'Pa$$w0rd!', 'Zorita Hoppers', 'lihar@mailinator.com', 0, 'Lecturer'),
(6, 'MC220919', '123', 'Anushinee', 'anu@gmail.com', 0, 'Admin'),
(11, '123', '123', 'Beverly Holland', 'birawucufi@mailinator.com0', 0, 'Admin'),
(12, 'AD1234', 'abcd1234', 'Deacon Carney', 'tejyrefar@mailinator.com', 0, 'Admin'),
(13, 'Nulla pariatur Quis', '123', 'Yen Hensley', 'nomir@mailinator.com0', 0, 'Student'),
(14, 'Ad a dolorem anim au', '123', 'Keiko Bradley', 'galifif@mailinator.com0', 0, 'Student'),
(15, 'Exercitationem quos ', '123', 'Tobias Vang', 'cigemyfal@mailinator.com0', 0, 'Lecturer'),
(16, 'LC12345656', '123', 'Drake Stewart', 'qipyz@mailinator.com', 0, 'Lecturer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_student_id` (`student_id`),
  ADD KEY `fk_exam_id` (`exam_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `fk_exam_id` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`),
  ADD CONSTRAINT `fk_student_id` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
