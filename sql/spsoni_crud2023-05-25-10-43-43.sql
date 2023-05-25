DROP TABLE IF EXISTS `project`;

CREATE TABLE `project` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `db_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `platform` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `root_path` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO project VALUES
("1","BBPL-PP-NEW","bbpl_payments","laravel-8.x-bbpl","/var/www/html/pp_new"),
("2","MeraJobs","merajobs_new","laravel-10-nice-admin","D:\\wamp64\\www\\html\\merajobs.in"),
("3","Pronero Billing","u112224359_billing","laravel-10-nice-admin","D:\\wamp64\\www\\html\\billing.pronero.in");


DROP TABLE IF EXISTS `project_module`;

CREATE TABLE `project_module` (
  `id` int NOT NULL AUTO_INCREMENT,
  `module` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `project_id` int NOT NULL,
  `controller_parent_class` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `base_model_suffix` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Base',
  `controller_path` text COLLATE utf8mb4_general_ci NOT NULL,
  `model_path` text COLLATE utf8mb4_general_ci NOT NULL,
  `view_path` text COLLATE utf8mb4_general_ci NOT NULL,
  `route_path` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `module` (`module`,`project_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO project_module VALUES
("1","Admin","1","AppBaseController","Base","app/Http/Controllers","app/models","resources/views",""),
("2","Admin","2","App\\Custom\\Base\\AdminController","Base","app/Http/Controllers","app/models","resources/views",""),
("3","Admin","3","App\\Custom\\Base\\AdminController","Base","app/Http/Controllers","app/models","resources/views","");


