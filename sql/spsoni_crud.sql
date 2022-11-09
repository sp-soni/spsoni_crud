-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: spitech_crud
-- ------------------------------------------------------
-- Server version	5.7.36

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(100) NOT NULL,
  `db_name` varchar(100) NOT NULL,
  `platform` enum('codeigniter-3.x','laravel-8.x') NOT NULL DEFAULT 'laravel-8.x',
  `root_path` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (1,'Product-Ecom','u103431999_ecommv','laravel-8.x','C:\\wamp64\\www\\html\\products\\product_ecom'),(2,'Product-Billing-CI','product_billing_ci','codeigniter-3.x','C:\\wamp64\\www\\html\\products\\product_billing_ci'),(3,'Product-Broker-CI','u172594077_demobroker_ci','codeigniter-3.x','C:\\wamp64\\www\\html\\products\\product_broker_ci'),(4,'Product-HRMS','u172594077_demohrms','laravel-8.x','C:\\wamp64\\www\\html\\products\\product_hrms'),(5,'SPS-Accounting','u103431999_sps','codeigniter-3.x','C:\\wamp64\\www\\html\\products\\sps'),(6,'CityWalaDriver','u103431999_citywaladriver','codeigniter-3.x','C:\\wamp64\\www\\html\\citywaladriver.com');
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_module`
--

DROP TABLE IF EXISTS `project_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_module` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_module`
--

LOCK TABLES `project_module` WRITE;
/*!40000 ALTER TABLE `project_module` DISABLE KEYS */;
INSERT INTO `project_module` VALUES (1,'Admin',1,'App\\CustomComponents\\AdminAbstractController','Base','App\\Http\\Controllers\\Admin','app\\Models','resources\\views\\admin',''),(2,'Vendor',1,'App\\CustomComponents\\VendorAbstractController','Base','App\\Http\\Controllers\\Vendor','app\\Models','resources\\views\\vendor',''),(3,'Admin',2,'NA','Base','C:\\xampp\\htdocs\\practice\\products\\product_billing_ci\\app\\modules\\admin\\controllers','C:\\xampp\\htdocs\\practice\\products\\product_billing_ci\\app\\models','C:\\xampp\\htdocs\\practice\\products\\product_billing_ci\\app\\modules\\admin\\views',''),(4,'Admin',3,'NA','Base','D:\\wamp64\\www\\spsoni\\products\\product_broker_ci\\app\\modules\\admin\\controllers','D:\\wamp64\\www\\spsoni\\products\\product_broker_ci\\app\\models','D:\\wamp64\\www\\spsoni\\products\\product_broker_ci\\app\\modules\\admin\\views',''),(5,'Admin',4,'App\\CustomComponents\\AdminAbstractController','Base','Modules\\Admin\\Http\\Controllers','app\\Models','Modules\\Admin\\Resources\\views',''),(6,'Admin',5,'NA','Base','app\\modules\\admin\\controllers','app\\models','app\\modules\\admin\\views',''),(7,'Admin',6,'NA','Base','app\\modules\\admin\\controllers','app\\models','app\\modules\\admin\\views','');
/*!40000 ALTER TABLE `project_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'spitech_crud'
--
/*!50003 DROP FUNCTION IF EXISTS `column_exists` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `column_exists`(`table_name_IN` VARCHAR(100), `field_name_IN` VARCHAR(100)) RETURNS int(11)
RETURN (

    SELECT COUNT(COLUMN_NAME) 

    FROM INFORMATION_SCHEMA.columns 

    WHERE TABLE_SCHEMA = DATABASE() 

    AND TABLE_NAME = table_name_IN 

    AND COLUMN_NAME = field_name_IN

) ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `add_column_if_not_exists` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_column_if_not_exists`(IN `table_name_IN` VARCHAR(100), IN `field_name_IN` VARCHAR(100), IN `field_definition_IN` VARCHAR(100))
BEGIN



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



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `drop_column_if_exists` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `drop_column_if_exists`(`tname` VARCHAR(64), `cname` VARCHAR(64))
BEGIN

    IF column_exists(tname, cname)

    THEN

      SET @drop_column_if_exists = CONCAT('ALTER TABLE `', tname, '` DROP COLUMN `', cname, '`');

      PREPARE drop_query FROM @drop_column_if_exists;

      EXECUTE drop_query;

    END IF;

  END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-10 10:44:45
