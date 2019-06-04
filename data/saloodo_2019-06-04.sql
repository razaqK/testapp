# ************************************************************
# Sequel Pro SQL dump
# Version 5438
#
# https://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.26)
# Database: saloodo
# Generation Time: 2019-06-04 14:40:46 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table bundle_list
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bundle_list`;

CREATE TABLE `bundle_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bundle_id` int(11) unsigned DEFAULT NULL,
  `product_id` int(11) unsigned DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bundle_id` (`bundle_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `bundle_list_ibfk_1` FOREIGN KEY (`bundle_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `bundle_list_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `bundle_list` WRITE;
/*!40000 ALTER TABLE `bundle_list` DISABLE KEYS */;

INSERT INTO `bundle_list` (`id`, `bundle_id`, `product_id`, `status`, `created_at`, `updated_at`)
VALUES
	(1,NULL,4,'active','2019-06-03 05:32:35','2019-06-03 05:32:35'),
	(2,NULL,4,'active','2019-06-03 05:33:34','2019-06-03 05:33:34'),
	(3,NULL,4,'active','2019-06-03 05:36:27','2019-06-03 05:36:27'),
	(4,16,4,'active','2019-06-03 06:19:52','2019-06-03 06:19:52'),
	(5,17,4,'active','2019-06-03 06:32:55','2019-06-03 06:32:55'),
	(6,18,4,'active','2019-06-03 06:43:01','2019-06-03 06:43:01'),
	(7,19,4,'active','2019-06-03 06:44:03','2019-06-03 06:44:03'),
	(8,20,4,'active','2019-06-03 06:44:50','2019-06-03 06:44:50'),
	(9,21,4,'active','2019-06-03 06:45:49','2019-06-03 06:45:49'),
	(10,22,4,'active','2019-06-03 08:04:21','2019-06-03 08:04:21'),
	(11,23,4,'active','2019-06-03 08:05:10','2019-06-03 08:05:10'),
	(12,24,4,'active','2019-06-03 08:07:14','2019-06-03 08:07:14'),
	(13,25,25,'active','2019-06-03 08:15:14','2019-06-03 08:15:14'),
	(14,25,25,'active','2019-06-03 08:15:14','2019-06-03 08:15:14'),
	(15,25,25,'active','2019-06-03 08:15:14','2019-06-03 08:15:14'),
	(16,26,26,'active','2019-06-03 08:18:03','2019-06-03 08:18:03'),
	(17,26,26,'active','2019-06-03 08:18:03','2019-06-03 08:18:03'),
	(18,26,26,'active','2019-06-03 08:18:03','2019-06-03 08:18:03'),
	(19,27,9,'active','2019-06-03 08:29:01','2019-06-03 08:29:01'),
	(20,27,1,'active','2019-06-03 08:29:01','2019-06-03 08:29:01'),
	(21,27,4,'active','2019-06-03 08:29:01','2019-06-03 08:29:01');

/*!40000 ALTER TABLE `bundle_list` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table order_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order_items`;

CREATE TABLE `order_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `orders_id` int(11) unsigned DEFAULT NULL,
  `identifier` varchar(15) NOT NULL DEFAULT '',
  `product_id` int(11) unsigned DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;

INSERT INTO `order_items` (`id`, `orders_id`, `identifier`, `product_id`, `quantity`, `status`, `created_at`, `updated_at`)
VALUES
	(1,4,'GJSHOGHW74',NULL,3,'active','2019-06-04 06:00:44','2019-06-04 06:00:44'),
	(2,5,'VHTQ2U0L4W',NULL,3,'active','2019-06-04 06:01:27','2019-06-04 06:01:27'),
	(3,6,'6RI91F6NK4',1,3,'active','2019-06-04 06:05:54','2019-06-04 06:05:54'),
	(4,7,'3EXW24BD35',1,3,'active','2019-06-04 06:21:38','2019-06-04 06:21:38'),
	(5,8,'BXLXZ2HTO9',1,3,'active','2019-06-04 06:28:11','2019-06-04 06:28:11'),
	(6,9,'YAQURLRI9Q',1,3,'active','2019-06-04 06:29:24','2019-06-04 06:29:24'),
	(7,10,'I1C147N79G',1,3,'active','2019-06-04 06:30:00','2019-06-04 06:30:00'),
	(8,11,'QAGF5BFYXB',1,3,'active','2019-06-04 06:31:01','2019-06-04 06:31:01'),
	(9,12,'XQK1XNR0UE',1,2,'active','2019-06-04 06:38:46','2019-06-04 06:38:46'),
	(10,12,'XQK1XNR0UQ',1,2,'active','2019-06-04 06:38:46','2019-06-04 06:38:46');

/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(20) NOT NULL DEFAULT '',
  `total_price` decimal(15,2) NOT NULL,
  `customer_id` int(11) unsigned DEFAULT NULL,
  `status` enum('success','pending','processing','failed','deliveried') DEFAULT 'pending',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;

INSERT INTO `orders` (`id`, `identifier`, `total_price`, `customer_id`, `status`, `created_at`, `updated_at`)
VALUES
	(4,'W1RC5NFQM9',1470.00,NULL,'processing','2019-06-04 06:00:44','2019-06-04 06:00:44'),
	(5,'QNA45O9OC7',1470.00,NULL,'processing','2019-06-04 06:01:27','2019-06-04 06:01:27'),
	(6,'GDB0GE7L0A',1470.00,NULL,'processing','2019-06-04 06:05:54','2019-06-04 06:05:54'),
	(7,'WYFQGF7C0K',1470.00,2,'processing','2019-06-04 06:21:38','2019-06-04 06:21:38'),
	(8,'5FG015JTXY',1470.00,2,'processing','2019-06-04 06:28:11','2019-06-04 06:28:11'),
	(9,'A8K6R5M0Z6',1470.00,2,'processing','2019-06-04 06:29:24','2019-06-04 06:29:24'),
	(10,'DCTJ1853S1',1470.00,2,'processing','2019-06-04 06:30:00','2019-06-04 06:30:00'),
	(11,'S4QZX48YIH',1470.00,2,'processing','2019-06-04 06:31:01','2019-06-04 06:31:01'),
	(12,'QQOIUFZQLQ',980.00,2,'processing','2019-06-04 06:38:46','2019-06-04 06:38:46');

/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL DEFAULT '',
  `is_bundle` tinyint(1) NOT NULL DEFAULT '0',
  `amount` decimal(15,2) NOT NULL,
  `discounted_amount` decimal(15,2) DEFAULT NULL,
  `currency` char(3) NOT NULL DEFAULT '',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;

INSERT INTO `products` (`id`, `name`, `is_bundle`, `amount`, `discounted_amount`, `currency`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'add',0,500.00,490.00,'EUR',NULL,'2019-06-02 19:25:28','2019-06-02 19:25:28'),
	(2,'add',0,300.00,294.00,'EUR',NULL,'2019-06-02 19:28:10','2019-06-03 14:02:38'),
	(3,'add',0,500.00,490.00,'EUR',NULL,'2019-06-02 19:29:22','2019-06-02 19:29:22'),
	(4,'add',0,500.00,490.00,'EUR',NULL,'2019-06-02 19:30:06','2019-06-02 19:30:06'),
	(5,'product 1',0,500.00,490.00,'EUR','active','2019-06-03 04:55:39','2019-06-03 04:55:39'),
	(6,'product 1',0,500.00,490.00,'EUR','active','2019-06-03 05:14:36','2019-06-03 05:14:36'),
	(7,'product 1',1,500.00,490.00,'EUR','active','2019-06-03 05:27:25','2019-06-03 05:27:25'),
	(8,'product 1',1,500.00,490.00,'EUR','active','2019-06-03 05:28:12','2019-06-03 05:28:12'),
	(9,'product 1',1,500.00,490.00,'EUR','active','2019-06-03 05:28:58','2019-06-03 05:28:58'),
	(10,'product 1',1,500.00,490.00,'EUR','active','2019-06-03 05:30:29','2019-06-03 05:30:29'),
	(11,'product 1',1,500.00,490.00,'EUR','active','2019-06-03 05:32:35','2019-06-03 05:32:35'),
	(12,'product 2',1,500.00,490.00,'EUR','active','2019-06-03 05:33:34','2019-06-03 05:33:34'),
	(13,'product 2',1,500.00,490.00,'EUR','active','2019-06-03 05:36:27','2019-06-03 05:36:27'),
	(14,'product 2',1,500.00,490.00,'EUR','active','2019-06-03 05:46:30','2019-06-03 05:46:30'),
	(15,'product 2',1,500.00,490.00,'EUR','active','2019-06-03 05:49:11','2019-06-03 05:49:11'),
	(16,'product 2',1,500.00,490.00,'EUR','active','2019-06-03 06:19:52','2019-06-03 06:19:52'),
	(17,'product 2',1,500.00,490.00,'EUR','active','2019-06-03 06:32:55','2019-06-03 06:32:55'),
	(18,'product 3',1,500.00,490.00,'EUR','active','2019-06-03 06:43:01','2019-06-03 06:43:01'),
	(19,'product 3',1,500.00,490.00,'EUR','active','2019-06-03 06:44:03','2019-06-03 06:44:03'),
	(20,'product 3',1,500.00,490.00,'EUR','active','2019-06-03 06:44:50','2019-06-03 06:44:50'),
	(21,'product 3',1,500.00,490.00,'EUR','active','2019-06-03 06:45:49','2019-06-03 06:45:49'),
	(22,'product 3',1,500.00,490.00,'EUR','active','2019-06-03 08:04:21','2019-06-03 08:04:21'),
	(23,'product 3',1,500.00,490.00,'EUR','active','2019-06-03 08:05:10','2019-06-03 08:05:10'),
	(24,'product 3',1,500.00,490.00,'EUR','active','2019-06-03 08:07:14','2019-06-03 08:07:14'),
	(25,'product 3',1,500.00,490.00,'EUR','active','2019-06-03 08:15:14','2019-06-03 08:15:14'),
	(26,'product 4',1,500.00,490.00,'EUR','active','2019-06-03 08:18:03','2019-06-03 08:18:03'),
	(27,'product 4',1,500.00,490.00,'EUR','active','2019-06-03 08:29:01','2019-06-03 08:29:01');

/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(80) NOT NULL DEFAULT '',
  `password` varchar(120) NOT NULL DEFAULT '',
  `token` varchar(120) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `role` varchar(100) DEFAULT 'ROLE_USER',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `token`, `status`, `role`, `created_at`, `updated_at`)
VALUES
	(1,'test','user','testuser@test.com','$2b$10$piQp.XnfQg0.DUBzRWY4LO.aKm/CAH/LTxLbEngThv3diD.m05ita','94364024ef2941103ad8df4fbb0e6ffc','active','ROLE_ADMIN','2019-06-03 08:45:47','2019-06-03 23:07:42'),
	(2,'test','user1','testuser1@test.com','$2b$10$piQp.XnfQg0.DUBzRWY4LO.aKm/CAH/LTxLbEngThv3diD.m05ita','ad8df4fb943f2941103b0e664024effc','active','ROLE_USER','2019-06-03 08:45:47','2019-06-03 23:07:54');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
