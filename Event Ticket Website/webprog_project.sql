-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 13, 2024 at 12:34 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webprog_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `entry`
--

DROP TABLE IF EXISTS `entry`;
CREATE TABLE IF NOT EXISTS `entry` (
  `Entry_Id` int(11) NOT NULL AUTO_INCREMENT,
  `User_Id` int(11) NOT NULL,
  `Event_Id` int(11) NOT NULL,
  `Register` tinyint(1) NOT NULL,
  PRIMARY KEY (`Entry_Id`),
  KEY `User_Id` (`User_Id`),
  KEY `Event_Id` (`Event_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `entry`
--

INSERT INTO `entry` (`Entry_Id`, `User_Id`, `Event_Id`, `Register`) VALUES
(4, 3, 3, 1),
(8, 5, 5, 1),
(10, 2, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `Event_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Time` date DEFAULT NULL,
  `Title` varchar(200) DEFAULT NULL,
  `Venue` varchar(200) DEFAULT NULL,
  `Description` varchar(2000) DEFAULT NULL,
  `Limitation` int(11) NOT NULL,
  PRIMARY KEY (`Event_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`Event_Id`, `Time`, `Title`, `Venue`, `Description`, `Limitation`) VALUES
(3, '2024-02-24', 'Ed Sheeran: The Mathematics Tour', 'Bukit Jalil National Stadium, Kuala Lumpur', 'His sophomore output, entitled x (Multiply), would receive a similarly favourable reception from audiences through the singles Sing, Donâ€™t, and Thinking Out Loud. During the 2016 Grammy Awards, Sheeran bagged both two awards for Song of The Year and Best Solo Pop Performance, in addition to nabbing the British Male Solo Artist and British Album of the Year for Ã— at the 2015 Brit Awards.', 500),
(5, '2024-03-01', 'Tour with Lukman', 'DSS UNITEN, Bangi', 'Good News to all Lukman local fans. He will held his own concert to all his local fans with a surprise performance. He was the winner of the Lifestyle and Breakout Influencer category at the 2017 Asia Influencer Awards held at KLCC.', 1),
(6, '2024-01-09', 'Bunkface', 'Axiata Arena, Bukit Jalil', 'Local Singer', 50);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(200) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `Admin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Username`, `Email`, `Age`, `Password`, `Admin`) VALUES
(1, 'Admin', '123@gmail.com', 0, 'Admin123', 1),
(2, 'Chong', 'abc123@gmail.com', 23, 'test987', 0),
(3, 'Kai', 'abc@gmail.com', 26, 'qwezxc', 0),
(4, 'Amin', 'iou@jamal.com', 24, 'poimnb', 0),
(5, 'Iss', 'qwe@samal.com', 28, 'asdzxc', 0),
(6, 'Afiq', 'asdf@gmail.co.m', 15, 'asdfgh', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `entry`
--
ALTER TABLE `entry`
  ADD CONSTRAINT `entry_ibfk_1` FOREIGN KEY (`User_Id`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entry_ibfk_2` FOREIGN KEY (`Event_Id`) REFERENCES `events` (`Event_Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
