-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 30, 2020 at 09:00 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `betlive`
--
CREATE DATABASE IF NOT EXISTS `betlive` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `betlive`;

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

DROP TABLE IF EXISTS `balance`;
CREATE TABLE IF NOT EXISTS `balance` (
  `balance_id` int(11) NOT NULL AUTO_INCREMENT,
  `balance` decimal(10,0) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`balance_id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `FK_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `balance`
--

INSERT INTO `balance` (`balance_id`, `balance`, `user_id`) VALUES
(14, '0', 2),
(15, '0', 3),
(16, '10', 6);

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

DROP TABLE IF EXISTS `matches`;
CREATE TABLE IF NOT EXISTS `matches` (
  `match_id` int(11) NOT NULL AUTO_INCREMENT,
  `home_team` int(11) NOT NULL,
  `away_team` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `start_date` date NOT NULL,
  `home_score` int(11) DEFAULT NULL,
  `away_score` int(11) DEFAULT NULL,
  PRIMARY KEY (`match_id`),
  UNIQUE KEY `match_id` (`match_id`),
  KEY `FK_home_team` (`home_team`),
  KEY `FK_away_team` (`away_team`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`match_id`, `home_team`, `away_team`, `start_time`, `start_date`, `home_score`, `away_score`) VALUES
(4, 3, 18, '12:00:00', '2020-01-31', 1, 0),
(5, 1, 2, '12:00:00', '2020-01-31', NULL, NULL),
(7, 85, 75, '12:00:00', '2020-02-01', NULL, NULL),
(11, 23, 3, '12:00:00', '2020-02-01', NULL, NULL),
(35, 76, 82, '21:00:00', '2020-02-01', NULL, NULL),
(36, 77, 79, '21:00:00', '2020-02-02', NULL, NULL),
(37, 86, 88, '21:00:00', '2020-02-02', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `odds_data`
--

DROP TABLE IF EXISTS `odds_data`;
CREATE TABLE IF NOT EXISTS `odds_data` (
  `odd_id` int(11) NOT NULL AUTO_INCREMENT,
  `home_team_odd` decimal(4,2) NOT NULL,
  `away_team_odd` decimal(4,2) NOT NULL,
  `x_odd` decimal(4,2) NOT NULL,
  `match_id` int(11) NOT NULL,
  PRIMARY KEY (`odd_id`),
  KEY `FK_match_id` (`match_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `odds_data`
--

INSERT INTO `odds_data` (`odd_id`, `home_team_odd`, `away_team_odd`, `x_odd`, `match_id`) VALUES
(1, '2.41', '1.43', '3.20', 4),
(3, '2.50', '6.20', '5.10', 7),
(4, '1.61', '2.10', '3.50', 5),
(5, '1.65', '1.85', '3.25', 11),
(6, '1.32', '2.98', '2.55', 35),
(7, '1.21', '2.10', '2.45', 36),
(8, '1.56', '2.76', '3.22', 37);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `team_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`team_id`),
  UNIQUE KEY `team_id` (`team_id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`team_id`, `name`) VALUES
(1, 'Real Madrid'),
(2, 'Liverpool'),
(3, 'Bayern'),
(18, 'Milan'),
(23, 'Chelsea'),
(75, 'Roma'),
(76, 'Ajax'),
(77, 'Juventus'),
(78, 'Barcelona'),
(79, 'Manchester City'),
(80, 'Manchester United'),
(81, 'Arsenal'),
(82, 'Tottenham'),
(83, 'Porto'),
(84, 'Lyon'),
(85, 'PSG'),
(86, 'Atl. Madrid'),
(87, 'B. Dortmund'),
(88, 'Schalke');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE IF NOT EXISTS `tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `bet` json NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `possible_win` decimal(10,2) NOT NULL,
  PRIMARY KEY (`ticket_id`),
  KEY `FK_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `user_id`, `bet`, `amount`, `possible_win`) VALUES
(49, 3, '[{\"type\": 1, \"home_odd\": \"2.41\", \"away_team\": \"Milan\", \"home_team\": \"Bayern\", \"start_date\": \"2019-05-30\", \"start_time\": \"12:00:00\"}]', '1.00', '2.00'),
(50, 3, '[{\"type\": 1, \"home_odd\": \"2.50\", \"away_team\": \"Roma\", \"home_team\": \"PSG\", \"start_date\": \"2019-05-29\", \"start_time\": \"12:00:00\"}]', '1.00', '3.00'),
(51, 3, '[{\"type\": 1, \"home_odd\": \"1.21\", \"away_team\": \"Manchester City\", \"home_team\": \"Juventus\", \"start_date\": \"2019-05-08\", \"start_time\": \"21:00:00\"}]', '1.00', '1.00'),
(52, 3, '[{\"type\": 1, \"home_odd\": \"2.41\", \"away_team\": \"Milan\", \"home_team\": \"Bayern\", \"start_date\": \"2019-05-30\", \"start_time\": \"12:00:00\"}]', '1.00', '2.00'),
(53, 3, '[{\"type\": 1, \"home_odd\": \"2.41\", \"away_team\": \"Milan\", \"home_team\": \"Bayern\", \"start_date\": \"2019-05-30\", \"start_time\": \"12:00:00\"}]', '2.00', '4.82'),
(54, 3, '[{\"type\": 1, \"home_odd\": \"2.41\", \"away_team\": \"Milan\", \"home_team\": \"Bayern\", \"start_date\": \"2019-05-30\", \"start_time\": \"12:00:00\"}]', '2.00', '4.82'),
(55, 3, '[{\"type\": 1, \"home_odd\": \"2.41\", \"away_team\": \"Milan\", \"home_team\": \"Bayern\", \"start_date\": \"2019-05-30\", \"start_time\": \"12:00:00\"}, {\"type\": \"X\", \"x_odd\": \"2.55\", \"away_team\": \"Tottenham\", \"home_team\": \"Ajax\", \"start_date\": \"2019-05-08\", \"start_time\": \"21:00:00\"}]', '2.00', '12.29'),
(56, 3, '[{\"type\": 1, \"home_odd\": \"2.50\", \"away_team\": \"Roma\", \"home_team\": \"PSG\", \"start_date\": \"2019-05-09\", \"start_time\": \"12:00:00\"}, {\"type\": 2, \"away_odd\": \"2.98\", \"away_team\": \"Tottenham\", \"home_team\": \"Ajax\", \"start_date\": \"2019-06-10\", \"start_time\": \"21:00:00\"}, {\"type\": 1, \"home_odd\": \"1.56\", \"away_team\": \"Schalke\", \"home_team\": \"Atl. Madrid\", \"start_date\": \"2019-06-20\", \"start_time\": \"21:00:00\"}, {\"type\": 2, \"away_odd\": \"1.43\", \"away_team\": \"Milan\", \"home_team\": \"Bayern\", \"start_date\": \"2019-06-08\", \"start_time\": \"12:00:00\"}]', '2.00', '33.24'),
(57, 2, '[{\"type\": 1, \"home_odd\": \"1.65\", \"away_team\": \"Bayern\", \"home_team\": \"Chelsea\", \"start_date\": \"2019-06-09\", \"start_time\": \"12:00:00\"}, {\"type\": \"X\", \"x_odd\": \"3.20\", \"away_team\": \"Milan\", \"home_team\": \"Bayern\", \"start_date\": \"2019-06-08\", \"start_time\": \"12:00:00\"}]', '5.00', '26.40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `is_approved` tinyint(4) NOT NULL DEFAULT '0',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`user_id`),
  KEY `FK_created_by` (`approved_by`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `approved_by`, `status`, `is_approved`, `balance`) VALUES
(2, 'ajla', 'superadmin@hotmail.com', '123', NULL, 2, 1, '10.00'),
(3, 'ajlina', 'admin@hotmail.com', '123456', 2, 1, 1, '65.00'),
(6, 'user123', 'user@live.com', '123456', 2, 0, 1, '90.00'),
(7, 'test123', 'test@hotmail.com', '123456', 2, 0, 1, '0.00'),
(8, 'test111', 'test111@hotmail.com', '123456', NULL, 0, 0, '0.00'),
(9, 'test654', 'test654@hotmail.com', '654321', NULL, 0, 0, '0.00'),
(10, 'proba', 'proba@gmail.com', '654321', 3, 0, 1, '0.00'),
(11, 'ajlaaaaa', 'admin@aaa.ba', '123456', 2, 0, 1, '0.00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `odds_data`
--
ALTER TABLE `odds_data`
  ADD CONSTRAINT `FK_match_id` FOREIGN KEY (`match_id`) REFERENCES `matches` (`match_id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `FK_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FKk_created_by` FOREIGN KEY (`approved_by`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
