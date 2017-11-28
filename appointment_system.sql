-- MySQL dump 10.13  Distrib 5.7.11, for Linux (x86_64)
--
-- Host: localhost    Database: appointment_system
-- ------------------------------------------------------
-- Server version	5.7.11-0ubuntu6

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addresses` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  `deleted_at` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` VALUES (2,'16 Cedarwoods Cres','Kitchener','Canada','N2C 2L4','1234567891',NULL,'2017-09-23 03:52:23',NULL),(22,'fvfv','cvdvdvdfvdvdf','cvbdfbvdfvdf','cvfdvdfvdfvf','154445151515','2017-06-13 19:13:38','2017-06-18 05:40:59','2017-06-18 05:40:59'),(23,'sdfvnsdjnjdsjvsd','cv kncfkb nkfnb kdgb','x,v kdfxnvknsfkvnkdfx','v,ckv kvm kfcmk fv','-09089888','2017-06-13 19:24:07','2017-06-16 08:07:23','2017-06-16 08:07:23'),(24,'#1704, 16 Cedarwoods Crescent','Kitchener','Canada','N2C 2L4','2665454854','2017-06-17 01:02:42','2017-07-08 18:21:28','2017-07-08 18:21:28'),(25,'#1704, 16 Cedarwoods Crescent','Kitchener','Canada','N2C 2L4','5554544854','2017-06-18 05:40:45','2017-09-23 03:51:23','2017-09-23 03:51:23'),(26,'fvfvdvfdvv','cvdvdvdfvdvdf','cvbdfbvdfvdf','cvfdvdfvdfvf','154445151515','2017-06-18 02:01:10','2017-06-24 18:23:15','2017-06-24 18:23:15'),(27,'dncjsdkjdsjks','sdjfbsjdbjsdbkf','sfuhsfsd','fnvjndsjvjds','445454545','2017-07-09 01:55:28','2017-07-09 05:55:59','2017-07-09 05:55:59');
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appointments` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `service_id` int(10) unsigned NOT NULL,
  `organization_id` int(10) unsigned NOT NULL,
  `employee_id` int(15) unsigned NOT NULL,
  `client_id` int(15) unsigned NOT NULL,
  `date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `cancellation_reason` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `employee_id` (`employee_id`),
  KEY `fk_appointments_org_id` (`organization_id`),
  KEY `fk_appointments_service_id` (`service_id`),
  CONSTRAINT `fk_appointments_client_id` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_appointments_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `person` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_appointments_org_id` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_appointments_service_id` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointments`
--

LOCK TABLES `appointments` WRITE;
/*!40000 ALTER TABLE `appointments` DISABLE KEYS */;
INSERT INTO `appointments` VALUES (3,'For booking tickets',2,1,3,2,'2017-07-10','11:00:00','12:00:00',NULL,NULL,'2017-07-25 08:30:09',NULL),(4,'Haircut',2,1,3,1,'2017-07-21','10:00:00','10:30:00',NULL,NULL,'2017-07-25 02:27:04',NULL),(5,'Train ticket',1,1,3,2,'2017-07-21','15:00:00','16:00:00',NULL,NULL,'2017-07-25 02:46:45',NULL),(7,'New appointment',1,1,3,1,'2017-07-05','11:30:00','12:30:00',NULL,'2017-07-25 08:41:11','2017-07-27 06:58:44',NULL),(8,'Lunch',2,1,3,1,'2017-07-03','16:30:00','17:30:00',NULL,'2017-07-25 09:11:04','2017-07-27 06:54:12',NULL),(9,'Hello kk',1,1,3,2,'2017-07-12','09:00:00','10:30:00',NULL,'2017-07-27 07:01:26','2017-07-27 07:01:26',NULL),(10,'Book tickets',1,1,3,1,'2017-09-05','00:00:00','00:00:00',NULL,'2017-09-26 22:54:13','2017-09-26 22:54:13',NULL),(11,'Meeting',1,1,3,2,'2017-09-05','10:00:00','11:30:00',NULL,'2017-09-26 22:55:43','2017-09-26 22:56:01',NULL),(12,'New appointment',1,1,3,1,'2017-10-10','11:30:00','12:30:00',NULL,'2017-10-03 00:03:41','2017-10-03 00:03:41',NULL);
/*!40000 ALTER TABLE `appointments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `organization_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_clients_org_id` (`organization_id`),
  CONSTRAINT `fk_clients_org_id` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,'Gagandeep','Singh',NULL,'gagan@gmail.com',1,NULL,NULL,NULL),(2,'Gagan','Singh',NULL,'gagan@gmail.com',1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `default_schedules`
--

DROP TABLE IF EXISTS `default_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `default_schedules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) unsigned NOT NULL,
  `day_of_week` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `daily_schedule_unique_daily` (`organization_id`,`day_of_week`),
  CONSTRAINT `fk_default_schedule_org_id` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `default_schedules`
--

LOCK TABLES `default_schedules` WRITE;
/*!40000 ALTER TABLE `default_schedules` DISABLE KEYS */;
INSERT INTO `default_schedules` VALUES (2,1,1,'09:00:00','17:00:00',NULL,'2017-07-11 04:56:55',NULL),(3,1,2,'07:00:00','16:30:00',NULL,'2017-07-11 04:56:55',NULL),(5,1,3,'08:00:00','16:00:00',NULL,'2017-07-11 04:56:55',NULL),(6,1,4,'09:30:00','17:00:00',NULL,'2017-07-11 04:56:55',NULL),(7,1,5,'09:00:00','17:00:00',NULL,'2017-07-11 04:56:55',NULL),(10,2,1,'09:00:00','17:30:00','2017-07-15 05:36:45','2017-07-15 05:51:14',NULL),(11,2,2,'09:00:00','17:00:00','2017-07-15 05:36:45','2017-07-15 05:51:14',NULL),(12,2,3,'00:00:00','00:00:00','2017-07-15 05:36:45','2017-07-15 05:51:14',NULL),(13,2,4,'00:00:00','00:00:00','2017-07-15 05:36:45','2017-07-15 05:51:14',NULL),(14,2,5,'00:00:00','00:00:00','2017-07-15 05:36:45','2017-07-15 05:51:14',NULL);
/*!40000 ALTER TABLE `default_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2016_06_01_000001_create_oauth_auth_codes_table',2),(4,'2016_06_01_000002_create_oauth_access_tokens_table',2),(5,'2016_06_01_000003_create_oauth_refresh_tokens_table',2),(6,'2016_06_01_000004_create_oauth_clients_table',2),(7,'2016_06_01_000005_create_oauth_personal_access_clients_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organization_addresses`
--

DROP TABLE IF EXISTS `organization_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organization_addresses` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `organization_id` int(15) unsigned NOT NULL,
  `address_id` int(15) unsigned NOT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  `deleted_at` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Org_address_org_id` (`organization_id`),
  KEY `fk_Org_address_address_id` (`address_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organization_addresses`
--

LOCK TABLES `organization_addresses` WRITE;
/*!40000 ALTER TABLE `organization_addresses` DISABLE KEYS */;
INSERT INTO `organization_addresses` VALUES (2,1,2,NULL,'2017-09-23 03:52:23',NULL),(3,2,1,NULL,'2017-07-08 18:35:12','2017-07-08 18:35:12'),(18,1,22,'2017-06-13 19:13:38','2017-06-18 05:40:59','2017-06-18 05:40:59'),(19,24,23,'2017-06-13 19:24:07','2017-06-16 08:07:23','2017-06-16 08:07:23'),(20,25,24,'2017-06-17 01:02:42','2017-07-08 18:21:28','2017-07-08 18:21:28'),(21,1,25,'2017-06-18 05:40:45','2017-09-23 03:51:23','2017-09-23 03:51:23'),(22,26,26,'2017-06-18 02:01:11','2017-06-24 18:23:15','2017-06-24 18:23:15'),(23,27,27,'2017-07-09 01:55:28','2017-07-09 05:55:59','2017-07-09 05:55:59');
/*!40000 ALTER TABLE `organization_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organizations`
--

DROP TABLE IF EXISTS `organizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organizations` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organizations`
--

LOCK TABLES `organizations` WRITE;
/*!40000 ALTER TABLE `organizations` DISABLE KEYS */;
INSERT INTO `organizations` VALUES (1,'KK Org',NULL,'2017-09-23 07:52:15',NULL),(2,'Appointment System',NULL,'2017-07-08 22:35:33',NULL),(12,'sddsh','2017-06-06 11:20:21','2017-06-18 05:09:01',NULL),(13,'dbhsdhfsh','2017-06-09 20:57:57','2017-06-13 21:47:04','2017-06-13 21:47:04'),(24,'tuesday','2017-06-13 17:36:36','2017-07-09 09:49:18','2017-07-09 09:49:18'),(25,'Singh','2017-06-17 05:02:42','2017-09-26 22:57:47',NULL),(27,'dsfsjfbjsf','2017-07-09 05:55:28','2017-07-09 09:55:59','2017-07-09 09:55:59');
/*!40000 ALTER TABLE `organizations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reset_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organization_id` int(15) unsigned NOT NULL,
  `role_id` int(11) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `organisation_id` (`organization_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `fk_persons_org_id` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_persons_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person`
--

LOCK TABLES `person` WRITE;
/*!40000 ALTER TABLE `person` DISABLE KEYS */;
INSERT INTO `person` VALUES (2,'Amninder','Chahal','achahal@gmail.com','$2y$10$7IYgaHY7RWWNJFdE3z9iCum2QA9RE0xBr1TpKNifbidyYHST3zDiK','5197221603','341 Traynor Ave','Kitchener','Canada','n2c 2h4',1,1,NULL,'2017-06-17 03:33:31',NULL),(3,'Harsh','Mahale','harsh@gmail.com','$2y$10$3TcROJWhkjMtN7HlPD4aY.E/C/xohTO5N9YtuEJhkES8kyCfdY.Ii','1234567895','341 Traynor','Kitchener','Canada','N2C 2L4',1,3,NULL,'2017-07-10 11:36:38',NULL),(4,'Krishna','Kanahaya','kk@gmail.com','$2y$10$3TcROJWhkjMtN7HlPD4aY.E/C/xohTO5N9YtuEJhkES8kyCfdY.Ii','1234567894','341 Traynor Ave','Kitchener','Canada','N2C 2H5',1,2,'2017-06-07 05:04:06','2017-06-18 05:06:04',NULL),(11,'s,nddsngndjk','dxnm,vnxd,vnfxdm','abc@gmail.com','$2y$10$3TcROJWhkjMtN7HlPD4aY.E/C/xohTO5N9YtuEJhkES8kyCfdY.Ii','1235564454','#1704, 16 Cedarwoods Crescent','Kitchener','Canada','N2C 2L4',1,2,'2017-06-09 22:03:22','2017-07-10 10:02:25','2017-07-10 10:02:25'),(12,'Amninder','Chahal','amninderchahal@hotmail.com','$2y$10$7IYgaHY7RWWNJFdE3z9iCum2QA9RE0xBr1TpKNifbidyYHST3zDiK','5197221603','341 Traynor Ave','Kitchener','Canada','n2c 2h4',2,2,NULL,'2017-06-15 22:59:09',NULL),(13,'hvchdhchd','bdfhbdvbdh','fjvjfnvjnfjd','$2y$10$3TcROJWhkjMtN7HlPD4aY.E/C/xohTO5N9YtuEJhkES8kyCfdY.Ii','1234567894','341 Traynor Ave','Kitchener','Canada','N2C 2H5',2,2,'2017-06-07 05:04:06','2017-06-18 09:47:40','2017-06-18 09:47:40'),(14,'Amninder','Kanahay','achahdvdal@gmail.com','$2y$10$CJZApSe6MDqhPJTYQPtvHeT/JpHdeS9l8Nq9EJ/qrurZ/Mhmvr6RS','5197221603','#1704, 16 Cedarwoods Crescent','Kitchener','Canada','N2C 2L4',2,2,'2017-06-18 10:12:26','2017-07-11 21:28:10',NULL),(18,'Akshay','Grover','akshay@gmail.com','$2y$10$gWBlnqLEZmNkLAO2/BRRWOnMldhDR9pkY.ois9sjUTkiNmV.IJ3r6','5197221603','#1704, 16 Cedarwoods Crescent','Kitchener','Canada','N2C 2L4',1,2,'2017-07-10 08:03:05','2017-07-10 08:03:05',NULL),(19,'s,nddsngndjk','dxnm,vnxd,vnfxdm','dxvmxnfdx@gmail.com','$2y$10$q5eaDa/0cgB1dVFnshQIMeCIGoYVIm0Yd40n0AJYsM8sC2q3G4HzC','5197221603','#1704, 16 Cedarwoods Crescent','Kitchener','Canada','N2C 2L4',12,3,'2017-07-10 10:49:01','2017-09-23 09:52:40','2017-09-23 09:52:40');
/*!40000 ALTER TABLE `person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Admin'),(2,'Admin'),(3,'Employee');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedules` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(15) unsigned NOT NULL,
  `organization_id` int(10) unsigned NOT NULL,
  `day_of_week` int(11) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `schedules_unique_EmpOrgDay_of_week` (`employee_id`,`organization_id`,`day_of_week`),
  KEY `employee_id` (`employee_id`) USING BTREE,
  KEY `fk_schedules_org_id` (`organization_id`),
  CONSTRAINT `fk_schedules_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `person` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_schedules_org_id` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` VALUES (3,19,12,2,'07:00:00','16:00:00','2017-07-15 10:06:33','2017-07-20 19:41:41',NULL),(19,19,12,1,'01:00:00','01:00:00','2017-07-18 09:43:54','2017-07-20 19:41:41',NULL),(21,19,12,4,'09:00:00','05:30:00','2017-07-18 11:08:40','2017-07-20 19:41:41',NULL),(25,3,1,1,'08:30:00','17:00:00','2017-07-19 08:08:08','2017-09-28 00:21:04',NULL),(26,3,1,2,'09:30:00','17:30:00','2017-07-19 08:08:08','2017-09-28 00:21:04',NULL),(27,19,12,5,'08:30:00','16:30:00','2017-07-20 19:41:41','2017-07-20 19:41:41',NULL),(31,3,1,4,'09:00:00','16:30:00','2017-09-23 09:07:32','2017-09-28 00:21:04',NULL);
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `organization_id` int(15) unsigned NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `organization_id` (`organization_id`) USING BTREE,
  CONSTRAINT `fk_services_org_id` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'Book tickets',1,'The client wants to book tickets',NULL,'2017-07-04 02:52:09',NULL),(2,'Hello',1,'I understand that you\'ve got a front end limit, which is great until it isn\'t. *grin* The trick is to think of the DB as separate from the applications that connect to it. Just because one application puts a limit on the data.','2017-07-04 03:09:05','2017-07-04 13:11:36',NULL),(3,'General advice',1,NULL,'2017-07-04 13:10:39','2017-07-04 13:10:44','2017-07-04 13:10:44');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `api_token` (`api_token`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (12,'Amninder Chahal','achahal@gmail.com','$2y$10$UJBNXnkapryCc5ZWMXqGgeEvol1pkbEjj3hYeRGrFg87TeODP5B66',NULL,'hdMTf1TAAPyzrIlZb2JJrjBBTnkCBvZOsIHIpQ2O3IIiA9r53RU1tQ1FCQKj','2017-06-12 08:55:02','2017-06-12 08:55:02',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'appointment_system'
--
/*!50003 DROP PROCEDURE IF EXISTS `add_organization_proc` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_organization_proc`(
    IN org_name varchar(255),
    IN street varchar(255),
    IN city varchar(255),
    IN country varchar(255),
    IN postal_code varchar(255),
    IN phone_number varchar(255)
)
BEGIN 
   INSERT INTO `organizations`(`name`,`created_at`) VALUES(org_name, CURRENT_TIMESTAMP);
   set @org_id = LAST_INSERT_ID();
   
   INSERT INTO `addresses`(`street`,`city`, `country`, `postal_code`, `phone_number`,`created_at`) VALUES(street, city, country, postal_code, phone_number, CURRENT_TIMESTAMP);
   set @address_id = LAST_INSERT_ID();
   
    INSERT INTO `organization_addresses`(`organization_id`, `address_id`,`created_at`) VALUES(@org_id, @address_id, CURRENT_TIMESTAMP);
    
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

-- Dump completed on 2017-10-04  1:06:15
