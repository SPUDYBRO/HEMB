-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2025 at 03:41 PM
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
-- Database: `hemb`
--

-- --------------------------------------------------------

--
-- Table structure for table `eoi`
--

CREATE TABLE `eoi` (
  `EOInumber` int(11) NOT NULL COMMENT 'The Expression of interest unique identifier',
  `Job_Ref_Num` int(11) NOT NULL COMMENT 'The reference number to the job',
  `Firstname` varchar(20) NOT NULL COMMENT 'The first name of the user applying for the job',
  `Lastname` varchar(20) NOT NULL COMMENT 'the last name of the user applying for the job',
  `Address` varchar(80) NOT NULL COMMENT 'The address of the user applying for the job',
  `Email_Address` varchar(40) NOT NULL COMMENT 'The email address of the user applying for the job',
  `Phone_Number` int(12) NOT NULL COMMENT 'The phone number of the user applying for the job',
  `Technical_Skills` varchar(100) NOT NULL COMMENT 'The technical skills of the user applying for the job (all should be selected)',
  `Preferred_Skills` varchar(100) NOT NULL COMMENT 'the preferred skills for the user',
  `Other_Skills` varchar(100) NOT NULL COMMENT 'and other skills they thought they should mention',
  `Status` enum('New','Current','Final') NOT NULL DEFAULT 'New' COMMENT 'The status of the current report\r\n[New -> current -> complete]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eoi`
--

INSERT INTO `eoi` (`EOInumber`, `Job_Ref_Num`, `Firstname`, `Lastname`, `Address`, `Email_Address`, `Phone_Number`, `Technical_Skills`, `Preferred_Skills`, `Other_Skills`, `Status`) VALUES
(1, 300, 'John', 'Smith', '31 smith Creek Victoria', 'johnsmith@gmail.com', 123456789, 'Trouble Shooting,Networking,Security,Database Management', 'Communication,Teamwork,Time Managment,Autonomous,Fast Learner', 'I am great at making coffee', 'New'),
(2, 350, 'Jane', 'Doe', '1 franklin rd Vic', 'JaneDoe@gmail.com', 987654321, 'Networking,Hardware,Software,Security', 'Communication,Time Managment,Autonomous,Fast Learner', 'I can work for many hours without getting tired', 'Current');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `reference_number` varchar(5) NOT NULL COMMENT 'The jobs reference number',
  `title` varchar(100) NOT NULL COMMENT 'The title of the position',
  `type` enum('Full Time','Part Time') NOT NULL COMMENT 'Is it full time or part time?',
  `work_hours` varchar(50) NOT NULL COMMENT 'How long do they need to work?',
  `salary` varchar(50) NOT NULL COMMENT 'How much do they get paid?',
  `supervisor` varchar(100) NOT NULL COMMENT 'Who is watching over them?',
  `description` text NOT NULL COMMENT 'What they need to do',
  `responsibilities` text NOT NULL COMMENT 'Subtle more detail then in description',
  `essential_qualifications` text NOT NULL COMMENT 'What you need to be qualified in to apply for this job',
  `preferable_qualifications` text NOT NULL COMMENT 'What we want you to be good at for this job',
  `benefits` text NOT NULL COMMENT 'The benefits you get for working in this position'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`reference_number`, `title`, `type`, `work_hours`, `salary`, `supervisor`, `description`, `responsibilities`, `essential_qualifications`, `preferable_qualifications`, `benefits`) VALUES
('IT090', 'Service Desk Analyst', 'Full Time', '9:00 AM - 5:00 PM, Monday - Friday', '$55,000 - $80,000', 'IT Support Manager', 'As an Service Desk Analyst, you will be resolving support tickets by clients.', 'Advising clients on steps to take when encountering software or computer issues. \r\n|Provide support to questions asked on HEMB-IT\'s website. \r\n|Assist clients with cybersecurity and following legal regulations. \r\n|Determining suitable software and hardware solutions for clients.', 'Completed a suitable tertiary course in Information Technology. \r\n|6 months of work experience in an IT support position. \r\n|6 months of work experience in a customer support position. \r\n|An in-depth understanding of HTML5. \r\n|Knowledge in Troubleshooting. \r\n|Understanding of Network Infrastructure. |Knowledge of Computer Hardware. \r\n|Proficiency in Operating Systems. \r\n|Knowledge of Security Practices. \r\n|Familiarity with Database Concepts.', 'Work well unsupervised. \r\n|Passion in Information Technology. \r\n|A strong understanding of software and hardware.', '20 days of Paid-Time-Off per year'),
('IT240', 'IT Support Specialist', 'Full Time', '9:00 AM - 5:00 PM, Monday - Friday', '$60,000 - $80,000', 'IT Support Manager', 'As an IT Support Specialist, you will give one-on-one software assistance to clients. You will also manage elements of HEMB-IT\'s cybersecurity.', 'Provide support to questions asked on HEMB-IT\'s website. \r\n|Assist clients with cybersecurity and following legal regulations. \r\n|Determining suitable software and hardware solutions for clients. \r\n|Advising clients on steps to take when encountering software or computer issues. |Identifying and responding to software and computer issues.', 'Completed a suitable tertiary course in Information Technology. \r\n|1 year of work experience in an IT support position. \r\n|2 months of work experience in a customer support position. \r\n|Proficiency in HTML5. \r\n|Proficiency in Python and Ruby. \r\n|Knowledge in Troubleshooting. \r\n|Understanding of Network Infrastructure. |Knowledge of Computer Hardware. \r\n|Proficiency in Operating Systems. \r\n|Knowledge of Security Practices. \r\n|Familiarity with Database Concepts.', 'Work well unsupervised. \r\n|Passion in Information Technology. \r\n|A strong understanding of software and hardware.', '20 days of Paid-Time-Off per year'),
('IT300', 'IT Support Technician', 'Full Time', '9:00 AM - 5:00 PM, Monday - Friday', '$60,000 - $80,000', 'IT Support Manager', 'As an IT Support Technician, you will provide IT support to a broad range of companies.', 'Determining suitable software and hardware solutions for clients. \r\n|Installing software to common operating systems. |Designing web sites using HTML5. \r\n|Advising clients on steps to take when encountering software or computer issues. \r\n|Identifying and responding to software and computer issues.', 'Completed a suitable tertiary course in Information Technology. \r\n|1 year of work experience in an IT support position. \r\n|Proficiency in HTML5.\r\n|Proficiency in Python and Ruby. \r\n|Knowledge in Troubleshooting. \r\n|Understanding of Network Infrastructure. |Knowledge of Computer Hardware. \r\n|Proficiency in Operating Systems. \r\n|Knowledge of Security Practices. \r\n|Familiarity with Database Concepts. ', 'Prior work experience in customer support. \r\n|Work well unsupervised. \r\n|Passion in Information Technology.', '20 days of Paid-Time-Off per year'),
('IT350', 'Desktop Support Tech', 'Full Time', '9:00 AM - 5:00 PM, Monday - Friday', '$70,000 - $90,000', 'Desktop Support Manager', 'As an Desktop Support Technician, your job is to maintain HEMB-IT\'s software and hardware needs in the office.', 'Ensure office computers work as intended. \r\n|Routinely test software and hardware. \r\n|Provide support to co-workers. \r\n|Installing software to office computers. \r\n|Provide training for new IT support employees. |Identifying and responding to software and computer issues. \r\n|Deploy hardware in the office.', 'Completed a tertiary course in Networks and Switching. \r\n|2 years of work experience in an IT support position. \r\n|Proficiency in Python and Ruby. \r\n|In-depth knowledge and experience in IP networks, DNS, and DHCP. \r\n|Experience in troubleshooting networks and switches. \r\n|Knowledge in Troubleshooting. \r\n|Understanding of Network Infrastructure. |Knowledge of Computer Hardware. \r\n|Proficiency in Operating Systems. \r\n|Knowledge of Security Practices. \r\n|Familiarity with Database Concepts.', 'Work well unsupervised. \r\n|Passion in Information Technology. \r\n|A strong understanding of software and hardware.', '25 days of Paid-Time-Off per year');

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
(2, 'Member', '$2y$10$cHKivyXMQOf4FLskxMaB7eXncXMXjKrKFzhfHy/GWfk3g.kIhvJq2', 'Member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOInumber`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`reference_number`);

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
  MODIFY `EOInumber` int(11) NOT NULL AUTO_INCREMENT COMMENT 'The Expression of interest unique identifier', AUTO_INCREMENT=9119;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The id for the user (1,2,3....)', AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
