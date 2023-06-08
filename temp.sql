-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2023 at 08:40 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `temp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', 'admin@123');

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `title` varchar(30) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `answer_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `email`, `title`, `question_id`, `answer_text`, `created_at`) VALUES
(11, 'tejeswarareddy@gmail.com', 'survey', 54, 'grgtsdfv', '2023-05-31 09:28:59'),
(13, 'tejeswarareddy@gmail.com', 'Sample survey', 58, 'male', '2023-05-31 09:50:50'),
(14, 'tejeswarareddy@gmail.com', 'College information', 55, 'Durga', '2023-05-31 10:31:42'),
(15, 'tejeswarareddy@gmail.com', 'College information', 56, '4th year', '2023-05-31 10:31:42'),
(16, 'tejeswarareddy@gmail.com', 'College information', 57, 'Wipro,Jman', '2023-05-31 10:31:42'),
(17, 'teja0565@gmail.com', 'College information', 55, 'Vishali', '2023-05-31 12:39:54'),
(18, 'teja0565@gmail.com', 'College information', 56, '4th year', '2023-05-31 12:39:54'),
(19, 'teja0565@gmail.com', 'College information', 57, 'Wipro', '2023-05-31 12:39:54'),
(20, 'teja0565@gmail.com', 'Sports information', 62, 'Tejeswara reddy', '2023-06-01 08:18:03'),
(21, 'teja0565@gmail.com', 'Sports information', 63, 'male', '2023-06-01 08:18:03'),
(22, 'teja0565@gmail.com', 'temp', 73, 'fine', '2023-06-01 11:56:24'),
(23, 'newuser2@gmail.com', 'Sample survey', 58, 'male', '2023-06-01 11:59:10');

-- --------------------------------------------------------

--
-- Table structure for table `draftoptions`
--

CREATE TABLE `draftoptions` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `option_text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `draftoptions`
--

INSERT INTO `draftoptions` (`id`, `question_id`, `title`, `option_text`) VALUES
(9, 8, 'Admission details', 'above 70%'),
(10, 8, 'Admission details', 'above 80%'),
(11, 8, 'Admission details', 'above 90%');

-- --------------------------------------------------------

--
-- Table structure for table `draftquestions`
--

CREATE TABLE `draftquestions` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `question_type` varchar(50) DEFAULT NULL,
  `question` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `draftquestions`
--

INSERT INTO `draftquestions` (`id`, `title`, `question_type`, `question`) VALUES
(7, 'Admission details', 'textarea', 'Enter your name'),
(8, 'Admission details', 'radio', '10th percentage'),
(10, 'temp1', 'textarea', 'fasdf');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `email` varchar(30) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`email`, `password`) VALUES
('tejeswarareddy@gmail.com', '789456123'),
('teja0565@gmail.com', 'teja'),
('newuser@gmail.com', 'newuser'),
('newuser2@gmail.com', 'newuser1');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `title` varchar(30) NOT NULL,
  `option_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `question_id`, `title`, `option_text`) VALUES
(55, 54, 'survey', 'grgtsdfv'),
(56, 54, 'survey', 'rtydgfn'),
(57, 56, 'College information', '1st year'),
(58, 56, 'College information', '2nd year'),
(59, 56, 'College information', '3rd year'),
(60, 56, 'College information', '4th year'),
(61, 57, 'College information', 'TCS'),
(62, 57, 'College information', 'Wipro'),
(63, 57, 'College information', 'Jman'),
(64, 58, 'Sample survey', 'male'),
(65, 58, 'Sample survey', 'female'),
(66, 60, 'Personal information', 'male'),
(67, 60, 'Personal information', 'female'),
(68, 61, 'Personal information', 'TV'),
(69, 61, 'Personal information', 'AC'),
(70, 61, 'Personal information', 'Fridge'),
(71, 63, 'Sports information', 'male'),
(72, 63, 'Sports information', 'female'),
(73, 65, 'Personal information', 'GEC'),
(74, 65, 'Personal information', 'SRKR'),
(75, 65, 'Personal information', 'BVC'),
(76, 66, 'Personal information', 'JMAN'),
(77, 66, 'Personal information', 'TCS'),
(78, 66, 'Personal information', 'wipro'),
(79, 66, 'Personal information', 'infosys'),
(82, 68, 'fdsfasdf', 'ffine'),
(83, 68, 'fdsfasdf', 'note fine'),
(84, 69, 'Sports participation', 'Cricket'),
(85, 69, 'Sports participation', 'Kabaddi'),
(86, 69, 'Sports participation', 'vollyboll'),
(87, 69, 'Sports participation', 'Football'),
(88, 70, 'tej', 'CSE'),
(89, 70, 'tej', 'CIVIL'),
(90, 70, 'tej', 'IT'),
(93, 72, 'Public opinion', 'Dhoni'),
(94, 72, 'Public opinion', 'kohli'),
(95, 73, 'temp', 'fine'),
(96, 73, 'temp', 'note fine');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `question_type` varchar(50) DEFAULT NULL,
  `question` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `title`, `question_type`, `question`) VALUES
(6, 'Public opinion', 'textarea', 'Who is your favourite hero'),
(9, 'temp', 'radio', 'temp'),
(54, 'survey', 'radio', 'asdfasf'),
(55, 'College information', 'textarea', 'Enter your name'),
(56, 'College information', 'radio', 'Which year'),
(57, 'College information', 'checkbox', 'Companies selected'),
(58, 'Sample survey', 'radio', 'Gender'),
(59, 'Personal information', 'textarea', 'Enter your name'),
(60, 'Personal information', 'radio', 'Gender'),
(61, 'Personal information', 'checkbox', 'Select in which you own'),
(62, 'Sports information', 'textarea', 'Enter your name '),
(63, 'Sports information', 'radio', 'Gender'),
(64, 'Personal information', 'textarea', 'Enter your nane'),
(65, 'Personal information', 'radio', 'Which college you studied?'),
(66, 'Personal information', 'checkbox', 'Select the companies you got selected'),
(67, 'ssurvey', 'radio', 'dghnsdfter'),
(68, 'fdsfasdf', 'radio', 'How are you'),
(69, 'Sports participation', 'checkbox', 'Select any two to participate'),
(70, 'tej', 'radio', 'Which Branch ?'),
(72, 'Public opinion', 'radio', 'Select your favaourate cricketer'),
(73, 'temp', 'radio', 'How are you');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `draftoptions`
--
ALTER TABLE `draftoptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `draftquestions`
--
ALTER TABLE `draftquestions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `draftoptions`
--
ALTER TABLE `draftoptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `draftquestions`
--
ALTER TABLE `draftquestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
