-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 11, 2016 at 12:43 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lomada`
--

-- --------------------------------------------------------

--
-- Table structure for table `abt_revenue`
--

CREATE TABLE IF NOT EXISTS `abt_revenue` (
  `ts` int(14) NOT NULL,
  `plant` varchar(25) NOT NULL,
  `cross_export` double NOT NULL,
  `import` double NOT NULL,
  `net_export` double NOT NULL,
  `cuf` double NOT NULL,
  `revenue_cost` double NOT NULL,
  PRIMARY KEY (`ts`,`plant`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `abt_revenue`
--

INSERT INTO `abt_revenue` (`ts`, `plant`, `cross_export`, `import`, `net_export`, `cuf`, `revenue_cost`) VALUES
(1459967400, 'lomada', 500, 5, 495, 20.424836601307, 3663000);

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

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('e80bb9f82a9c89971a8fefaa2d31b2b1', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:44.0) Gecko/20100101 Firefox/44.0', 1462199615, 'a:2:{s:9:"user_data";s:0:"";s:9:"logged_in";a:2:{s:2:"id";s:1:"1";s:8:"username";s:6:"lomada";}}'),
('f6286f2f9a66cba09acf89b0513e38b3', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:44.0) Gecko/20100101 Firefox/44.0', 1462201606, '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logins`
--

INSERT INTO `logins` (`id`, `userid`, `username`, `timestamp`, `ipaddress`, `success`) VALUES
(1, 1, 'lomada', 1455087163, '192.168.2.109', 1),
(2, 1, 'lomada', 1455096165, '192.168.2.109', 1),
(3, 1, 'lomada', 1456400053, '192.168.2.158', 1),
(4, 1, 'lomada', 1456462969, '192.168.2.158', 1),
(5, 1, 'lomada', 1456481630, '192.168.2.158', 1),
(6, 1, 'lomada', 1456487419, '192.168.2.158', 1),
(7, 1, 'lomada', 1456724629, '192.168.2.158', 1),
(8, 1, 'lomada', 1456726511, '192.168.2.158', 1),
(9, 1, 'lomada', 1456737882, '192.168.2.158', 1),
(10, 1, 'lomada', 1456807316, '192.168.2.158', 1),
(11, 1, 'lomada', 1456807481, '192.168.2.158', 1),
(12, 1, 'lomada', 1456908188, '192.168.2.158', 1),
(13, 1, 'lomada', 1456909223, '192.168.2.158', 1),
(14, 1, 'lomada', 1456910800, '192.168.2.158', 1),
(15, 1, 'lomada', 1456912795, '192.168.2.151', 1),
(16, 1, 'lomada', 1456913321, '192.168.2.151', 1),
(17, 1, 'lomada', 1456915058, '192.168.2.151', 1),
(18, 1, 'lomada', 1456915109, '192.168.2.151', 1),
(19, 1, 'lomada', 1456981310, '192.168.2.135', 1),
(20, 1, 'lomada', 1456988529, '192.168.2.158', 1),
(21, 1, 'lomada', 1456996773, '192.168.2.158', 1),
(22, 1, 'lomada', 1456996848, '192.168.2.158', 1),
(23, 1, 'lomada', 1457002995, '192.168.2.158', 1),
(24, 1, 'lomada', 1457003346, '192.168.2.158', 1),
(25, 1, 'lomada', 1457003964, '192.168.2.158', 1),
(26, 1, 'lomada', 1457006491, '192.168.2.158', 1),
(27, 1, 'lomada', 1457075268, '192.168.2.135', 1),
(28, 1, 'lomada', 1457351778, '192.168.2.158', 1),
(29, 1, 'lomada', 1457426925, '192.168.2.158', 1),
(30, 1, 'lomada', 1457439206, '192.168.2.158', 1),
(31, 1, 'lomada', 1457512317, '192.168.2.158', 1),
(32, 1, 'lomada', 1457515071, '192.168.2.158', 1),
(33, 1, 'lomada', 1457516153, '192.168.2.158', 1),
(34, 1, 'lomada', 1457587686, '192.168.2.158', 1),
(35, 1, 'lomada', 1457589582, '192.168.2.158', 1),
(36, 1, 'lomada', 1457591940, '192.168.2.158', 1),
(37, 1, 'lomada', 1457592736, '192.168.2.158', 1),
(38, 1, 'lomada', 1457598762, '192.168.2.135', 1),
(39, 1, 'lomada', 1457601180, '192.168.2.158', 1),
(40, 1, 'lomada', 1457674754, '192.168.2.158', 1),
(41, 1, 'lomada', 1457691474, '192.168.2.158', 1),
(42, 1, 'lomada', 1457933200, '192.168.2.151', 1),
(43, 1, 'lomada', 1458284003, '192.168.2.151', 1),
(44, 1, 'lomada', 1458541891, '192.168.2.151', 1),
(45, 1, 'lomada', 1458554386, '192.168.2.135', 1),
(46, 1, 'lomada', 1458719028, '192.168.2.135', 1),
(47, 1, 'lomada', 1459171193, '192.168.2.158', 1),
(48, 1, 'lomada', 1459229668, '192.168.2.158', 1),
(49, 1, 'lomada', 1459229672, '192.168.2.115', 1),
(50, 1, 'lomada', 1459235086, '192.168.2.115', 1),
(51, 1, 'lomada', 1459235122, '192.168.2.115', 1),
(52, 1, 'lomada', 1459235573, '192.168.2.158', 1),
(53, 1, 'lomada', 1459248364, '192.168.2.151', 1),
(54, 1, 'lomada', 1459515740, '192.168.2.119', 1),
(55, 1, 'lomada', 1459581651, '127.0.0.1', 1),
(56, 1, 'lomada', 1459581851, '127.0.0.1', 1),
(57, 1, 'lomada', 1459581918, '192.168.2.135', 1),
(58, 1, 'lomada', 1459581939, '192.168.2.135', 1),
(59, 1, 'lomada', 1459768511, '192.168.2.111', 1),
(60, 1, 'lomada', 1459772227, '192.168.2.111', 1),
(61, 1, 'lomada', 1459772711, '192.168.2.111', 1),
(62, 1, 'lomada', 1459851855, '192.168.2.111', 1),
(63, 1, 'lomada', 1459934190, '192.168.2.111', 1),
(64, 1, 'lomada', 1459943418, '192.168.2.151', 1),
(65, 1, 'lomada', 1459945003, '192.168.2.151', 1),
(66, 1, 'lomada', 1460007384, '192.168.2.111', 1),
(67, 1, 'lomada', 1460013956, '192.168.2.111', 1),
(68, 1, 'lomada', 1460019694, '192.168.2.111', 1),
(69, 1, 'lomada', 1460020856, '192.168.2.111', 1),
(70, 1, 'lomada', 1460021481, '192.168.2.111', 1),
(71, 1, 'lomada', 1460022094, '192.168.2.111', 1),
(72, 1, 'lomada', 1460031278, '192.168.2.111', 1),
(73, 1, 'lomada', 1460032878, '192.168.2.111', 1),
(74, 1, 'lomada', 1460090338, '192.168.2.111', 1),
(75, 1, 'lomada', 1460093828, '192.168.2.111', 1),
(76, 1, 'lomada', 1460094819, '192.168.2.111', 1),
(77, 1, 'lomada', 1460095259, '192.168.2.111', 1),
(78, 1, 'lomada', 1460096023, '192.168.2.111', 1),
(79, 1, 'lomada', 1460096687, '192.168.2.111', 1),
(80, 1, 'lomada', 1460097118, '192.168.2.111', 1),
(81, 1, 'lomada', 1460098552, '192.168.2.111', 1),
(82, 1, 'lomada', 1460099316, '192.168.2.111', 1),
(83, 1, 'lomada', 1460099869, '192.168.2.111', 1),
(84, 1, 'lomada', 1460435810, '192.168.2.135', 1),
(85, 1, 'lomada', 1460444206, '192.168.2.111', 1),
(86, 1, 'lomada', 1460524327, '192.168.2.111', 1),
(87, 1, 'lomada', 1460551359, '192.168.2.111', 1),
(88, 1, 'lomada', 1460971076, '192.168.2.48', 1),
(89, 1, 'lomada', 1461041580, '192.168.2.48', 1),
(90, 1, 'lomada', 1461043897, '192.168.2.48', 1),
(91, 1, 'lomada', 1461055590, '192.168.2.48', 1),
(92, 1, 'lomada', 1461060478, '192.168.2.48', 1),
(93, 1, 'lomada', 1461129085, '192.168.2.14', 1),
(94, 1, 'lomada', 1461131667, '192.168.2.14', 1),
(95, 1, 'lomada', 1461133924, '192.168.2.120', 1),
(96, 1, 'lomada', 1461149203, '192.168.2.14', 1),
(97, 1, 'lomada', 1461150481, '192.168.2.120', 1),
(98, 1, 'lomada', 1461577044, '192.168.2.60', 1),
(99, 1, 'lomada', 1461825321, '192.168.2.60', 1),
(100, 1, 'lomada', 1461841450, '192.168.2.120', 1),
(101, 1, 'lomada', 1461841481, '192.168.2.120', 1),
(102, 1, 'lomada', 1461847974, '192.168.2.83', 1),
(103, 1, 'lomada', 1461849283, '192.168.2.83', 1),
(104, 1, 'lomada', 1461849712, '192.168.2.83', 1),
(105, 1, 'lomada', 1461850695, '127.0.0.1', 1),
(106, 1, 'lomada', 1461905143, '192.168.2.120', 1),
(107, 1, 'lomada', 1461905370, '127.0.0.1', 1),
(108, 1, 'lomada', 1461906822, '192.168.2.83', 1),
(109, 1, 'lomada', 1462164231, '192.168.2.120', 1),
(110, 1, 'lomada', 1462167066, '127.0.0.1', 1),
(111, 1, 'lomada', 1462174305, '192.168.2.120', 1),
(112, 1, 'lomada', 1462199085, '127.0.0.1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `new_reports`
--

CREATE TABLE IF NOT EXISTS `new_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plant` varchar(25) NOT NULL,
  `report_title` varchar(100) NOT NULL,
  `report_name` varchar(100) NOT NULL,
  `report_type` varchar(25) NOT NULL,
  `interval` varchar(5) NOT NULL,
  `block` int(2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `new_reports`
--

INSERT INTO `new_reports` (`id`, `plant`, `report_title`, `report_name`, `report_type`, `interval`, `block`, `status`) VALUES
(4, 'lomada', 'hi report', 'hi_report', 'historical', '01', 1, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `Name`, `username`, `password`, `status`) VALUES
(1, 'lomada', 'lomada', '39ce5752af9b2571565ac9830d8396c7', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
