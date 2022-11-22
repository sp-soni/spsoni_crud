-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Nov 17, 2022 at 09:25 PM
-- Server version: 10.9.4-MariaDB-1:10.9.4+maria~ubu2204
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spsoni_crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `db_name` varchar(100) NOT NULL,
  `platform` varchar(100) NOT NULL,
  `root_path` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `project_name`, `db_name`, `platform`, `root_path`) VALUES
(1, 'BBPL-PP-NEW', 'bbpl_payments', 'laravel-8.x-bbpl', '/var/www/html/pp_new');

-- --------------------------------------------------------

--
-- Table structure for table `project_module`
--

CREATE TABLE `project_module` (
  `id` int(11) NOT NULL,
  `module` varchar(50) NOT NULL,
  `project_id` int(11) NOT NULL,
  `controller_parent_class` varchar(250) NOT NULL,
  `base_model_suffix` varchar(50) NOT NULL DEFAULT 'Base',
  `controller_path` text NOT NULL,
  `model_path` text NOT NULL,
  `view_path` text NOT NULL,
  `route_path` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_module`
--

INSERT INTO `project_module` (`id`, `module`, `project_id`, `controller_parent_class`, `base_model_suffix`, `controller_path`, `model_path`, `view_path`, `route_path`) VALUES
(1, 'Admin', 1, 'AppBaseController', 'Base', 'app/Http/Controllers', 'app/models', 'resources/views', NULL);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `module` (`module`,`project_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `project_module`
--
ALTER TABLE `project_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
