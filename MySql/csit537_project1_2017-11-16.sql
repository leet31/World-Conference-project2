-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2016 at 06:16 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `wa_areas`
--

INSERT INTO `wa_areas` (`ID`, `NAME`, `DESCRIPTION`) VALUES
(1, 'Cloud Computing', 'All areas of cloud computing...'),
(2, 'Internet of Things', 'A bunch of thinngs on the Internet'),
(3, 'Machine Learning', 'Machines that learn'),
(4, 'Complicated Stuff', 'Lorem ipsum evante'),
(5, 'Computer Security', ''),
(6, 'Artificial Intellige', ''),
(7, 'Software Engineering', ''),
(8, 'Mobile Computing', ''),
(9, 'Simulation and Model', '');

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
  `BALANCE` float NOT NULL,
  `ORDER_DATE` datetime NOT NULL,
  `ISPAID` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `CUSTOMER_ID` (`CUSTOMER_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `wa_orders`
--

INSERT INTO `wa_orders` (`ID`, `CUSTOMER_ID`, `BALANCE`, `ORDER_DATE`, `ISPAID`) VALUES
(1, 52, 60, '0000-00-00 00:00:00', 0),
(2, 52, 60, '0000-00-00 00:00:00', 0),
(3, 52, 60, '0000-00-00 00:00:00', 0),
(4, 52, 60, '0000-00-00 00:00:00', 0),
(5, 52, 60, '0000-00-00 00:00:00', 0),
(6, 52, 60, '0000-00-00 00:00:00', 0),
(7, 52, 80, '0000-00-00 00:00:00', 0),
(8, 52, 80, '0000-00-00 00:00:00', 0),
(9, 52, 80, '0000-00-00 00:00:00', 0),
(10, 52, 80, '0000-00-00 00:00:00', 0),
(11, 52, 80, '0000-00-00 00:00:00', 0),
(12, 52, 80, '0000-00-00 00:00:00', 0),
(13, 52, 80, '0000-00-00 00:00:00', 0),
(14, 52, 80, '0000-00-00 00:00:00', 0),
(15, 52, 80, '0000-00-00 00:00:00', 0),
(16, 52, 80, '0000-00-00 00:00:00', 0),
(17, 53, 600, '2016-11-16 17:34:44', 1),
(18, 53, 600, '2016-11-16 17:38:19', 1),
(19, 53, 0, '2016-11-16 17:42:21', 0),
(20, 53, 600, '2016-11-16 17:43:30', 1),
(21, 53, 0, '2016-11-16 17:44:52', 0),
(22, 53, 600, '2016-11-16 17:49:38', 1),
(23, 53, 600, '2016-11-16 18:12:16', 1);

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
  KEY `ORDER_DETAILS_PRODUCT_ID` (`PRODUCT_ID`),
  KEY `PRODUCT_ID` (`PRODUCT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wa_order_details`
--

INSERT INTO `wa_order_details` (`ORDER_ID`, `PRODUCT_ID`, `QUANTITY`) VALUES
(4, 6, 6),
(5, 6, 6),
(6, 6, 6),
(7, 5, 10),
(7, 6, 8),
(8, 5, 10),
(8, 6, 8),
(9, 5, 10),
(9, 6, 8),
(10, 5, 10),
(10, 6, 8),
(11, 5, 10),
(11, 6, 8),
(12, 5, 10),
(12, 6, 8),
(13, 5, 10),
(13, 6, 8),
(14, 5, 10),
(14, 6, 8),
(15, 5, 10),
(15, 6, 8),
(16, 5, 10),
(16, 6, 8),
(17, 16, 1),
(18, 16, 1),
(20, 16, 1),
(22, 16, 1),
(23, 16, 1);

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
  UNIQUE KEY `LOCAL_FILENAME` (`LOCAL_FILENAME`),
  KEY `AUTHOR_ID` (`AUTHOR_ID`,`REVIEWER_ID`,`SUBAREA_ID`),
  KEY `REVIEWER_ID` (`REVIEWER_ID`),
  KEY `AUTHOR_ID_2` (`AUTHOR_ID`),
  KEY `SUBAREA_ID` (`SUBAREA_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `wa_papers`
--

INSERT INTO `wa_papers` (`ID`, `AUTHOR_ID`, `REVIEWER_ID`, `SUBAREA_ID`, `TITLE`, `FILENAME`, `LOCAL_FILENAME`) VALUES
(26, 1, 44, 5, 'Title', 'ook.csv', 'php686.tmp'),
(27, 51, 44, 1, 'Title2', 'Where is the number seven.pdf', 'phpD97E.tmp'),
(28, 20, 46, 1, 'test', 'new  2.txt', 'phpBEB1.tmp'),
(29, 44, NULL, 3, 'hhhh', 'Where is the number seven.docx', 'phpA7B9.tmp'),
(30, 1, NULL, 3, 'jkjkj', 'empty.txt', 'php6BC3.tmp'),
(31, 46, 44, 6, '4 q''s', 'WU503 problems.pdf', 'phpCA8C.tmp'),
(36, 1, NULL, 1, 'Test from Main', 'qr_codes.csv', 'phpFE4.tmp'),
(39, 1, NULL, 9, 'Test from Main 2', 'U3D.pdf', 'php5FDB.tmp'),
(41, 1, NULL, 3, 'Test from Main 3', 'Make Patti LaBelle''s sweet potato pie recipe at home - TODAY.pdf', 'php321D.tmp'),
(42, 1, NULL, 3, 'Test from Main 3', 'Make Patti LaBelle''s sweet potato pie recipe at home - TODAY.pdf', 'phpF232.tmp'),
(43, 1, NULL, 3, 'Test from Main 3', 'Make Patti LaBelle''s sweet potato pie recipe at home - TODAY.pdf', 'php130B.tmp'),
(44, 52, NULL, 15, '123', 'CSIT 570-Fall-2016-Sy.pdf', 'phpE3E6.tmp');

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
  `IMG_NAME` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `PROD_CAT_NAME` (`CATEGORY`,`NAME`) COMMENT 'Prevent two products with same name and category',
  KEY `CATEGORY` (`CATEGORY`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `wa_products`
--

INSERT INTO `wa_products` (`ID`, `CATEGORY`, `NAME`, `DESCRIPTION`, `PRICE`, `IMG_NAME`) VALUES
(1, 9, 'Widget', 'a Nice Thing', 99.999, ''),
(2, 9, 'test 1', 'test', 11, 'default.png'),
(3, 9, 'qaz', '1qdsad', 11, 'default.png'),
(4, 9, 'test 2', '', 0, 'default.png'),
(5, 9, 'test 3', '', 0, 'default.png'),
(6, 12, 'test 4', 'test', 10, 'default.png'),
(7, 9, 'test 5', '11', 10, 'default.png'),
(8, 9, 'test 6', 'test', 11, 'default.png'),
(9, 9, 'test 7', 'test', 11, 'default.png'),
(10, 9, 'today 8', 'today', 1, '1479227829.png'),
(11, 9, 'internet security', 'internet security', 100, '1479228149.png'),
(12, 9, 'test 9', '1234567890', 12, ''),
(13, 9, 'book', 'book', 12, ''),
(14, 9, 'test 10', 'test', 12, '1479233732.png'),
(15, 9, 'Space saving table a', 'testersafdjfnadfnkdsafda', 10, '1479233797.png'),
(16, 14, 'No Discount', 'The regular fee with no discounts applied.', 600, '1479306940.png'),
(17, 14, 'Student Discount Onl', 'Regular attendace fee with Student discount only', 450, '1479310773.png'),
(18, 14, '2 Paper Discount Onl', 'Regular fee with two paper discount only', 300, '1479310898.png'),
(19, 14, 'Both Discounts', 'Both Student and 2 Paper Discounts', 275, '1479310984.png');

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
(14, 'Conference Fees'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `wa_subareas`
--

INSERT INTO `wa_subareas` (`ID`, `PARENT_ID`, `NAME`, `DESCRIPTION`) VALUES
(1, 1, 'Distributed Database', 'Databases in the cloud'),
(3, 1, 'Thunder', 'more stuff in clouds'),
(5, 2, 'Thunder', 'test of duplicate names with different parent'),
(6, 4, 'Quantum Engineering', 'How to build quantumness'),
(7, 5, 'Basic Cryptography', ''),
(8, 5, 'System Security', ''),
(9, 5, 'Firewalls and Networ', ''),
(10, 5, 'Mobile Code Security', ''),
(11, 6, 'Superintelligence', ''),
(12, 6, 'Intelligent behavior', ''),
(13, 6, 'Existential risk', ''),
(14, 7, 'Development Phases', ''),
(15, 7, 'Process Models', ''),
(16, 7, 'Software Testing & Q', ''),
(17, 8, 'SQLite Database', ''),
(18, 8, 'Implement Drawing & ', ''),
(19, 8, 'Interactive Format f', ''),
(20, 9, 'Statistics and Proba', ''),
(21, 9, 'Techniques for Sensi', ''),
(22, 9, '"What-if" Analysis T', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Users of the WA Web App' AUTO_INCREMENT=54 ;

--
-- Dumping data for table `wa_users`
--

INSERT INTO `wa_users` (`ID`, `PW_HASH`, `FIRST_NAME`, `LAST_NAME`, `COMPANY`, `ADDRESS_1`, `ADDRESS_2`, `CITY`, `STATE`, `ZIP_CODE`, `PHONE_NUMBER`, `EMAIL`, `ADMIN`, `ATTENDEE`, `PRESENTER`, `STUDENT`, `REVIEWER`) VALUES
(1, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Kevin', 'Miller', 'company', '123 Main', 'Line2', 'MyCity', 'MY', '12345', '1234567890', 'ksmiller99@gmail.com', 1, 0, 0, 0, 0),
(20, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Kevin', 'Miller', 'Comp', 'Add1', 'Add2', 'Mycity', 'MY', '12345', '1234567890', 'neither@ab.com', 1, 0, 0, 0, 0),
(44, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Kevin', 'Jones', 'Big', 'a1', 'a2', 'city', 'KY', '12345', '1234567890', 'hj@8.g', 1, 0, 0, 0, 0),
(46, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Bob', 'Riff', 'Comp', 'Add1', '', '', '', '', '', 'a@a.a', 0, 0, 0, 0, 0),
(51, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Bob', 'Riff', 'Comp', 'Add1', '', '', '', '', '', 'a@b.a', 0, 0, 0, 0, 0),
(52, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'admin', 'admin', '', 'MSU', '', 'montclair', 'NJ', '07070', '1234567890', 'admin@admin.com', 1, 1, 0, 0, 0),
(53, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'John', 'Doe', '', '31 Elm', '', 'Rangoon', 'IL', '07102', '1234567890', 'J@b.d', 0, 1, 0, 0, 0);

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
