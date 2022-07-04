-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 04, 2022 at 07:34 AM
-- Server version: 8.0.21
-- PHP Version: 7.4.9

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

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id` int NOT NULL AUTO_INCREMENT,
  `db_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `platform` enum('codeigniter-3.x','laravel-8.x') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'laravel-8.x',
  `base_model_suffix` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `controller_prefix` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `route_prefix` text COLLATE utf8mb4_general_ci NOT NULL,
  `project_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `controller_path` text COLLATE utf8mb4_general_ci NOT NULL,
  `model_path` text COLLATE utf8mb4_general_ci NOT NULL,
  `view_path` text COLLATE utf8mb4_general_ci NOT NULL,
  `route_path` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `db_name`, `platform`, `base_model_suffix`, `controller_prefix`, `route_prefix`, `project_name`, `controller_path`, `model_path`, `view_path`, `route_path`) VALUES
(1, 'u172594077_demoecom', 'laravel-8.x', 'Base', '', '', 'Product Ecom', 'D:\\wamp64\\www\\spsoni\\products\\product_ecom\\Modules\\Admin\\Http\\Controllers/', 'D:\\wamp64\\www\\spsoni\\products\\product_ecom\\app\\Models/', 'D:\\wamp64\\www\\spsoni\\products\\product_ecom\\Modules\\Admin\\Resources\\views/', ''),
(2, 'product_billing_ci', 'codeigniter-3.x', 'Base', 'Admin_', 'admin_', 'Product Billing CI', 'D:\\wamp64\\www\\spsoni\\products\\product_ecom\\Modules\\Admin\\Http\\Controllers/', 'D:\\wamp64\\www\\spsoni\\products\\product_ecom\\app\\Models/', 'D:\\wamp64\\www\\spsoni\\products\\product_ecom\\Modules\\Admin\\Resources\\views/', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
