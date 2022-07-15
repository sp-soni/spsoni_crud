-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2022 at 10:17 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

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

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `db_name` varchar(100) NOT NULL,
  `platform` enum('codeigniter-3.x','laravel-8.x') NOT NULL DEFAULT 'laravel-8.x',
  `root_path` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `project_name`, `db_name`, `platform`, `root_path`) VALUES
(1, 'Product-Ecom', 'u103431999_ecom_test', 'laravel-8.x', ''),
(2, 'Product-Billing-CI', 'product_billing_ci', 'codeigniter-3.x', ''),
(3, 'Product-Broker-CI', 'u172594077_demobroker_ci', 'codeigniter-3.x', ''),
(4, 'Product-HRMS', 'u172594077_demohrms', 'laravel-8.x', 'C:\\xampp\\htdocs\\practice\\products\\product_hrms');

-- --------------------------------------------------------

--
-- Table structure for table `project_module`
--

CREATE TABLE `project_module` (
  `id` int(11) NOT NULL,
  `module` varchar(50) NOT NULL,
  `project_id` int(11) NOT NULL,
  `controller_parent_class` varchar(250) NOT NULL,
  `base_model_suffix` varchar(50) NOT NULL,
  `controller_path` text NOT NULL,
  `model_path` text NOT NULL,
  `view_path` text NOT NULL,
  `route_path` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_module`
--

INSERT INTO `project_module` (`id`, `module`, `project_id`, `controller_parent_class`, `base_model_suffix`, `controller_path`, `model_path`, `view_path`, `route_path`) VALUES
(1, 'Admin', 1, 'App\\CustomComponents\\AdminAbstractController', 'Base', 'D:\\wamp64\\www\\spsoni\\products\\product_ecom\\Modules\\Admin\\Http\\Controllers', 'D:\\wamp64\\www\\spsoni\\products\\product_ecom\\app\\Models', 'D:\\wamp64\\www\\spsoni\\products\\product_ecom\\Modules\\Admin\\Resources\\views', ''),
(2, 'Vendor', 1, 'App\\CustomComponents\\VendorAbstractController', 'Base', 'D:\\wamp64\\www\\spsoni\\products\\product_ecom\\Modules\\Vendor\\Http\\Controllers', 'D:\\wamp64\\www\\spsoni\\products\\product_ecom\\app\\Models', 'D:\\wamp64\\www\\spsoni\\products\\product_ecom\\Modules\\Vendor\\Resources\\views', ''),
(3, 'Admin', 2, 'NA', 'Base', 'C:\\xampp\\htdocs\\practice\\products\\product_billing_ci\\app\\modules\\admin\\controllers', 'C:\\xampp\\htdocs\\practice\\products\\product_billing_ci\\app\\models', 'C:\\xampp\\htdocs\\practice\\products\\product_billing_ci\\app\\modules\\admin\\views', ''),
(4, 'Admin', 3, 'NA', 'Base', 'D:\\wamp64\\www\\spsoni\\products\\product_broker_ci\\app\\modules\\admin\\controllers', 'D:\\wamp64\\www\\spsoni\\products\\product_broker_ci\\app\\models', 'D:\\wamp64\\www\\spsoni\\products\\product_broker_ci\\app\\modules\\admin\\views', ''),
(5, 'Admin', 4, 'App\\CustomComponents\\AdminAbstractController', 'Base', 'Modules\\Admin\\Http\\Controllers', 'app\\Models', 'Modules\\Admin\\Resources\\views', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_module`
--
ALTER TABLE `project_module`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `project_module`
--
ALTER TABLE `project_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
