-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 08, 2023 at 12:28 PM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

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

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `db_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `platform` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `root_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `project_name`, `db_name`, `platform`, `root_path`) VALUES
(4, 'Planet4Tech', 'planet4tech', 'laravel-9.x', 'D:\\wamp64\\www\\html\\inhouse\\planet4tech.com'),
(2, 'MeraJobs', 'merajobs_new', 'laravel-10-nice-admin', 'D:\\wamp64\\www\\html\\inhouse\\merajobs.in'),
(3, 'Pronero Billing', 'pronero_billing', 'laravel-10-nice-admin', 'C:\\wamp64\\www\\html\\inhouse\\billing.pronero.in'),
(5, 'Property Management', 'cybotiq_prop_mgmt', 'laravel-10-nice-admin', 'C:\\wamp64\\www\\html\\Cybotiq\\legacyreal.in\\backend'),
(6, 'Devaato', 'cybotiq_devaato', 'devaato', 'C:\\wamp64\\www\\html\\Cybotiq\\devaato.com\\backend');

-- --------------------------------------------------------

--
-- Table structure for table `project_module`
--

DROP TABLE IF EXISTS `project_module`;
CREATE TABLE IF NOT EXISTS `project_module` (
  `id` int NOT NULL AUTO_INCREMENT,
  `module` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `project_id` int NOT NULL,
  `controller_parent_class` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `base_model_suffix` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Base',
  `controller_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `model_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `view_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `route_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `module` (`module`,`project_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_module`
--

INSERT INTO `project_module` (`id`, `module`, `project_id`, `controller_parent_class`, `base_model_suffix`, `controller_path`, `model_path`, `view_path`, `route_path`) VALUES
(4, 'Admin', 4, 'App\\Custom\\Base\\Controller', 'Base', 'app/Http/Controllers', 'app/models', 'resources/views', NULL),
(2, 'Admin', 2, 'App\\Custom\\Base\\AdminController', 'Base', 'app/Http/Controllers', 'app/models', 'resources/views', NULL),
(3, 'Admin', 3, 'App\\Custom\\Base\\AdminController', 'Base', 'app/Http/Controllers', 'app/models', 'resources/views', NULL),
(5, 'Admin', 5, 'App\\Custom\\Base\\AdminController', 'Base', 'app/Http/Controllers', 'app/models', 'resources/views', NULL),
(6, 'Backend', 6, 'App\\Components\\AdminController', 'Base', 'app/Http/Controllers', 'app/Models', 'resources/views', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
