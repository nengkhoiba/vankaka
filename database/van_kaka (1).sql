-- phpMyAdmin SQL Dump
-- version 4.4.15.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2018 at 12:11 PM
-- Server version: 5.6.25
-- PHP Version: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `van_kaka`
--

-- --------------------------------------------------------

--
-- Table structure for table `vk_fee`
--

CREATE TABLE IF NOT EXISTS `vk_fee` (
  `bill_id` int(125) NOT NULL,
  `bill_no` int(20) NOT NULL,
  `amount` int(10) NOT NULL,
  `dop` date NOT NULL,
  `top` time NOT NULL,
  `fine` int(10) NOT NULL,
  `driver_id` int(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vk_login`
--

CREATE TABLE IF NOT EXISTS `vk_login` (
  `user_id` int(125) NOT NULL,
  `reg_id` varchar(800) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `password` varchar(20) NOT NULL,
  `otp` int(10) NOT NULL,
  `Role` int(5) NOT NULL,
  `isActive` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vk_login`
--

INSERT INTO `vk_login` (`user_id`, `reg_id`, `mobile`, `password`, `otp`, `Role`, `isActive`) VALUES
(1, '', '9774180184', 'welcome', 12345, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vk_payment`
--

CREATE TABLE IF NOT EXISTS `vk_payment` (
  `reg_id` int(125) NOT NULL,
  `amount` double NOT NULL,
  `status` varchar(10) NOT NULL,
  `tranc_id` varchar(50) NOT NULL,
  `ref_id` varchar(100) NOT NULL,
  `added_by` int(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vk_role`
--

CREATE TABLE IF NOT EXISTS `vk_role` (
  `role_id` int(125) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `isActive` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vk_role`
--

INSERT INTO `vk_role` (`role_id`, `code`, `description`, `isActive`) VALUES
(1, 'SA', 'SUPERADMIN', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vk_school`
--

CREATE TABLE IF NOT EXISTS `vk_school` (
  `id` int(125) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `batch` varchar(50) NOT NULL,
  `starttime` varchar(10) NOT NULL,
  `endtime` varchar(10) NOT NULL,
  `added_by` int(125) NOT NULL,
  `isActive` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vk_sessions`
--

CREATE TABLE IF NOT EXISTS `vk_sessions` (
  `id` int(10) NOT NULL,
  `year` year(4) NOT NULL,
  `added_by` int(125) NOT NULL,
  `isActive` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vk_student`
--

CREATE TABLE IF NOT EXISTS `vk_student` (
  `id` int(125) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `f_name` varchar(100) NOT NULL,
  `m_name` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `profile_url` varchar(100) NOT NULL,
  `added_by` int(125) NOT NULL,
  `isActive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vk_student_driver_data`
--

CREATE TABLE IF NOT EXISTS `vk_student_driver_data` (
  `session_id` int(10) NOT NULL,
  `school_id` int(10) NOT NULL,
  `driver_id` int(10) NOT NULL,
  `student_id` int(125) NOT NULL,
  `added_by` int(125) NOT NULL,
  `isActive` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vk_student_fee_relation`
--

CREATE TABLE IF NOT EXISTS `vk_student_fee_relation` (
  `fee_id` int(125) NOT NULL,
  `session_id` int(125) NOT NULL,
  `student_id` int(125) NOT NULL,
  `school_id` int(125) NOT NULL,
  `jan` int(11) NOT NULL DEFAULT '0',
  `feb` int(11) NOT NULL DEFAULT '0',
  `mar` int(11) NOT NULL DEFAULT '0',
  `april` int(11) NOT NULL DEFAULT '0',
  `may` int(11) NOT NULL DEFAULT '0',
  `june` int(11) NOT NULL DEFAULT '0',
  `july` int(11) NOT NULL DEFAULT '0',
  `aug` int(11) NOT NULL DEFAULT '0',
  `sept` int(11) NOT NULL DEFAULT '0',
  `oct` int(11) NOT NULL DEFAULT '0',
  `nov` int(11) NOT NULL DEFAULT '0',
  `decem` int(11) NOT NULL DEFAULT '0',
  `added_by` int(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vk_student_school_relation`
--

CREATE TABLE IF NOT EXISTS `vk_student_school_relation` (
  `session_id` int(125) NOT NULL,
  `student_id` int(125) NOT NULL,
  `school_id` int(125) NOT NULL,
  `start_month` varchar(10) NOT NULL,
  `end_month` varchar(10) NOT NULL,
  `class` varchar(10) NOT NULL,
  `roll` varchar(10) NOT NULL,
  `section` varchar(5) NOT NULL,
  `fee_amount` varchar(10) NOT NULL,
  `added_by` int(125) NOT NULL,
  `isActive` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vk_subscription_rate`
--

CREATE TABLE IF NOT EXISTS `vk_subscription_rate` (
  `rate_id` int(125) NOT NULL,
  `description` varchar(125) NOT NULL,
  `rate` decimal(30,0) NOT NULL,
  `isActive` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vk_subscription_rate`
--

INSERT INTO `vk_subscription_rate` (`rate_id`, `description`, `rate`, `isActive`) VALUES
(1, 'per month upto 3 driver', 200, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vk_union_data`
--

CREATE TABLE IF NOT EXISTS `vk_union_data` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vk_user_data`
--

CREATE TABLE IF NOT EXISTS `vk_user_data` (
  `user_id` int(125) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `age` int(3) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `profile_url` varchar(100) NOT NULL,
  `added_by` int(25) NOT NULL,
  `isActive` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vk_vehicle_data`
--

CREATE TABLE IF NOT EXISTS `vk_vehicle_data` (
  `vehicle_id` int(125) NOT NULL,
  `user_id` int(125) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `vehicle_photo` varchar(100) NOT NULL,
  `isActive` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vk_vehicle_driver_data`
--

CREATE TABLE IF NOT EXISTS `vk_vehicle_driver_data` (
  `vehicle_id` int(10) NOT NULL,
  `driver_id` int(125) NOT NULL,
  `added_by` int(125) NOT NULL,
  `isActive` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vk_fee`
--
ALTER TABLE `vk_fee`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `vk_login`
--
ALTER TABLE `vk_login`
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD UNIQUE KEY `login_id` (`user_id`);

--
-- Indexes for table `vk_payment`
--
ALTER TABLE `vk_payment`
  ADD PRIMARY KEY (`reg_id`);

--
-- Indexes for table `vk_role`
--
ALTER TABLE `vk_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `vk_school`
--
ALTER TABLE `vk_school`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vk_sessions`
--
ALTER TABLE `vk_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vk_student`
--
ALTER TABLE `vk_student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vk_student_fee_relation`
--
ALTER TABLE `vk_student_fee_relation`
  ADD PRIMARY KEY (`fee_id`);

--
-- Indexes for table `vk_subscription_rate`
--
ALTER TABLE `vk_subscription_rate`
  ADD PRIMARY KEY (`rate_id`);

--
-- Indexes for table `vk_union_data`
--
ALTER TABLE `vk_union_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vk_user_data`
--
ALTER TABLE `vk_user_data`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vk_vehicle_data`
--
ALTER TABLE `vk_vehicle_data`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vk_fee`
--
ALTER TABLE `vk_fee`
  MODIFY `bill_id` int(125) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vk_role`
--
ALTER TABLE `vk_role`
  MODIFY `role_id` int(125) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `vk_school`
--
ALTER TABLE `vk_school`
  MODIFY `id` int(125) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vk_sessions`
--
ALTER TABLE `vk_sessions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vk_student`
--
ALTER TABLE `vk_student`
  MODIFY `id` int(125) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vk_student_fee_relation`
--
ALTER TABLE `vk_student_fee_relation`
  MODIFY `fee_id` int(125) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vk_subscription_rate`
--
ALTER TABLE `vk_subscription_rate`
  MODIFY `rate_id` int(125) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `vk_union_data`
--
ALTER TABLE `vk_union_data`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vk_user_data`
--
ALTER TABLE `vk_user_data`
  MODIFY `user_id` int(125) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vk_vehicle_data`
--
ALTER TABLE `vk_vehicle_data`
  MODIFY `vehicle_id` int(125) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
