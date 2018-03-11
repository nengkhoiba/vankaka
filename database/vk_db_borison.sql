-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 11, 2018 at 05:52 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vk_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `vk_fee`
--

DROP TABLE IF EXISTS `vk_fee`;
CREATE TABLE IF NOT EXISTS `vk_fee` (
  `bill_id` int(125) NOT NULL AUTO_INCREMENT,
  `bill_no` int(20) NOT NULL,
  `amount` int(10) NOT NULL,
  `dop` date NOT NULL,
  `top` time NOT NULL,
  `fine` int(10) NOT NULL,
  `driver_id` int(125) NOT NULL,
  PRIMARY KEY (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vk_login`
--

DROP TABLE IF EXISTS `vk_login`;
CREATE TABLE IF NOT EXISTS `vk_login` (
  `user_id` int(125) NOT NULL,
  `reg_id` varchar(800) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `password` varchar(20) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `Role` int(5) NOT NULL,
  `isActive` int(1) NOT NULL,
  UNIQUE KEY `mobile` (`mobile`),
  UNIQUE KEY `login_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vk_payment`
--

DROP TABLE IF EXISTS `vk_payment`;
CREATE TABLE IF NOT EXISTS `vk_payment` (
  `reg_id` int(125) NOT NULL,
  `amount` double NOT NULL,
  `status` varchar(10) NOT NULL,
  `tranc_id` varchar(50) NOT NULL,
  `ref_id` varchar(100) NOT NULL,
  `added_by` int(125) NOT NULL,
  PRIMARY KEY (`reg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vk_role`
--

DROP TABLE IF EXISTS `vk_role`;
CREATE TABLE IF NOT EXISTS `vk_role` (
  `role_id` int(125) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `isActive` int(1) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `vk_role`
--

INSERT INTO `vk_role` (`role_id`, `code`, `description`, `isActive`) VALUES
(1, 'SA', 'SUPERADMIN', 1),
(2, 'DA', 'Driver Admin', 1),
(3, 'D', 'Driver', 1),
(4, 'P', 'Parents', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vk_school`
--

DROP TABLE IF EXISTS `vk_school`;
CREATE TABLE IF NOT EXISTS `vk_school` (
  `id` int(125) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `batch` varchar(50) NOT NULL,
  `starttime` varchar(10) NOT NULL,
  `endtime` varchar(10) NOT NULL,
  `added_by` int(125) NOT NULL,
  `isActive` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vk_sessions`
--

DROP TABLE IF EXISTS `vk_sessions`;
CREATE TABLE IF NOT EXISTS `vk_sessions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `year` year(4) NOT NULL,
  `added_by` int(125) NOT NULL,
  `isActive` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vk_student`
--

DROP TABLE IF EXISTS `vk_student`;
CREATE TABLE IF NOT EXISTS `vk_student` (
  `id` int(125) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `f_name` varchar(100) NOT NULL,
  `m_name` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `profile_url` varchar(100) NOT NULL,
  `added_by` int(125) NOT NULL,
  `isActive` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vk_student_driver_data`
--

DROP TABLE IF EXISTS `vk_student_driver_data`;
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

DROP TABLE IF EXISTS `vk_student_fee_relation`;
CREATE TABLE IF NOT EXISTS `vk_student_fee_relation` (
  `fee_id` int(125) NOT NULL AUTO_INCREMENT,
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
  `added_by` int(125) NOT NULL,
  PRIMARY KEY (`fee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vk_student_school_relation`
--

DROP TABLE IF EXISTS `vk_student_school_relation`;
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

DROP TABLE IF EXISTS `vk_subscription_rate`;
CREATE TABLE IF NOT EXISTS `vk_subscription_rate` (
  `rate_id` int(125) NOT NULL AUTO_INCREMENT,
  `description` varchar(125) NOT NULL,
  `rate` decimal(30,0) NOT NULL,
  `isActive` int(1) NOT NULL,
  PRIMARY KEY (`rate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `vk_subscription_rate`
--

INSERT INTO `vk_subscription_rate` (`rate_id`, `description`, `rate`, `isActive`) VALUES
(1, 'per month upto 3 driver', '200', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vk_union_data`
--

DROP TABLE IF EXISTS `vk_union_data`;
CREATE TABLE IF NOT EXISTS `vk_union_data` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vk_user_data`
--

DROP TABLE IF EXISTS `vk_user_data`;
CREATE TABLE IF NOT EXISTS `vk_user_data` (
  `user_id` int(125) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `age` int(3) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `profile_url` varchar(100) NOT NULL,
  `added_by` int(25) NOT NULL,
  `isActive` int(1) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vk_vehicle_data`
--

DROP TABLE IF EXISTS `vk_vehicle_data`;
CREATE TABLE IF NOT EXISTS `vk_vehicle_data` (
  `vehicle_id` int(125) NOT NULL AUTO_INCREMENT,
  `user_id` int(125) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `vehicle_photo` varchar(100) NOT NULL,
  `isActive` int(1) NOT NULL,
  PRIMARY KEY (`vehicle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vk_vehicle_driver_data`
--

DROP TABLE IF EXISTS `vk_vehicle_driver_data`;
CREATE TABLE IF NOT EXISTS `vk_vehicle_driver_data` (
  `vehicle_id` int(10) NOT NULL,
  `driver_id` int(125) NOT NULL,
  `added_by` int(125) NOT NULL,
  `isActive` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
