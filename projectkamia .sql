-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2017 at 08:15 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectkamia`
--
CREATE DATABASE IF NOT EXISTS `projectkamia` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `projectkamia`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `fullnames` varchar(45) NOT NULL,
  `email` varchar(56) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `fullnames`, `email`, `username`, `password`) VALUES
(1, 'Admin', 'admin@admin.com', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `dates` date NOT NULL,
  `value` int(11) NOT NULL,
  `confirmed` int(11) DEFAULT '0',
  `class` int(11) NOT NULL,
  `year_attended` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student`, `dates`, `value`, `confirmed`, `class`, `year_attended`) VALUES
(1, 1, '2017-05-24', 1, 1, 1, 2017),
(2, 1, '2017-05-24', 1, 1, 2, 2017),
(3, 2, '2017-05-24', 1, 1, 1, 2017),
(4, 2, '2017-05-24', 1, 1, 2, 2017),
(5, 5, '2017-05-24', 1, 1, 1, 2017),
(6, 5, '2017-05-24', 1, 1, 2, 2017);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `thatdate` date NOT NULL,
  `schedule` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `thatdate`, `schedule`) VALUES
(1, '2017-05-24', 1),
(2, '2017-05-24', 2);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `school` int(11) NOT NULL,
  `department` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `school`, `department`, `description`) VALUES
(1, 'Bachelor of Science in Droid Making', 1, 1, 'This is all about robbots'),
(2, 'Bachelor of Science in Sociology', 1, 1, 'Love associations this is for you');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `school` int(11) NOT NULL,
  `name` varchar(123) NOT NULL,
  `hod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `school`, `name`, `hod`) VALUES
(1, 1, 'Informations and informatics', 3),
(2, 1, 'Science and Criminology', 4);

-- --------------------------------------------------------

--
-- Table structure for table `donesvote`
--

CREATE TABLE `donesvote` (
  `id` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  `evaluation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donesvote`
--

INSERT INTO `donesvote` (`id`, `student`, `unit`, `evaluation`) VALUES
(1, 2, 2, 8),
(2, 2, 3, 8),
(3, 1, 1, 8),
(4, 1, 1, 8),
(5, 1, 1, 10),
(6, 1, 1, 11),
(7, 2, 1, 12),
(8, 1, 1, 12),
(9, 1, 3, 12),
(10, 1, 2, 12),
(11, 1, 4, 12),
(12, 1, 1, 13),
(13, 1, 3, 13),
(14, 1, 2, 13),
(15, 1, 4, 13),
(16, 5, 2, 14),
(17, 5, 1, 14),
(18, 5, 3, 14),
(19, 5, 4, 14),
(20, 5, 5, 14),
(21, 1, 1, 14),
(22, 1, 2, 14),
(23, 2, 2, 14),
(24, 2, 3, 14),
(25, 2, 1, 14),
(26, 2, 4, 14),
(27, 2, 5, 14);

-- --------------------------------------------------------

--
-- Table structure for table `hod`
--

CREATE TABLE `hod` (
  `id` int(11) NOT NULL,
  `department` int(11) NOT NULL,
  `fullnames` varchar(50) NOT NULL,
  `email` varchar(68) NOT NULL,
  `password` varchar(68) NOT NULL,
  `username` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hod`
--

INSERT INTO `hod` (`id`, `department`, `fullnames`, `email`, `password`, `username`) VALUES
(1, 0, 'Silas Kenneth', 'silaskenn@gmail.com', 'f09aca9a83a10a581d20fa69a56daf73859ebcc6', 'silaskenn'),
(2, 0, 'Derrick Kales', 'kendrick@gmail.com', 'Nyamwaro2012', 'kendrick'),
(3, 1, 'Silas Kenneth', 'silaskenneth1@gmail.com', 'f09aca9a83a10a581d20fa69a56daf73859ebcc6', 'silaskenneth1'),
(4, 2, 'Kiriki Kindiki', 'kiriki@gmail.com', 'Kindiki', 'kiriki');

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

CREATE TABLE `lecturers` (
  `id` int(11) NOT NULL,
  `idnumber` int(11) NOT NULL,
  `fullnames` varchar(120) NOT NULL,
  `email` varchar(56) NOT NULL,
  `password` varchar(68) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`id`, `idnumber`, `fullnames`, `email`, `password`, `status`) VALUES
(1, 33902999, 'Janet Nombi', 'janetnombi@gmail.com', '5a6ac3924f4c55a9907c523afdaa7e6486c84a8a', 1),
(2, 32281737, 'Silas Kenneth', 'silaskenn@gmail.com', 'd06e7b97af4b61955baaf052b09c03fe5ba0c662', 1),
(3, 32671727, 'Suleiman Khassim', 'suleimankassim@gmail.com', '5463d900f9919943aa87a3fec235509702984062', 1),
(4, 34525564, 'Evans Otieno', 'evansotieno@gmail.com', '6f6f1f3ad2ca6ffe0fec132b2f08cd56be0f5c86', 1),
(5, 40000013, 'Milicent Nombi', 'milicentnombi@gmail.com', '1bf286da0c743cef74cd000d4720213cdf16eeb4', 1),
(6, 32222222, 'Derrick Banners', 'derekbanners@gmail.com', 'bd4c6fe1b3b0021c3ad54583264a5196f399524a', 1),
(7, 35415672, 'Kendrick Lamar', 'kendrick@gmail.com', 'd0dc6b51fd2376a91eb4b5607326a6126106611d', 1),
(8, 32281729, 'Jackline Kijana', 'jackline@gmail.com', '2ac2c415b7f3744d8fb30dfcdcfb9fe3003dd838', 1),
(10, 32222229, 'Kadeka Ruku', 'kadeka@gmail.com', '374b4f6c95b52b30a78793bee7bfbce42582a3d7', 1),
(11, 20000000, 'Derrick Banners', 'jamesabe@gmail.com', '481cf200a59ba9f7f2f723dff9a78a6ff9a9dca5', 1);

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` int(11) NOT NULL,
  `name` varchar(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `name`) VALUES
(1, 'Diploma'),
(2, 'Bachelors Degree'),
(3, 'Master'),
(4, 'Phd');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `qtype` int(11) NOT NULL,
  `survey` int(11) NOT NULL,
  `bodytext` varchar(100) DEFAULT NULL,
  `topic` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `qtype`, `survey`, `bodytext`, `topic`) VALUES
(1, 1, 6, 'Please tell us what you think about the lecturer', 2),
(2, 1, 6, 'Can you rate the presentation', 2),
(3, 1, 6, 'What do you give to his/her performance on Main exams?', 2),
(4, 2, 6, 'Can you comment on what the lecturer needs to change on?', 1),
(5, 1, 7, 'Can you rate the punctuality of the lecturer?', 1),
(6, 2, 7, 'Can you tell us what the lecturer needs to change on?', 1),
(7, 1, 8, 'How do you rate the lecturers performance?', 1),
(8, 2, 8, 'Comment about grooming', 1),
(9, 1, 8, 'Can you rate the fluency of the lecturer?', 1),
(10, 1, 10, 'What do you give to the performance?', 1),
(11, 1, 11, 'Just rate', 1),
(12, 1, 11, 'How do you rate audibility?', 1),
(13, 1, 12, 'Please rate the audibility of the lecturer?', 1),
(14, 1, 13, 'Rate the performace', 1),
(15, 2, 13, 'Comment on the performnce', 1),
(16, 1, 14, 'How do you rate general performance?', 1),
(17, 2, 14, 'Comment about dressing', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiztype`
--

CREATE TABLE `quiztype` (
  `id` int(11) NOT NULL,
  `description` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiztype`
--

INSERT INTO `quiztype` (`id`, `description`) VALUES
(1, 'Open ended'),
(2, 'Rating Question');

-- --------------------------------------------------------

--
-- Table structure for table `recommendations`
--

CREATE TABLE `recommendations` (
  `id` int(11) NOT NULL,
  `lecturer` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  `evaluation` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recommendations`
--

INSERT INTO `recommendations` (`id`, `lecturer`, `unit`, `evaluation`, `content`) VALUES
(1, 7, 3, 12, 'I like how you do your stuff continue with the same spirit'),
(2, 7, 1, 12, 'guru'),
(3, 7, 1, 12, 'guru'),
(4, 7, 1, 12, 'guru'),
(5, 7, 3, 12, 'Good work'),
(6, 7, 2, 13, 'That''s fucking awsome');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `days` int(11) NOT NULL,
  `begintime` time NOT NULL DEFAULT '00:00:00',
  `endtime` time NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `unit`, `course`, `days`, `begintime`, `endtime`, `year`) VALUES
(1, 1, 1, 3, '09:00:00', '10:00:00', 2017),
(2, 2, 1, 3, '11:00:00', '13:00:00', 2017),
(3, 1, 1, 1, '12:00:00', '16:00:00', 2017),
(4, 1, 1, 1, '12:09:00', '12:40:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `title` varchar(67) NOT NULL,
  `about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `title`, `about`) VALUES
(1, 'Information Communication and Journalist(INFOCOMS)', 'All about coding');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `regno` varchar(16) NOT NULL,
  `names` varchar(50) NOT NULL,
  `password` varchar(70) NOT NULL,
  `course` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `sem` int(11) NOT NULL,
  `insession` tinyint(1) NOT NULL DEFAULT '1',
  `gender` varchar(11) NOT NULL,
  `courselevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `regno`, `names`, `password`, `course`, `year`, `sem`, `insession`, `gender`, `courselevel`) VALUES
(1, 'INF/029/2014', 'Silas Kenneth', 'bd4c6fe1b3b0021c3ad54583264a5196f399524a', 1, 1, 1, 1, 'Male', 0),
(2, 'ISC/020/2014', 'Samwel Okola', 'f09aca9a83a10a581d20fa69a56daf73859ebcc6', 1, 1, 1, 1, 'Male', 1),
(5, 'INF/030/2014', 'Karim Benzema', '36b8266bc0126922ad13f4d3009e7e4409148bcd', 1, 1, 1, 1, 'Male', 1);

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE `surveys` (
  `id` int(11) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`id`, `startdate`, `enddate`, `status`) VALUES
(1, '2017-05-14', '2016-08-09', 0),
(2, '2017-05-14', '2017-06-09', 0),
(3, '2017-05-14', '2017-06-09', 0),
(4, '2017-05-14', '2016-08-09', 0),
(5, '2017-05-16', '2017-05-01', 0),
(6, '2017-05-18', '2018-04-06', 0),
(7, '2017-05-18', '2017-09-09', 0),
(8, '2017-05-18', '2017-06-09', 0),
(9, '2017-05-19', '2017-05-12', 0),
(10, '2017-05-19', '2017-06-23', 0),
(11, '2017-05-19', '2017-07-09', 0),
(12, '2017-05-19', '2017-06-07', 0),
(13, '2017-05-22', '2017-08-08', 0),
(14, '2017-05-24', '2017-09-08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `title` varchar(120) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `code` varchar(23) NOT NULL DEFAULT 'INF230',
  `year` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `description` text,
  `lecturer` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `course`, `code`, `year`, `semester`, `title`, `description`, `lecturer`, `status`) VALUES
(1, 1, 'INF230', 1, 1, 'Introduction to computing', NULL, 7, 1),
(2, 1, 'ISC100', 1, 1, 'Soil science', NULL, 7, 1),
(3, 1, 'INF200', 1, 1, 'Discrete Mathematics for Informaticists', 'All about graphs', 2, 1),
(4, 1, 'INF230', 1, 1, 'Introduction to Criminology', 'This is all about crme', 1, 0),
(5, 1, 'INF230', 1, 1, 'Reliability', 'All about', 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `unitselection`
--

CREATE TABLE `unitselection` (
  `id` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `lec` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `rating` decimal(4,2) NOT NULL,
  `lec` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  `evaluation` int(11) NOT NULL,
  `comment` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `student`, `rating`, `lec`, `unit`, `evaluation`, `comment`) VALUES
(1, 1, '5.00', 8, 1, 8, 'Silas was good'),
(2, 2, '5.00', 7, 3, 12, 'He dresses so good'),
(3, 2, '1.00', 8, 3, 8, 'He dresses so good'),
(4, 1, '4.50', 8, 1, 8, 'He deserves good classes'),
(5, 1, '4.50', 7, 1, 8, 'He deserves good classes'),
(6, 1, '5.00', 8, 1, 10, ''),
(7, 1, '4.50', 8, 1, 11, ''),
(8, 2, '5.00', 8, 1, 12, ''),
(9, 1, '2.00', 7, 1, 12, ''),
(10, 1, '4.00', 3, 3, 12, ''),
(11, 1, '2.00', 7, 2, 12, ''),
(12, 1, '2.00', 0, 4, 12, ''),
(13, 1, '4.00', 7, 1, 13, 'Just good'),
(14, 1, '4.00', 3, 3, 13, 'Looking fine'),
(15, 1, '4.00', 7, 2, 13, 'alllsls'),
(16, 1, '5.00', 1, 4, 13, 'Whatever'),
(17, 5, '4.00', 7, 2, 14, 'Good'),
(18, 5, '5.00', 7, 1, 14, 'Amazing'),
(19, 5, '1.00', 2, 3, 14, 'Amazing but pull up'),
(20, 5, '4.00', 1, 4, 14, 'No comment'),
(21, 5, '4.00', 0, 5, 14, 'No comment'),
(22, 1, '3.00', 7, 1, 14, 'sokokos'),
(23, 1, '5.00', 7, 2, 14, 'sokokos'),
(24, 2, '4.00', 7, 2, 14, 'Just good'),
(25, 2, '2.00', 2, 3, 14, 'Just good'),
(26, 2, '4.00', 7, 1, 14, 'Karick'),
(27, 2, '4.00', 1, 4, 14, 'Karick'),
(28, 2, '4.00', 7, 5, 14, 'Llal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donesvote`
--
ALTER TABLE `donesvote`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hod`
--
ALTER TABLE `hod`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `idnumber` (`idnumber`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiztype`
--
ALTER TABLE `quiztype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`,`course`);

--
-- Indexes for table `unitselection`
--
ALTER TABLE `unitselection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `donesvote`
--
ALTER TABLE `donesvote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `hod`
--
ALTER TABLE `hod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `lecturers`
--
ALTER TABLE `lecturers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `quiztype`
--
ALTER TABLE `quiztype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `recommendations`
--
ALTER TABLE `recommendations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `unitselection`
--
ALTER TABLE `unitselection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
