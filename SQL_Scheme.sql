-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 03, 2018 at 11:38 PM
-- Server version: 5.6.40
-- PHP Version: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xzedni12`
--

-- --------------------------------------------------------

--
-- Table structure for table `Conversations`
--

CREATE TABLE IF NOT EXISTS `Conversations` (
  `ID` int(64) NOT NULL AUTO_INCREMENT,
  `Topic` varchar(256) COLLATE latin2_czech_cs NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `ID_2` (`ID`),
  KEY `ID_3` (`ID`),
  KEY `ID_4` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=79 ;

-- --------------------------------------------------------

--
-- Table structure for table `ConversationsUsers`
--

CREATE TABLE IF NOT EXISTS `ConversationsUsers` (
  `ID` int(64) NOT NULL AUTO_INCREMENT,
  `IDUser` int(64) NOT NULL,
  `IDConversation` int(64) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=191 ;

-- --------------------------------------------------------

--
-- Table structure for table `Events`
--

CREATE TABLE IF NOT EXISTS `Events` (
  `ID` int(255) NOT NULL AUTO_INCREMENT,
  `Title` longtext COLLATE latin2_czech_cs NOT NULL,
  `Description` longtext COLLATE latin2_czech_cs NOT NULL,
  `Time` time NOT NULL,
  `Date` date NOT NULL,
  `Place` text COLLATE latin2_czech_cs NOT NULL,
  `Deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `EventsAttended`
--

CREATE TABLE IF NOT EXISTS `EventsAttended` (
  `ID` int(64) NOT NULL AUTO_INCREMENT,
  `IDEvent` int(64) NOT NULL,
  `IDUser` int(64) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `EventsCreators`
--

CREATE TABLE IF NOT EXISTS `EventsCreators` (
  `ID` int(64) NOT NULL AUTO_INCREMENT,
  `IDEvent` int(64) NOT NULL,
  `IDUser` int(64) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `Friends`
--

CREATE TABLE IF NOT EXISTS `Friends` (
  `ID` int(64) NOT NULL AUTO_INCREMENT,
  `IDUser1` int(64) NOT NULL,
  `IDUser2` int(64) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- Table structure for table `Messages`
--

CREATE TABLE IF NOT EXISTS `Messages` (
  `ID` int(64) NOT NULL AUTO_INCREMENT,
  `IDSender` int(64) NOT NULL,
  `IDConversation` int(64) NOT NULL,
  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Message` longtext COLLATE latin2_czech_cs NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=108 ;

-- --------------------------------------------------------

--
-- Table structure for table `Online`
--

CREATE TABLE IF NOT EXISTS `Online` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IDUser` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=95 ;

-- --------------------------------------------------------

--
-- Table structure for table `Posts`
--

CREATE TABLE IF NOT EXISTS `Posts` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IDUser` int(11) NOT NULL,
  `Message` longtext COLLATE latin2_czech_cs NOT NULL,
  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Shared` tinyint(1) NOT NULL DEFAULT '1',
  `Deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=144 ;

-- --------------------------------------------------------

--
-- Table structure for table `PostsTag`
--

CREATE TABLE IF NOT EXISTS `PostsTag` (
  `ID` int(64) NOT NULL AUTO_INCREMENT,
  `IDUser` int(64) NOT NULL,
  `IDTag` int(64) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `ID` int(64) NOT NULL AUTO_INCREMENT,
  `School` varchar(255) COLLATE latin2_czech_cs DEFAULT NULL,
  `Residence` varchar(255) COLLATE latin2_czech_cs DEFAULT NULL,
  `Occupation` varchar(255) COLLATE latin2_czech_cs DEFAULT NULL,
  `Phone` varchar(15) COLLATE latin2_czech_cs DEFAULT NULL,
  `RelationshipStatus` enum('single','married','widowed','dating','complicated') COLLATE latin2_czech_cs DEFAULT NULL,
  `Relationship` int(11) DEFAULT NULL,
  `Deleted` tinyint(1) NOT NULL DEFAULT '0',
  `Email` varchar(255) COLLATE latin2_czech_cs DEFAULT NULL,
  `Password` varchar(255) COLLATE latin2_czech_cs DEFAULT NULL,
  `Admin` tinyint(1) NOT NULL DEFAULT '0',
  `FirstName` text COLLATE latin2_czech_cs NOT NULL,
  `LastName` text COLLATE latin2_czech_cs NOT NULL,
  `Birthday` date DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Email` (`Email`),
  KEY `Relationship` (`Relationship`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=38 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`ID`, `School`, `Residence`, `Occupation`, `Phone`, `RelationshipStatus`, `Relationship`, `Deleted`, `Email`, `Password`, `Admin`, `FirstName`, `LastName`, `Birthday`) VALUES
(34, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'admin@admin.com', 'admin', 1, 'Admin', 'Adminov', NULL),
(35, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'user1@user.com', 'user1', 0, 'User', 'Userov', NULL),
(36, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'user2@user.com', 'user2', 0, 'Uživatel', 'Uživatelov', NULL),
(37, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'user3@user.com', 'user3', 0, 'User', 'Uživatelov', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
