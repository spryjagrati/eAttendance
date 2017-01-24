-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 11, 2016 at 02:39 PM
-- Server version: 5.5.46
-- PHP Version: 5.4.45-2+deb.sury.org~precise+2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `eattendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE IF NOT EXISTS `application` (
  `idapplication` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL COMMENT '2=>pl\n3=>cl\n4=>sl',
  `title` varchar(256) DEFAULT NULL,
  `description` mediumtext,
  `status` int(2) DEFAULT NULL COMMENT '1=>pending\n2=>approved\n3=>rejected',
  `created_on` timestamp NULL DEFAULT NULL,
  `updated_on` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idapplication`),
  UNIQUE KEY `idapplication_UNIQUE` (`idapplication`),
  KEY `fk_app_usr_idx` (`iduser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `idattendance` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `cdate` date NOT NULL,
  `in_time` time DEFAULT NULL,
  `out_time` time DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT NULL,
  `updated_on` timestamp NULL DEFAULT NULL,
  `type` int(2) DEFAULT '1' COMMENT '-1=>unmarked\n0=>absent\n1=>present\n2=>PL 3=>CL\n4=>SL\n5=>halfday\n6=>sunday\n7=>holiday\n8=>2nd Saturday\n9=>4th Saturday',
  `remark` mediumtext,
  `idapplication` int(11) DEFAULT NULL COMMENT 'to be added when type = 0',
  PRIMARY KEY (`idattendance`),
  UNIQUE KEY `idattendance_UNIQUE` (`idattendance`),
  KEY `fk_attendan_usr_idx` (`iduser`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=309 ;

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE IF NOT EXISTS `document` (
  `iddocument` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(20) NOT NULL,
  `title` varchar(256) DEFAULT NULL,
  `description` mediumtext,
  `taken_date` date DEFAULT NULL,
  `given_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT NULL,
  `updated_on` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`iddocument`),
  UNIQUE KEY `iddocument_UNIQUE` (`iddocument`),
  KEY `fk_doc_us_idx` (`iduser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE IF NOT EXISTS `education` (
  `ideducation` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `title` varchar(64) DEFAULT NULL,
  `description` mediumtext,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `college` varchar(124) DEFAULT NULL,
  `grade` varchar(8) DEFAULT NULL COMMENT 'grade or percentage',
  `stream` varchar(32) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT NULL,
  `updated_on` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ideducation`),
  UNIQUE KEY `ideducation_UNIQUE` (`ideducation`),
  KEY `fk_edu_usr_idx` (`iduser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE IF NOT EXISTS `experience` (
  `idexperience` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `title` varchar(64) DEFAULT NULL,
  `description` mediumtext,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `company` varchar(128) DEFAULT NULL,
  `company_address` mediumtext,
  `company_ctc` int(16) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT NULL,
  `updated_on` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`idexperience`),
  UNIQUE KEY `idexperience_UNIQUE` (`idexperience`),
  KEY `fk_exp_usr_idx` (`iduser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `system_meta`
--

CREATE TABLE IF NOT EXISTS `system_meta` (
  `idsystem_meta` int(11) NOT NULL AUTO_INCREMENT,
  `meta_name` varchar(64) DEFAULT NULL,
  `meta_value` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`idsystem_meta`),
  UNIQUE KEY `idsystem_meta_UNIQUE` (`idsystem_meta`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `system_meta`
--

INSERT INTO `system_meta` (`idsystem_meta`, `meta_name`, `meta_value`) VALUES
(2, 'PL', NULL),
(3, 'CL', NULL),
(4, 'SL', NULL),
(5, 'Office_intime', '09:15'),
(6, 'Office_outtime', '06:15'),
(7, '2016_official_leave_MakarSankranti', '2016-01-15'),
(8, '2016_official_leave_RepublicDay', '2016-01-26'),
(9, '2016_official_leave_Holi', '2016-03-24'),
(10, '2016_official_leave_Independence day', '2016-08-15'),
(11, '2016_official_leave_Rakshabandhan', '2016-08-18'),
(12, '2016_official_leave_Dussehra', '2016-10-11'),
(13, '2016_official_leave_diwali', '2016-10-28'),
(14, '2016_official_leave_diwali', '2016-10-29'),
(15, '2016_official_leave_diwali', '2016-10-30'),
(16, '2016_official_leave_diwali', '2016-10-31');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) DEFAULT NULL,
  `username` varchar(64) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `type` int(2) DEFAULT NULL COMMENT '1=>admin, 2=>manager, 3=>employee',
  `status` int(2) DEFAULT '0' COMMENT '0=>inactive, 1=>active',
  `password_reset_digest` varchar(128) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT NULL,
  `updated_on` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`iduser`),
  UNIQUE KEY `iduser_UNIQUE` (`iduser`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`iduser`, `email`, `username`, `password`, `type`, `status`, `password_reset_digest`, `created_by`, `updated_by`, `created_on`, `updated_on`) VALUES
(1, 'admin@eattendance.com', 'admin', 'f78a918845e4691c0789939d49d97d3ce8fc0366', 1, 1, '', 1, 1, '2015-10-19 00:00:00', '2016-01-11 09:06:36');

-- --------------------------------------------------------

--
-- Table structure for table `user_meta`
--

CREATE TABLE IF NOT EXISTS `user_meta` (
  `iduser_meta` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `first_name` varchar(32) DEFAULT NULL,
  `last_name` varchar(32) DEFAULT NULL,
  `designation` varchar(64) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `alt_phone` varchar(16) DEFAULT NULL,
  `landline` varchar(16) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `alt_email` varchar(128) DEFAULT NULL,
  `current_address` mediumtext,
  `permanent_address` mediumtext,
  `communication_address` mediumtext,
  `landlord_detail` mediumtext,
  `father_name` varchar(64) DEFAULT NULL,
  `father_phone` varchar(16) DEFAULT NULL,
  `mother_name` varchar(64) DEFAULT NULL,
  `mother_phone` varchar(16) DEFAULT NULL,
  `pan` varchar(16) DEFAULT NULL,
  `bank` varchar(64) DEFAULT NULL,
  `branch` varchar(64) DEFAULT NULL,
  `account_number` varchar(32) DEFAULT NULL,
  `micr_code` varchar(64) DEFAULT NULL,
  `ifsc` varchar(16) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT NULL,
  `updated_on` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`iduser_meta`),
  UNIQUE KEY `iduser_meta_UNIQUE` (`iduser_meta`),
  KEY `fk_usr_meta_usr_idx` (`iduser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `fk_app_usr` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `fk_attendan_usr` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `fk_doc_us` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `education`
--
ALTER TABLE `education`
  ADD CONSTRAINT `fk_edu_usr` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `experience`
--
ALTER TABLE `experience`
  ADD CONSTRAINT `fk_exp_usr` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_meta`
--
ALTER TABLE `user_meta`
  ADD CONSTRAINT `fk_usr_meta_usr` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
