-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 07:44 AM
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
-- Database: `employees`
--

-- --------------------------------------------------------

--
-- Table structure for table `class_times`
--

CREATE TABLE `class_times` (
  `Class_Time_ID` int(11) UNSIGNED NOT NULL,
  `Employee_ID` int(11) NOT NULL,
  `Day` enum('Monday','Tuesday','Wednesday','Thursday','Friday') CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `Start_Time` time NOT NULL,
  `End_Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_times`
--

INSERT INTO `class_times` (`Class_Time_ID`, `Employee_ID`, `Day`, `Start_Time`, `End_Time`) VALUES
(1, 1, 'Thursday', '14:30:00', '16:30:00'),
(2, 2, 'Thursday', '14:30:00', '16:30:00'),
(3, 3, 'Thursday', '14:30:00', '16:30:00'),
(4, 4, 'Thursday', '14:30:00', '16:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `contributions`
--

CREATE TABLE `contributions` (
  `Contribution_ID` int(11) UNSIGNED NOT NULL,
  `Employee_ID` int(11) NOT NULL,
  `Contribution` varchar(100) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contributions`
--

INSERT INTO `contributions` (`Contribution_ID`, `Employee_ID`, `Contribution`) VALUES
(1, 1, 'Home Page'),
(2, 1, 'CSS'),
(3, 1, 'Manage Page'),
(4, 1, 'Login Page'),
(5, 1, 'Accessibility Settings'),
(6, 1, 'Common elements to .inc'),
(7, 1, 'Info Card'),
(8, 2, 'Apply Page'),
(9, 2, 'CSS'),
(10, 2, 'Process EOI'),
(11, 3, 'About Page'),
(12, 3, 'CSS'),
(13, 3, 'Powerpoint'),
(14, 4, 'Jobs Page'),
(15, 4, 'CSS');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `ID` int(10) UNSIGNED NOT NULL COMMENT 'The employees ID',
  `First_name` varchar(100) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'The Employees first name',
  `Last_Name` varchar(100) CHARACTER SET armscii8 COLLATE armscii8_general_ci NOT NULL COMMENT 'The Employees last name',
  `Student_ID` int(9) NOT NULL COMMENT 'The employees student ID',
  `Tutor_ID` int(11) UNSIGNED NOT NULL COMMENT 'The link to the tutor for this employee',
  `Photo` varchar(255) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'The file name for the photo of this employee',
  `Photo_Alt` varchar(255) NOT NULL COMMENT 'The Employees alternate description for the photo incase it doesn''t load or for accessibility reasons',
  `Description` text NOT NULL COMMENT 'The description of what this employee does for the company'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Stores the information about a employee';

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`ID`, `First_name`, `Last_Name`, `Student_ID`, `Tutor_ID`, `Photo`, `Photo_Alt`, `Description`) VALUES
(1, 'Evan', 'Harrison', 105929605, 1, 'Evan_Harrison.webp', 'Front-facing picture of Evan Harrison', 'Evan Harrison is our go-to tech troubleshooter, known for his sharp problem-solving skills and technical expertise. Whether it\'s fixing system crashes, resolving software bugs, or optimizing performance, Evan handles it all with speed and precision. He focuses not just on quick fixes but also long-term solutions—streamlining workflows, securing systems, and integrating new tools. Methodical, resourceful, and always up-to-date with the latest tech trends, Evan is a vital force in keeping our operations running smoothly'),
(2, 'Henry ', 'Bennett', 105923571, 1, 'Henry_Bennett.webp', 'Front-facing image of Henry Bennett taking a photo with a phone', 'Henry Bennett is our cybersecurity expert, focused on keeping digital systems secure and resilient. From blocking malware to securing networks and access points, he handles threats quickly and effectively. Beyond incident response, Henry implements long-term protections like audits, encryption, and continuous monitoring to ensure data safety and smooth operations.'),
(3, 'Ben', 'Romano', 105773284, 1, 'Ben_Romano.webp', 'A front-facing picture of Ben Romano', 'Ben Romano is our hardware specialist, ensuring all devices, workstations, and network equipment run smoothly and efficiently. From diagnosing issues to setting up new systems, he handles hardware with precision and care. Ben goes beyond quick fixes, building reliable, scalable setups with quality components and structured cabling. His attention to detail ensures every system is optimized for performance and durability.'),
(4, 'Michael', 'Sharpley', 105913792, 1, 'Michael_Sharpley.webp', 'A picture of Michael Sharpley with a blue background', 'Michael Sharpley is our database specialist, focused on building and maintaining efficient, scalable, and secure data systems. From designing robust schemas to optimizing queries and implementing backups, he ensures your data is structured for performance and reliability. Whether starting from scratch or improving existing setups, Michael brings a strategic, detail-driven approach that keeps systems fast, stable, and future-ready.');

-- --------------------------------------------------------

--
-- Table structure for table `tutors`
--

CREATE TABLE `tutors` (
  `Tutor_ID` int(11) UNSIGNED NOT NULL COMMENT 'The ID for a tutor',
  `Name` varchar(100) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL COMMENT 'The Name for that tutor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`Tutor_ID`, `Name`) VALUES
(1, 'Nick'),
(2, 'Atie'),
(3, 'Rahul'),
(4, 'Razeen');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class_times`
--
ALTER TABLE `class_times`
  ADD PRIMARY KEY (`Class_Time_ID`);

--
-- Indexes for table `contributions`
--
ALTER TABLE `contributions`
  ADD PRIMARY KEY (`Contribution_ID`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Tutor link` (`Tutor_ID`);

--
-- Indexes for table `tutors`
--
ALTER TABLE `tutors`
  ADD PRIMARY KEY (`Tutor_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class_times`
--
ALTER TABLE `class_times`
  MODIFY `Class_Time_ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contributions`
--
ALTER TABLE `contributions`
  MODIFY `Contribution_ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The employees ID', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tutors`
--
ALTER TABLE `tutors`
  MODIFY `Tutor_ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The ID for a tutor', AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `Tutor link` FOREIGN KEY (`Tutor_ID`) REFERENCES `tutors` (`Tutor_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
