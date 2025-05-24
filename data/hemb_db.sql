-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 09:32 AM
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
-- Table structure for table `about_us_content`
--

CREATE TABLE `about_us_content` (
  `section` varchar(50) NOT NULL,
  `heading` text NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_us_content`
--

INSERT INTO `about_us_content` (`section`, `heading`, `content`) VALUES
('about', 'About Us!', ''),
('contributions', 'Member Contributions', 'Each member of our team has played a crucial role in the development of this project, bringing their unique skills, perspectives, and dedication to the table. From initial brainstorming sessions to final implementation, every contribution—whether in design, coding, research, or project management—has been integral to our progress. The success of this project is a direct result of our collaborative efforts, mutual support, and shared commitment to excellence.'),
('what_we_do', 'What We Do!', 'At HEMB IT Solutions, we specialize in delivering top-tier IT support tailored to meet the unique needs of businesses across various industries. Our team of experienced professionals is dedicated to providing reliable, efficient, and proactive technology solutions that help our clients operate smoothly and stay ahead of the curve. From network management and cybersecurity to cloud services and technical consulting, we offer comprehensive support designed to enhance productivity, minimize downtime, and drive business growth. Partner with us for IT services that are not only responsive but also strategic—empowering your organization to focus on what it does best.\r\n\r\n');

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
-- Table structure for table `member_roles`
--

CREATE TABLE `member_roles` (
  `name` varchar(100) NOT NULL,
  `contribution` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member_roles`
--

INSERT INTO `member_roles` (`name`, `contribution`) VALUES
('1. Evan Harrison', 'Evan Harrison has developed the index and login pages, ensuring a functional and user-friendly entry point to the site. He implemented accessibility modes to enhance usability for all users and integrated information cards for improved content presentation. In addition, he created the necessary .inc files to support modular and maintainable code. Evan also developed Manager.php to handle management-specific features and contributed to overall improvements across the website, enhancing both performance and design consistency.'),
('2. Henry Bennett', 'Henry Bennett designed and developed the Apply page, creating the CSS to ensure a polished and intuitive user interface that aligns with the overall site design. He also built the Expression of Interest (EOI) database, carefully structuring it to efficiently store and organize applicant data. To maintain data accuracy and improve user experience, he implemented comprehensive data validation processes that ensured all submissions met the required standards before being accepted.'),
('3. Ben Romano', 'Ben Romano developed the About page, designing its layout and content to effectively communicate key information. He also created the corresponding database to manage and store relevant data for the page. Additionally, Ben worked on the CSS styling to ensure the About page was visually appealing and consistent with the overall site design.'),
('4. Michael Sharpley', 'Michael Sharpley developed the jobs.html page, applied appropriate styling to ensure a consistent user interface, and created the jobs table with relevant data entries. He also implemented database integration within jobs.php, established a placeholder settings.php file for future configurations, and performed a thorough cleanup by removing unused comments across the entire project to improve readability and maintainability');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `student_id` int(9) NOT NULL,
  `tutor_name` varchar(50) NOT NULL,
  `class_times` varchar(100) NOT NULL,
  `website_goal` varchar(100) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_alt` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `student_id`, `tutor_name`, `class_times`, `website_goal`, `image_path`, `image_alt`, `description`) VALUES
(0, 'Evan Harrison', 105929605, 'Nick', 'Thursday 14:30 - 16:30', 'Home Page', '../images/Evan_Harrison.webp', 'Front-facing picture of Evan Harrison', 'Evan Harrison is our go-to tech troubleshooter, known for his sharp problem-solving skills and technical expertise. Whether it\'s fixing system crashes, resolving software bugs, or optimizing performance, Evan handles it all with speed and precision. He focuses not just on quick fixes but also long-term solutions—streamlining workflows, securing systems, and integrating new tools. Methodical, resourceful, and always up-to-date with the latest tech trends, Evan is a vital force in keeping our operations running smoothly'),
(1, 'Henry Bennett', 105923571, 'Nick', 'Thursday 14:30 - 16:30', 'Application Page', '../images/Henry_Bennett.webp', 'Front-facing image of Henry Bennett taking a photo with a phone', 'Henry Bennett is our cybersecurity expert, focused on keeping digital systems secure and resilient. From blocking malware to securing networks and access points, he handles threats quickly and effectively. Beyond incident response, Henry implements long-term protections like audits, encryption, and continuous monitoring to ensure data safety and smooth operations.'),
(2, 'Ben Romano', 105773284, 'Nick', 'Thursday 14:30 - 16:30', 'About Us Page', '../images/Ben_Romano.webp', 'A front-facing picture of Ben Romano', 'Ben Romano is our hardware specialist, ensuring all devices, workstations, and network equipment run smoothly and efficiently. From diagnosing issues to setting up new systems, he handles hardware with precision and care. Ben goes beyond quick fixes, building reliable, scalable setups with quality components and structured cabling. His attention to detail ensures every system is optimized for performance and durability.'),
(3, 'Michael Sharpley', 105913792, 'Nick', 'Thursday 14:30 - 16:30', 'Jobs Page', '../images/Michael_Sharpley.webp', 'A picture of Michael Sharpley outside', 'Michael Sharpley is our database specialist, focused on building and maintaining efficient, scalable, and secure data systems. From designing robust schemas to optimizing queries and implementing backups, he ensures your data is structured for performance and reliability. Whether starting from scratch or improving existing setups, Michael brings a strategic, detail-driven approach that keeps systems fast, stable, and future-ready.');

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
-- Indexes for table `about_us_content`
--
ALTER TABLE `about_us_content`
  ADD PRIMARY KEY (`section`);

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOInumber`);

--
-- Indexes for table `member_roles`
--
ALTER TABLE `member_roles`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

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
