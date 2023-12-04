-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 28, 2023 at 12:13 PM
-- Server version: 10.11.3-MariaDB-1+rpi1
-- PHP Version: 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendance2`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`) VALUES
(3, 'Bachelor of Computer Science(System & Networking)'),
(4, 'Bachelor of Computer Science(Software Engineering)'),
(5, 'Bachelor of Computer Science(Cyber Security)'),
(6, 'Bachelor of Information Technology (Information Systems)'),
(7, 'Bachelor of Information Technology (Visual Media)'),
(8, 'Bachelor of Information Technology (Visual Media)');

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`id`, `name`, `datetime`) VALUES
(1, 'System Analysis Design', '2023-12-20 09:00:00'),
(2, 'Computer Forensic', '2023-12-09 21:00:00'),
(3, 'Nasim Oneill', '2009-02-09 23:14:00'),
(4, 'Cisco2', '2023-12-07 09:13:00');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`id`, `name`) VALUES
(2, 'Semester 1 (2023/2024)'),
(3, 'Semester 2 (2023/2024)'),
(4, 'Semester 3 (2023/2024)	');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ic_no` varchar(99) NOT NULL,
  `student_id` varchar(99) NOT NULL,
  `email` varchar(99) NOT NULL,
  `enrol_fingerprint` int(1) NOT NULL,
  `course_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `ic_no`, `student_id`, `email`, `enrol_fingerprint`, `course_id`, `semester_id`) VALUES
(1, 'Brody Carney', 'Possimus laboriosam', 'SE0104928', 'rajepaja@mailinator.com', 1, 8, 3),
(2, 'Adrienne Jarvis', 'Quos et magna volupt', 'SG0193814', 'tuwy@mailinator.com', 1, 7, 3),
(3, 'Pavenarsh A/L Arichanthiran', '011012-11-1656', 'CS0106373', 'pave1@gmail.com', 1, 8, 3),
(4, 'Andrew Norman', '990121037823', 'SN0107382', 'renik@mailinator.com', 1, 8, 2),
(5, 'Ted Bryan', '871173-10-2832', 'CS0137338', 'bryan@yahoo.com', 0, 5, 4),
(6, 'Fatira', '5267265-19-3833', 'CS0164738', 'fat@gmail.com', 0, 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `student_has_exam`
--

CREATE TABLE `student_has_exam` (
  `id` int(9) NOT NULL,
  `student_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `attendance` int(11) NOT NULL,
  `attendance_date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_has_exam`
--

INSERT INTO `student_has_exam` (`id`, `student_id`, `exam_id`, `attendance`, `attendance_date_time`) VALUES
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
  `staffId` varchar(99) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type_user` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `staffId`, `password`, `name`, `email`, `type_user`) VALUES
(1, 'Admin', '123', 'Test Admin', 'admin@test.com', 'Admin'),
(2, 'ST0128385', 'Pa$$w0rd!', 'Kitra Vazquez', 'jyqozaju@mailinator.com', 'Lecturer'),
(3, 'ST01283812', 'Pa$$w0rd!', 'Zorita Hoppers', 'lihar@mailinator.com', 'Lecturer'),
(4, 'ST0127839', '123', 'Marina', 'marina@uniten.edu.my', 'Lecturer'),
(5, 'Admin2', '123', 'Admin2', 'admin@test.com', 'Admin'),
(6, 'MC220919', 'asdf', 'Anushinee', 'anu@gmail.com', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD KEY `fk_course_id` (`course_id`),
  ADD KEY `fk_semester_id` (`semester_id`);

--
-- Indexes for table `student_has_exam`
--
ALTER TABLE `student_has_exam`
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
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student_has_exam`
--
ALTER TABLE `student_has_exam`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_course_id` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `fk_semester_id` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`id`);

--
-- Constraints for table `student_has_exam`
--
ALTER TABLE `student_has_exam`
  ADD CONSTRAINT `fk_exam_id` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`),
  ADD CONSTRAINT `fk_student_id` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
