
-- FUNCTION column_exists

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `column_exists`(table_name_IN VARCHAR(100), field_name_IN VARCHAR(100)) RETURNS int
RETURN (
    SELECT COUNT(COLUMN_NAME) 
    FROM INFORMATION_SCHEMA.columns 
    WHERE TABLE_SCHEMA = DATABASE() 
    AND TABLE_NAME = table_name_IN 
    AND COLUMN_NAME = field_name_IN
)$$
DELIMITER ;


-- PROCEDURE add_column_if_not_exists

DELIMITER $$
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

END$$
DELIMITER ;


-- PROCEDURE drop_column_if_exists

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `drop_column_if_exists`(
  tname VARCHAR(64),
  cname VARCHAR(64)
)
BEGIN
    IF column_exists(tname, cname)
    THEN
      SET @drop_column_if_exists = CONCAT('ALTER TABLE `', tname, '` DROP COLUMN `', cname, '`');
      PREPARE drop_query FROM @drop_column_if_exists;
      EXECUTE drop_query;
    END IF;
  END$$
DELIMITER ;
