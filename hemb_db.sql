-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2025 at 09:24 AM
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
-- Database: `hemb_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `eoi`
--

CREATE TABLE `eoi` (
  `EOInumber` int(11) NOT NULL,
  `Job_Ref_Num` int(11) NOT NULL,
  `Firstname` varchar(20) NOT NULL,
  `Lastname` varchar(20) NOT NULL,
  `Address` varchar(80) NOT NULL,
  `Email_Address` varchar(40) NOT NULL,
  `Phone_Number` int(12) NOT NULL,
  `Technical_Skills` varchar(100) NOT NULL,
  `Preferred_Skills` varchar(100) NOT NULL,
  `Other_Skills` varchar(100) NOT NULL,
  `Status` enum('New','Current','Final') NOT NULL DEFAULT 'New'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eoi`
--

INSERT INTO `eoi` (`EOInumber`, `Job_Ref_Num`, `Firstname`, `Lastname`, `Address`, `Email_Address`, `Phone_Number`, `Technical_Skills`, `Preferred_Skills`, `Other_Skills`, `Status`) VALUES
(1, 1, 'John', 'Smith', '31 smith Creek Victoria', 'johnsmith@gmail.com', 123456789, 'Trouble Shooting,Networking,Security,Database Management', 'Communication,Teamwork,Time Managment,Autonomous,Fast Learner', 'I am great at making coffee', 'New'),
(2, 3, 'Jane', 'Doe', '1 franklin rd Vic', 'JaneDoe@gmail.com', 987654321, 'Networking,Hardware,Software,Security', 'Communication,Time Managment,Autonomous,Fast Learner', 'I can work for many hours without getting tired', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(10) UNSIGNED NOT NULL COMMENT 'The id for the user (1,2,3....)',
  `Username` varchar(32) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'The users "username" that is used to login with',
  `Password` varchar(255) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'The hashed password of a user',
  `Role` enum('Admin','Member') CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT 'Member' COMMENT 'Admin or Member'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Username`, `Password`, `Role`) VALUES
(1, 'Admin', '$2y$10$OzO8HpC0TxmBjsq86nfO5eK/ipwBILhRG./.pNb3HXQboM09NiqaO', 'Admin'),
(2, 'Member', '$2y$10$SDyVOpo3F9uKWL7qZOtO5.BVLn.YDMSMy2ANLiKsHBBSsaUe2O9Pi', 'Member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOInumber`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Unique_Username` (`Username`),
  ADD UNIQUE KEY `Unique_Password` (`Password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `EOInumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The id for the user (1,2,3....)', AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
