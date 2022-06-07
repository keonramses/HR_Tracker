-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 06, 2022 at 10:22 AM
-- Server version: 8.0.21
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrtracker`
--
CREATE DATABASE IF NOT EXISTS `hrtracker` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `hrtracker`;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `contactID` int NOT NULL AUTO_INCREMENT,
  `contactName` varchar(1000) NOT NULL,
  `contactLocal` varchar(50) NOT NULL,
  `contactCell` varchar(50) NOT NULL,
  PRIMARY KEY (`contactID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`contactID`, `contactName`, `contactLocal`, `contactCell`) VALUES
(3, 'Watch Tower', '1001', '123-456-4568'),
(4, 'Bat Cave', '1005', '604-000-1234'),
(9, 'Atlantis Customer Support', '2005', '604-278-2636');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) NOT NULL,
  `local` varchar(50) NOT NULL,
  `cell` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `lastUpdated` varchar(50) NOT NULL,
  `team` varchar(50) NOT NULL,
  `isManager` varchar(10) NOT NULL,
  `hasSpecialRole` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(30) NOT NULL,
  `loginPwd` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `isAdmin` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `name`, `local`, `cell`, `status`, `comment`, `lastUpdated`, `team`, `isManager`, `hasSpecialRole`, `email`, `loginPwd`, `isAdmin`) VALUES
(1, 'Clark Kent', '0152', '123-456-7782', 'Out', 'I wonder what i make for dinner tonight, wait a minute, i don\'t need food do i?', '04-Apr-2022 @ <b>11:16 am</b>', 'Security', 'Yes', 'Yes', 'ck@test.com', '$2y$10$JNjxkOq70QTkT1SdoLwLUOJmyhirD2oBGxo3Z2Io.EiPRpxJFlW3i', 'No'),
(2, 'Bruce Wayne', '5359', '123-456-7890', 'Out', 'Just bought a new batmobile, taking it out for a spin with Alfred later.', '04-Apr-2022 @ <b>11:15 am</b>', 'Accounting', 'No', 'Yes', 'test@email.com', '$2y$10$JNjxkOq70QTkT1SdoLwLUOJmyhirD2oBGxo3Z2Io.EiPRpxJFlW3i', 'Yes'),
(3, 'Kenneth Iwuchukwu', '1234', '123-456-7845', 'Lunch', 'I want a 3090, but i can\'t find where to buy one.', '05-Apr-2022 @ <b>9:33 pm</b>', 'Human Resources (HR)', 'Yes', 'Yes', 'we@test.com', '$2y$10$JNjxkOq70QTkT1SdoLwLUOJmyhirD2oBGxo3Z2Io.EiPRpxJFlW3i', 'No'),
(8, 'Madara Uchiha', '6666', '604-789-1666', 'In', 'Building Infinite Tsukyuomi Pathways with Tobi.', '31-Mar-2022 @ <b>10:22 pm</b>', 'Security', 'No', 'Yes', 'madara@test.com', '$2y$10$JNjxkOq70QTkT1SdoLwLUOJmyhirD2oBGxo3Z2Io.EiPRpxJFlW3i', 'No'),
(9, 'Itachi Uchiha', '1666', '604-789-0675', 'Out', 'Making Sasuke\'s Jounin Uniform', '04-Apr-2022 @ <b>11:27 am</b>', 'IT Support (IT)', 'No', 'No', 'itachi@test.com', '$2y$10$JNjxkOq70QTkT1SdoLwLUOJmyhirD2oBGxo3Z2Io.EiPRpxJFlW3i', 'No'),
(12, 'Kenshiro Kasumi', '2334', '604-789-1669', 'In', 'Claiming the North Star', '04-Apr-2022 @ <b>12:01 am</b>', 'Human Resources (HR)', 'No', 'No', 'lolk@test.com', '$2y$10$JNjxkOq70QTkT1SdoLwLUOJmyhirD2oBGxo3Z2Io.EiPRpxJFlW3i', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `specialrole`
--

DROP TABLE IF EXISTS `specialrole`;
CREATE TABLE IF NOT EXISTS `specialrole` (
  `roleID` int NOT NULL AUTO_INCREMENT,
  `roleName` varchar(1000) NOT NULL,
  `assignedTo` varchar(1000) NOT NULL,
  `lastUpdated` varchar(50) NOT NULL,
  PRIMARY KEY (`roleID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `specialrole`
--

INSERT INTO `specialrole` (`roleID`, `roleName`, `assignedTo`, `lastUpdated`) VALUES
(2, 'Key Holder', 'Bruce Wayne', '05-Mar-2022 @ <b>9:17 pm</b>'),
(5, 'Inventory Manager', 'Clark Kent', '13-Feb-2022 @ <b>5:40 pm</b>'),
(10, 'First Aid Officer', 'Bruce Wayne', '13-Feb-2022 @ <b>5:21 pm</b>'),
(11, 'Coordinator', 'Kenneth Iwuchukwu', '13-Feb-2022 @ <b>5:38 pm</b>');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
