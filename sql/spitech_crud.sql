-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 06, 2022 at 01:12 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spitech_crud`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `add_column_if_not_exists`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_column_if_not_exists` (IN `table_name_IN` VARCHAR(100), IN `field_name_IN` VARCHAR(100), IN `field_definition_IN` VARCHAR(100))  BEGIN

    SET @isFieldThere = column_exists(table_name_IN, field_name_IN);
    IF (@isFieldThere = 0) THEN

        SET @ddl = CONCAT('ALTER TABLE ', table_name_IN);
        SET @ddl = CONCAT(@ddl, ' ', 'ADD COLUMN') ;
        SET @ddl = CONCAT(@ddl, ' ', field_name_IN);
        SET @ddl = CONCAT(@ddl, ' ', field_definition_IN);

        PREPARE stmt FROM @ddl;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;

    END IF;

END$$

DROP PROCEDURE IF EXISTS `drop_column_if_exists`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `drop_column_if_exists` (`tname` VARCHAR(64), `cname` VARCHAR(64))  BEGIN
    IF column_exists(tname, cname)
    THEN
      SET @drop_column_if_exists = CONCAT('ALTER TABLE `', tname, '` DROP COLUMN `', cname, '`');
      PREPARE drop_query FROM @drop_column_if_exists;
      EXECUTE drop_query;
    END IF;
  END$$

--
-- Functions
--
DROP FUNCTION IF EXISTS `column_exists`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `column_exists` (`table_name_IN` VARCHAR(100), `field_name_IN` VARCHAR(100)) RETURNS INT(11) RETURN (
    SELECT COUNT(COLUMN_NAME) 
    FROM INFORMATION_SCHEMA.columns 
    WHERE TABLE_SCHEMA = DATABASE() 
    AND TABLE_NAME = table_name_IN 
    AND COLUMN_NAME = field_name_IN
)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(100) NOT NULL,
  `db_name` varchar(100) NOT NULL,
  `platform` enum('codeigniter-3.x','laravel-8.x') NOT NULL DEFAULT 'laravel-8.x',
  `root_path` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `project_name`, `db_name`, `platform`, `root_path`) VALUES
(1, 'Product-Ecom', 'u103431999_ecom_test', 'laravel-8.x', 'C:\\wamp64\\www\\html\\products\\product_ecom'),
(2, 'Product-Billing-CI', 'product_billing_ci', 'codeigniter-3.x', 'C:\\wamp64\\www\\html\\products\\product_billing_ci'),
(3, 'Product-Broker-CI', 'u172594077_demobroker_ci', 'codeigniter-3.x', 'C:\\wamp64\\www\\html\\products\\product_broker_ci'),
(4, 'Product-HRMS', 'u172594077_demohrms', 'laravel-8.x', 'C:\\wamp64\\www\\html\\products\\product_hrms'),
(5, 'SPS-Accounting', 'u103431999_sps', 'codeigniter-3.x', 'C:\\wamp64\\www\\html\\products\\sps'),
(6, 'CityWalaDriver', 'u103431999_citywaladriver', 'codeigniter-3.x', 'C:\\wamp64\\www\\html\\citywaladriver.com');

-- --------------------------------------------------------

--
-- Table structure for table `project_module`
--

DROP TABLE IF EXISTS `project_module`;
CREATE TABLE IF NOT EXISTS `project_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(50) NOT NULL,
  `project_id` int(11) NOT NULL,
  `controller_parent_class` varchar(250) NOT NULL,
  `base_model_suffix` varchar(50) NOT NULL,
  `controller_path` text NOT NULL,
  `model_path` text NOT NULL,
  `view_path` text NOT NULL,
  `route_path` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_module`
--

INSERT INTO `project_module` (`id`, `module`, `project_id`, `controller_parent_class`, `base_model_suffix`, `controller_path`, `model_path`, `view_path`, `route_path`) VALUES
(1, 'Admin', 1, 'App\\CustomComponents\\AdminAbstractController', 'Base', 'Modules\\Admin\\Http\\Controllers', 'app\\Models', 'Modules\\Admin\\Resources\\views', ''),
(2, 'Vendor', 1, 'App\\CustomComponents\\VendorAbstractController', 'Base', 'D:\\wamp64\\www\\spsoni\\products\\product_ecom\\Modules\\Vendor\\Http\\Controllers', 'D:\\wamp64\\www\\spsoni\\products\\product_ecom\\app\\Models', 'D:\\wamp64\\www\\spsoni\\products\\product_ecom\\Modules\\Vendor\\Resources\\views', ''),
(3, 'Admin', 2, 'NA', 'Base', 'C:\\xampp\\htdocs\\practice\\products\\product_billing_ci\\app\\modules\\admin\\controllers', 'C:\\xampp\\htdocs\\practice\\products\\product_billing_ci\\app\\models', 'C:\\xampp\\htdocs\\practice\\products\\product_billing_ci\\app\\modules\\admin\\views', ''),
(4, 'Admin', 3, 'NA', 'Base', 'D:\\wamp64\\www\\spsoni\\products\\product_broker_ci\\app\\modules\\admin\\controllers', 'D:\\wamp64\\www\\spsoni\\products\\product_broker_ci\\app\\models', 'D:\\wamp64\\www\\spsoni\\products\\product_broker_ci\\app\\modules\\admin\\views', ''),
(5, 'Admin', 4, 'App\\CustomComponents\\AdminAbstractController', 'Base', 'Modules\\Admin\\Http\\Controllers', 'app\\Models', 'Modules\\Admin\\Resources\\views', ''),
(6, 'Admin', 5, 'NA', 'Base', 'app\\modules\\admin\\controllers', 'app\\models', 'app\\modules\\admin\\views', ''),
(7, 'Admin', 6, 'NA', 'Base', 'app\\modules\\admin\\controllers', 'app\\models', 'app\\modules\\admin\\views', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
