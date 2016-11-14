-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2016 at 04:05 AM
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

DROP TABLE IF EXISTS `wa_areas`;
CREATE TABLE IF NOT EXISTS `wa_areas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(20) NOT NULL,
  `DESCRIPTION` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `NAME` (`NAME`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `wa_areas`
--

INSERT INTO `wa_areas` (`ID`, `NAME`, `DESCRIPTION`) VALUES
(1, 'Cloud Computing', 'All areas of cloud computing...'),
(2, 'Internet of Things', 'A bunch of thinngs on the Internet'),
(3, 'Machine Learning', 'Machines that learn'),
(4, 'Complicated Stuff', 'Lorem ipsum evante');

-- --------------------------------------------------------

--
-- Table structure for table `wa_book_details`
--

DROP TABLE IF EXISTS `wa_book_details`;
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

DROP TABLE IF EXISTS `wa_orders`;
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

DROP TABLE IF EXISTS `wa_order_details`;
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

DROP TABLE IF EXISTS `wa_papers`;
CREATE TABLE IF NOT EXISTS `wa_papers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `AUTHOR_ID` int(11) NOT NULL COMMENT 'User ID of paper''s author',
  `REVIEWER_ID` int(11) DEFAULT NULL COMMENT 'User ID of paper''s reviewer',
  `SUBAREA_ID` int(11) NOT NULL COMMENT 'ID from wa_subareas',
  `TITLE` varchar(50) NOT NULL,
  `FILENAME` varchar(255) NOT NULL,
  `LOCAL_FILENAME` varchar(255) NOT NULL COMMENT 'File name on server',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `DOC_FILENAME` (`FILENAME`),
  UNIQUE KEY `LOCAL_FILENAME` (`LOCAL_FILENAME`),
  KEY `AUTHOR_ID` (`AUTHOR_ID`,`REVIEWER_ID`,`SUBAREA_ID`),
  KEY `REVIEWER_ID` (`REVIEWER_ID`),
  KEY `AUTHOR_ID_2` (`AUTHOR_ID`),
  KEY `SUBAREA_ID` (`SUBAREA_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `wa_papers`
--

INSERT INTO `wa_papers` (`ID`, `AUTHOR_ID`, `REVIEWER_ID`, `SUBAREA_ID`, `TITLE`, `FILENAME`, `LOCAL_FILENAME`) VALUES
(26, 1, 44, 5, 'Title', 'ook.csv', 'php686.tmp'),
(27, 51, 44, 1, 'Title2', 'Where is the number seven.pdf', 'phpD97E.tmp'),
(28, 20, 46, 1, 'test', 'new  2.txt', 'phpBEB1.tmp'),
(29, 44, NULL, 3, 'hhhh', 'Where is the number seven.docx', 'phpA7B9.tmp'),
(30, 1, NULL, 3, 'jkjkj', 'empty.txt', 'php6BC3.tmp'),
(31, 46, 44, 6, '4 q''s', 'WU503 problems.pdf', 'phpCA8C.tmp');

-- --------------------------------------------------------

--
-- Table structure for table `wa_products`
--

DROP TABLE IF EXISTS `wa_products`;
CREATE TABLE IF NOT EXISTS `wa_products` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY` int(11) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  `DESCRIPTION` varchar(256) NOT NULL,
  `PRICE` float NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `CATEGORY` (`CATEGORY`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `wa_products`
--

INSERT INTO `wa_products` (`ID`, `CATEGORY`, `NAME`, `DESCRIPTION`, `PRICE`) VALUES
(1, 9, 'Widget', 'a Nice Thing', 99.999);

-- --------------------------------------------------------

--
-- Table structure for table `wa_product_categories`
--

DROP TABLE IF EXISTS `wa_product_categories`;
CREATE TABLE IF NOT EXISTS `wa_product_categories` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY_NAME` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `CATEGORY_NAME` (`CATEGORY_NAME`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

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

DROP TABLE IF EXISTS `wa_subareas`;
CREATE TABLE IF NOT EXISTS `wa_subareas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PARENT_ID` int(11) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  `DESCRIPTION` varchar(256) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `SUBAREA_NAME_PARENT` (`PARENT_ID`,`NAME`) COMMENT 'Prevent duplicate subareas',
  KEY `PARENT_ID` (`PARENT_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `wa_subareas`
--

INSERT INTO `wa_subareas` (`ID`, `PARENT_ID`, `NAME`, `DESCRIPTION`) VALUES
(1, 1, 'Distributed Database', 'Databases in the cloud'),
(3, 1, 'Thunder', 'more stuff in clouds'),
(5, 2, 'Thunder', 'test of duplicate names with different parent'),
(6, 4, 'Quantum Engineering', 'How to build quantumness');

-- --------------------------------------------------------

--
-- Table structure for table `wa_users`
--

DROP TABLE IF EXISTS `wa_users`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Users of the WA Web App' AUTO_INCREMENT=52 ;

--
-- Dumping data for table `wa_users`
--

INSERT INTO `wa_users` (`ID`, `PW_HASH`, `FIRST_NAME`, `LAST_NAME`, `COMPANY`, `ADDRESS_1`, `ADDRESS_2`, `CITY`, `STATE`, `ZIP_CODE`, `PHONE_NUMBER`, `EMAIL`, `ADMIN`, `ATTENDEE`, `PRESENTER`, `STUDENT`, `REVIEWER`) VALUES
(1, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Kevin', 'Miller', 'company', '123 Main', 'Line2', 'MyCity', 'MY', '12345', '1234567890', 'ksmiller99@gmail.com', 1, 1, 0, 0, 0),
(20, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Kevin', 'Miller', 'Comp', 'Add1', 'Add2', 'Mycity', 'MY', '12345', '1234567890', 'neither@ab.com', 1, 0, 0, 0, 0),
(44, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Kevin', 'Jones', 'Big', 'a1', 'a2', 'city', 'KY', '12345', '1234567890', 'hj@8.g', 1, 0, 0, 0, 0),
(46, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Bob', 'Riff', 'Comp', 'Add1', '', '', '', '', '', 'a@a.a', 0, 0, 0, 0, 0),
(51, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Bob', 'Riff', 'Comp', 'Add1', '', '', '', '', '', 'a@b.a', 0, 0, 0, 0, 0);

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
-- Constraints for table `wa_products`
--
ALTER TABLE `wa_products`
  ADD CONSTRAINT `FK_PRODCAT_ID_CATEGORY` FOREIGN KEY (`CATEGORY`) REFERENCES `wa_product_categories` (`ID`);

--
-- Constraints for table `wa_subareas`
--
ALTER TABLE `wa_subareas`
  ADD CONSTRAINT `FK_AREA_SUBAREA` FOREIGN KEY (`PARENT_ID`) REFERENCES `wa_areas` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
