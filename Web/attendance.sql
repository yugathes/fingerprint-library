-- phpMyAdmin SQL Dump
-- version 5.0.4deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 04, 2022 at 04:29 AM
-- Server version: 10.5.15-MariaDB-0+deb11u1
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attnID` int(11) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `usrID` int(9) NOT NULL,
  `cID` int(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attnID`, `time`, `date`, `usrID`, `cID`) VALUES
(46, '08:00:00', '2022-05-04', 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `cID` int(9) NOT NULL,
  `name` varchar(225) NOT NULL,
  `lecturer` varchar(99) NOT NULL,
  `student` varchar(999) NOT NULL,
  `timeSlot` time NOT NULL,
  `timeSlot2` time NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`cID`, `name`, `lecturer`, `student`, `timeSlot`, `timeSlot2`) VALUES
(2, 'System Analysis And Design', 'Puven', '100', '10:00:00', '15:00:00'),
(3, 'Data Communication', 'Puven', '50', '12:00:00', '16:00:00'),
(4, 'Web Programming', 'Puven', '30', '08:00:00', '14:00:00'),
(6, 'Embeded system', 'hanani', '30', '10:00:00', '16:00:00'),
(7, 'Security Infrastructure', 'Saliza', '50', '13:30:00', '17:00:00'),
(8, 'Airtificial Inteligence', 'Saliza', '40', '08:00:00', '17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(9) NOT NULL,
  `sID` varchar(99) NOT NULL,
  `cID` int(9) NOT NULL,
  `LID` varchar(99) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `sID`, `cID`, `LID`) VALUES
(1, 'Yuga', 2, 'Puven'),
(2, 'Yuven', 2, 'Puven'),
(3, 'Obama', 2, 'Puven'),
(4, 'saranya', 3, 'Puven'),
(5, 'saranya', 7, 'saliza'),
(6, 'Yuga', 7, 'Saliza'),
(7, 'Yuven', 7, 'Saliza');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(9) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `Hp` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type_user` varchar(20) NOT NULL,
  `fingerprint` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `password`, `id`, `name`, `Hp`, `email`, `type_user`, `fingerprint`) VALUES
(1, 'Yuga', '123', 'SN0106769', 'Yugathes ', '0149165192', 'yugathesyuga@gmail.com', 'Student', 1),
(2, 'Admin', '123', '', '', '', '', 'Admin', 0),
(3, 'Puven', '123', 'EE913728', 'Puvendra Dasan', '019384342', 'puvendradasan1699@gmail.com', 'Lecturer', 0),
(4, 'Yuven', '123', 'SN0107612', 'Yuven Raj', '0165824723', 'mac.yuven@gmail.com', 'Student', 1),
(12, 'Saliza', '123', 'SE123847', 'Saliza', '013224553556', 'saliza@gmail.com', 'Lecturer', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attnID`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`cID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attnID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `cID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
