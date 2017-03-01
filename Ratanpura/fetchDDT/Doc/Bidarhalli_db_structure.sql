-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 10, 2015 at 05:42 PM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vemulapadu`
--

-- --------------------------------------------------------

--
-- Table structure for table `1min_data`
--

CREATE TABLE IF NOT EXISTS `1min_data` (
  `ts` int(14) NOT NULL,
  `blockname` varchar(5) CHARACTER SET latin1 NOT NULL,
  `device_name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `field` varchar(50) CHARACTER SET latin1 NOT NULL,
  `value` varchar(100) CHARACTER SET latin1 NOT NULL,
  `insertedts` int(14) NOT NULL,
  PRIMARY KEY (`ts`,`blockname`,`device_name`,`field`),
  KEY `blockname` (`blockname`),
  KEY `device_name` (`device_name`),
  KEY `field` (`field`),
  KEY `insertedts` (`insertedts`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `1min_data_text`
--

CREATE TABLE IF NOT EXISTS `1min_data_text` (
  `ts` int(14) NOT NULL,
  `blockname` varchar(5) CHARACTER SET latin1 NOT NULL,
  `device_name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `field` varchar(50) CHARACTER SET latin1 NOT NULL,
  `value` varchar(256) CHARACTER SET latin1 NOT NULL,
  `insertedts` int(14) NOT NULL,
  PRIMARY KEY (`ts`,`blockname`,`device_name`,`field`),
  KEY `blockname` (`blockname`),
  KEY `device_name` (`device_name`),
  KEY `field` (`field`),
  KEY `insertedts` (`insertedts`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `1min_data_text_today`
--

CREATE TABLE IF NOT EXISTS `1min_data_text_today` (
  `ts` int(14) NOT NULL,
  `blockname` varchar(5) CHARACTER SET latin1 NOT NULL,
  `device_name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `field` varchar(50) CHARACTER SET latin1 NOT NULL,
  `value` varchar(256) CHARACTER SET latin1 NOT NULL,
  `insertedts` int(14) NOT NULL,
  PRIMARY KEY (`ts`,`blockname`,`device_name`,`field`),
  KEY `blockname` (`blockname`),
  KEY `device_name` (`device_name`),
  KEY `field` (`field`),
  KEY `insertedts` (`insertedts`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `1min_data_text_today_csv`
--

CREATE TABLE IF NOT EXISTS `1min_data_text_today_csv` (
  `ts` int(14) NOT NULL,
  `blockname` varchar(5) CHARACTER SET latin1 NOT NULL,
  `device_name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `field` varchar(50) CHARACTER SET latin1 NOT NULL,
  `value` varchar(256) CHARACTER SET latin1 NOT NULL,
  `insertedts` int(14) NOT NULL,
  PRIMARY KEY (`ts`,`blockname`,`device_name`,`field`),
  KEY `blockname` (`blockname`),
  KEY `device_name` (`device_name`),
  KEY `field` (`field`),
  KEY `insertedts` (`insertedts`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `1min_data_today`
--

CREATE TABLE IF NOT EXISTS `1min_data_today` (
  `ts` int(14) NOT NULL,
  `blockname` varchar(5) CHARACTER SET latin1 NOT NULL,
  `device_name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `field` varchar(50) CHARACTER SET latin1 NOT NULL,
  `value` varchar(100) CHARACTER SET latin1 NOT NULL,
  `insertedts` int(14) NOT NULL,
  PRIMARY KEY (`ts`,`blockname`,`device_name`,`field`),
  KEY `blockname` (`blockname`),
  KEY `device_name` (`device_name`),
  KEY `field` (`field`),
  KEY `insertedts` (`insertedts`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `1min_data_today_csv`
--

CREATE TABLE IF NOT EXISTS `1min_data_today_csv` (
  `ts` int(14) NOT NULL,
  `blockname` varchar(5) CHARACTER SET latin1 NOT NULL,
  `device_name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `field` varchar(50) CHARACTER SET latin1 NOT NULL,
  `value` varchar(100) CHARACTER SET latin1 NOT NULL,
  `insertedts` int(14) NOT NULL,
  PRIMARY KEY (`ts`,`blockname`,`device_name`,`field`),
  KEY `blockname` (`blockname`),
  KEY `device_name` (`device_name`),
  KEY `field` (`field`),
  KEY `insertedts` (`insertedts`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `1min_data_today_unique`
--

CREATE TABLE IF NOT EXISTS `1min_data_today_unique` (
  `ts` int(14) NOT NULL,
  `blk_dv_fld_id` int(10) NOT NULL,
  `value` double DEFAULT NULL,
  `insertedts` int(14) NOT NULL,
  PRIMARY KEY (`ts`,`blk_dv_fld_id`),
  KEY `insertedts` (`insertedts`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `1min_data_unique`
--

CREATE TABLE IF NOT EXISTS `1min_data_unique` (
  `ts` int(14) NOT NULL,
  `blk_dv_fld_id` int(10) NOT NULL,
  `value` double DEFAULT NULL,
  `insertedts` int(14) NOT NULL,
  PRIMARY KEY (`ts`,`blk_dv_fld_id`),
  KEY `insertedts` (`insertedts`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `5min_data`
--

CREATE TABLE IF NOT EXISTS `5min_data` (
  `ts` int(14) NOT NULL,
  `blockname` varchar(5) CHARACTER SET latin1 NOT NULL,
  `device_name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `field` varchar(50) CHARACTER SET latin1 NOT NULL,
  `value` varchar(100) CHARACTER SET latin1 NOT NULL,
  `insertedts` int(14) NOT NULL,
  PRIMARY KEY (`ts`,`blockname`,`device_name`,`field`),
  KEY `blockname` (`blockname`),
  KEY `device_name` (`device_name`),
  KEY `field` (`field`),
  KEY `insertedts` (`insertedts`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `5min_data_today`
--

CREATE TABLE IF NOT EXISTS `5min_data_today` (
  `ts` int(14) NOT NULL,
  `blockname` varchar(5) CHARACTER SET latin1 NOT NULL,
  `device_name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `field` varchar(50) CHARACTER SET latin1 NOT NULL,
  `value` varchar(100) CHARACTER SET latin1 NOT NULL,
  `insertedts` int(14) NOT NULL,
  PRIMARY KEY (`ts`,`blockname`,`device_name`,`field`),
  KEY `ts` (`ts`),
  KEY `blockname` (`blockname`),
  KEY `device_name` (`device_name`),
  KEY `field` (`field`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `5min_data_today_unique`
--

CREATE TABLE IF NOT EXISTS `5min_data_today_unique` (
  `ts` int(14) NOT NULL,
  `blk_dv_fld_id` int(10) NOT NULL,
  `value` double DEFAULT NULL,
  `insertedts` int(14) NOT NULL,
  PRIMARY KEY (`ts`,`blk_dv_fld_id`),
  KEY `insertedts` (`insertedts`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `5min_data_unique`
--

CREATE TABLE IF NOT EXISTS `5min_data_unique` (
  `ts` int(14) NOT NULL,
  `blk_dv_fld_id` int(10) NOT NULL,
  `value` double DEFAULT NULL,
  `insertedts` int(14) NOT NULL,
  PRIMARY KEY (`ts`,`blk_dv_fld_id`),
  KEY `insertedts` (`insertedts`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `accord_em_report`
--

CREATE TABLE IF NOT EXISTS `accord_em_report` (
  `ReportDate` int(14) NOT NULL,
  `Device` varchar(50) NOT NULL,
  `field` varchar(50) NOT NULL,
  `DisplayName` varchar(20) NOT NULL,
  `lastts` int(14) NOT NULL,
  `value` double NOT NULL,
  `timeinhour` int(5) NOT NULL,
  `peak_pac` double NOT NULL,
  PRIMARY KEY (`ReportDate`,`Device`,`field`,`timeinhour`),
  KEY `Device` (`Device`,`field`),
  KEY `ReportDate` (`ReportDate`),
  KEY `lastts` (`lastts`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `alarm`
--

CREATE TABLE IF NOT EXISTS `alarm` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `ts` int(25) NOT NULL,
  `type` varchar(25) NOT NULL,
  `block` varchar(5) NOT NULL,
  `device_name` varchar(60) NOT NULL,
  `field` varchar(100) NOT NULL,
  `altype` varchar(25) NOT NULL,
  `error_txt` varchar(256) NOT NULL,
  `ack_datetime` varchar(25) NOT NULL DEFAULT 'Null',
  `solved_datetime` datetime NOT NULL,
  `reset_datetime` datetime NOT NULL,
  `remark` text,
  `operator` varchar(100) DEFAULT NULL,
  `added_datetime` int(14) DEFAULT NULL,
  `status` int(5) NOT NULL,
  `reset` int(2) NOT NULL DEFAULT '1',
  `priority` varchar(2) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`),
  UNIQUE KEY `block` (`block`,`device_name`,`field`,`error_txt`,`solved_datetime`),
  KEY `ts` (`ts`),
  KEY `status` (`status`),
  KEY `altype` (`altype`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `alarm_fields`
--

CREATE TABLE IF NOT EXISTS `alarm_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alarm_type` varchar(256) NOT NULL,
  `alarm_field` varchar(256) NOT NULL,
  `type` varchar(50) NOT NULL,
  `status` int(2) NOT NULL,
  `audio_status` int(2) NOT NULL,
  `history_enable` tinyint(2) NOT NULL,
  `priority` varchar(2) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alarm` (`alarm_type`,`alarm_field`,`type`),
  KEY `type` (`type`),
  KEY `status` (`status`),
  KEY `audio_status` (`audio_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `alarm_users`
--

CREATE TABLE IF NOT EXISTS `alarm_users` (
  `userId` int(100) NOT NULL AUTO_INCREMENT,
  `Name` varchar(48) DEFAULT NULL,
  `username` varchar(24) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userId`),
  UNIQUE KEY `user` (`username`,`password`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `daily_energy`
--

CREATE TABLE IF NOT EXISTS `daily_energy` (
  `ts` int(14) NOT NULL,
  `blockname` varchar(10) NOT NULL,
  `device_name` varchar(50) NOT NULL,
  `display` varchar(50) NOT NULL,
  `field` varchar(50) NOT NULL,
  `value` double NOT NULL,
  PRIMARY KEY (`ts`,`blockname`,`device_name`,`field`),
  KEY `ts` (`ts`),
  KEY `blockname` (`blockname`),
  KEY `device_name` (`device_name`),
  KEY `field` (`field`),
  KEY `display` (`display`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `day_variable`
--

CREATE TABLE IF NOT EXISTS `day_variable` (
  `ts` int(14) NOT NULL,
  `block` varchar(10) NOT NULL,
  `device` varchar(50) NOT NULL,
  `field` varchar(50) NOT NULL,
  `value` varchar(25) NOT NULL,
  PRIMARY KEY (`ts`,`block`,`device`,`field`),
  KEY `ts` (`ts`),
  KEY `block` (`block`),
  KEY `device` (`device`),
  KEY `field` (`field`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `day_variable_fields`
--

CREATE TABLE IF NOT EXISTS `day_variable_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(25) NOT NULL,
  `field` varchar(100) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE IF NOT EXISTS `device` (
  `igate` int(10) DEFAULT NULL,
  `type` varchar(512) DEFAULT NULL,
  `deviceid` int(14) NOT NULL AUTO_INCREMENT,
  `blockname` varchar(255) NOT NULL,
  `capacity` double NOT NULL DEFAULT '-1',
  `device_name` varchar(512) DEFAULT NULL,
  `parent` int(10) NOT NULL DEFAULT '-1',
  `master` int(10) NOT NULL DEFAULT '-1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `e_total` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`deviceid`),
  UNIQUE KEY `displayname` (`device_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `email_alert`
--

CREATE TABLE IF NOT EXISTS `email_alert` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `disk_usage_in_percn` double NOT NULL,
  `createdAt` date NOT NULL,
  `remarks` varchar(100) COLLATE utf8_bin NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `ts` int(25) NOT NULL,
  `type` varchar(25) NOT NULL,
  `block` varchar(5) NOT NULL,
  `device_name` varchar(60) NOT NULL,
  `field` varchar(100) NOT NULL,
  `altype` varchar(25) NOT NULL,
  `error_txt` varchar(256) NOT NULL,
  `source` varchar(50) DEFAULT NULL,
  `remark` text,
  `status` int(5) NOT NULL,
  `remarkts` datetime NOT NULL,
  `reset` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `ts` (`ts`),
  KEY `block` (`block`),
  KEY `device_name` (`device_name`),
  KEY `field` (`field`),
  KEY `altype` (`altype`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE IF NOT EXISTS `fields` (
  `blk_dv_fld_id` int(10) NOT NULL AUTO_INCREMENT,
  `blockname` varchar(5) CHARACTER SET latin1 NOT NULL,
  `device_name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `field` varchar(50) CHARACTER SET latin1 NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`blk_dv_fld_id`),
  UNIQUE KEY `blockname` (`blockname`,`device_name`,`field`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `hourly_compressedvalue`
--

CREATE TABLE IF NOT EXISTS `hourly_compressedvalue` (
  `ts` int(14) NOT NULL,
  `block` varchar(10) NOT NULL,
  `display` varchar(15) NOT NULL,
  `field` varchar(50) NOT NULL,
  `hour` int(5) NOT NULL,
  `hourts` int(14) NOT NULL,
  `value` double NOT NULL,
  PRIMARY KEY (`ts`,`block`,`display`,`field`,`hour`),
  KEY `ts` (`ts`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inverterdata_15mints`
--

CREATE TABLE IF NOT EXISTS `inverterdata_15mints` (
  `ts` int(14) NOT NULL,
  `blockname` varchar(5) NOT NULL,
  `device_name` varchar(25) NOT NULL,
  `field` varchar(25) NOT NULL,
  `value` double NOT NULL,
  `insertedts` int(14) NOT NULL,
  PRIMARY KEY (`ts`,`blockname`,`device_name`,`field`),
  KEY `blockname` (`blockname`,`device_name`,`field`),
  KEY `ts` (`ts`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inverterenergy`
--

CREATE TABLE IF NOT EXISTS `inverterenergy` (
  `ts` int(14) NOT NULL,
  `Block` varchar(5) NOT NULL,
  `Device` varchar(10) NOT NULL,
  `Field` varchar(50) NOT NULL,
  `Type` varchar(10) NOT NULL,
  `Value` double NOT NULL,
  PRIMARY KEY (`ts`,`Block`,`Device`,`Field`,`Type`),
  KEY `ts` (`ts`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invertermaxpac`
--

CREATE TABLE IF NOT EXISTS `invertermaxpac` (
  `ts` int(14) NOT NULL,
  `Block` varchar(5) NOT NULL,
  `Device` varchar(15) NOT NULL,
  `Field` varchar(10) NOT NULL,
  `Value` double NOT NULL,
  PRIMARY KEY (`ts`,`Block`,`Device`,`Field`),
  KEY `ts` (`ts`),
  KEY `Block` (`Block`,`Device`,`Field`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inverter_dcframe_report`
--

CREATE TABLE IF NOT EXISTS `inverter_dcframe_report` (
  `ReportDate` date NOT NULL,
  `ts` int(14) NOT NULL,
  `Block` varchar(15) NOT NULL,
  `Device` varchar(100) NOT NULL,
  `StartTime` varchar(14) NOT NULL,
  `StopTime` varchar(14) NOT NULL,
  `TotalSMU` int(10) NOT NULL,
  `SmuConnected` int(10) NOT NULL,
  `MinEnergy` double NOT NULL,
  `MaxEnergy` double NOT NULL,
  `EnergyGeneration` double NOT NULL,
  `PeakPAC` double NOT NULL,
  `remark` text NOT NULL,
  `operator` varchar(25) NOT NULL,
  `remarkdate` datetime NOT NULL,
  `invStart` int(11) NOT NULL,
  `invStop` int(11) NOT NULL,
  PRIMARY KEY (`ReportDate`,`Block`,`Device`),
  KEY `ts` (`ts`),
  KEY `remarkdate` (`remarkdate`),
  KEY `ReportDate` (`ReportDate`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE IF NOT EXISTS `logins` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `ipaddress` varchar(15) DEFAULT NULL,
  `success` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `plant_generation_report`
--

CREATE TABLE IF NOT EXISTS `plant_generation_report` (
  `ts` int(14) NOT NULL,
  `block` varchar(5) NOT NULL,
  `device` varchar(25) NOT NULL,
  `field` varchar(25) NOT NULL,
  `value` double NOT NULL,
  PRIMARY KEY (`ts`,`block`,`device`,`field`),
  KEY `blockname` (`block`,`device`,`field`),
  KEY `ts` (`ts`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `plant_ov_report`
--

CREATE TABLE IF NOT EXISTS `plant_ov_report` (
  `ts` int(14) NOT NULL,
  `blockname` varchar(5) NOT NULL,
  `inv1_pac` varchar(10) NOT NULL,
  `inv2_pac` varchar(10) NOT NULL,
  `inv3_pac` varchar(10) NOT NULL,
  `inv4_pac` varchar(10) NOT NULL,
  `elite_pac` varchar(10) NOT NULL,
  `inv1_gen` varchar(10) NOT NULL,
  `inv2_gen` varchar(10) NOT NULL,
  `inv3_gen` varchar(10) NOT NULL,
  `inv4_gen` varchar(10) NOT NULL,
  `elite_gen` varchar(10) NOT NULL,
  `inv1_pr` varchar(10) NOT NULL,
  `inv2_pr` varchar(10) NOT NULL,
  `inv3_pr` varchar(10) NOT NULL,
  `inv4_pr` varchar(10) NOT NULL,
  `blk_pr` varchar(10) NOT NULL,
  PRIMARY KEY (`ts`,`blockname`),
  KEY `ts` (`ts`),
  KEY `blockname` (`blockname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `scada_latest_igate_data`
--

CREATE TABLE IF NOT EXISTS `scada_latest_igate_data` (
  `id` int(25) NOT NULL,
  `ts` int(14) NOT NULL,
  `blockname` varchar(5) NOT NULL,
  `device_name` varchar(50) NOT NULL,
  `field` varchar(50) NOT NULL,
  `value` varchar(100) NOT NULL,
  `format` int(10) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `path` varchar(256) NOT NULL,
  `idoffset` int(10) NOT NULL,
  `masterId` int(10) NOT NULL,
  PRIMARY KEY (`blockname`,`device_name`,`field`),
  KEY `ts` (`ts`),
  KEY `blockname` (`blockname`),
  KEY `device_name` (`device_name`),
  KEY `field` (`field`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_report_mail`
--

CREATE TABLE IF NOT EXISTS `schedule_report_mail` (
  `sno` int(11) NOT NULL AUTO_INCREMENT,
  `heading` varchar(30) NOT NULL,
  `mail_subject` varchar(255) DEFAULT NULL,
  `mail_to` varchar(255) NOT NULL,
  `mail_cc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `smucomparison_data`
--

CREATE TABLE IF NOT EXISTS `smucomparison_data` (
  `ts` int(14) NOT NULL,
  `blockname` varchar(10) NOT NULL,
  `device_name` varchar(25) NOT NULL,
  `module` varchar(50) NOT NULL,
  `smustatus` int(5) NOT NULL,
  `duration` double NOT NULL,
  `modulecldate` date NOT NULL,
  `moduleduedate` date NOT NULL,
  PRIMARY KEY (`ts`,`blockname`,`device_name`),
  KEY `ts` (`ts`),
  KEY `blockname` (`blockname`),
  KEY `device_name` (`device_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `smustringconn`
--

CREATE TABLE IF NOT EXISTS `smustringconn` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `block` varchar(10) NOT NULL,
  `device` varchar(50) NOT NULL,
  `module` varchar(50) NOT NULL,
  `num_strings_connected` int(10) NOT NULL,
  `num_module_connected` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `block` (`block`,`device`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `system_architecture`
--

CREATE TABLE IF NOT EXISTS `system_architecture` (
  `block` varchar(10) NOT NULL,
  `device` varchar(50) NOT NULL,
  `field` varchar(50) NOT NULL,
  `value` varchar(25) NOT NULL,
  `solved` varchar(5) NOT NULL,
  `ack` varchar(5) NOT NULL,
  PRIMARY KEY (`block`,`device`,`field`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(100) NOT NULL AUTO_INCREMENT,
  `Name` varchar(48) DEFAULT NULL,
  `username` varchar(24) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userId`),
  UNIQUE KEY `user` (`username`,`password`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
