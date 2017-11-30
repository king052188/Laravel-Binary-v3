CREATE DATABASE  IF NOT EXISTS `kpadb_bloops` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `kpadb_bloops`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: kpadb_bloops
-- ------------------------------------------------------
-- Server version	5.7.17-log

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
-- Table structure for table `db_price_references`
--

DROP TABLE IF EXISTS `db_price_references`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_price_references` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_code` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `amount` decimal(18,2) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_price_references`
--

LOCK TABLES `db_price_references` WRITE;
/*!40000 ALTER TABLE `db_price_references` DISABLE KEYS */;
INSERT INTO `db_price_references` VALUES (1,'CD','Commission Deduction','Commission Deduction',-1100.00,3,1),(2,'PD','Paid','Paid',1100.00,2,1);
/*!40000 ALTER TABLE `db_price_references` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_user_group`
--

DROP TABLE IF EXISTS `db_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_user_group` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `code` tinyint(4) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `descriptions` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_user_group`
--

LOCK TABLES `db_user_group` WRITE;
/*!40000 ALTER TABLE `db_user_group` DISABLE KEYS */;
INSERT INTO `db_user_group` VALUES (1,20,'Administrator','Master'),(2,21,'Manager','Mother'),(3,22,'Finance','Child'),(4,23,'Leader','Grand Child');
/*!40000 ALTER TABLE `db_user_group` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (3,'2014_10_12_000000_create_users_table',1),(4,'2014_10_12_100000_create_password_resets_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_mobile_index` (`mobile`)
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
-- Table structure for table `user_activation_code`
--

DROP TABLE IF EXISTS `user_activation_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_activation_code` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(50) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `amount` decimal(18,2) DEFAULT NULL,
  `generated_by` int(11) DEFAULT NULL,
  `generated_for` int(11) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_activation_code`
--

LOCK TABLES `user_activation_code` WRITE;
/*!40000 ALTER TABLE `user_activation_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_activation_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_genealogy_summary`
--

DROP TABLE IF EXISTS `user_genealogy_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_genealogy_summary` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `member_uid` varchar(30) DEFAULT NULL,
  `position_id` tinyint(4) DEFAULT NULL,
  `type_id` tinyint(4) DEFAULT NULL,
  `points` tinyint(4) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_genealogy_summary`
--

LOCK TABLES `user_genealogy_summary` WRITE;
/*!40000 ALTER TABLE `user_genealogy_summary` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_genealogy_summary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_genealogy_transaction`
--

DROP TABLE IF EXISTS `user_genealogy_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_genealogy_transaction` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction` varchar(50) DEFAULT NULL,
  `sponsor_id` varchar(30) DEFAULT NULL,
  `placement_id` varchar(30) DEFAULT NULL,
  `member_uid` varchar(30) DEFAULT NULL,
  `activation_code` varchar(10) DEFAULT NULL,
  `position_` tinyint(4) DEFAULT NULL,
  `status_` tinyint(4) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_genealogy_transaction`
--

LOCK TABLES `user_genealogy_transaction` WRITE;
/*!40000 ALTER TABLE `user_genealogy_transaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_genealogy_transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_wallet`
--

DROP TABLE IF EXISTS `user_wallet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_wallet` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `member_uid` varchar(30) DEFAULT NULL,
  `t_number` varchar(30) DEFAULT NULL,
  `t_description` varchar(500) DEFAULT NULL,
  `t_type` tinyint(2) DEFAULT NULL,
  `t_role` tinyint(1) DEFAULT NULL,
  `t_amount` decimal(18,2) DEFAULT NULL,
  `t_status` tinyint(2) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_wallet`
--

LOCK TABLES `user_wallet` WRITE;
/*!40000 ALTER TABLE `user_wallet` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_wallet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_primary_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `streets` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connected_to` int(11) NOT NULL,
  `activation_id` int(11) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_user_token_unique` (`user_token`),
  UNIQUE KEY `users_member_uid_unique` (`member_uid`),
  UNIQUE KEY `users_fb_uid_unique` (`fb_uid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'570ba9b8e185cae072abc5843cc55124','8011-2120-0000-0000',NULL,NULL,'king.a','$2y$10$LnrolhQ42OQTjh3hRWZCjO.prBjMetyCowzV0v7NJewWaQLZmuvzO','king paulo','aquino',NULL,NULL,NULL,'king@gmail.com','09177715380',0,0,20,2,'8sJbTTChDpK9ZctbCuzaA4s7FKopHjHZaTpxFklk93nALUJDKClVIXO3ifXq','2017-11-28 10:55:50','2017-11-28 10:55:50'),(2,'acecbe4619c788e7381b5e6f4d2d5bd0','8011-2121-0000-0000',NULL,NULL,'mark.f','$2y$10$btriHH.N88ZUyBA6Ma99YeDzZ6wm.hRLF1Y3ihAcEU8gXkPODfXSO','mark','fernandez',NULL,NULL,NULL,'mark@gmail.com','09212071581',1,0,21,2,'cP6gaaGc1v7ONe3iHiQhlKIQOXITMqp6qyg244033oFW4q8USUPb76jFgzU2','2017-11-20 11:55:43','2017-11-20 11:55:43'),(3,'83cf1469871a1bc686cbcb30d48a9a1c','8011-2122-0000-0000',NULL,NULL,'gelo.d','$2y$10$3jPb0.CFue1ADB5wO0Qs5.jvdXvDVsyrwqgrLQH38VrpmBMRQ.7lS','Angelo Carlo','Del Rio',NULL,NULL,NULL,'sample@samp.com','09950912795',1,0,21,2,NULL,'2017-11-30 12:24:32','2017-11-30 12:24:32'),(4,'1ef0f8c4b0817c65621c511bf7d8f1cd','8011-2123-0000-0000',NULL,NULL,'sam.a','$2y$10$Ax5tM6VQcvmPfmKECvjcgOpiWuBNB61aA8F8QjomTpSsj0rG92Odq','Samuel jr','Abiva',NULL,NULL,NULL,'sample@sam.com','09276545193',1,0,21,2,NULL,'2017-11-30 12:25:23','2017-11-30 12:25:23'),(5,'676369af2364d7d2ebaf59fdbe88c9c0','8011-2124-0000-0000',NULL,NULL,'albert.c','$2y$10$LXh9i79kZjswxBOrkTa2FeX/eK.TYGALskuzmZYS2AFEZQP6qFLxm','Christian Albert','Cabrera',NULL,NULL,NULL,'sasas@asasa.com','09502887556',1,0,21,2,NULL,'2017-11-30 12:25:39','2017-11-30 12:25:39'),(6,'833ccbde826923983dc240adc43d9233','8011-2125-0000-0000',NULL,NULL,'epro.a','$2y$10$M/LoYLNMkbTeSb2oLCV7C.u12uA7tx6pWz71SflpJE8x3wYjnOG0W','Enghage Pro','Affliliate',NULL,NULL,NULL,'enghage.pro@gmail.com','09474746282',1,0,1,2,'16WqzHnm6QlYDUyBgS9zJtM8Q6noWpaZdqFigZrsOW16Or8Xe0ctFIwPREpu','2017-11-30 12:27:27','2017-11-30 12:27:27');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-30 21:19:11
