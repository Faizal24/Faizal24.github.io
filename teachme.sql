# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.54-0ubuntu0.14.04.1)
# Database: admin_teachme
# Generation Time: 2017-02-03 08:19:33 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table _charts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `_charts`;

CREATE TABLE `_charts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `style` text,
  `order` decimal(20,2) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `filters` text,
  `order_limit` text,
  `from` varchar(255) DEFAULT NULL,
  `x_axis` varchar(255) DEFAULT NULL,
  `x_labels` varchar(255) DEFAULT NULL,
  `x_precision` varchar(255) DEFAULT NULL,
  `y_axis` varchar(255) DEFAULT NULL,
  `y_labels` varchar(255) DEFAULT NULL,
  `y_precision` varchar(255) DEFAULT NULL,
  `dimensions` text,
  `span` varchar(255) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `height` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `_charts` WRITE;
/*!40000 ALTER TABLE `_charts` DISABLE KEYS */;

INSERT INTO `_charts` (`id`, `style`, `order`, `type`, `title`, `filters`, `order_limit`, `from`, `x_axis`, `x_labels`, `x_precision`, `y_axis`, `y_labels`, `y_precision`, `dimensions`, `span`, `prefix`, `suffix`, `height`)
VALUES
	(1,'text-align: center; margin: 20px',1.00,'heading','Dashboard',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(15,NULL,1.50,'pie','Parent Account Status','`type` = \'parent\'',NULL,'users','status',NULL,NULL,'COUNT(`id`)',NULL,NULL,NULL,'1-2',NULL,NULL,NULL),
	(72,NULL,1.10,'figure','Registered Parents','`type` = \'parent\'',NULL,'users','COUNT(`id`)',NULL,'0',NULL,NULL,NULL,NULL,'1-3',NULL,NULL,NULL),
	(73,NULL,1.20,'figure','Registered Tutors','`type` = \'tutor\'',NULL,'users','COUNT(`id`)',NULL,'0',NULL,NULL,NULL,NULL,'1-3',NULL,NULL,NULL),
	(74,NULL,1.30,'figure','Total Registered','`type` = \'parent\' OR `type` = \'tutor\'',NULL,'users','COUNT(`id`)',NULL,'0',NULL,NULL,NULL,NULL,'1-3',NULL,NULL,NULL),
	(75,NULL,1.40,'bar','Tutor By Gender','',NULL,'tutor_profile','gender','',NULL,'COUNT(`id`)',NULL,NULL,NULL,'1-2',NULL,NULL,NULL),
	(76,NULL,1.40,'bar','Tutor By State','',NULL,'tutor_profile','state','',NULL,'COUNT(`id`)',NULL,NULL,NULL,'1-2',NULL,NULL,NULL),
	(77,NULL,1.50,'pie','Tutor Account Status','`type` = \'tutor\'',NULL,'users','status',NULL,NULL,'COUNT(`id`)',NULL,NULL,NULL,'1-2',NULL,NULL,NULL),
	(78,NULL,1.50,'pie','Tutor by Subjects','',NULL,'tutor_subjects','subject',NULL,NULL,'COUNT(`id`)',NULL,NULL,NULL,'1-2',NULL,NULL,NULL),
	(79,NULL,1.50,'pie','Tutor by Grade','',NULL,'tutor_subjects','grade',NULL,NULL,'COUNT(`id`)',NULL,NULL,NULL,'1-2',NULL,NULL,NULL),
	(80,NULL,1.41,'table','Top 10 Cities',NULL,NULL,'tutor_profile','city',NULL,NULL,'COUNT(`id`)',NULL,NULL,NULL,'1',NULL,NULL,NULL),
	(81,NULL,2.00,'figure','Tutor Requests','',NULL,'job_requests','COUNT(`id`)',NULL,'0',NULL,NULL,NULL,NULL,'1-4',NULL,NULL,NULL),
	(82,NULL,2.20,'figure','Confirmed Requests','`status` = \'Pending Payment\'',NULL,'job_requests','COUNT(`id`)',NULL,'0',NULL,NULL,NULL,NULL,'1-4',NULL,NULL,NULL),
	(83,NULL,2.30,'figure','Hired / Paid','`status` = \'Hired\'',NULL,'job_requests','COUNT(`id`)',NULL,'0',NULL,NULL,NULL,NULL,'1-4',NULL,NULL,NULL),
	(84,NULL,2.10,'figure','Awaiting Response','`status` = \'Awaiting Confirmation\'',NULL,'job_requests','COUNT(`id`)',NULL,'0',NULL,NULL,NULL,NULL,'1-4',NULL,NULL,NULL),
	(85,'text-align: center; margin: 20px',1.99,'heading','Matching',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(86,NULL,2.30,'figure','Payable to Tutor (MYR)','',NULL,'job_orders','SUM(`amount_payable`)',NULL,'2',NULL,NULL,NULL,NULL,'1-3',NULL,NULL,NULL),
	(87,NULL,2.30,'figure','Paid Out (MYR)','',NULL,'job_orders','0',NULL,'2',NULL,NULL,NULL,NULL,'1-3',NULL,NULL,NULL),
	(88,NULL,2.30,'figure','MaiTutor Commissions (MYR)','',NULL,'job_orders','SUM(`amount_commission`)',NULL,'2',NULL,NULL,NULL,NULL,'1-3',NULL,NULL,NULL),
	(89,'text-align: center; margin: 20px',2.99,'heading','Sessions',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(90,NULL,3.00,'figure','Scheduled Sessions','',NULL,'tutor_sessions','COUNT(`id`)',NULL,'0',NULL,NULL,NULL,NULL,'1-2',NULL,NULL,NULL),
	(91,NULL,3.00,'figure','Completed Sessions','`status` = \'Completed\'',NULL,'tutor_sessions','COUNT(`id`)',NULL,'0',NULL,NULL,NULL,NULL,'1-2',NULL,NULL,NULL);

/*!40000 ALTER TABLE `_charts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table commission_tiering
# ------------------------------------------------------------

DROP TABLE IF EXISTS `commission_tiering`;

CREATE TABLE `commission_tiering` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `config` varchar(255) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table conversation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `conversation`;

CREATE TABLE `conversation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(11) DEFAULT NULL,
  `from` varchar(255) DEFAULT NULL,
  `to` varchar(255) DEFAULT NULL,
  `message` text,
  `datetime` datetime DEFAULT NULL,
  `seen` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `from` (`from`),
  KEY `uid` (`uid`),
  KEY `to` (`to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table conversation_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `conversation_sessions`;

CREATE TABLE `conversation_sessions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `from` varchar(255) DEFAULT NULL,
  `to` varchar(255) DEFAULT NULL,
  `last_message` text,
  `last_sender` text,
  `last_seen` datetime DEFAULT NULL,
  `seen` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table devices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `devices`;

CREATE TABLE `devices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `api_key` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table invoices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `invoices`;

CREATE TABLE `invoices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` date DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `job_order_id` int(11) DEFAULT NULL,
  `amount_tax` decimal(20,2) DEFAULT NULL,
  `amount_payable` decimal(20,2) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_email` (`user_email`),
  KEY `job_order_id` (`job_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table job_orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `job_orders`;

CREATE TABLE `job_orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `job_request_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `payment_metadata` longtext,
  `payment_gateway` varchar(255) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `amount_payable` decimal(20,2) DEFAULT NULL,
  `amount_tax` decimal(20,2) DEFAULT NULL,
  `amount_commission` decimal(20,2) DEFAULT NULL,
  `message` longtext,
  `payout_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `job_request_id` (`job_request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `job_orders` WRITE;
/*!40000 ALTER TABLE `job_orders` DISABLE KEYS */;

INSERT INTO `job_orders` (`id`, `job_request_id`, `status`, `payment_status`, `payment_metadata`, `payment_gateway`, `datetime`, `amount_payable`, `amount_tax`, `amount_commission`, `message`, `payout_status`)
VALUES
	(3,1,'Pending','Unpaid',NULL,NULL,'2016-12-16 00:27:22',0.00,0.00,0.00,'',NULL);

/*!40000 ALTER TABLE `job_orders` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table job_requests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `job_requests`;

CREATE TABLE `job_requests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `request_from` varchar(255) DEFAULT NULL,
  `request_to` varchar(255) DEFAULT NULL,
  `request_data` longtext,
  `remarks` longtext,
  `datetime` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `request_from` (`request_from`),
  KEY `request_to` (`request_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `job_requests` WRITE;
/*!40000 ALTER TABLE `job_requests` DISABLE KEYS */;

INSERT INTO `job_requests` (`id`, `request_from`, `request_to`, `request_data`, `remarks`, `datetime`, `status`)
VALUES
	(1,'parent@plexsol.com','tutor@plexsol.com','{\"subject\":\"Mathematics\",\"rate\":\"5000\",\"grade\":\"Std 1-3\",\"hours\":\"2 hours\",\"sessions\":\"5\",\"student_name\":\"Shafiq\",\"student_age\":\"12\",\"student_gender\":\"Male\",\"address1\":\"41 Lrg Indah\",\"city\":\"Bukit Mertajam\"}',NULL,'2016-12-15 23:56:47','Hired'),
	(2,'parent@plexsol.com','tutor2@plexsol.com','{\"subject\":\"Mathematics\",\"rate\":\"3000\",\"grade\":\"Std 1-3\",\"hours\":\"1.5 hours\",\"sessions\":\"5\",\"student_name\":\"shafiq\",\"student_age\":\"10\",\"student_gender\":\"Male\",\"address1\":\"adsad asdasdsa\",\"city\":\"Bukit Mertajam\"}',NULL,'2017-01-05 07:34:47','Pending Payment');

/*!40000 ALTER TABLE `job_requests` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table message_alerts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `message_alerts`;

CREATE TABLE `message_alerts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sender_user_email` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_email` varchar(150) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `to_email` varchar(150) DEFAULT NULL,
  `to_name` varchar(255) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `sponsor_id` int(11) DEFAULT NULL,
  `message` longtext,
  `datetime` datetime DEFAULT NULL,
  `seen` int(1) DEFAULT NULL,
  `seen_time` datetime DEFAULT NULL,
  `chat_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table notes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notes`;

CREATE TABLE `notes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `note` longtext,
  `datetime` datetime DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `added_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table notifications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) DEFAULT NULL,
  `message` text,
  `url` text,
  `datetime` datetime DEFAULT NULL,
  `seen` int(1) DEFAULT NULL,
  `from_user` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;

INSERT INTO `notifications` (`id`, `user_email`, `message`, `url`, `datetime`, `seen`, `from_user`)
VALUES
	(1,'tutor@plexsol.com','<strong>Ahmad Albab</strong> has requested to hire you','tutor/request_details/1','2016-12-15 23:56:47',1,'parent@plexsol.com'),
	(2,'parent@plexsol.com','<strong>Shafiq Rizwan</strong> has accepted your request!','mytutor/details/1','2016-12-15 23:58:22',1,'tutor@plexsol.com'),
	(3,NULL,'<strong> </strong> has hired you','tutor/request_details/1','2016-12-16 00:20:35',NULL,NULL),
	(4,NULL,'<strong> </strong> has hired you','tutor/request_details/1','2016-12-16 00:23:56',NULL,NULL),
	(5,'tutor2@plexsol.com','<strong>Parent One</strong> has requested to hire you','tutor/request_details/2','2017-01-05 07:34:47',NULL,'parent@plexsol.com'),
	(6,'parent@plexsol.com','<strong>Sarah Aliya</strong> has accepted your request!','mytutor/details/2','2017-01-05 07:36:23',1,'tutor2@plexsol.com');

/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qa
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qa`;

CREATE TABLE `qa` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `set` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `question` text,
  `answers` longtext,
  `has_correct_answer` int(1) DEFAULT NULL,
  `correct_answer` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `qa` WRITE;
/*!40000 ALTER TABLE `qa` DISABLE KEYS */;

INSERT INTO `qa` (`id`, `set`, `number`, `question`, `answers`, `has_correct_answer`, `correct_answer`)
VALUES
	(1,'tutor_signup','1','Have you ever been a teacher?','[\"Yes\",\"No\"]',NULL,NULL),
	(2,'tutor_signup','2','How many years of tutoring experience do you have?','[\"0\",\"1\",\"2-4\",\"5-10\",\"10+\"]',NULL,NULL),
	(3,'tutor_signup','3','Which type of students do you like to tutor?','[\"Elementary\",\"MIddle School\",\"High School\",\"College\",\"Adult\"]',NULL,NULL),
	(4,'tutor_signup','4','Where do you prefer having lessons?','[\"Student\'s Location\",\"Coffee Shop\",\"Library\",\"Location I select\",\"Online\"]',NULL,NULL),
	(5,'tutor_signup','5','Which of these do you find rewarding?','[\"Improving your student\'s grades\",\"Helping students get ahead\",\"Giving a student confidence to succeed\",\"Providing test prep\",\"Teaching a hobby\"]',NULL,NULL),
	(6,'tutor_signup','6','Do you have access to a car?','[\"Yes\",\"No\"]',NULL,NULL),
	(7,'tutor_signup','7','Are you interested in online tutoring?','[\"Yes\",\"No\"]',NULL,NULL),
	(8,'tutor_signup','8','How many hours per week do you currently tutor outside of MyTutor?','[\"0\",\"1-5\",\"6-10\",\"11-20\",\"21-35\",\"35+\"]',NULL,NULL),
	(9,'Mathematics|Std 1-3','1','What is 1 + 1?','[\"1\",\"2\",\"3\",\"4\"]',1,'2');

/*!40000 ALTER TABLE `qa` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qa_responses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qa_responses`;

CREATE TABLE `qa_responses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `set` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `answer` text,
  `datetime` datetime DEFAULT NULL,
  `correct` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `qa_responses` WRITE;
/*!40000 ALTER TABLE `qa_responses` DISABLE KEYS */;

INSERT INTO `qa_responses` (`id`, `set`, `user_email`, `number`, `answer`, `datetime`, `correct`)
VALUES
	(20,'tutor_signup','abc@def.com',1,'No','2016-09-15 13:39:34',NULL),
	(21,'tutor_signup','abc@def.com',2,'2-4','2016-09-15 13:39:34',NULL),
	(22,'tutor_signup','abc@def.com',3,'MIddle School','2016-09-15 13:39:34',NULL),
	(23,'tutor_signup','abc@def.com',4,'Library','2016-09-15 13:39:34',NULL),
	(24,'tutor_signup','abc@def.com',5,'Teaching a hobby','2016-09-15 13:39:34',NULL),
	(25,'tutor_signup','abc@def.com',6,'No','2016-09-15 13:39:34',NULL),
	(26,'tutor_signup','abc@def.com',7,'No','2016-09-15 13:39:34',NULL),
	(27,'tutor_signup','abc@def.com',8,'6-10','2016-09-15 13:39:34',NULL),
	(44,'tutor_signup','sha@fiq.com',1,'No','2016-09-30 15:13:18',0),
	(45,'tutor_signup','sha@fiq.com',2,'2-4','2016-09-30 15:13:18',0),
	(46,'tutor_signup','sha@fiq.com',3,'Adult','2016-09-30 15:13:18',0),
	(47,'tutor_signup','sha@fiq.com',4,'Student\'s Location','2016-09-30 15:13:18',0),
	(48,'tutor_signup','sha@fiq.com',5,'Giving a student confidence to succeed','2016-09-30 15:13:18',0),
	(49,'tutor_signup','sha@fiq.com',6,'No','2016-09-30 15:13:18',0),
	(50,'tutor_signup','sha@fiq.com',7,'No','2016-09-30 15:13:18',0),
	(51,'tutor_signup','sha@fiq.com',8,'6-10','2016-09-30 15:13:18',0),
	(52,'tutor_signup','ahmad@plexsol.com',1,'Yes','2016-11-16 10:56:43',0),
	(53,'tutor_signup','ahmad@plexsol.com',2,'2-4','2016-11-16 10:56:43',0),
	(54,'tutor_signup','ahmad@plexsol.com',3,'College','2016-11-16 10:56:43',0),
	(55,'tutor_signup','ahmad@plexsol.com',4,'Coffee Shop','2016-11-16 10:56:43',0),
	(56,'tutor_signup','ahmad@plexsol.com',5,'Giving a student confidence to succeed','2016-11-16 10:56:43',0),
	(57,'tutor_signup','ahmad@plexsol.com',6,'No','2016-11-16 10:56:43',0),
	(58,'tutor_signup','ahmad@plexsol.com',7,'Yes','2016-11-16 10:56:43',0),
	(59,'tutor_signup','ahmad@plexsol.com',8,'11-20','2016-11-16 10:56:43',0),
	(60,'tutor_signup','tutor@plexsol.com',1,'Yes','2016-12-02 14:28:22',0),
	(61,'tutor_signup','tutor@plexsol.com',2,'2-4','2016-12-02 14:28:22',0),
	(62,'tutor_signup','tutor@plexsol.com',3,'High School','2016-12-02 14:28:22',0),
	(63,'tutor_signup','tutor@plexsol.com',4,'Location I select','2016-12-02 14:28:22',0),
	(64,'tutor_signup','tutor@plexsol.com',5,'Providing test prep','2016-12-02 14:28:22',0),
	(65,'tutor_signup','tutor@plexsol.com',6,'Yes','2016-12-02 14:28:22',0),
	(66,'tutor_signup','tutor@plexsol.com',7,'No','2016-12-02 14:28:22',0),
	(67,'tutor_signup','tutor@plexsol.com',8,'21-35','2016-12-02 14:28:22',0),
	(76,'tutor_signup','tutor2@plexsol.com',1,'Yes','2017-01-05 07:35:04',0),
	(77,'tutor_signup','tutor2@plexsol.com',2,'2-4','2017-01-05 07:35:04',0),
	(78,'tutor_signup','tutor2@plexsol.com',3,'MIddle School','2017-01-05 07:35:04',0),
	(79,'tutor_signup','tutor2@plexsol.com',4,'Coffee Shop','2017-01-05 07:35:04',0),
	(80,'tutor_signup','tutor2@plexsol.com',5,'Giving a student confidence to succeed','2017-01-05 07:35:04',0),
	(81,'tutor_signup','tutor2@plexsol.com',6,'No','2017-01-05 07:35:04',0),
	(82,'tutor_signup','tutor2@plexsol.com',7,'Yes','2017-01-05 07:35:04',0),
	(83,'tutor_signup','tutor2@plexsol.com',8,'11-20','2017-01-05 07:35:04',0),
	(84,'tutor_signup','3tu3ni@gmail.com',1,'Yes','2017-01-16 14:26:04',0),
	(85,'tutor_signup','3tu3ni@gmail.com',2,'2-4','2017-01-16 14:26:04',0),
	(86,'tutor_signup','3tu3ni@gmail.com',3,'High School','2017-01-16 14:26:04',0),
	(87,'tutor_signup','3tu3ni@gmail.com',4,'Online','2017-01-16 14:26:04',0),
	(88,'tutor_signup','3tu3ni@gmail.com',5,'Helping students get ahead','2017-01-16 14:26:04',0),
	(89,'tutor_signup','3tu3ni@gmail.com',6,'Yes','2017-01-16 14:26:04',0),
	(90,'tutor_signup','3tu3ni@gmail.com',7,'Yes','2017-01-16 14:26:04',0),
	(91,'tutor_signup','3tu3ni@gmail.com',8,'6-10','2017-01-16 14:26:04',0),
	(100,'tutor_signup','luqman.is@gmail.com',1,'Yes','2017-01-17 11:45:55',0),
	(101,'tutor_signup','luqman.is@gmail.com',2,'2-4','2017-01-17 11:45:55',0),
	(102,'tutor_signup','luqman.is@gmail.com',3,'MIddle School','2017-01-17 11:45:55',0),
	(103,'tutor_signup','luqman.is@gmail.com',4,'Online','2017-01-17 11:45:55',0),
	(104,'tutor_signup','luqman.is@gmail.com',5,'Improving your student\'s grades','2017-01-17 11:45:55',0),
	(105,'tutor_signup','luqman.is@gmail.com',6,'Yes','2017-01-17 11:45:55',0),
	(106,'tutor_signup','luqman.is@gmail.com',7,'Yes','2017-01-17 11:45:55',0),
	(107,'tutor_signup','luqman.is@gmail.com',8,'1-5','2017-01-17 11:45:55',0);

/*!40000 ALTER TABLE `qa_responses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table questionnaire
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questionnaire`;

CREATE TABLE `questionnaire` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` int(11) DEFAULT NULL,
  `question` text,
  `answers` longtext,
  `correct_answer` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table report_card
# ------------------------------------------------------------

DROP TABLE IF EXISTS `report_card`;

CREATE TABLE `report_card` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `summary` text,
  `ratings` text,
  `job_order_Id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table reviews
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reviews`;

CREATE TABLE `reviews` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tutor_email` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `review` longtext,
  `rating` int(11) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table states
# ------------------------------------------------------------

DROP TABLE IF EXISTS `states`;

CREATE TABLE `states` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;

INSERT INTO `states` (`id`, `value`)
VALUES
	(1,'Perlis'),
	(2,'Perak'),
	(3,'Pulau Pinang'),
	(4,'Kedah'),
	(5,'Selangor'),
	(6,'Negeri Sembilan'),
	(7,'Melaka'),
	(8,'Johor'),
	(9,'Kelantan'),
	(10,'Terengganu'),
	(11,'Pahang'),
	(12,'Sabah'),
	(13,'Sarah'),
	(14,'WP Labuan'),
	(15,'WP Kuala Lumpur'),
	(16,'WP Putrajaya');

/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table student
# ------------------------------------------------------------

DROP TABLE IF EXISTS `student`;

CREATE TABLE `student` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table subjects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subjects`;

CREATE TABLE `subjects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(255) DEFAULT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;

INSERT INTO `subjects` (`id`, `value`, `grade`, `order`)
VALUES
	(1,'Bahasa Melayu','Std 1-3',1),
	(2,'English','Std 1-3',1),
	(3,'Mathematics','Std 1-3',1),
	(4,'Science','Std 1-3',1),
	(5,'Bahasa Melayu','Std 4-6',2),
	(6,'English','Std 4-6',2),
	(7,'Mathematics','Std 4-6',2),
	(8,'Science','Std 4-6',2),
	(9,'Bahasa Melayu','Form 1-3 (PT3)',3),
	(10,'English','Form 1-3 (PT3)',3),
	(11,'Science','Form 1-3 (PT3)',3),
	(12,'Mathematics','Form 1-3 (PT3)',3),
	(13,'Geography','Form 1-3 (PT3)',3),
	(14,'Kemahiran Hidup','Form 1-3 (PT3)',3),
	(15,'Sejarah','Form 1-3 (PT3)',3),
	(23,NULL,'Form 4-5 (SPM)',4),
	(24,NULL,'O-Level / IGCSE',5),
	(25,NULL,'A-Level / Pre-U',6);

/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tutor_availability
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tutor_availability`;

CREATE TABLE `tutor_availability` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) DEFAULT NULL,
  `day` varchar(255) DEFAULT NULL,
  `morning` int(1) DEFAULT NULL,
  `afternoon` int(1) DEFAULT NULL,
  `evening` int(1) DEFAULT NULL,
  `fulldata` longtext,
  PRIMARY KEY (`id`),
  KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tutor_profile
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tutor_profile`;

CREATE TABLE `tutor_profile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zipcode` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `about` longtext,
  `passed_assessment` varchar(255) DEFAULT NULL,
  `approved` int(1) DEFAULT NULL,
  `nric` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `ethnicity` varchar(255) DEFAULT NULL,
  `qualification` longtext,
  `institution` longtext,
  `availability` longtext,
  `dob` date DEFAULT NULL,
  `tutoring_experience` varchar(32) DEFAULT NULL,
  `tutoring_duration` varchar(32) DEFAULT NULL,
  `tutoring_career` varchar(32) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `bank_account_number` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `education` text,
  `locations` text,
  `enable_availability` int(1) DEFAULT '0',
  `race` varchar(255) DEFAULT NULL,
  `languages` text,
  `interview_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`user_email`),
  KEY `address1` (`address1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tutor_profile` WRITE;
/*!40000 ALTER TABLE `tutor_profile` DISABLE KEYS */;

INSERT INTO `tutor_profile` (`id`, `user_email`, `address1`, `address2`, `city`, `state`, `zipcode`, `country`, `about`, `passed_assessment`, `approved`, `nric`, `gender`, `ethnicity`, `qualification`, `institution`, `availability`, `dob`, `tutoring_experience`, `tutoring_duration`, `tutoring_career`, `occupation`, `bank_account_number`, `bank_name`, `education`, `locations`, `enable_availability`, `race`, `languages`, `interview_status`)
VALUES
	(7,'tutor@plexsol.com','41 LORONG INDAH','','Bukit Mertajam',NULL,'14000','Malaysia','I am a dedicated tutor bla bla bla',NULL,NULL,'880102355071','Male',NULL,NULL,NULL,'Mon - Morning - 9AM,Mon - Morning - 10AM,Mon - Morning - 11AM,Mon - Afternoon - 3PM,Mon - Afternoon - 4PM,Mon - Afternoon - 5PM,Mon - Evening - 9PM,Mon - Evening - 10PM,Mon - Evening - 11PM','1988-02-01','Yes',NULL,NULL,'Software Developer','157091015693','Maybank','{\"year\":[\"204\"],\"institution\":[\"Universiti Sains Malaysia\"],\"certificate\":[\"Degree in Electrical Engineering\"]}','Bukit Mertajam',1,'Malay',NULL,NULL),
	(8,'tutor2@plexsol.com','41 Lorong Indah','Taman Bukit Indah','Bukit Mertajam',NULL,'14000','Malaysia','test','Passed Assessment',NULL,'950513071232','Female',NULL,NULL,NULL,'Mon - Morning - 9AM,Mon - Morning - 10AM,Mon - Morning - 11AM,Mon - Afternoon - 3PM,Mon - Afternoon - 4PM,Mon - Afternoon - 5PM,Mon - Evening - 9PM,Mon - Evening - 10PM,Mon - Evening - 11PM','1988-11-30','Yes',NULL,NULL,'Product Designer','12312312','Maybank','{\"year\":[\"2016\"],\"institution\":[\"USM\"],\"certificate\":[\"Product Design Degree\"]}','Bukit Mertajam',1,'Malay',NULL,'Interviewed'),
	(9,'3tu3ni@gmail.com','Addy is','','Petaling JAya',NULL,'47810','Malaysia','Loren Ipsum',NULL,NULL,'640615086185','Male',NULL,NULL,NULL,NULL,'0000-00-00','Yes',NULL,NULL,'Unemployed','1234456789B','bank name','{\"year\":[\"1988\",\"2000\"],\"institution\":[\"ABC Pondok\",\"ABC Uni\"],\"certificate\":[\"SPM\",\"BSc\"]}','Kuala Terengganu,Kuala Lumpur',0,'Malay',NULL,NULL),
	(10,'luqman.is@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'Male',NULL,NULL,NULL,'Wed - Evening - 7PM,Thu - Evening - 7PM,Fri - Evening - 7PM',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
	(11,'ssuris29@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Male',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL),
	(12,'ssuria29@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Male',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL),
	(13,'luqman2.is@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Male',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL);

/*!40000 ALTER TABLE `tutor_profile` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tutor_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tutor_sessions`;

CREATE TABLE `tutor_sessions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `job_order_id` int(11) DEFAULT NULL,
  `job_request_id` int(11) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `duration` varchar(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `assessment` longtext,
  `assessment_seen` int(1) DEFAULT NULL,
  `assessment_seen_datetime` datetime DEFAULT NULL,
  `assessment_datetime` datetime DEFAULT NULL,
  `parent_email` varchar(255) DEFAULT NULL,
  `session_start` datetime DEFAULT NULL,
  `session_end` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `job_order_id` (`job_order_id`),
  KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tutor_sessions` WRITE;
/*!40000 ALTER TABLE `tutor_sessions` DISABLE KEYS */;

INSERT INTO `tutor_sessions` (`id`, `job_order_id`, `job_request_id`, `user_email`, `date`, `time`, `duration`, `status`, `assessment`, `assessment_seen`, `assessment_seen_datetime`, `assessment_datetime`, `parent_email`, `session_start`, `session_end`)
VALUES
	(36,3,1,'tutor@plexsol.com','2016-12-26','15:00:00','2','Scheduled',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(37,3,1,'tutor@plexsol.com','2017-01-02','15:00:00','2','Completed',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(38,3,1,'tutor@plexsol.com','2017-01-09','15:00:00','2','Scheduled',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(39,3,1,'tutor@plexsol.com','2017-01-16','15:00:00','2','Scheduled',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(40,3,1,'tutor@plexsol.com','2017-01-23','15:00:00','2','Scheduled',NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `tutor_sessions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tutor_subjects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tutor_subjects`;

CREATE TABLE `tutor_subjects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT '',
  `grade` varchar(255) DEFAULT NULL,
  `active` int(1) DEFAULT '0',
  `rate` decimal(20,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tutor_subjects` WRITE;
/*!40000 ALTER TABLE `tutor_subjects` DISABLE KEYS */;

INSERT INTO `tutor_subjects` (`id`, `user_email`, `subject`, `grade`, `active`, `rate`)
VALUES
	(58,'shafiqriz@hotmail.com','Bahasa Melayu','Std 1-3',0,NULL),
	(59,'shafiqriz@hotmail.com','English','Std 1-3',0,NULL),
	(60,'shafiqriz@hotmail.com','Mathematics','Std 1-3',0,NULL),
	(61,'shafiqriz@hotmail.com','Bahasa Melayu','Std 4-6',0,NULL),
	(62,'shafiqriz@hotmail.com','English','Std 4-6',0,NULL),
	(63,'shafiqriz@hotmail.com','Mathematics','Std 4-6',0,NULL),
	(87,'abc@def.com','English','Std 1-3',0,NULL),
	(88,'abc@def.com','English','Std 4-6',0,NULL),
	(89,'abc@def.com','English','Form 1-3 (PT3)',0,NULL),
	(106,'sha@fiq.com','Bahasa Melayu','Std 1-3',0,0.00),
	(107,'sha@fiq.com','Bahasa Melayu','Std 4-6',0,0.00),
	(108,'sha@fiq.com','Bahasa Melayu','Form 1-3 (PT3)',0,0.00),
	(109,'sha@fiq.com','Mathematics','Std 1-3',1,50.00),
	(110,'ahmad@plexsol.com','Bahasa Melayu','Std 1-3',0,NULL),
	(111,'ahmad@plexsol.com','Bahasa Melayu','Std 4-6',0,NULL),
	(112,'tutor@plexsol.com','Bahasa Melayu','Std 1-3',1,50.00),
	(113,'tutor@plexsol.com','Bahasa Melayu','Std 4-6',1,50.00),
	(114,'tutor@plexsol.com','Bahasa Melayu','Form 1-3 (PT3)',1,20.00),
	(115,'tutor@plexsol.com','Mathematics','Std 1-3',1,50.00),
	(116,'tutor@plexsol.com','Mathematics','Std 4-6',1,40.00),
	(117,'tutor@plexsol.com','Mathematics','Form 1-3 (PT3)',1,40.00),
	(121,'tutor2@plexsol.com','Mathematics','Std 1-3',0,30.00),
	(122,'tutor2@plexsol.com','Mathematics','Std 4-6',0,30.00),
	(123,'tutor2@plexsol.com','Mathematics','Form 1-3 (PT3)',0,30.00),
	(124,'3tu3ni@gmail.com','Bahasa Melayu','Std 1-3',0,70.00),
	(129,'luqman.is@gmail.com','Bahasa Melayu','Std 4-6',0,30.00),
	(130,'luqman.is@gmail.com','English','Std 1-3',0,40.00),
	(131,'luqman.is@gmail.com','Mathematics','Std 4-6',0,0.00),
	(132,'luqman.is@gmail.com','Science','Std 1-3',0,0.00);

/*!40000 ALTER TABLE `tutor_subjects` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_types`;

CREATE TABLE `user_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `permission` text,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `fbid` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `verified` int(1) DEFAULT NULL,
  `online_status` int(1) DEFAULT NULL,
  `online_datetime` datetime DEFAULT NULL,
  `registered_on` datetime DEFAULT NULL,
  `super` int(1) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `review_count` int(11) DEFAULT NULL,
  `review_rating` varchar(255) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `type`, `firstname`, `lastname`, `fbid`, `email`, `password`, `mobile`, `state`, `photo`, `verified`, `online_status`, `online_datetime`, `registered_on`, `super`, `status`, `review_count`, `review_rating`, `key`)
VALUES
	(47,'admin','Shafiq','Rizwan',NULL,'shafiq@plexsol.com','f865b53623b121fd34ee5426c792e5c33af8c227',NULL,NULL,'',NULL,NULL,NULL,'2016-09-30 20:45:42',NULL,'Unverified',NULL,NULL,NULL),
	(50,'tutor','Shafiq','Rizwan',NULL,'tutor@plexsol.com','f865b53623b121fd34ee5426c792e5c33af8c227','0124205391',NULL,'bg.jpg',1,0,NULL,'2016-12-02 14:27:55',NULL,'Verified',NULL,NULL,'1fb97ebed2cd1778fe5c8c4fb216cd1a54f3a2c4'),
	(52,'tutor','Sarah','Aliya',NULL,'tutor2@plexsol.com','f865b53623b121fd34ee5426c792e5c33af8c227','1232132121',NULL,'',1,0,NULL,'2016-12-02 14:35:05',NULL,'Verified',NULL,NULL,'aaf961820c4280e734ccc045af8208c1a81f8bee'),
	(53,'user','Parent','One',NULL,'parent@plexsol.com','f865b53623b121fd34ee5426c792e5c33af8c227','0124994979',NULL,'201010fa2b1.jpg',1,NULL,NULL,'2016-12-24 12:49:12',NULL,'Unverified',NULL,NULL,NULL),
	(54,'tutor','John','Travolta',NULL,'3tu3ni@gmail.com','380ac1c71bf1b9076f51998a45609df537b55e6a','0193947911',NULL,'',1,NULL,NULL,'2017-01-16 14:24:38',NULL,'Verified',NULL,NULL,NULL),
	(55,'user','Anak','Murid',NULL,'dagangniaga@gmail.com','ceed5bcc7ddb0f551817bbb198ea7a7d3ebcadcc','0193947911',NULL,NULL,1,NULL,NULL,'2017-01-16 14:32:32',NULL,'Unverified',NULL,NULL,NULL),
	(56,'tutor','Zairudin','Jamaludin',NULL,'luqman.is@gmail.com','3f369f90f24ffe892810dda78cc79cebcac89661','0182708843',NULL,'',NULL,NULL,NULL,'2017-01-16 20:44:02',NULL,'Verified',NULL,NULL,NULL),
	(57,'user','Testing','Test1',NULL,'zairudin@twoseas.com.my','7c3607b8e61bcf1944e9e8503a660f21f4b6f3f1',NULL,NULL,NULL,NULL,NULL,NULL,'2017-01-17 11:42:23',NULL,'Unverified',NULL,NULL,NULL),
	(58,'user','Testing','Jamaludin',NULL,'buletincatur@gmail.com','7c3607b8e61bcf1944e9e8503a660f21f4b6f3f1',NULL,NULL,NULL,NULL,NULL,NULL,'2017-01-18 14:21:26',NULL,'Unverified',NULL,NULL,NULL),
	(59,'tutor','Zairudin','Test1',NULL,'ssuris29@gmail.com','7c3607b8e61bcf1944e9e8503a660f21f4b6f3f1','',NULL,NULL,NULL,NULL,NULL,'2017-01-18 14:40:08',NULL,'Unverified',NULL,NULL,NULL),
	(60,'tutor','Zairudin','Test1',NULL,'ssuria29@gmail.com','7c3607b8e61bcf1944e9e8503a660f21f4b6f3f1','',NULL,NULL,NULL,NULL,NULL,'2017-01-18 14:47:26',NULL,'Unverified',NULL,NULL,NULL),
	(61,'tutor','aaa','aaa',NULL,'luqman2.is@gmail.com','7c3607b8e61bcf1944e9e8503a660f21f4b6f3f1','',NULL,NULL,NULL,NULL,NULL,'2017-01-18 14:48:05',NULL,'Unverified',NULL,NULL,NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
