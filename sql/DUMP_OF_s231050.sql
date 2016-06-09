-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 09, 2016 at 01:06 PM
-- Server version: 5.5.49
-- PHP Version: 5.3.10-1ubuntu3.22

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `s231050`
--

-- --------------------------------------------------------

--
-- Table structure for table `RESERVATIONS`
--

CREATE TABLE IF NOT EXISTS `RESERVATIONS` (
  `res_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `start_time` int(11) NOT NULL,
  `duration_time` int(11) NOT NULL,
  `selected_machine` int(11) NOT NULL,
  PRIMARY KEY (`res_id`),
  KEY `foreign_key` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `RESERVATIONS`
--

INSERT INTO `RESERVATIONS` (`res_id`, `user_id`, `start_time`, `duration_time`, `selected_machine`) VALUES
(1, 3, 420, 20, 1),
(2, 1, 310, 35, 1),
(3, 2, 1190, 10, 1),
(4, 2, 975, 20, 1),
(5, 1, 960, 20, 2),
(7, 1, 600, 25, 3),
(8, 2, 1210, 45, 4),
(9, 3, 1335, 5, 2),
(10, 3, 1335, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE IF NOT EXISTS `USERS` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `unique_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `USERS`
--

INSERT INTO `USERS` (`user_id`, `email`, `password`, `name`, `lastname`) VALUES
(1, 'u1@p.it', '83878c91171338902e0fe0fb97a8c47a', 'first', 'user'),
(2, 'u2@p.it', '1d665b9b1467944c128a5575119d1cfd', 'second', 'user'),
(3, 'u3@p.it', '7bc3ca68769437ce986455407dab2a1f', 'third', 'user');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `RESERVATIONS`
--
ALTER TABLE `RESERVATIONS`
  ADD CONSTRAINT `RESERVATIONS_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `USERS` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
