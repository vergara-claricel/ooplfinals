-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2024 at 06:27 PM
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
-- Database: `quizzie`
--

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `option1` varchar(255) NOT NULL,
  `option2` varchar(255) NOT NULL,
  `option3` varchar(255) NOT NULL,
  `option4` varchar(255) NOT NULL,
  `correctans` varchar(255) NOT NULL,
  `qpoints` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `quiz_id`, `question`, `option1`, `option2`, `option3`, `option4`, `correctans`, `qpoints`) VALUES
(30, 20, 'ano ang korapsyonz', 'sara duterte', 'bbm', 'marcos fam', 'alice guo', 'sara duterte', 100),
(31, 20, 'alin sa mga sumusunod ang mali', 'magtapon ng basura', 'ipilit ang gusto', 'kumain ng matcha', 'isawsaw sa bagoong ang singkamas', '0', 30),
(32, 21, 'what is use case', 'mimi', 'yuyu', 'haha', 'lol', 'mimi', 5),
(33, 21, 'hahah', 'daasd', 'adsada', 'dsadad', 'dasasd', 'adsada', 10),
(43, 24, 'hahaha', 'yasdukh', 'das', 'das', 'ads', 'ads', 5),
(44, 24, 'again', 'dasd', 'ads', 'ad', 'das', 'dasd', 5),
(48, 30, 'fsd', 'fsdf', 'fsdf', 'fsd', 'fds', 'fsdf', 4);

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(11) NOT NULL,
  `quiz_title` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`quiz_id`, `quiz_title`, `subject`, `user_id`) VALUES
(2, 'gdfg', 'dgfdf', 0),
(20, 'napapanahong isyu', 'komfil', 2),
(21, 'post test', 'mosim', 2),
(24, 'finals', 'dbms', 2),
(25, 'haha', 'hihi', 2),
(30, 'grsfes', 'gsdf', 2),
(32, 'sample', 'shet', 2);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `quiz_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `attempt_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_results`
--

INSERT INTO `quiz_results` (`quiz_id`, `student_id`, `score`, `attempt_at`) VALUES
(12, 1, 1, '2024-12-13 17:11:45'),
(12, 1, 1, '2024-12-13 17:11:45'),
(12, 1, 1, '2024-12-13 17:11:45'),
(12, 1, 1, '2024-12-13 17:11:45'),
(13, 1, 0, '2024-12-13 17:11:45'),
(15, 4, 0, '2024-12-13 17:11:45'),
(12, 4, 0, '2024-12-13 17:11:45'),
(14, 5, 0, '2024-12-13 17:11:45'),
(13, 5, 3, '2024-12-13 17:11:45'),
(14, 6, 4, '2024-12-13 17:11:45'),
(20, 6, 2, '2024-12-13 17:11:45'),
(15, 6, 2, '2024-12-13 17:11:45'),
(21, 6, 15, '2024-12-13 17:11:45'),
(20, 5, 130, '2024-12-13 17:11:45'),
(21, 5, 0, '2024-12-13 17:11:45'),
(20, 1, 100, '2024-12-13 17:11:45'),
(21, 1, 0, '2024-12-13 17:11:45'),
(21, 1, 0, '2024-12-13 17:11:45'),
(22, 1, 0, '2024-12-13 17:11:45'),
(22, 1, 0, '2024-12-13 17:11:45'),
(23, 1, 0, '2024-12-13 17:19:14'),
(23, 1, 0, '2024-12-13 17:19:14'),
(23, 5, 0, '2024-12-13 17:20:22'),
(23, 5, 0, '2024-12-13 17:20:22'),
(24, 5, 0, '2024-12-13 17:23:54'),
(24, 5, 0, '2024-12-13 17:23:54'),
(24, 1, 10, '2024-12-13 17:27:49');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_students`
--

CREATE TABLE `quiz_students` (
  `quiz_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_students`
--

INSERT INTO `quiz_students` (`quiz_id`, `student_id`) VALUES
(7, 1),
(9, 4),
(10, 1),
(10, 4),
(12, 1),
(12, 4),
(13, 1),
(13, 5),
(14, 4),
(14, 5),
(14, 6),
(15, 4),
(15, 6),
(20, 1),
(20, 5),
(20, 6),
(21, 1),
(21, 4),
(21, 5),
(21, 6),
(22, 1),
(22, 4),
(22, 5),
(22, 6),
(23, 1),
(23, 4),
(23, 5),
(24, 1),
(24, 4),
(24, 5),
(24, 6),
(28, 4);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `section` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `name`, `section`, `user_id`) VALUES
(1, 'John Smith', 'BSIT-203', 1),
(2, 'Jennifer Huh', 'BSIT-203', 4),
(3, 'Regina George', 'BSIT-203', 5),
(4, 'Galinda', 'BSIT-303', 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('student','teacher') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `user_type`) VALUES
(1, 'sample123', 'sample123', 'student'),
(2, 'teacher123', 'teacher123', 'teacher'),
(4, 'student2', 'student2', 'student'),
(5, 'student3', 'student3', 'student'),
(6, 'student4', 'student4', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Indexes for table `quiz_students`
--
ALTER TABLE `quiz_students`
  ADD PRIMARY KEY (`quiz_id`,`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
