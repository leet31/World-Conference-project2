-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2016 at 07:29 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `csit537_project1`
--
CREATE DATABASE IF NOT EXISTS `csit537_project1` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `csit537_project1`;

-- --------------------------------------------------------

--
-- Table structure for table `wa_areas`
--

CREATE TABLE IF NOT EXISTS `wa_areas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(20) NOT NULL,
  `DESCRIPTION` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wa_book_details`
--

CREATE TABLE IF NOT EXISTS `wa_book_details` (
  `PRODUCT_ID` int(11) NOT NULL,
  `TITLE` varchar(256) NOT NULL,
  `ISBN` int(11) NOT NULL,
  `PUBLISHER` varchar(40) NOT NULL,
  `PUB_DATE` year(4) NOT NULL,
  `EDITION` tinyint(4) NOT NULL,
  `NUM_PAGES` int(11) NOT NULL,
  PRIMARY KEY (`PRODUCT_ID`),
  UNIQUE KEY `ISBN` (`ISBN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wa_orders`
--

CREATE TABLE IF NOT EXISTS `wa_orders` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CUSTOMER_ID` int(11) NOT NULL,
  `ORDER_DATE` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `CUSTOMER_ID` (`CUSTOMER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wa_order_details`
--

CREATE TABLE IF NOT EXISTS `wa_order_details` (
  `ORDER_ID` int(11) NOT NULL,
  `PRODUCT_ID` int(11) NOT NULL,
  `QUANTITY` int(11) NOT NULL,
  PRIMARY KEY (`ORDER_ID`,`PRODUCT_ID`),
  KEY `ORDER_DETAILS_PRODUCT_ID` (`PRODUCT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wa_papers`
--

CREATE TABLE IF NOT EXISTS `wa_papers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `AUTHOR_ID` int(11) NOT NULL COMMENT 'User ID of paper''s author',
  `REVIEWER_ID` int(11) NOT NULL COMMENT 'User ID of paper''s reviewer',
  `SUBAREA_ID` int(11) NOT NULL COMMENT 'ID from wa_subareas',
  `TITLE` varchar(50) NOT NULL,
  `DOCUMENT` tinyblob NOT NULL COMMENT 'Attach PDF/Word Doc',
  PRIMARY KEY (`ID`),
  KEY `AUTHOR_ID` (`AUTHOR_ID`,`REVIEWER_ID`,`SUBAREA_ID`),
  KEY `REVIEWER_ID` (`REVIEWER_ID`),
  KEY `AUTHOR_ID_2` (`AUTHOR_ID`),
  KEY `SUBAREA_ID` (`SUBAREA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wa_products`
--

CREATE TABLE IF NOT EXISTS `wa_products` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY` int(11) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  `DESCRIPTION` varchar(256) NOT NULL,
  `PRICE` float NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wa_product_categories`
--

CREATE TABLE IF NOT EXISTS `wa_product_categories` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY_NAME` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `CATEGORY_NAME` (`CATEGORY_NAME`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `wa_product_categories`
--

INSERT INTO `wa_product_categories` (`ID`, `CATEGORY_NAME`) VALUES
(9, 'Category 5'),
(12, 'Category 7'),
(13, 'category 8'),
(1, 'Test Category'),
(2, 'Test Category 3'),
(3, 'Test Category 4');

--
-- Triggers `wa_product_categories`
--
DROP TRIGGER IF EXISTS `PREV_BLANK_CAT_INSERT`;
DELIMITER //
CREATE TRIGGER `PREV_BLANK_CAT_INSERT` BEFORE INSERT ON `wa_product_categories`
 FOR EACH ROW BEGIN
	IF NEW.CATEGORY_NAME = '' THEN
		SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Blank values are not allowed';
    END IF;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `PREV_BLANK_CAT_UPDATE`;
DELIMITER //
CREATE TRIGGER `PREV_BLANK_CAT_UPDATE` BEFORE UPDATE ON `wa_product_categories`
 FOR EACH ROW BEGIN
	IF NEW.CATEGORY_NAME = '' THEN
		SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Blank values are not allowed';
    END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `wa_subareas`
--

CREATE TABLE IF NOT EXISTS `wa_subareas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PARENT_ID` int(11) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  `DESCRIPTION` varchar(256) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `PARENT_ID` (`PARENT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wa_users`
--

CREATE TABLE IF NOT EXISTS `wa_users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'AI User ID',
  `PW_HASH` varchar(40) NOT NULL COMMENT 'User PW SHA1 Hash',
  `FIRST_NAME` varchar(25) NOT NULL,
  `LAST_NAME` varchar(25) NOT NULL,
  `COMPANY` varchar(25) DEFAULT NULL,
  `ADDRESS_1` varchar(25) NOT NULL,
  `ADDRESS_2` varchar(25) DEFAULT NULL,
  `CITY` varchar(25) NOT NULL,
  `STATE` varchar(2) NOT NULL,
  `ZIP_CODE` varchar(10) NOT NULL,
  `PHONE_NUMBER` varchar(10) NOT NULL,
  `EMAIL` varchar(25) DEFAULT NULL COMMENT 'Required for login',
  `ADMIN` tinyint(1) NOT NULL DEFAULT '0',
  `ATTENDEE` tinyint(1) NOT NULL DEFAULT '0',
  `PRESENTER` tinyint(1) NOT NULL DEFAULT '0',
  `STUDENT` tinyint(1) NOT NULL DEFAULT '0',
  `REVIEWER` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `EMAIL` (`EMAIL`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Users of the WA Web App' AUTO_INCREMENT=29 ;

--
-- Dumping data for table `wa_users`
--

INSERT INTO `wa_users` (`ID`, `PW_HASH`, `FIRST_NAME`, `LAST_NAME`, `COMPANY`, `ADDRESS_1`, `ADDRESS_2`, `CITY`, `STATE`, `ZIP_CODE`, `PHONE_NUMBER`, `EMAIL`, `ADMIN`, `ATTENDEE`, `PRESENTER`, `STUDENT`, `REVIEWER`) VALUES
(1, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Kevin', 'Miller', 'company', '123 Main', 'Line2', 'MyCity', 'MY', '12345', '1234567890', 'a@a.com', 0, 1, 0, 0, 0),
(20, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Kevin', 'Miller', 'Comp', 'Add1', 'Add2', 'Mycity', 'MY', '12345', '1234567890', 'neither@a.com', 0, 1, 0, 0, 0),
(23, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Kevin', 'Miller', 'Comp', 'Add1', 'Add2', 'Mycity', 'MY', '12345', '1234567890', 'student@a.com', 0, 1, 0, 1, 0),
(26, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Kevin', 'Miller', 'Comp', 'Add1', 'Add2', 'Mycity', 'MY', '12345', '1234567890', 'presenter@a.com', 0, 1, 1, 0, 0),
(27, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Kevin', 'Miller', 'comp2', 'aDD1', 'Add2', 'A City', 'NY', '54321', '9876543210', 'b@b.com', 0, 1, 0, 0, 0),
(28, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Kevin', 'Miller', 'comp3', 'add1', 'add2', 'ciyu', 'ss', '65498', '1112223333', 'c@c.com', 0, 1, 0, 1, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wa_orders`
--
ALTER TABLE `wa_orders`
  ADD CONSTRAINT `ORDER_USER_ID` FOREIGN KEY (`CUSTOMER_ID`) REFERENCES `wa_users` (`ID`);

--
-- Constraints for table `wa_order_details`
--
ALTER TABLE `wa_order_details`
  ADD CONSTRAINT `ORDER_DETAILS+ORDER_ID` FOREIGN KEY (`ORDER_ID`) REFERENCES `wa_orders` (`ID`),
  ADD CONSTRAINT `ORDER_DETAILS_PRODUCT_ID` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `wa_products` (`ID`);

--
-- Constraints for table `wa_papers`
--
ALTER TABLE `wa_papers`
  ADD CONSTRAINT `FK_SUBAREA_SUBAREA` FOREIGN KEY (`SUBAREA_ID`) REFERENCES `wa_subareas` (`ID`),
  ADD CONSTRAINT `FK_USER_AUTHOR` FOREIGN KEY (`AUTHOR_ID`) REFERENCES `wa_users` (`ID`),
  ADD CONSTRAINT `FK_USER_REVEIWER` FOREIGN KEY (`REVIEWER_ID`) REFERENCES `wa_users` (`ID`);

--
-- Constraints for table `wa_subareas`
--
ALTER TABLE `wa_subareas`
  ADD CONSTRAINT `FK_AREA_SUBAREA` FOREIGN KEY (`PARENT_ID`) REFERENCES `wa_areas` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
